<?php

require __DIR__ . '/../vendor/autoload.php';

use League\Flysystem\Filesystem;
use Ramsey\Uuid\Uuid;

$config = require_once __DIR__ . '/../config.php';
$users = $config['users'];
$adapter = $config['adapter'];
$url = $config['url'];
$login = isset($_POST["username"]) ? $_POST["username"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';

if (!isset($config['users'][$login]) || $config['users'][$login] !== $password) {
    http_response_code(403);
    echo http_response_code();
}

http_response_code(202);
echo http_response_code()."\n";

if (isset($_FILES['image'])) {
    $filesystem = new Filesystem($adapter);
    $ext = substr(strrchr($_FILES['image']['name'], '.'), 1);
    $uuid = Uuid::uuid4()->toString();
    $filename = "{$uuid}.{$ext}";
    $filesystem->writeStream($filename, fopen($_FILES['image']['tmp_name'], "rb"), ['visibility' => 'public']);
    echo "$url" . $filename;
}