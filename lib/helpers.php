<?php
spl_autoload_register('autoLoader');

/**
 * Method for autoload all the classes within directory
 * @param $class
 * @param null $dir
 */
function autoLoader($class, $dir = null)
{
    $namespace = 'Valitor';
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "IValitorCommunicationLogger.class.php");

    if (0 !== strpos($class, $namespace)) {
        return;
    }

    if (is_null($dir)) {
        $dir = dirname(__FILE__);
    }
    //Load the Valitor SDK version
    //TODO: refactor this
    include_once $dir . DIRECTORY_SEPARATOR . "VALITOR_VERSION.php";

    $listDir = scandir(realpath($dir));
    if (isset($listDir) && !empty($listDir)) {
        foreach ($listDir as $listDirkey => $subDir) {
            if ($subDir == '.' || $subDir == '..') {
                continue;
            }
            $file = $dir . DIRECTORY_SEPARATOR . $subDir . DIRECTORY_SEPARATOR . $class . '.class.php';
            if (file_exists($file)) {
                require_once $file;
                break;
            }
        }
    }
}
