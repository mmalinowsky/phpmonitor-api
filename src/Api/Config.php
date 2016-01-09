<?php
namespace Api;

/**
 * @property mixed $memcachedIp
 * @property mixed $memcachedPort
 * @property mixed $mysqlHost
 * @property mixed $mysqlUser
 * @property mixed $mysqlPassword
 * @property mixed $whitelistEnabled
 * @property mixed $whitelist
 * @property mixed $defaultHostToPing
 * @property mixed $hostToPing
 */
class Config
{

    private $data = array();
    
    public function __construct()
    {
        $this->data['memcachedIp'] = 'localhost';
        $this->data['memcachedPort'] = 11211;

        $this->data['mysqlHost'] = 'localhost';
        $this->data['mysqlUser'] = 'root';
        $this->data['mysqlPassword'] = '';

        $this->data['whitelistEnabled']=false;
        $this->data['whitelist'][]='127.0.0.1';

        $this->data['defaultHostToPing'] = "google.com";
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
