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
use Kovey\Container\Event;
use Demo\Protobuf;

class Hello extends HandlerAbstract
{
    #[Module\Hello]
    private $hello;

    #[Event\Protocol(1001, Protobuf\PacketHello::class, Protobuf\Base::class)]
    public function world($message, $fd)
    {
        return $this->hello->world($message, $fd);
    }
}
