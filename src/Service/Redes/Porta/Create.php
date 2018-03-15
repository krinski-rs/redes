<?php
namespace App\Service\Redes\Porta;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use App\Entity\Redes\Switches as EntitySwitches;
use App\Entity\Redes\Porta;

class Create
{
    private $objEntityManager       = NULL;
    private $objSwitches            = NULL;
    private $objPorta               = NULL;
    
    const IF_ADMIN_STATUS_UP        = 'up(1)';
    const IF_ADMIN_STATUS_DOWN      = 'down(2)';
    const IF_ADMIN_STATUS_TESTING   = 'testing(3)';
    
    const IF_OPER_STATUS_UP             = 'up(1)';
    const IF_OPER_STATUS_DOWN           = 'down(2)';
    const IF_OPER_STATUS_TESTING        = 'testing(3)';
    const IF_OPER_STATUS_UNKNOWN        = 'unknown(4)';
    const IF_OPER_STATUS_DORMANT        = 'dormant(5)';
    const IF_OPER_STATUS_NOTPRESENT     = 'notPresent(6)';
    const IF_OPER_STATUS_LOWERLAYERDOWN = 'lowerLayerDown(7)';
    
    const DUPLEX_STATUS_UNKNOWN     = 'unknown(1)';
    const DUPLEX_STATUS_HALFDUPLEX  = 'halfDuplex(2)';
    const DUPLEX_STATUS_FULLDUPLEX  = 'fullDuplex(3)';
    
    const PORT_DUPLEX_HALF      = 'half(1)';
    const PORT_DUPLEX_FULL      = 'full(2)';
    const PORT_DUPLEX_DISAGREE  = 'disagree(3)';
    const PORT_DUPLEX_AUTO      = 'auto(4)';
    
    public static function getArrayChoiceAdminStatus():array
    {
        return [
            self::IF_ADMIN_STATUS_UP,
            self::IF_ADMIN_STATUS_DOWN,
            self::IF_ADMIN_STATUS_TESTING
        ];
    }
    
    public static function getArrayChoicePortStatus():array
    {
        return [
            self::PORT_DUPLEX_HALF,
            self::PORT_DUPLEX_FULL,
            self::PORT_DUPLEX_DISAGREE,
            self::PORT_DUPLEX_AUTO
        ];
    }
    
    public static function getArrayChoiceOperStatus():array
    {
        return [
            self::IF_OPER_STATUS_UP,
            self::IF_OPER_STATUS_DOWN,
            self::IF_OPER_STATUS_TESTING,
            self::IF_OPER_STATUS_UNKNOWN,
            self::IF_OPER_STATUS_DORMANT,
            self::IF_OPER_STATUS_NOTPRESENT,
            self::IF_OPER_STATUS_LOWERLAYERDOWN
        ];
    }
    
    public static function getArrayChoiceDuplexStatus():array
    {
        return [
            self::DUPLEX_STATUS_UNKNOWN,
            self::DUPLEX_STATUS_HALFDUPLEX,
            self::DUPLEX_STATUS_FULLDUPLEX
        ];
    }
    
    public function __construct(EntityManager $objEntityManager)
    {
        $this->objEntityManager = $objEntityManager;
    }    
    
    public function setSwitches(EntitySwitches $objSwitches)
    {
        $this->objSwitches = $objSwitches;
    }
    
    public function getPorta():Porta
    {
        return $this->objPorta;
    }
    
