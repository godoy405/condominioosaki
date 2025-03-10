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
                'rules' => [
                    'required',
                    'max_length[100]'
                ],
                'errors' => [ 
                    'required'   => 'O nome é obrigatório',
                    'max_length' => 'O nome deve ter no máximo 100 caractéres'
                ],
            ],

            'mobile_phone' => [
                'rules' => [
                    'required',
                    "is_unique[residents.mobile_phone, code, {$code}]",
                ],                
            ],

            'apartment' => [
                'rules' => [
                    'required',                    
                ],                
            ],
        ];

    }
    
}
