<?php
namespace App\Transformer\Redes;

use League\Fractal\TransformerAbstract;
use App\Entity\Redes\ModeloSwitch as EntityRedesModeloSwitch;

class ModeloSwitchTransformer extends TransformerAbstract
{
    public function transform(EntityRedesModeloSwitch $objModeloSwitch)
    {
        return [
            'id'    => $objModeloSwitch->getId(),
            'ativo' => $objModeloSwitch->getAtivo(),
            'nome'  => $objModeloSwitch->getNome(),
            'links' => [
                'rel'   => 'self',
                'uri'   => '/api/modeloswitch/'.$objModeloSwitch->getId()
            ]
        ];
    }
}

