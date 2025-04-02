<?php

namespace App\Validation;

class ResidentValidation
{
    public function getRules(): array
    {
        return [
            'name' => [
                'label' => 'Nome',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'O campo Nome é obrigatório',
                    'min_length' => 'O Nome deve ter no mínimo 3 caracteres',
                    'max_length' => 'O Nome deve ter no máximo 100 caracteres'
                ]
            ],
            'mobile_phone' => [
                'label' => 'Telefone',
                'rules' => 'required|min_length[10]|max_length[15]|is_unique[residents.mobile_phone,id,{id}]',
                'errors' => [
                    'required' => 'O campo Telefone é obrigatório',
                    'min_length' => 'O Telefone deve ter no mínimo 10 caracteres',
                    'max_length' => 'O Telefone deve ter no máximo 15 caracteres',
                    'is_unique' => 'Este número de telefone já está cadastrado'
                ]
            ],
            'apartment' => [
                'label' => 'Apartamento',
                'rules' => 'required|min_length[1]|max_length[10]',
                'errors' => [
                    'required' => 'O campo Apartamento é obrigatório',
                    'min_length' => 'O Apartamento deve ter no mínimo 1 caractere',
                    'max_length' => 'O Apartamento deve ter no máximo 10 caracteres'
                ]
            ]
        ];
    }
}
