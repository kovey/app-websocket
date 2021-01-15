<?php
/**
 *
 * @description 传输协议
 *
 * @package     Packet
 *
 * @time        2019-11-16 18:14:53
 *
 * @author      kovey
 */
namespace Packet;

use Google\Protobuf\Internal\Message;
use Protocol\Packet;
use Demo\Protobuf\Base;
use Kovey\Library\Exception\CloseConnectionException;

class Protobuf
{
	/**
	 * @description 打包
	 *
	 * @param Protobuf $packet
     *
     * @param int $action
	 *
	 * @return string
	 */
	public static function pack(Message $packet, int $action)
	{
        $base = new Base();
        $base->setAction($action)
            ->setPacket($packet->serializeToString());

        return $base->serializeToString();
	}

	/**
	 * @description 解包
	 *
	 * @param string $data
	 *
	 * @return ProtocolInterface
	 *
	 * @throws Exception
	 */
	public static function unpack(string $data)
	{
        $base = new Base();
        $base->mergeFromString($data);

        return $base;
	}
}
