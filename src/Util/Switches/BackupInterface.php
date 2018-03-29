<?php
namespace App\Util\Switches;

interface BackupInterface
{
    public function connect(): BackupInterface;
    public function backup(): BackupInterface;
    public function getSocket();
    
    public function getCommand():string;
    
    public function setCommand(string $command):BackupInterface;
    
    /**
     *
     * @param string $host
     * @return \App\Util\Switches\BackupInterface
     *
     */
    public function setHost(string $host):BackupInterface;
    
    /**
     *
     * @param int $port
     * @return \App\Util\Switches\BackupInterface
     *
     */
    public function setPort(int $port):BackupInterface;
    
    /**
     *
     * @return string
     *
     */
    public function getHost():string;
    
    /**
     *
     * @return int
     *
     */
    public function getPort():int;
    
    public function send();
}
