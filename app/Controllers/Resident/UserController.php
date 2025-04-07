<?php

namespace App\Controllers\Resident;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function manage($userId)
    {
        $userModel = auth()->getProvider();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não encontrado');
        }

        if ($this->request->getPost('unban')) {
            $userModel->update($userId, ['status' => 'active']);
            return redirect()->back()->with('success', 'Acesso liberado com sucesso');
        }

        if ($this->request->getPost('ban')) {
            $userModel->update($userId, ['status' => 'banned']);
            return redirect()->back()->with('success', 'Acesso bloqueado com sucesso');
        }

        // Handle other user updates here...
        return redirect()->back();
    }
}