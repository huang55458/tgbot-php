<?php

function jdd($var, $name=null)
{
    header('Content-Type: application/json; charset=utf-8');
    if(is_scalar($name)){
        $var = [$name=>$var];
    }
    echo json_encode($var, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    die;
}


function cmmLog($message, $level = 'debug')
{
    if (is_array($message)) {
        $message = json_encode($message, JSON_UNESCAPED_UNICODE);
    }
    $log_content = [
        date('Y-m-d_H:i:s'),
        $level,
//        microtime(true),
        $message,
    ];
    $path        = BASE_PATH . "logs";
    $filename    = $path . "/cmmLog_" . date('Y-m-d') . ".log";
    if (!is_dir(dirname($filename)) && !mkdir($concurrentDirectory = dirname($filename), 0777, true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }
    $f = file_put_contents($filename, implode(' ', $log_content) . "\n", FILE_APPEND);
    jdd($f);
}
