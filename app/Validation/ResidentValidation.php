<?php

namespace App\Validation;

class ResidentValidation
{ 
    public function getRules(?string $code = null): array {

        return [
            'id' => [
                'rules' => 'permit_empty|is_natural_no_zero'
            ],

            'name' => [
                'label' => 'Nome',
                'rules' => [
                    'required',
                    'max_length[100]'
                ],
                'errors' => [ 
                    'required'   => 'O nome é obrigatório',
                    'max_length' => 'O nome deve ter no máximo 100 caracteres'
                ],
            ],

            'mobile_phone' => [
                'label' => 'Telefone',
                'rules' => [
                    'required',
                    "is_unique[residents.mobile_phone, code, {$code}]",
                ],                
                'errors' => [
                    'required'  => 'O telefone é obrigatório',
                    'is_unique' => 'Este telefone já está cadastrado para outro residente'
                ],
            ],

            'apartment' => [
                'label' => 'Apartamento',
                'rules' => [
                    'required',                    
                ],                
                'errors' => [
                    'required' => 'O apartamento é obrigatório',
                ],
            ],
        ];

    }
    
}
