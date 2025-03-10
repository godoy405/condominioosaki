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
    public function index(string $code)
    {
        // Buscamos o resident com o possível user dele
        $resident = model(ResidentModel::class)->getByCode(code: $code, contains: ['user']);

        $route = route_to($resident->hasUser() ? 'residents.user.update' : 'residents.user.create', $resident->code);

        $data = [
            'title'    => "Usuário do residente {$resident->name}",
            'resident' => $resident,
            'route'    => $route,
            'hidden'   => $resident->hasUser() ? ['_method' => 'PUT'] : [],
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

        $user = new User([
            'username'    => mb_url_title("{$resident->name}-{$resident->code}", '-', true),
            'email'       => $this->request->getPost('email'),
            'password'    => $this->request->getPost('password'),
            'resident_id' => $resident->id,
        ]);

        $userModel = auth()->getProvider();
        $userModel->setAllowedFields(['resident_id', 'username']);
        $userModel->model->save($user);

        $user = $userModel->findById($userModel->getInsertID());
        $userModel->addToDefaultGroup($user);

        $resident->user_id = $user->id;
        model(ResidentModel::class)->save($resident);

        return redirect()->route('residents.show', [$resident->code])->with('success', 'Sucesso !');

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
        /**
         *  @var user
         */

        $user = $resident->user;

        $user->isBanned() ? $user->unBan() : $user->ban('Sua conta está temporariamente bloqueada. Procure o síndico');
       
        return redirect()->back()->with('success', 'Sucesso !');

    }
}
