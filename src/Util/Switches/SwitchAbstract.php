<?php
namespace App\Util\Switches;

use App\Entity\Redes\Switches;

abstract class SwitchAbstract implements SwitchInterface
{
    private $objSNMP        = NULL;
    private $objSwitches    = NULL;
    
    public function __construct(Switches $objSwitches)
    {
        $this->objSNMP = new \SNMP(\SNMP::VERSION_1, $objSwitches->getIp(), 'stechtelecom');
        $this->objSwitches = $objSwitches;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::status()
     */
    public function status(): array
    {
        $arrayRetorno = [];
        array_push($arrayRetorno, ["sysDescr", trim(str_replace('STRING:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.1')))]);
        array_push($arrayRetorno, ["sysObjectID", trim(str_replace('OID:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.2')))]);
        array_push($arrayRetorno, ["sysUpTimeInstance", trim(str_replace('Timeticks:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.3')))]);
        array_push($arrayRetorno, ["sysContact", trim(str_replace('STRING:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.4')))]);
        array_push($arrayRetorno, ["sysName", trim(str_replace('STRING:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.5')))]);
        array_push($arrayRetorno, ["sysLocation", trim(str_replace('STRING:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.6')))]);
        array_push($arrayRetorno, ["sysServices", trim(str_replace('INTEGER:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.7')))]);
        array_push($arrayRetorno, ["sysORLastChange", trim(str_replace('Timeticks:', '', $this->objSNMP->getnext('iso.3.6.1.2.1.1.8')))]);
        return $arrayRetorno;
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::backup()
     */
    public function backup(): SwitchInterface
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getAdminStatus()
     * up(1)
     * down(2)
     * testing(3)   
     */
    public function getAdminStatus(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('ifAdminStatus');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getAlias()
     */
    public function getAlias(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('ifAlias');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getName()
     */
    public function getName(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('ifName');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getOperStatus()
     * up(1)
     * down(2)
     * testing(3)
     * unknown(4)
     * dormant(5)
     * notPresent(6)
     * lowerLayerDown(7)
     */
    public function getOperStatus(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('ifOperStatus');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getStatsDuplexStatus()
     * 1-unknown
     * 2-halfDuplex
     * 3-fullDuplex
     */
    public function getStatsDuplexStatus(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('dot3StatsDuplexStatus');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getVlanType()
     * 1 : static
     * 2 : dynamic
     * 3 : multiVlan

     */
    public function getVlanType(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.4.1.9.9.68.1.2.2.1.1');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getVmVlan()

     */
    public function getVmVlan(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.4.1.9.9.68.1.2.2.1.2');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getVmPortStatus()
     * 1 : inactive
     * 2 : active
     * 3 : shutdown

     */
    public function getVmPortStatus(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.4.1.9.9.68.1.2.2.1.3');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getPortDuplex()
     * 1 : half
     * 2 : full
     * 3 : disagree
     * 4 : auto

     */
    public function getPortDuplex(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.4.1.9.5.1.4.1.1.10');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getPortSpeed()
     */
    public function getPortSpeed(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.2.1.2.2.1.5');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\SwitchInterface::getPortSpeed()
     */
    public function getDescr(): array
    {
        // TODO Auto-generated method stub
        $arrayAlias = $this->objSNMP->walk('iso.3.6.1.2.1.2.2.1.2');
        
        if(!is_array($arrayAlias)){
            $arrayAlias = [];
        }
        
        return $arrayAlias;
    }
    
    public function __destruct()
    {
        if($this->objSNMP instanceof \SNMP){
            $this->objSNMP->close();
            unset($this->objSNMP);
        }
    }
}
