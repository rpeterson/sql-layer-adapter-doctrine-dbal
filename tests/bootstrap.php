<?php

/** @var  \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Doctrine\Tests', realpath(__DIR__ . '/../vendor/doctrine/dbal/tests'));
