<?php

$loader = new \Phalcon\Loader();




$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->formsDir
        // 'PhalconDemo\Controllers' => DOCROOT . $config->get('application')->controllersDir,
        // 'PhalconDemo\Forms' => DOCROOT . $config->get('application')->formsDir,
        // 'PhalconDemo\Models'      => DOCROOT . $config->get('application')->modelsDir,
    ]
)->register();
