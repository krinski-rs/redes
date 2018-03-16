<?php
namespace App\Service\Redes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Redes\ModeloSwitch\Create;
use App\Service\Redes\ModeloSwitch\Update;
use App\Service\Redes\ModeloSwitch\Listing;

class ModeloSwitch
{
    private $objEntityManager   = NULL;
    
    public function __construct(Registry $objRegistry)
    {
        $this->objEntityManager = $objRegistry->getManager('redes');
    }
    
    public function create(Request $objRequest)
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
}
