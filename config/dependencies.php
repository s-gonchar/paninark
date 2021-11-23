<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
/**
 * @param \Interop\Container\ContainerInterface $c
 * @return \Slim\Views\PhpRenderer
 */
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache']
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

$container['redis'] = function($c) {
    $settings = $c->get('settings')['redis'];
    $redis = new \Predis\Client(
        $settings['connection']
    );

    return $redis;
};