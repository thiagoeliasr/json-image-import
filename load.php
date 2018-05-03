<?php

if (!isset($argv[1])) {
    die('File Path is mandatory. '. PHP_EOL .'E.g.: php load.php file1.json');
}

$files = json_decode(file_get_contents(trim($argv[1])));
$folder = 'photos';

foreach ($files as $file) {
    $path = $folder . DIRECTORY_SEPARATOR . $file->code;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    foreach ($file->photos as $url) {
        $pieces = explode("/", $url);
        $filename = end($pieces);

        echo PHP_EOL . "File: " . $filename . " | Status: ";

        $data = file_get_contents($url);
        if (file_put_contents($path . DIRECTORY_SEPARATOR . $filename, $data, LOCK_EX)) {
            echo "OK";
        } else {
            echo "* ERROR *";
        }
    }
}

echo PHP_EOL . "** END **";