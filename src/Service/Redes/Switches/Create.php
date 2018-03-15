<?php
namespace App\Service\Redes\Switches;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\EntityManager;
use App\Entity\Redes\SwitchesDatacom3224F2;
use App\Entity\Redes\SwitchesLinksysSRW2024;
use App\Entity\Redes\SwitchesLinksysSRW224G4;
use App\Entity\Redes\SwitchesMikrotik;
use App\Entity\Redes\SwitchesCiscoCatalyst2950;
use App\Entity\Redes\SwitchesCiscoSF300;
use App\Entity\Redes\SwitchesLinksysSRW2024G4;
use App\Entity\Redes\SwitchesExtremeSummit250e;
use App\Entity\Redes\SwitchesExtremeSummitX450a48t;
use App\Entity\Redes\SwitchesExtremeSummitX35024t;
use App\Entity\Redes\SwitchesExtremeSummitX35048t;
use App\Entity\Redes\SwitchesCiscoCatalyst2970;
use App\Entity\Redes\SwitchesDatacom3224F3;
use App\Entity\Redes\Porta;
use App\Entity\Redes\Switches as EntitySwitches;

class Create
{
    const SWITCH_DATACOM_3224F2             = 1;
    const SWITCH_LINKSYS_SRW2024            = 2;
    const SWITCH_LINKSYS_SRW224G4           = 3;
    const SWITCH_MIKROTIK                   = 4;
    const SWITCH_CISCO_CATALYST2950         = 5;
    const SWITCH_CISCO_SF300                = 6;
    const SWITCH_LINKSYS_SRW2024G4          = 7;
    const SWITCH_EXTREME_SUMMIT_250E        = 8;
    const SWITCH_EXTREME_SUMMIT_X450a48t    = 9;
    const SWITCH_EXTREME_SUMMIT_X35024t     = 10;
    const SWITCH_EXTREME_SUMMIT_X35048t     = 11;
    const SWITCH_CISCO_CATALYST2970         = 12;
    const SWITCH_DATACOM_3224F3             = 13;
    
    private $objEntityManager       = NULL;
    private $objSwitches            = NULL;
    
    public function __construct(EntityManager $objEntityManager)
    {
        $this->objEntityManager = $objEntityManager;
    }
    
