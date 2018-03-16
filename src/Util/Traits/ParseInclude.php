<?php
namespace App\Util\Traits;

use Symfony\Component\HttpFoundation\Request;

trait ParseInclude
{
    public function getIncludes(Request $objRequest)
    {
        if($objRequest->attributes->has('include')){
            return explode(",", $objRequest->attributes->get('include'));
        }
        
        if($objRequest->request->has('include')){
            return explode(",", $objRequest->request->get('include'));
        }
        
        if($objRequest->query->has('include')){
            return explode(",", $objRequest->query->get('include'));
        }
        return [];
    }
}
