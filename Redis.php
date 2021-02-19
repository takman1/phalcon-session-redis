<?php

namespace Takman1;

use Redis as RedisBase;

class Redis extends RedisBase
{
    public function setTimeout($key, $ttl)
    {
        $this->expire($key, $ttl);
    }
}
