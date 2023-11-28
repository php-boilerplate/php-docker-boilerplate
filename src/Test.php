<?php

namespace My\Site;

class Test {
    public static function test() {
        // connect to mysql and get version
        $mysqli = new \mysqli('127.0.0.1', 'user', 'userpass');
        echo "MySQL:$mysqli->server_info\n";

        // connect to redis and get version
        $redis = new \Redis();
        $redis->connect('localhost');
        echo "Redis:" . $redis->info()['redis_version'] . "\n";

        // example of warning
        $a = [];
        $a['some'];

        phpinfo();
    }
}