    public static function createPort(EntitySwitches $objSwitches)
    {
        try {
            echo "\n\t\t".get_class($objSwitches);
            switch (get_class($objSwitches)){
                case 'App\Entity\Redes\SwitchesDatacom3224F2':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 25, 28, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesLinksysSRW2024':
                    self::addPorta('GE', 1, 24, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesLinksysSRW224G4':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 1, 4, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesMikrotik':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesCiscoCatalyst2950':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesCiscoSF300':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 1, 4, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesLinksysSRW2024G4':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 1, 4, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesExtremeSummit250e':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 25, 26, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesExtremeSummitX450a48t':
                    self::addPorta('GE', 1, 48, $objSwitches);
                    self::addPorta('10GE', 49, 50, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesExtremeSummitX35024t':
                    self::addPorta('FE', 1, 20, $objSwitches);
                    self::addPorta('GE', 21, 24, $objSwitches);
                    self::addPorta('10GE', 25, 26, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesExtremeSummitX35048t':
                    self::addPorta('GE', 1, 48, $objSwitches);
                    self::addPorta('10GE', 49, 50, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesCiscoCatalyst2970':
                    self::addPorta('GE', 1, 24, $objSwitches);
                    break;
                case 'App\Entity\Redes\SwitchesDatacom3224F3':
                    self::addPorta('FE', 1, 24, $objSwitches);
                    self::addPorta('GE', 25, 28, $objSwitches);
                    break;
                default:
                    throw new \RuntimeException('Modelo de switch não encontrado.');
                    break;
            }
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    
    private function addPorta(string $portName, int $start, int $limit, EntitySwitches $objSwitches)
    {
        while($start <= $limit){
            $porta = $portName.str_pad($start, 2, '0', STR_PAD_LEFT);
            $objPorta = new Porta();
            $objPorta->setAdminStatus('down(2)');
            $objPorta->setAutoNeg('up(1)');
//             $objPorta->setDuplex($duplex);
            $objPorta->setFlowCtrl('down(2)');
            $objPorta->setModo('access');
            $objPorta->setOperStatus('down(2)');
            $objPorta->setPorta($porta);
//             $objPorta->setSpeed($speed);
            $objPorta->setSwitch($objSwitches);
            //$objPorta->setVlanBase($vlanBase);
            
            $objSwitches->addPorta($objPorta);
            $start++;
        }
        
    }
    
    public function create(Request $objRequest)
    {
        try {
            
            $this->validate($objRequest);
            switch ($objRequest->get('modeloSwitchId', NULL)){
                case self::SWITCH_DATACOM_3224F2:
                    $this->objSwitches = new SwitchesDatacom3224F2();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 25, 28, $this->objSwitches);
                    break;
                case self::SWITCH_LINKSYS_SRW2024:
                    $this->objSwitches = new SwitchesLinksysSRW2024();
//                     $this->addPorta('GE', 1, 24, $this->objSwitches);
                    break;
                case self::SWITCH_LINKSYS_SRW224G4:
                    $this->objSwitches = new SwitchesLinksysSRW224G4();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 1, 4, $this->objSwitches);
                    break;
                case self::SWITCH_MIKROTIK:
                    $this->objSwitches = new SwitchesMikrotik();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
                    break;
                case self::SWITCH_CISCO_CATALYST2950:
                    $this->objSwitches = new SwitchesCiscoCatalyst2950();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
                    break;
                case self::SWITCH_CISCO_SF300:
                    $this->objSwitches = new SwitchesCiscoSF300();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 1, 4, $this->objSwitches);
                    break;
                case self::SWITCH_LINKSYS_SRW2024G4:
                    $this->objSwitches = new SwitchesLinksysSRW2024G4();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 1, 4, $this->objSwitches);
                    break;
                case self::SWITCH_EXTREME_SUMMIT_250E:
                    $this->objSwitches = new SwitchesExtremeSummit250e();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 25, 26, $this->objSwitches);
                    break;
                case self::SWITCH_EXTREME_SUMMIT_X450a48t:
                    $this->objSwitches = new SwitchesExtremeSummitX450a48t();
//                     $this->addPorta('GE', 1, 48, $this->objSwitches);
//                     $this->addPorta('10GE', 49, 50, $this->objSwitches);
                    break;
                case self::SWITCH_EXTREME_SUMMIT_X35024t:
                    $this->objSwitches = new SwitchesExtremeSummitX35024t();
//                     $this->addPorta('FE', 1, 20, $this->objSwitches);
//                     $this->addPorta('GE', 21, 24, $this->objSwitches);
//                     $this->addPorta('10GE', 25, 26, $this->objSwitches);
                    break;
                case self::SWITCH_EXTREME_SUMMIT_X35048t:
                    $this->objSwitches = new SwitchesExtremeSummitX35048t();
//                     $this->addPorta('GE', 1, 48, $this->objSwitches);
//                     $this->addPorta('10GE', 49, 50, $this->objSwitches);
                    break;
                case self::SWITCH_CISCO_CATALYST2970:
                    $this->objSwitches = new SwitchesCiscoCatalyst2970();
//                     $this->addPorta('GE', 1, 24, $this->objSwitches);
                    break;
                case self::SWITCH_DATACOM_3224F3:
                    $this->objSwitches = new SwitchesDatacom3224F3();
//                     $this->addPorta('FE', 1, 24, $this->objSwitches);
//                     $this->addPorta('GE', 25, 28, $this->objSwitches);
                    break;
                default:
                    throw new \RuntimeException('Modelo de switch não encontrado.');
                    break;
            }
            $this->objSwitches->setAtivo(TRUE);
            $this->objSwitches->setDataCadastro(new \DateTime());
            $this->objSwitches->setIp($objRequest->get('ip', NULL));
            $this->objSwitches->setNome($objRequest->get('nome', NULL));
            $this->objSwitches->setVlan($objRequest->get('vlan', NULL));
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
    }
    
    public function save()
    {
        $this->objEntityManager->persist($this->objSwitches);
        $this->objEntityManager->flush();
        return $this->objSwitches;
    }
}
