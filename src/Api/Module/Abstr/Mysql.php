<?php
namespace Api\Module\Abstr;

use Api\Exception\Api as ApiException;
use Api\Module\ModuleInterface;

abstract class Mysql implements ModuleInterface
{
    
    private $mysqlHandler;

    public function __construct()
    {
        if (func_num_args() != 3) {
            throw new \InvalidArgumentException('Bad number of arguments given');
        }

        list($hostname, $user, $password) = func_get_args();
        $this->connect($hostname, $user, $password);
    }

    private function connect($hostname, $user, $password)
    {
        if (!class_exists('\mysqli')) {
            throw new ApiException('Mysqli class not found');
        }

        $this->mysqlHandler = @new \mysqli($hostname, $user, $password);

        if ($this->mysqlHandler->connect_errno || !$this->mysqlHandler) {
            throw new ApiException('Can\'t Connect to Mysql');
        }
    }

    public function returnData()
    {
        $status = explode('  ', mysqli_stat($this->mysqlHandler));
        foreach ($status as $k => $v) {
            $v = explode(':', $v, 2);
            $status[$k] = (float)$v[1];
        }
        
        return array(
            'mysql_slow_query' => $status[3],
            'mysql_query_avg' => $status[7]
        );
    }
}
