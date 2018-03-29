<?php
namespace App\Service\Redes\Switches;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use App\Entity\Redes\Switches;

class Update
{
    private $objEntityManager   = NULL;
    private $objSwitches        = NULL;
    private $objModeloSwitch    = NULL;
    
    public function __construct(EntityManager $objEntityManager)
    {
        $this->objEntityManager = $objEntityManager;
    }
    
    public function put(int $id, Request $objRequest)
    {
        try {
            $this->validatePut($objRequest);
            $this->validate($id, $objRequest);
            $this->objModeloSwitch = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch')->find($objRequest->get('modeloSwitchId', NULL));
            $this->objSwitches->setModeloSwitch($this->objModeloSwitch);
            $this->objSwitches->setAtivo($objRequest->get('ativo', NULL));
            $this->objSwitches->setDataCadastro(new \DateTime());
            $this->objSwitches->setIp($objRequest->get('ip', NULL));
            $this->objSwitches->setNome($objRequest->get('nome', NULL));
            $this->objSwitches->setVlanBase($objRequest->get('vlan', NULL));
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function patch(int $id, Request $objRequest)
    {
        try {
            $this->validate($id, $objRequest);
            if($objRequest->attributes->has('ativo')){
                $this->objSwitches->setAtivo($objRequest->get('ativo', NULL));
            }
            
            if($objRequest->attributes->has('ip')){
                $this->objSwitches->setIp($objRequest->get('ip', NULL));
            }
            
            if($objRequest->attributes->has('nome')){
                $this->objSwitches->setNome($objRequest->get('nome', NULL));
            }
            
            if($objRequest->attributes->has('vlan')){
                $this->objSwitches->setVlanBase($objRequest->get('vlan', NULL));
            }
            
            if($objRequest->attributes->has('modeloSwitchId')){
                $this->objModeloSwitch = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch')->find($objRequest->get('modeloSwitchId', NULL));
                $this->objSwitches->setModeloSwitch($this->objModeloSwitch);
            }
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    
    private function validatePut(Request $objRequest)
    {
        if(!$objRequest->attributes->has('ativo') || !$objRequest->attributes->has('ip') || !$objRequest->attributes->has('nome') || !$objRequest->attributes->has('modeloSwitchId') || !$objRequest->attributes->has('vlan')){
            throw new \RuntimeException('Os parâmetros [ativo, ip, nome, modeloSwitchId, vlan] são obrigatórios.');
        }
        
    }
    
    private function validate(int $id, Request $objRequest)
    {
        $this->objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($id);
        if(!($this->objSwitches instanceof Switches)){
            throw new \RuntimeException('Switch não localizado.');
        }
        $objNotNull = new Assert\NotNull();
        $objNotNull->message = "Esse valor não deve ser nulo.";
        $objNotBlank = new Assert\NotBlank();
        $objNotBlank->message = "Esse valor não deve estar em branco.";
        
        $objLength = new Assert\Length(
            [
                "min" => 2,
                "max" => 100,
                "minMessage" => "O campo deve ter pelo menos {{ limit }} caracteres.",
                "maxMessage" => "O campo não pode ser maior do que {{ limit }} caracteres."
            ]
        );
        
        $objRange = new Assert\Range(
            [
                "min" => 1,
                "minMessage" => "Esse valor deve ser '{{ limit }}' ou mais.",
                "max" => 9999999,
                "maxMessage" => "Esse valor deve ser '{{ limit }}' ou menor."
            ]
        );
        
        $objType = new Assert\Type(
            [
                "type" => 'bool',
                "message" => "O valor '{{ value }}' não é válido '{{ type }}'."
            ]
        );
        
        $objIp = new Assert\Ip(
            [
                "version" => 'all',
                "message" => "Este não é um endereço IP válido."
            ]
        );
        
        $arrayData = [];
        $arrayCollection = [ 'fields' => [] ];
        
        if($objRequest->attributes->has('ip')){
            $arrayData['ip'] = $objRequest->get('ip');
            $arrayCollection['fields']['ip'] = new Assert\Required(
                [
                    $objNotNull,
                    $objNotBlank,
                    $objIp
                ]
            );
        }
        
        if($objRequest->attributes->has('nome')){
            $arrayData['nome'] = $objRequest->get('nome');
            $arrayCollection['fields']['nome'] = new Assert\Required(
                [
                    $objNotNull,
                    $objNotBlank,
                    $objLength
                ]
            );
        }
        
        if($objRequest->attributes->has('modeloSwitchId')){
            $arrayData['modeloSwitchId'] = $objRequest->get('modeloSwitchId');
            $arrayCollection['fields']['modeloSwitchId'] = new Assert\Required(
                [
                    $objNotNull,
                    $objNotBlank,
                    $objRange
                ]
            );
        }
        
        if($objRequest->attributes->has('vlan')){
            $arrayData['vlan'] = $objRequest->get('vlan');
            $arrayCollection['fields']['vlan'] = new Assert\Required(
                [
                    $objRange
                ]
            );
        }
        
        $objRecursiveValidator = Validation::createValidatorBuilder()->getValidator();
        $objCollection = new Assert\Collection($arrayCollection);
        $objConstraintViolationList = $objRecursiveValidator->validate($arrayData, $objCollection);
        
        if($objConstraintViolationList->count()){
            $objArrayIterator = $objConstraintViolationList->getIterator();
            $objArrayIterator->rewind();
            $mensagem = "";
            while($objArrayIterator->valid()){
                if($objArrayIterator->key()){
                    $mensagem.= "\n";
                }
                $mensagem.= $objArrayIterator->current()->getPropertyPath().': '.$objArrayIterator->current()->getMessage();
                $objArrayIterator->next();
            }
            throw new \RuntimeException($mensagem);
        }
    }
    
    public function save()
    {
        if($this->objSwitches->getId()){
            $this->objEntityManager->merge($this->objSwitches);
        }else{
            $this->objEntityManager->persist($this->objSwitches);
        }
        
        $this->objEntityManager->flush();
        return $this->objSwitches;
    }
}

