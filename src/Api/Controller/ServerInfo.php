<?php
namespace Api\Controller;

use Api\Module\Facade as Facade;
use Api\Format\Factory as FormatFactory;
use Api\Format\Processor as FormatProcessor;
use Api\Config\ConfigProxy as Config;
use League\Container\Container;
use Symfony\Component\HttpFoundation\Response;

class ServerInfo
{

    public function getInfo(Container $container, $format, $pingHostname = null)
    {
        $config = $container->get('Config');
        $ip = $container->get('Request')->getClientIp();
        is_null($pingHostname) ? $config->hostToPing = $config->defaultHostToPing : $config->hostToPing = $pingHostname;
        $this->addModules($container->get('ModuleFacade'), $config);
        $renderData = $container->get('ModuleFacade')->returnModulesData();
        if ( ! $this->canUserPassWhiteList($ip, $config)) {
            $renderData = ['error' => 'Your ip is not on whitelist.'];
        }
        $response = $this->renderFormat(
            $container->get('FormatFactory'),
            $container->get('FormatProcessor'),
            $format,
            $renderData
        );
        $response->send();
    }

    private function canUserPassWhiteList($clientIp, Config $config)
    {
        if ($config->whitelistEnabled) {
            if ( ! in_array($clientIp, $config->whitelist)) {
                return false;
            }
        }
        return true;
    }

    private function renderFormat(
        FormatFactory $formatFactory,
        FormatProcessor $formatProcessor,
        $format,
        array $data
    ) {
        try {
            $formatClass = $formatFactory->createFormat($format);
        } catch (\Exception $e) {
            $data = ['error' => 'Format type not supported.'];
            $formatClass = $formatFactory->createFormat('json');
        }
        $responseData = $formatProcessor->format($formatClass, $data);
        $response = new Response($responseData);
        $response->headers->set('Content-Type', $formatClass->getHeader());
        return $response;
    }

    private function addModules(Facade $moduleFacade, Config $config)
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
