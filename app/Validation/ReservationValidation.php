<?php

namespace App\Validation;

use CodeIgniter\Validation\ValidationInterface; // Correct import
use Config\Services;

class ReservationValidation
{
    private ValidationInterface $validation;

    public function __construct()
    {
        $this->validation = Services::validation(); // Use the service to get the validation instance
    }

    public function getRules(?string $code = null): array
    {
        return [
            'area_id' => [
                'label' => 'Área',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'A área é obrigatória',
                    'integer' => 'A área deve ser um número inteiro'
                ]
            ],
            'desired_date' => [
                'label' => 'Data desejada',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'A data desejada é obrigatória',
                    'valid_date' => 'A data desejada deve ser uma data válida'
                ]
            ],
            'notes' => [
                'label' => 'Observações',
                'rules' => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'As observações devem ter no máximo 255 caracteres'
                ]
            ]
        ];
    }

    public function withRequest($request)
    {
        $this->validation->setRules($this->getRules());
        return $this->validation->withRequest($request)->run(); // Ensure run is called here
    }

    public function run()
    {
        return $this->validation->run();
    }

    public function getErrors()
    {
        return $this->validation->getErrors();
    }
}