<?php
/**
 * @description
 *
 * @package
 *
 * @author kovey
 *
 * @time 2021-01-13 14:47:10
 *
 */
use Kovey\Library\Config\Manager;
use Kovey\Rpc\Server\Port;
use Kovey\Rpc\App\AppBase;
use Kovey\Rpc\App\Bootstrap\Autoload;
use Kovey\Library\Exception\CloseConnectionException;
use Kovey\Library\Exception\ProtocolException;
use Kovey\Websocket\Event as TE;
use Kovey\App\Event;
use Packet\Protobuf as PP;
use Demo\Protobuf;

class Bootstrap
{
    public function __initRpc($app)
    {
        $port = new Port($app->getServer()->getServ(), Manager::get('server.rpc'));
        $autoload = new Autoload();
        $autoload->register();
        $appBase = new AppBase(Manager::get('server'));
        $appBase->registerServer($port)
                ->registerAutoload($autoload)
                ->registerContainer($app->getContainer());
        $app->registerOtherApp('rpc', $appBase);
    }

	public function __initEvents($app)
	{
		$app->on('run_handler', function (TE\RunHandler $event) {
			try {
				return call_user_func(array($event->getHandler(), $event->getMethod()), $event->getMessage(), $event->getFd());
			} catch (ProtocolException $e) {
                Logger::writeExceptionLog(__LINE__, __FILE__, $e, $handler->traceId);
                $error = new Protobuf\Error();
                $error->setMsg($e->getMessage())
                    ->setCode($e->getCode());
                return array(
                    'action' => 500,
                    'message' => $error
                );
			} catch (BusiException $e) {
                Logger::writeExceptionLog(__LINE__, __FILE__, $e, $handler->traceId);
                $error = new Protobuf\Error();
                $error->setMsg($e->getMessage())
                    ->setCode($e->getCode());
                return array(
                    'action' => 500,
                    'message' => $error
                );
			}
        })
	    ->on('error', function (TE\Error $event) {
            $error = new Protobuf\Error();
            $error->setMsg(is_string($event->getError()) ? $event->getError() : $event->getError()->getMessage())
                ->setCode(1000);
            return array(
                'action' => 500,
                'message' => $error
            );
		})
        ->on('monitor', function (Event\Monitor $event) {
            // monitor process
            // some code here
        })
        ->serverOn('error', function (TE\Error $event) {
            $error = new Protobuf\Error();
            $error->setMsg(is_string($event->getError()) ? $event->getError() : $event->getError()->getMessage())
                ->setCode(1000);
            return array(
                'action' => 500,
                'message' => $error
            );
        })
        ->serverOn('close', function (TE\Close $event) use ($app) {
            // some code here
        })
        ->serverOn('open', function (TE\Open $event) use ($app) {
            // some code here
        });
	}
}
