<?php
namespace App\Util\Switches;

abstract class SocketAbstract implements SocketInterface
{
    private $socket = NULL;
    
    public function __construct(string $address, int $port = NULL)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(!$this->socket){
            throw new \RuntimeException('Erro ao criar o socket.');
        }
        
        if(!$this->connect($address, $port)){
            throw new \RuntimeException('Falha na conexão com o host "$address".');
        }
    }
    
    public function disconnect():bool
    {
        if($this->socket){
            socket_close($this->socket);
        }
        return true;
    }
    
    public function __destruct()
    {
        if($this->socket){
            $this->disconnect();
        }
    }
}

