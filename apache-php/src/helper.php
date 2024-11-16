<?php
const
host = 'db',
dbUser = 'user',
password = 'password',
db = 'appDb';

function openMysqli(): mysqli
{
    return new mysqli(
        host, dbUser, password, db
    );
}

function hash_password($password): string {
    $result = "{SHA}";
    $sha = sha1($password);
    $hash = base64_encode(pack("H".strlen($sha), $sha));
    $result = $result . $hash;
    return $result;
}

function openRedis(): Redis {
    $redis = new Redis();
    $redis->connect("redis", 6379);
    return $redis;
}