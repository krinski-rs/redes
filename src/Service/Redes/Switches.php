<?php
namespace App\Service\Redes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Redes\Switches\Create;
use App\Entity\Redes\Switches as EntitySwitches;
use App\Service\Redes\Switches\Listing;
use App\Service\Redes\Switches\Update;
use App\Util\Switches\SwitchStatus;
use App\Util\Switches\Backup;
use Psr\Log\LoggerInterface;

class Switches
{    
    private $objEntityManager   = NULL;
    private $objLoggerInterface = NULL;
    
    public function __construct(Registry $objRegistry, LoggerInterface $objLoggerInterface)
    {
        $this->objEntityManager = $objRegistry->getManager('redes');
        $this->objLoggerInterface = $objLoggerInterface;
    }
    
    public function get(int $id)
    {
        try {
            $objListing = new Listing($this->objEntityManager);
            return $objListing->get($id);
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function list(Request $objRequest)
    {
        try {
            $objListing = new Listing($this->objEntityManager);
            return $objListing->list($objRequest);
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
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
    
    public function put(int $id, Request $objRequest)
    {
        try {
            $objRedesSwitchUpdate = new Update($this->objEntityManager);
            $objRedesSwitchUpdate->put($id, $objRequest);
            return $objRedesSwitchUpdate->save();
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function patch(int $id, Request $objRequest)
    {
        try {
            $objRedesSwitchUpdate = new Update($this->objEntityManager);
            $objRedesSwitchUpdate->patch($id, $objRequest);
            return $objRedesSwitchUpdate->save();
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
            return $objSwitchStatus->getDescr();
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function backup(int $id):array
    {
        try {
            $objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
            if(!($objSwitches instanceof EntitySwitches)){
                throw new \RuntimeException("Switch id '$id' não foi localizado.");
            }
            $objBackup = new Backup($this->objLoggerInterface);
            $objBackup->setHost($objSwitches->getIp());
            $objBackup->setCommand("copy running-config tftp 172.16.0.218 AIRSW/{$objSwitches->getNome()}-DIARIO.CFG");
            $objBackup->backup();
            $objBackup->setCommand("tftp put 172.16.0.218 vr \"VR-Default\" primary.cfg /{$objSwitches->getNome()}-DIARIO.CFG");
            $objBackup->backup();
            return ['connect'];
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
}
