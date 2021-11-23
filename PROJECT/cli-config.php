<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$settings = include 'src/settings.php';
$settings = $settings['settings']['doctrine'];


$config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache']
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);