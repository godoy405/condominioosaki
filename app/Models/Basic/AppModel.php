<?php

namespace App\Models\Basic;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

abstract class AppModel extends Model
{    
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;    
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;  

    protected bool $updateOnlyChanged = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
  
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setCode'];    
    protected $beforeUpdate   = ['escapeData'];

    protected function escapeData(array $data): array {
        return esc($data);
    }

    protected function setCode(array $data): array {
        

            do {
                //para gerar um número aleatório de 8 dígitos
                $code = rand(10000000, 99999999);

                // Verifica se o código já existe no banco de dados
                $result = $this->select('code')->where('code', $code)->countAllResults();

            }while($result > 0);

            // Adiciona o código ao array $data
            $data['data']['code'] = $code;

            // Retorna o array modificado
            return $data;
        
    }

    /**
     * Recupera uma entidade por código
     * 
     * @param string $code Código único da entidade
     * @param array $contains Relacionamentos a carregar
     * @return object Retorna a entidade correspondente ao `returnType`
     * @throws  PageNotFoundException
     * 
     */

    public function getByCode(string $code, array $contains = []): object {
        $row = $this->where('code', $code)->first();

        if(!$row){
            // App\ModelsResidentModel
            $className =static::class;
            throw new PageNotFoundException("Registro com o código {$code} não encontrado na tabela {$this->table} ({$className})");

        }

        $this->relateData($row, $contains);

        return $row;
    }

    /**
     * Relaciona dados extras à entidade, se configurados na classe filha
     * 
     * @param mixed $object Entidade a ser enriquecida
     * @param array $contains Relacionados a serem carregados
     * @return void 
     * 
     * novo envio para o git
     */

    protected function relateData(object &$entity, array $contains = []): void {
        // esse método as classes filhas podem sobrescrevê-lo para atender a necessidade específica da classe
    }
         
    
}
 