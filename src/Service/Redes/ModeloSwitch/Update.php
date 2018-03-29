<?php
namespace App\Service\Redes\ModeloSwitch;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use App\Entity\Redes\ModeloSwitch;

class Update
{
    private $objEntityManager   = NULL;
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
            $this->objModeloSwitch->setAtivo((bool)$objRequest->get('ativo'));
            $this->objModeloSwitch->setNome($objRequest->get('nome', NULL));
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
                $this->objModeloSwitch->setAtivo($objRequest->get('ativo', NULL));
            }
            
            if($objRequest->attributes->has('nome')){
                $this->objModeloSwitch->setNome($objRequest->get('nome', NULL));
            }
            
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    
    private function validatePut(Request $objRequest)
    {
        if(!$objRequest->attributes->has('ativo') || !$objRequest->attributes->has('nome')){
            throw new \RuntimeException('Os parâmetros "ativo" e "nome" são obrigatórios.');
        }
        
    }
    
    private function validate(int $id, Request $objRequest)
    {
        $this->objModeloSwitch = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch')->find($id);
        if(!($this->objModeloSwitch instanceof ModeloSwitch)){
            throw new \RuntimeException('Switch não localizado.');
        }
        
        $objNotNull = new Assert\NotNull();
        $objNotNull->message = "Esse valor não deve ser nulo.";
        $objNotBlank = new Assert\NotBlank();
        $objNotBlank->message = "Esse valor não deve estar em branco.";
        
        $objLength = new Assert\Length(
            [
                "min" => 2,
                "max" => 255,
                "minMessage" => "O campo deve ter pelo menos {{ limit }} caracteres.",
                "maxMessage" => "O campo não pode ser maior do que {{ limit }} caracteres."
            ]
        );
        
        $objType = new Assert\Type(
            [
                "type" => 'boolean',
                "message" => "O valor '{{ value }}' não é do tipo '{{ type }}'."
            ]
        );
        
        $arrayData = [];
        $arrayCollection = [ 'fields' => [] ];
        if($objRequest->attributes->has('ativo')){
            $arrayData['ativo'] = $objRequest->get('ativo');
            $arrayCollection['fields']['ativo'] = new Assert\Required(
                [
                    $objNotNull,
                    $objType
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
        if($this->objModeloSwitch->getId()){
            $this->objEntityManager->merge($this->objModeloSwitch);
        }else{
            $this->objEntityManager->persist($this->objModeloSwitch);
        }
        
        $this->objEntityManager->flush();
        return $this->objModeloSwitch;
    }
}

