<?php

if (!function_exists('app_namespace')) {
    function app_namespace()
    {
        return app('Luissobrinho\LCrud\Services\AppService')
            ->getAppNamespace();
    }
}
