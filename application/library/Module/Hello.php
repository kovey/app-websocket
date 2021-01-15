<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-13 14:49:41
 *
 */
namespace Module;

use Demo\Protobuf\PacketHello;

#[\Attribute]
class Hello
{
    public function world(PacketHello $hello, $fd)
    {
        $this->redis->set('kovey', $hello->getName());
        $result = $this->redis->get('kovey');
        $hello->setLabels(array('aaaa', 'bbb'));

        return array(
            'message' => $hello,
            'action' => 2001
        );
    }
}
