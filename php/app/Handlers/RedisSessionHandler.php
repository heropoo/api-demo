<?php
/**
 * Date: 2019-12-11
 * Time: 18:58
 */

namespace App\Handlers;

use Predis\Client;

class RedisSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var Client
     */
    protected $redis;
    protected $prefix = 'session:';

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function close()
    {
        $this->redis->disconnect();
        return true;
    }

    public function destroy($session_id)
    {
        $this->redis->del([$this->prefix . $session_id]);
        return true;
    }

    public function gc($maxlifetime)
    {
        return true;
    }

    public function open($save_path, $name)
    {
        $this->prefix .= $name . ':';
        return true;
    }

    public function read($session_id)
    {
        $result = $this->redis->get($this->prefix . $session_id);
        return empty($result) ? '' : $result;
    }

    public function write($session_id, $session_data)
    {
        $this->redis->setex($this->prefix . $session_id, 3600, $session_data);
        return true;
    }
}