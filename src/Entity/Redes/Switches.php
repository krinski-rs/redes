<?php

namespace App\Entity\Redes;

/**
 * Switches
 */
class Switches
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var int|null
     */
    private $vlanBase;

    /**
     * @var bool
     */
    private $ativo = true;

    /**
     * @var \DateTime
     */
    private $dataCadastro = 'now()';

    /**
     * @var \App\Entity\Redes\ModeloSwitch
     */
    private $modeloSwitch;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome.
     *
     * @param string $nome
     *
     * @return Switches
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return Switches
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set vlanBase.
     *
     * @param int|null $vlanBase
     *
     * @return Switches
     */
    public function setVlanBase($vlanBase = null)
    {
        $this->vlanBase = $vlanBase;

        return $this;
    }

    /**
     * Get vlanBase.
     *
     * @return int|null
     */
    public function getVlanBase()
    {
        return $this->vlanBase;
    }

    /**
     * Set ativo.
     *
     * @param bool $ativo
     *
     * @return Switches
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo.
     *
     * @return bool
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set dataCadastro.
     *
     * @param \DateTime $dataCadastro
     *
     * @return Switches
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get dataCadastro.
     *
     * @return \DateTime
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set modeloSwitch.
     *
     * @param \App\Entity\Redes\ModeloSwitch|null $modeloSwitch
     *
     * @return Switches
     */
    public function setModeloSwitch(\App\Entity\Redes\ModeloSwitch $modeloSwitch = null)
    {
        $this->modeloSwitch = $modeloSwitch;

        return $this;
    }

    /**
     * Get modeloSwitch.
     *
     * @return \App\Entity\Redes\ModeloSwitch|null
     */
    public function getModeloSwitch()
    {
        return $this->modeloSwitch;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $porta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $vlan;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->porta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vlan = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add portum.
     *
     * @param \App\Entity\Redes\Porta $portum
     *
     * @return Switches
     */
    public function addPortum(\App\Entity\Redes\Porta $portum)
    {
        $this->porta[] = $portum;

        return $this;
    }

    /**
     * Remove portum.
     *
     * @param \App\Entity\Redes\Porta $portum
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePortum(\App\Entity\Redes\Porta $portum)
    {
        return $this->porta->removeElement($portum);
    }

    /**
     * Get porta.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPorta()
    {
        return $this->porta;
    }

    /**
     * Add vlan.
     *
     * @param \App\Entity\Redes\Vlan $vlan
     *
     * @return Switches
     */
    public function addVlan(\App\Entity\Redes\Vlan $vlan)
    {
        $this->vlan[] = $vlan;

        return $this;
    }

    /**
     * Remove vlan.
     *
     * @param \App\Entity\Redes\Vlan $vlan
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVlan(\App\Entity\Redes\Vlan $vlan)
    {
        return $this->vlan->removeElement($vlan);
    }

    /**
     * Get vlan.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVlan()
    {
        return $this->vlan;
    }
}
