<?php

namespace App\Validation;

class AreaValidation
{ 
    public function getRules(?string $code = null): array 
    {
       return [
            'id' => [                
                'rules' => 'permit_empty|is_natural_no_zero'
                ],
            'name' => [
                'label' => 'Nome',
                'rules' => [
                    'required',
                    'min_length[3]',
                    'max_length[100]'
                ],
                'errors' => [ 
                    'required'   => 'O nome é obrigatório',
                    'max_length' => 'O nome deve ter no máximo 100 caracteres'
                ],
            ],

            'description' => [
                'label' => 'Descrição',
                'rules' => [
                    'permit_empty',
                    'max_length[5000]'
                ],
                'errors' => [
                    'max_length' => 'A descrição deve ter no máximo 5000 caracteres'
                ],
            ],
        ];

        if ($code) {
            $rules['name']['rules'][] = "is_unique[areas.name,code,{$code}]";
        } else {
            $rules['name']['rules'][] = "is_unique[areas.name]";
        }

        return $rules;
    }
} 