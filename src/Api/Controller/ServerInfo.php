<?php
namespace Api\Controller;

use Api\Config as Config;
use Api\Module\Facade as Facade;
use Api\Format\Factory as FormatFactory;
use Api\Format\Processor as FormatProcessor;

class ServerInfo
{
    
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function getInfo($container, $format, $pingHostname = null)
    {
        is_null($pingHostname) ? $this->config->hostToPing = $this->config->defaultHostToPing : $this->config->hostToPing = $pingHostname;
        $this->addModules($container->get('ModuleFacade'), $this->config);
        $renderData = $container->get('ModuleFacade')->returnModulesData();
        if (!$this->canUserPassWhiteList($_SERVER['SERVER_ADDR'])) {
            $renderData = ['error' => 'Your ip is not on whitelist.'];
        }
        echo $this->renderFormat($container->get('FormatFactory'), $container->get('FormatProcessor'), $format, $renderData);
    }

    private function canUserPassWhiteList($clientIp)
    {
        if ($this->config->whitelistEnabled) {
            if (!in_array($clientIp, $this->config->whitelist)) {
                return false;
            }
        }
        return true;
    }

    private function renderFormat(FormatFactory $formatFactory, FormatProcessor $formatProcessor, $format, array $data)
    {
        try {
            $formatClass = $formatFactory->createFormat($format);
        } catch (\Exception $e) {
            $data = ['error' => 'Format type not supported.'];
            $formatClass = $formatFactory->createFormat('json');
        }
        $formatProcessor->setHeader($formatClass);
        return $formatProcessor->format($formatClass, $data);
    }

    private function addModules(Facade $moduleFacade, $config)
    {
        $moduleFacade->addModule(
            'System',
            [
            $config->hostToPing
            ]
        );
        $moduleFacade->addModule(
            'Mysql',
            [
            $config->mysqlHost,
            $config->mysqlUser,
            $config->mysqlPassword
            ]
        );
        $moduleFacade->addModule(
            'Memcached',
            [
            $config->memcachedIp,
            $config->memcachedPort
            ]
        );
    }
}
