<?php
// cSpell:disable

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResidentModel;
use App\Validation\UserValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;

class ResidentUserController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(string $code)    
    {
        // Busca o residente com o possível user dele
        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);

        if (!$resident) {
            return redirect()->back()->with('error', 'Residente não encontrado.');
        }

        $hasUser = $resident->hasUser();
        $route = route_to($hasUser ? 'residents.user.update' : 'residents.user.create', $resident->code);

        $data = [
            'title'    => "Usuário do residente {$resident->name}",
            'resident' => $resident,
            'route'    => $route,
            'hidden'   => $hasUser ? ['_method' => 'PUT'] : [],
            'showActionButton' => $hasUser,
        ];

        return view('Residents/User/form', $data);
    }

    public function create(string $code): RedirectResponse
    {
        $rules = (new UserValidation)->getRules();

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // recupero sem usuário, pois estamos criando
        $resident = model(ResidentModel::class)->getByCode(code: $code);

        // Cria a identidade do usuário (email)
        $identities = [
            [
                'type' => 'email_password',
                'secret' => $this->request->getPost('email'),
                'secret2' => $this->request->getPost('password'),
            ]
        ];

        // Cria o usuário
        $userModel = auth()->getProvider();
        $user = new User([
            'username' => mb_url_title("{$resident->name}-{$resident->code}", '-', true),
            'active' => 1,
            'status' => 'active',
            'resident_id' => $resident->id,
        ]);

        try {
            $userModel->save($user);
            
            // Pega o ID do usuário recém criado
            $userId = $userModel->getInsertID();

            // Adiciona as identidades
            foreach ($identities as $identity) {
                $identity['user_id'] = $userId;
                $this->db->table('auth_identities')->insert($identity);
            }

            // Adiciona ao grupo padrão
            $user = $userModel->findById($userId);
            $userModel->addToDefaultGroup($user);

            // Atualiza o residente com o ID do usuário
            $resident->user_id = $userId;
            model(ResidentModel::class)->save($resident);

            return redirect()->route('residents.show', [$resident->code])->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário. ' . $e->getMessage());
        }
    }

    public function update(string $code): RedirectResponse
    {

        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);
        /**
         *  @var user
         */

        $user = $resident->user;

        $rules = (new UserValidation)->getRules(id: $user->id);

        $inputRequest = $this->request->getPost();
        if (empty($inputRequest['password'])) {
            unset($rules['password'], $rules['password_confirm']);
        }

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        
        $user->fill([            
            'email'    => $inputRequest['email'],
            'password' => $inputRequest['password'],        
        ]);

        auth()->getProvider()->save($user);
       
        return redirect()->route('residents.show', [$resident->code])->with('success', 'Sucesso !');

    }

    public function action(string $code): RedirectResponse
    {
        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);

        if (!$resident || !$resident->hasUser()) {
            return redirect()->back()->with('error', 'Residente não encontrado ou não possui usuário.');
        }

        $user = $resident->user;
        $userModel = auth()->getProvider();

        try {
            if ($user->isBanned()) {
                $user->unBan();
                $message = 'Usuário liberado com sucesso!';
            } else {
                $user->ban('Sua conta está temporariamente bloqueada. Procure o síndico');
                $message = 'Usuário bloqueado com sucesso!';
            }

            $userModel->save($user);
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status do usuário. ' . $e->getMessage());
        }
    }
}
