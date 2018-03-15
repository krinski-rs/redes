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
    private $vlan;

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
     * Set vlan.
     *
     * @param int|null $vlan
     *
     * @return Switches
     */
    public function setVlan($vlan = null)
    {
        $this->vlan = $vlan;

        return $this;
    }

    /**
     * Get vlan.
     *
     * @return int|null
     */
    public function getVlan()
    {
        return $this->vlan;
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
}
