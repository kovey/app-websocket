<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-13 14:47:38
 *
 */
namespace Handler;

use Module;
use Kovey\Websocket\Handler\HandlerAbstract;
use Kovey\Container\Event\Redis;

class Hello extends HandlerAbstract
{
    #[Module\Hello]
    private $hello;

    #[Redis('master')]
    public function world($message, $fd)
    {
        return $this->hello->world($message, $fd);
    }
}
