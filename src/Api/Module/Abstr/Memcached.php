<?php
namespace Api\Module\Abstr;

use Api\Exception\Module as ModuleException;
use Api\Contract\Module\ModuleInterface as ModuleInterface;

abstract class Memcached implements ModuleInterface
{

    private $ip = null;
    private $port = null;
    private $memcached = null;

    public function __construct()
    {
        if (func_num_args() != 2) {
            throw new \InvalidArgumentException('Bad number of arguments');
        }
        if (! class_exists('\Memcached')) {
            throw new ModuleException('Can\'t find Memcached class');
        }
        
        list($ip, $port) = func_get_args();
        $this->memcached = new \Memcached();
        $this->memcached->addServer($ip, $port);
        $this->ip = $ip;
        $this->port = $port;
    }

    public function returnData()
    {
        $memcachedStats = $this->memcached->getstats();
        $statsArr = $memcachedStats[$this->ip . ":" . $this->port];
        return array(
            'memcache_get'       => $statsArr['cmd_get'],
            'memcache_hits'      => $statsArr['get_hits'],
            'memcache_miss'      => $statsArr['get_misses'],
            'memcache_max_bytes' => $statsArr['limit_maxbytes'],
            'memcache_bytes'     => $statsArr['bytes_written']
        );
    }
}
