<?php

namespace Takman1\Phalcon\Cache\Backend;

use Exception;
use Phalcon\Cache\Backend\Redis as RedisCacheBackend;
use Phalcon\Cache\FrontendInterface;
use Takman1\Redis as RedisBase;

class Redis extends RedisCacheBackend
{
    public function __construct(FrontendInterface $frontend, $options = null)
    {
        parent::__construct($frontend, $options);
        $this->_redis = null;
    }

    /**
     * @throws Exception
     */
    public function _connect()
    {
        $options = $this->_options;
        $redis = new RedisBase();

        if (!isset($options['host'], $options['port'], $options['persistent'], $options['timeout'])) {
            throw new Exception('Unexpected inconsistency in options');
        }

        $method = $options['persistent'] ? 'pconnect' : 'connect';
        if (!$redis->$method($options['host'], $options['port'], $options['timeout'])) {
            throw new Exception(
                'Could not connect to the Redis server ' . $options['host'] . ':' . $options['port']
            );
        }

        if (!empty($options['auth']) && !$redis->auth($options['auth'])) {
            throw new Exception('Failed to authenticate with the Redis server');
        }

        if (!empty($options['index']) && $options['index'] > 0 && !$redis->select($options['index'])) {
            throw new Exception('Redis server selected database failed');
        }

        $this->_redis = $redis;
    }
}
