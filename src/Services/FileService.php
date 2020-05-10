<?php

namespace Luissobrinho\LCrud\Services;

use Illuminate\Filesystem\Filesystem;

class FileService
{
    public function mkdir($path, $mode, $recursive)
    {
        if (! is_dir($path)) {
            mkdir($path, $mode, $recursive);
        }
    }

    public function get($file)
    {
        $filesystem = new Filesystem();
        $templateSource = config('lcrud.template_source');
        $orginalFileSource = __DIR__.'/../Templates/Laravel/';

        if (is_null($templateSource)) {
            $templateSource = base_path('resources/lcrud');
        }

        if (! file_exists($file)) {
            $file = str_replace($templateSource, $orginalFileSource, $file);
        }

        return $filesystem->get($file);
    }
}
