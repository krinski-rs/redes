<?php
namespace App\Util\Switches;

use Psr\Log\LoggerInterface;

class Backup extends BackupAbstract
{    
    public function __construct(LoggerInterface $objLoggerInterface)
    {
        parent::__construct($objLoggerInterface);
    }
    
    public function backup(): BackupInterface
    {
        
        $this->connect();
        $this->send();
        return $this;
    }

    public function connect(): BackupInterface
    {
        if(!$this->getPort()){
            $this->setPort(self::PORT);
        }
        
        if(!socket_connect($this->getSocket(), $this->getHost(), $this->getPort())){
            throw new \RuntimeException(socket_strerror(socket_last_error($this->getSocket())));
        }
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::send()
     */
    public function send()
    {
        // TODO Auto-generated method stub
        socket_write($this->getSocket(), $this->getCommand()."\n", strlen($this->getCommand()));
        
        echo socket_strerror(socket_last_error($this->getSocket()));
        
        while($buf = socket_read($this->getSocket(), 2048)){
            if($buf = trim($buf))
                break;
            print_r($buf);
        }
        
    }
}

