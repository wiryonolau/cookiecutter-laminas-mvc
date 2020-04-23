<?php
declare(strict_types=1);

namespace Application;

use Laminas\Stdlib\ArrayUtils;

class Module
{
    public function getConfig() {
        $config = array();

        $configFiles = array(
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/route.config.php',
            include __DIR__ . '/../config/service.config.php',
        );


        foreach ($configFiles as $file) {
            $config = ArrayUtils::merge($config, $file);
        }

        return $config;
    }


}
