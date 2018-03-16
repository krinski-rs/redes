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

use App\Service\Redes\Switches as ServiceRedesSwitches;
use App\Entity\Redes\Switches as EntityRedesSwitches;
use App\Transformer\Redes\SwitchesTransformer;
use App\Util\Traits\ParseInclude;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Pagerfanta;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\RouterInterface;

class SwitchController extends Controller
{
    use ParseInclude;
    
    public function postSwitch(Request $objRequest)
    {
        try {
            $objServiceRedesSwitches = $this->get('redes.switch');
            if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objSwitches = $objServiceRedesSwitches->create($objRequest);
            
            return new JsonResponse(['id'=>$objSwitches->getId()], Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function postSwitchPorta(int $id, Request $objRequest)
    {
        try {
            $objServiceRedesSwitches = $this->get('redes.switch');
            if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objPorta = $objServiceRedesSwitches->postSwitchPorta($id, $objRequest);
            return new JsonResponse(['id'=>$objPorta->getId()], Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function getSwitch(int $id, Request $objRequest)
    {
        try {
            $objServiceRedesSwitches = $this->get('redes.switch');
            if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $objSwitches = $objServiceRedesSwitches->get($id);
            if(!($objSwitches instanceof EntityRedesSwitches)){
                return new JsonResponse([], Response::HTTP_NOT_FOUND);
            }
            
            $arrayIncludes = $this->getIncludes($objRequest);
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            
            if(count($arrayIncludes)){
                $objFractalManager->parseIncludes($arrayIncludes);
            }
            
            $objItem = new Item($objSwitches, new SwitchesTransformer(), 'switch');
            
            $objFractalManager->createData($objItem)->toJson();
            return new JsonResponse($objFractalManager->createData($objItem)->toArray(), Response::HTTP_OK);
            
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse(['ab' => 123], Response::HTTP_OK);
    }
    
    public function getSwitchs(Request $objRequest)
    {
        try {
            $objServiceRedesSwitches = $this->get('redes.switch');
            if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $arraySwitches = $objServiceRedesSwitches->list($objRequest);
            
            $arrayIncludes = $this->getIncludes($objRequest);
            $objFractalManager = new FractalManager();
            $objFractalManager->setSerializer(new JsonApiSerializer('http://redes.local/api'));
            
            if(count($arrayIncludes)){
                $objFractalManager->parseIncludes($arrayIncludes);
            }
            
            $doctrineAdapter = new DoctrineCollectionAdapter(new ArrayCollection($arraySwitches));
            $paginator = new Pagerfanta($doctrineAdapter);
            $filteredResults = $paginator->getCurrentPageResults();
            $objRouterInterface = $this->get('router');
            
            
            $paginatorAdapter = new PagerfantaPaginatorAdapter($paginator, function(int $page) use ($objRequest, $objRouterInterface) {
                $route = $objRequest->attributes->get('_route');
                $inputParams = $objRequest->attributes->get('_route_params');
                $newParams = array_merge($inputParams, $objRequest->query->all());
                $newParams['page'] = $page;
                return $objRouterInterface->generate($route, $newParams, 0);
            });
            
            $objCollection = new FractalCollection($arraySwitches, new SwitchesTransformer(), 'switch');
            $objCollection->setPaginator($paginatorAdapter);
            
            return new JsonResponse($objFractalManager->createData($objCollection)->toArray(), Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function deleteSwitch(int $id)
    {
        return new JsonResponse([], Response::HTTP_NOT_IMPLEMENTED);
    }
    
    public function putSwitch(int $id)
    {
        return new JsonResponse(['id'=>['putSwitch']], Response::HTTP_OK);
    }
    
    public function patchSwitch(int $id)
    {
        return new JsonResponse(['id'=>['patchSwitch']], Response::HTTP_OK);
    }
    
    public function status(int $id)
    {
        try {
            $objServiceRedesSwitches = $this->get('redes.switch');
            if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
                return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $arrayStatus = $objServiceRedesSwitches->status($id);
            return new JsonResponse($arrayStatus, Response::HTTP_OK);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_PRECONDITION_FAILED);
        } catch (\Exception $e) {
            return new JsonResponse(['mensagem'=>$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function putSwitchPorta(int $id)
    {
        $objServiceRedesSwitches = $this->get('redes.switch');
        if(!$objServiceRedesSwitches instanceof ServiceRedesSwitches){
            return new JsonResponse(['message'=> 'Class "App\Service\Redes\Switches not found."'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $arrayStatus = $objServiceRedesSwitches->updateSwitchPorta($id);
        
        return new JsonResponse($arrayStatus, Response::HTTP_OK);
    }
}

