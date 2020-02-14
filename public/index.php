<?php

require __DIR__ . '/../vendor/autoload.php';

use League\Flysystem\FileExistsException;
use League\Flysystem\Filesystem;
use Ramsey\Uuid\Uuid;

$config = require_once __DIR__ . '/../config.php';
$users = $config['users'];
$adapter = $config['adapter'];
$url = $config['url'];
$root = $config['root'];
$login = isset($_POST["username"]) ? $_POST["username"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';

if (!isset($config['users'][$login][1]) || $config['users'][$login][1] !== $password) {
    http_response_code(403);
}
else {
    echo "yes\n";
    echo $config['users'][$login][0]."\n";
}

if (isset($_FILES['image'])) {
    $filesystem = new Filesystem($adapter);
    $uploadfile = __DIR__ . '/../'.$_FILES['image']['name'];
    //echo $uploadfile;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    $file = fopen($uploadfile, "rb");

    $ext = substr(strrchr($_FILES['image']['name'], '.'), 1);
    try {
        $uuid = Uuid::uuid4()->toString();
    } catch (Exception $e) {
    }

    $filename = "{$uuid}.{$ext}";
    try {
        $filesystem->writeStream($filename, $file, ['visibility' => 'public']);
    } catch (FileExistsException $e) {
    }
    $imageName = $adapter->getRoot() . $filename;
    unlink($uploadfile);
    echo "$url"."$root"."$filename";
}
