<?php
namespace App\Controller\Redes;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use League\Fractal\Manager as FractalManager;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection as FractalCollection;

use App\Service\Redes\ModeloSwitch as ServiceRedesModeloSwitch;
use App\Entity\Redes\ModeloSwitch as EntityRedesModeloSwitch;
use App\Transformer\Redes\ModeloSwitchTransformer;

class ModeloSwitchController extends Controller
{
    
    public function postModeloSwitch(Request $objRequest)
    {
        try {
            $objRedesModeloSwitch = $this->get('redes.modelo_switch');
            if(!$objRedesModeloSwitch instanceof ServiceRedesModeloSwitch){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\ModeloSwitch not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objModeloSwitch = $objRedesModeloSwitch->create($objRequest);
            
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            $objItem = new Item($objModeloSwitch, new ModeloSwitchTransformer(), 'modeloswitch');
            
            $objFractalManager->createData($objItem)->toJson();
            return new JsonResponse($objFractalManager->createData($objItem)->toArray(), Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function getModeloSwitch(int $id)
    {
        try {
            $objRedesModeloSwitch = $this->get('redes.modelo_switch');
            if(!$objRedesModeloSwitch instanceof ServiceRedesModeloSwitch){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\ModeloSwitch not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $objModeloSwitch = $objRedesModeloSwitch->get($id);
            if(!($objModeloSwitch instanceof EntityRedesModeloSwitch)){
                return new JsonResponse([], Response::HTTP_NOT_FOUND);
            }
            
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            $objItem = new Item($objModeloSwitch, new ModeloSwitchTransformer(), 'modeloswitch');
            
            $objFractalManager->createData($objItem)->toJson();
            return new JsonResponse($objFractalManager->createData($objItem)->toArray(), Response::HTTP_OK);
            
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse(['ab' => 123], Response::HTTP_OK);
    }
    
    public function getModeloSwitchs(Request $objRequest)
    {
        try {
            $objRedesModeloSwitch = $this->get('redes.modelo_switch');
            if(!$objRedesModeloSwitch instanceof ServiceRedesModeloSwitch){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\ModeloSwitch not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $arrayModeloSwitch = $objRedesModeloSwitch->list($objRequest);
            
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            $objCollection = new FractalCollection($arrayModeloSwitch, new ModeloSwitchTransformer(), 'modeloswitch');
            
            return new JsonResponse($objFractalManager->createData($objCollection)->toArray(), Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function deleteModeloSwitch(int $id)
    {
        return new JsonResponse([], Response::HTTP_NOT_IMPLEMENTED);
    }
    
    public function putModeloSwitch(int $id, Request $objRequest)
    {
        try {
            $objRedesModeloSwitch = $this->get('redes.modelo_switch');
            if(!$objRedesModeloSwitch instanceof ServiceRedesModeloSwitch){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\ModeloSwitch not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objModeloSwitch = $objRedesModeloSwitch->put($id, $objRequest);
            
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            $objItem = new Item($objModeloSwitch, new ModeloSwitchTransformer(), 'modeloswitch');
            
            $objFractalManager->createData($objItem)->toJson();
            return new JsonResponse($objFractalManager->createData($objItem)->toArray(), Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function patchModeloSwitch(int $id, Request $objRequest)
    {
        try {
            $objRedesModeloSwitch = $this->get('redes.modelo_switch');
            if(!$objRedesModeloSwitch instanceof ServiceRedesModeloSwitch){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\ModeloSwitch not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objModeloSwitch = $objRedesModeloSwitch->patch($id, $objRequest);
            
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            $objItem = new Item($objModeloSwitch, new ModeloSwitchTransformer(), 'modeloswitch');
            
            $objFractalManager->createData($objItem)->toJson();
            return new JsonResponse($objFractalManager->createData($objItem)->toArray(), Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

