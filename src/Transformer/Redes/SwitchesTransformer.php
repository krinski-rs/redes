<?php
namespace App\Transformer\Redes;

use League\Fractal\TransformerAbstract;
use App\Entity\Redes\Switches as EntityRedesSwitches;
use App\Entity\Redes\ModeloSwitch as EntityRedesModeloSwitch;

class SwitchesTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'modeloswitch'
    ];
    
    public function transform(EntityRedesSwitches $objSwitches)
    {
        return [
            'id'    => $objSwitches->getId(),
            'ativo' => $objSwitches->getAtivo(),
            'dataCadastro' => $objSwitches->getDataCadastro()->format("Y-m-d H:i:s"),
            'ip' => $objSwitches->getIp(),
            'nome'  => $objSwitches->getNome(),
            'vlanBase'  => $objSwitches->getVlanBase(),
            'links' => [
                'rel'   => 'self',
                'uri'   => '/api/switch/'.$objSwitches->getId()
            ]
        ];
    }
    
    public function includeModeloSwitch(EntityRedesSwitches $objSwitches)
    {
        return $this->item($objSwitches->getModeloSwitch(), new ModeloSwitchTransformer(), 'modeloswitch');
    }
}

