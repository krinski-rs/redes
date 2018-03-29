<?php
namespace App\Service\Redes\Switches;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use App\Entity\Redes\Switches;

class Create
{    
    private $objEntityManager   = NULL;
    private $objSwitches        = NULL;
    private $objModeloSwitch    = NULL;
    
    public function __construct(EntityManager $objEntityManager)
    {
        $this->objEntityManager = $objEntityManager;
    }
    
    public function create(Request $objRequest)
    {
        try {
            
            $this->validate($objRequest);
            $this->objSwitches = new Switches();
            $this->objSwitches->setModeloSwitch($this->objModeloSwitch);
            $this->objSwitches->setAtivo(TRUE);
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
    
    private function validate(Request $objRequest)
    {
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
        
        
        $objCollection = new Assert\Collection(
            [
                'fields' => [
                    'ip' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objIp
                        ]
                    ),
                    'nome' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objLength
                        ]
                    ),
                    'modeloSwitchId' => new Assert\Required( [
                        $objNotNull,
                        $objNotBlank,
                        $objRange
                        ]
                    ),
                    'vlan' => new Assert\Optional( [
                            $objRange
                        ]
                    )
                ]
            ]
        );

        $data = [
            'ip'                => $objRequest->get('ip', NULL),
            'nome'              => $objRequest->get('nome', NULL),
            'vlan'              => $objRequest->get('vlan', NULL),
            'modeloSwitchId'    => $objRequest->get('modeloSwitchId', NULL)
        ];
        
        $objRecursiveValidator = Validation::createValidatorBuilder()->getValidator();
        $objConstraintViolationList = $objRecursiveValidator->validate($data, $objCollection);
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
        $this->objModeloSwitch = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch')->find($objRequest->get('modeloSwitchId', NULL));
    }
    
    public function save()
    {
        $this->objEntityManager->persist($this->objSwitches);
        $this->objEntityManager->flush();
        return $this->objSwitches;
    }
}
