<?php
namespace Api\Module\Windows;

class System extends \Api\Module\Abstr\System
{
    protected function getAvgLoad()
    {
        $wmi = new \COM("Winmgmts://");
        $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
        $load_total = 0;
           
        foreach ($server as $cpu) {
            $load_total += $cpu->loadpercentage;
        }
           
        return (float)$load_total / 100;
    }

    protected function getMemory()
    {
        $memory = [];
        exec('wmic memorychip get capacity', $totalMemory);
        $memory['MemTotal'] = array_sum($totalMemory);
        exec('wmic OS get FreePhysicalMemory /Value 2>&1', $output, $return);
        $memory['MemFree'] = substr($output[2], 19) * 1024;
        return $memory;
    }

    protected function getCores()
    {
        $process = @popen('wmic cpu get NumberOfCores', 'rb');
        if (false !== $process) {
            fgets($process);
            $cores= intval(fgets($process));
            pclose($process);
            return $cores;
        }
        return 0;
    }
}
