<?php

use League\Flysystem\Sftp\SftpAdapter;

return [
    'users' => [
        'login_1' => 'password',
        'login_2' => 'password',
    ],
    'url' => 'https://screenshot.example.com/',
    'adapter' => new SftpAdapter([
        'host' => 'ftp.example.com',
        'username' => 'Bill',
        'password' => 'Gates',
        'port' => 22,
        'root' => '/screenshots/',
        'passive' => true,
        'ssl' => true,
        'timeout' => 10,
        'ignorePassiveAddress' => false,
    ]),
];