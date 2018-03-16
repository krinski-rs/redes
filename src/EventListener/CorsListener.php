<?php
namespace App\EventListener;
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Response;
class CorsListener// implements EventSubscriberInterface
{
//     public static function getSubscribedEvents()
//     {
//         return [
//             KernelEvents::REQUEST,
//             KernelEvents::RESPONSE,
//         ];
//     }
    
    public function onKernelRequest(GetResponseEvent $objGetResponseEvent)
    {
        /*
         * Não faça nada se não for o MASTER_REQUEST
         */
        if (HttpKernelInterface::MASTER_REQUEST !== $objGetResponseEvent->getRequestType()) {
            return;
        }
        
        $objRequest = $objGetResponseEvent->getRequest();
        $method  = $objRequest->getRealMethod();
        if ('OPTIONS' === strtoupper($method)) {
            $objResponse = new Response();
            $objResponse->headers->set('Access-Control-Allow-Credentials', 'true');
            $objResponse->headers->set('Access-Control-Allow-Methods', 'POST,GET,PUT,DELETE,PATCH,OPTIONS');
            $objResponse->headers->set('Access-Control-Allow-Headers', 'AccessToken,Content-Type,AuthVersion,AppKey,Cookie,Accept,Origin,Authorization');
            $objResponse->headers->set('Access-Control-Max-Age', 3600);
            $objGetResponseEvent->setResponse($objResponse);
            return ;
        }
        
        if ($objRequest->headers->get('content-type') == 'application/json') {
            $data = json_decode($objGetResponseEvent->getRequest()->getContent(), true);
            $total = count($data);
            if($total){
                reset($data);
                $ini = 0;
                while($ini < $total){
                    $dado = current($data);
                    $objRequest->attributes->set(key($data), $dado);
                    next($data);
                    $ini++;
                }
            }
        }
    }
    
    public function onKernelResponse(FilterResponseEvent $objFilterResponseEvent)
    {
        $request = $objFilterResponseEvent->getRequest();
        /*
         * Execute o CORS aqui para garantir que o domínio esteja no sistema
         */
        
        //if (in_array($request->headers->get('origin'), $this->cors)) {
        if (HttpKernelInterface::MASTER_REQUEST !== $objFilterResponseEvent->getRequestType()) {
            return;
        }
        $objResponse = $objFilterResponseEvent->getResponse();
        $objResponse->headers->set('Access-Control-Allow-Origin', '*');
        $objResponse->headers->set('Access-Control-Allow-Credentials', 'true');
        $objResponse->headers->set('Access-Control-Allow-Methods', 'POST,GET,PUT,DELETE,PATCH,OPTIONS');
        $objResponse->headers->set('Access-Control-Allow-Headers', 'AccessToken,Content-Type,AuthVersion,AppKey,Cookie,Accept,Origin,Authorization');
    }
}