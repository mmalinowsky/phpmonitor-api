<?php
namespace Api\Module\Abstr;

use Api\Module\ModuleInterface;

abstract class System implements ModuleInterface
{
    
    private $pingHost;
    
    public function __construct()
    {
        if (func_num_args() < 1) {
            throw new \InvalidArgumentException('Bad number of arguments given');
        }
        list($host) = func_get_args();
        $this->pingHost = $host;
    }

    public function returnData()
    {
        $meminfo = $this->getMemory();
        return array(
            'hostname'     => $this->getHostname(),
            'sys_load'     => $this->getAvgLoad(),
            'cpu_cores'    => $this->getCores(),
            'disk_free'    => $this->getDiskfree(),
            'disk_total'   => $this->getDiskTotal(),
            'memory_usage' => $meminfo['MemTotal'] - $meminfo['MemFree'],
            'memory_total' => $meminfo['MemTotal'],
            'memory_free'  => $meminfo['MemFree'],
            'disk_usage'   => $this->getDiskTotal() - $this->getDiskFree(),
            'ping'         => $this->getPing($this->pingHost)
        );
    }

    protected function getPing($server_host, $port = 80, $timeout = 1)
    {
        $ret = 0;
        if (!function_exists('fSockOpen')) {
            return 0;
        }
        $ping_start = microtime(true);
        $fP = @fSockOpen($server_host, $port, $errno, $errstr, $timeout);
        $ping_end = microtime(true);
        if (is_resource($fP)) {
            $ret = round((($ping_end - $ping_start) * 1000), 0);
            fclose($fP);
        }
        return $ret;
    }

    protected function getHostname()
    {
        if (!function_exists("gethostname")) {
            $ip = $_SERVER['SERVER_ADDR'];
            return gethostbyaddr($ip);
        }

        return gethostname();
    }

    protected function getDiskTotal()
    {
        if (!function_exists('disk_total_space')) {
            return 0;
        }
        return (float)@disk_total_space("/");
    }

    protected function getDiskFree()
    {
        if (!function_exists('disk_free_space')) {
            return 0;
        }
        return (float)disk_free_space("/");
    }

    protected function getAvgLoad()
    {
        if (!function_exists('sys_getloadavg')) {
            return 0;
        }
        
        $ret = sys_getloadavg();
        return (float)$ret[0];
    }

    protected function getMemory()
    {
        $meminfoFile = file_get_contents('/proc/meminfo', false);
        if ((bool)$meminfoFile === false) {
            return 0;
        }

        $data = explode("\n", $meminfoFile);
        $meminfo = [];
        foreach ($data as $line) {
            if (count(explode(":", $line)) >= 2) {
                list($key, $val) = explode(":", $line);
                $meminfo[$key] = trim($val * 1024);
            }
        }
        if (isset($meminfo['Active'])) {
            $meminfo['MemFree'] = $meminfo['Active'];
        }
        if (isset($meminfo['Available'])) {
            $meminfo['MemFree'] = $meminfo['MemAvailable'];
        }
        return $meminfo;
    }

    protected function getCores()
    {
        if (!is_readable('/proc/stat')) {
            return 0;
        }
        
        $coreFile = file_get_contents('/proc/stat', false);
        if ($coreFile == false) {
            return 0;
        }

        $coreFile = explode("\n", $coreFile);
        $cores = 0;
        foreach ($coreFile as $line) {
            if (preg_match('/cpu[0-9]/', $line)) {
                $cores++;
            }
        }
        return (int)$cores;
    }
}
