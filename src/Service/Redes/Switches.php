<?php
namespace App\Service\Redes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Redes\Switches\Create;
use App\Entity\Redes\Switches as EntitySwitches;
use App\Util\Switches\SwitchStatus;
use App\Entity\Redes\Porta;
use \App\Service\Redes\Porta\Create as CreatePorta;

class Switches
{
    private $objEntityManager   = NULL;
    
    public function __construct(Registry $objRegistry)
    {
        $this->objEntityManager = $objRegistry->getManager('trouble');
    }
    
    public function create(Request $objRequest):EntitySwitches
    {
        try {
            $objRedesSwitchCreate = new Create($this->objEntityManager);
            $objRedesSwitchCreate->create($objRequest);
            return $objRedesSwitchCreate->save();
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function status(int $id):array
    {
        try {
            $objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
            if(!($objSwitches instanceof EntitySwitches)){
                throw new \RuntimeException("Switch id '$id' não foi localizado.");
            }
            $objSwitchStatus = new SwitchStatus($objSwitches);
            return $objSwitchStatus->getVmVlan();
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function updateSwitchPorta(int $id)
    {
//         $objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
//         if(!($objSwitches instanceof EntitySwitches)){
//             throw new \RuntimeException("Switch id '$id' não foi localizado.");
//         }
//         $objSwitchStatus = new SwitchStatus($objSwitches);
//         $arrayPorta = $objSwitches->getPorta();
//         if($arrayPorta->count()){
            
//             $arrayAlias         = $objSwitchStatus->getAlias();
//             $arrayAdminStatus   = $objSwitchStatus->getAdminStatus();
//             $arrayOperStatus    = $objSwitchStatus->getOperStatus();
//             $arrayVlanType      = $objSwitchStatus->getVlanType();
//             $arrayVmVlan        = $objSwitchStatus->getVmVlan();
//             $arrayVmPortStatus  = $objSwitchStatus->getVmPortStatus();
//             $arrayPortSpeed     = $objSwitchStatus->getPortSpeed();
            
//             //             if(count($arrayAlias) != $arrayPorta->count()){
//             //                 throw new \RuntimeException('Número de portas no switch "'.count($arrayAlias).'" diverge do cadastro "'.$arrayPorta->count().'"');
//             //             }
//             print_r($arrayPortSpeed);
//             exit();
//             $arrayPorta->first();
//             echo "\nclass: ".get_class($objSwitches);
//             echo "\nSwitch: ".$objSwitches->getId();
//             echo "\nTotal: ".$arrayPorta->count();
//             while($objPorta = $arrayPorta->current()){
//                 echo "\n\t".$objPorta->getId();
//                 $arrayPorta->next();
//             }
//         }
//         echo "\n";
//         return ['final'=>1];
    }
    
    public function postSwitchPorta(int $id, Request $objRequest):Porta
    {
        $objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
        if(!($objSwitches instanceof EntitySwitches)){
            throw new \RuntimeException("Switch id '$id' não foi localizado.");
        }
        
        $objCreatePorta = new CreatePorta($this->objEntityManager);
        $objCreatePorta->setSwitches($objSwitches);
        $objCreatePorta->create($objRequest);
        return $objCreatePorta->save();
    }
    
    public function backup(int $id)
    {
        try {
            $objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
            if(!($objSwitches instanceof EntitySwitches)){
                throw new \RuntimeException("Switch id '$id' não foi localizado.");
            }
            $objSwitchStatus = new SwitchStatus($objSwitches);
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
}