    public function create(Request $objRequest)
    {
        try {
            $this->validate($objRequest);
            $this->objPorta = new Porta();
            $this->objPorta->setAdminStatus($objRequest->get('adminStatus', 'down(2)'));
            $this->objPorta->setAutoNeg($objRequest->get('autoNeg', 'auto(4)'));
            $this->objPorta->setDuplex($objRequest->get('duplex', NULL));
            $this->objPorta->setFlowCtrl($objRequest->get('flowCtrl', 'down(2)'));
            $this->objPorta->setModo($objRequest->get('modo', 'access'));
            $this->objPorta->setOperStatus($objRequest->get('operStatus', 'down(2)'));
            $this->objPorta->setPorta($objRequest->get('porta', NULL));
            $this->objPorta->setSpeed($objRequest->get('speed', NULL));
            $this->objPorta->setVlanBase($objRequest->get('vlanBase', NULL));
            $this->objPorta->setSwitch($this->objSwitches);
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
        
        $objRange = new Assert\Range(
            [
                "min" => 1,
                "minMessage" => "Esse valor deve ser '{{ limit }}' ou mais.",
                "max" => 9999999,
                "maxMessage" => "Esse valor deve ser '{{ limit }}' ou menor."
            ]
        );
        
        $objLength = new Assert\Length(
            [
                "min" => 2,
                "max" => 10,
                "minMessage" => "O campo deve ter pelo menos {{ limit }} caracteres.",
                "maxMessage" => "O campo não pode ser maior do que {{ limit }} caracteres."
            ]
        );
        
        $objChoiceAdminStatus = new Assert\Choice(
            [
                "choices" => self::getArrayChoiceAdminStatus(),
                "min" => 1,
                "message" => "O valor selecionado '{{ value }}' não é uma escolha válida.",
                "minMessage" => "Você deve selecionar pelo menos {{ limit }} opções.",
                "maxMessage" => "Você deve selecionar no máximo {{ limit }} opções."
            ]
        );
        
        $objChoiceDuplexStatus = new Assert\Choice(
            [
                "choices" => self::getArrayChoiceDuplexStatus(),
                "min" => 1,
                "message" => "O valor selecionado '{{ value }}' não é uma escolha válida.",
                "minMessage" => "Você deve selecionar pelo menos {{ limit }} opções.",
                "maxMessage" => "Você deve selecionar no máximo {{ limit }} opções."
            ]
        );
        
        $objChoiceAutoNeg = new Assert\Choice(
            [
                "choices" => self::getArrayChoicePortStatus(),
                "min" => 1,
                "message" => "O valor selecionado '{{ value }}' não é uma escolha válida.",
                "minMessage" => "Você deve selecionar pelo menos {{ limit }} opções.",
                "maxMessage" => "Você deve selecionar no máximo {{ limit }} opções."
            ]
        );
        
        $objChoiceOperStatus = new Assert\Choice(
            [
                "choices" => self::getArrayChoiceOperStatus(),
                "min" => 1,
                "message" => "O valor selecionado '{{ value }}' não é uma escolha válida.",
                "minMessage" => "Você deve selecionar pelo menos {{ limit }} opções.",
                "maxMessage" => "Você deve selecionar no máximo {{ limit }} opções."
            ]
        );
        
        $objCollection = new Assert\Collection(
            [
                'fields' => [
                    'adminStatus' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objChoiceAdminStatus
                        ]
                    ),
                    'autoNeg' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objChoiceAutoNeg
                        ]
                    ),
                    'duplex' => new Assert\Optional( [
                            $objChoiceDuplexStatus
                        ]
                    ),
                    'flowCtrl' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objLength
                        ]
                    ),
                    'modo' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objLength
                        ]
                    ),
                    'operStatus' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objChoiceOperStatus
                        ]
                    ),
                    'porta' => new Assert\Required( [
                            $objNotNull,
                            $objNotBlank,
                            $objLength
                        ]
                    ),
                    'speed' => new Assert\Optional( [
                            $objRange
                        ]
                    ),
                    'vlanBase' => new Assert\Optional( [
                            $objRange
                        ]
                    )
                ]
            ]
        );

        $data = [
            'adminStatus'   => $objRequest->get('adminStatus', 'down(2)'),
            'autoNeg'       => $objRequest->get('autoNeg', 'up(1)'),
            'duplex'        => $objRequest->get('duplex', NULL),
            'flowCtrl'      => $objRequest->get('flowCtrl', 'down(2)'),
            'modo'          => $objRequest->get('modo', 'access'),
            'operStatus'    => $objRequest->get('operStatus', 'down(2)'),
            'porta'         => $objRequest->get('porta', NULL),
            'speed'         => $objRequest->get('speed', NULL),
            'vlanBase'      => $objRequest->get('vlanBase', NULL)
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
        
        if(!($this->objSwitches instanceof EntitySwitches)){
            $this->objSwitches = $this->objEntityManager->getRepository('App\Entity\Redes\Switches')->find($objRequest->get('switchId', NULL));
            if(!($this->objSwitches instanceof EntitySwitches)){
                throw new \RuntimeException('Switch não localizado.');
            }
        }
    }
    
    public function save()
    {
        $this->objEntityManager->persist($this->objPorta);
        $this->objEntityManager->flush();
        return $this->objPorta;
    }
}
