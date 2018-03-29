<?php
namespace App\Util\Switches;

interface SocketInterface
{
    public function connect(string $address, int $port = NULL):bool;
    public function disconnect():bool;
}

