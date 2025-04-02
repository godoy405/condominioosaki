<?php
// cSpell:disable
namespace App\Models;

use App\Entities\Area;
use App\Models\Basic\AppModel;

class AreaModel extends AppModel
{
    protected $table            = 'areas';    
    protected $returnType       = Area::class;   
    protected $allowedFields    = [
        'name',
        'code',
        'description',
    ];

    protected $beforeInsert = ['generateCode'];

    protected function generateCode(array $data): array
    {
        if (!isset($data['data']['code'])) {
            $data['data']['code'] = random_int(10000000, 99999999);
        }
        return $data;
    }

    public function getByCode(string $code, array $contains = []): object
    {
        $area = $this->where('code', $code)->first();

        if ($area === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Área com o código {$code} não encontrada");
        }

        $this->relateData($area, $contains);

        return $area;
    }

    protected function relateData(object &$area, array $contains = []): void
    {
        if(in_array('reservation', $contains)) {
            //TODO: Implementar a relação com a tabela de reservas
        }
    }

}
