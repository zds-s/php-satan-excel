<?php
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
function includeAll(?string $dirs_path = null)
{
    $notIncludes = [
        'read.php','writer.php','.','..','read_listener.php'
    ];
    $dirs_path = $dirs_path ?? __DIR__;
    foreach (scandir($dirs_path) as $dir) {
        if (in_array($dir,$notIncludes))
        {
            continue;
        }
        $pathFile = $dirs_path.DIRECTORY_SEPARATOR.$dir;
        if (is_dir($pathFile)){
            includeAll($pathFile);
            continue;
        }
        $pathinfo = pathinfo($pathFile);
        if ($pathinfo['extension'] === 'php'){
            require_once $pathFile;
        }
    }
}
includeAll();