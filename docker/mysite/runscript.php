<?php

if (function_exists('xdebug_disable')) {
    xdebug_disable();
}

var_dump('docker start');

$files = [
    '/var/log/redis/redis-server.log',
    '/var/log/nginx/access.log',
    '/var/log/nginx/error.log',
    '/var/log/php_errors.log',
    '/var/log/php8.1-fpm.log',
    '/var/log/mysql/error.log',
    '/var/log/mysql-slow.log',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        continue;
    }
    touch($file);
    chmod($file, 0777);
    echo 'created file: ' . $file . PHP_EOL;
}

$command = "tail -f $(find /var/log -type f -iname '*log') & for i in  $(seq 1 288000) ; do sleep 5 ; echo ; done ;";
system($command);