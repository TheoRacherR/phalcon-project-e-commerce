<?php

$loader = new \Phalcon\Loader();




$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->formsDir,
        $config->application->pluginsDir,
        $config->application->classDir,
    ]
)->register();
