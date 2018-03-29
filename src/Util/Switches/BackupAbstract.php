<?php
namespace App\Util\Switches;

use Psr\Log\LoggerInterface;

abstract class BackupAbstract implements BackupInterface
{
    
    const PORT                  = 23;
    const TIME_OUT              = 10;
    
    private $objLoggerInterface = NULL;
    private $objDate            = NULL;
    private $socket             = NULL;
    private $host               = '';
    private $port               = 0;
    private $command            = '';
    
    public function __construct(LoggerInterface $objLoggerInterface)
    {
        $this->objLoggerInterface   = $objLoggerInterface;
        $this->objDate              = new \DateTime();
        $this->socket               = socket_create(AF_INET, SOCK_STREAM, 0);
        if(!$this->socket){
            throw new \RuntimeException(socket_strerror(socket_last_error()));
        }
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::setHost()
     */
    public function setHost(string $host): BackupInterface
    {
        $this->host = $host;
        // TODO Auto-generated method stub
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::setPort()
     */
    public function setPort(int $port): BackupInterface
    {
        $this->port = $port;
        // TODO Auto-generated method stub
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::getHost()
     */
    public function getHost(): string
    {
        // TODO Auto-generated method stub
        return $this->host;
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::getPort()
     */
    public function getPort(): int
    {
        // TODO Auto-generated method stub
        return $this->port;
    }
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::getSocket()
     */
    public function getSocket()
    {
        // TODO Auto-generated method stub
        return $this->socket;
    }
    
    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::getCommand()
     */
    public function getCommand(): string
    {
        // TODO Auto-generated method stub
        return $this->command;
    }

    /**
     * {@inheritDoc}
     * @see \App\Util\Switches\BackupInterface::setCommand()
     */
    public function setCommand(string $command): BackupInterface
    {
        // TODO Auto-generated method stub
        $this->command = $command;
        return $this;
    }

    public function __destruct()
    {
        if($this->getSocket()){
            socket_close($this->getSocket());
        }
    }
}
