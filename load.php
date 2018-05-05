<?php

$jsonParts = 1;

if (!isset($argv[1])) {
    die('File Path is mandatory. '. PHP_EOL .'E.g.: php load.php file1.json');
}

if (isset($argv[2])) {
    $jsonParts = (int)$argv[2];
}

$files = json_decode(file_get_contents(trim($argv[1])));
$folder = 'photos';

if ($jsonParts > 1) {
    $max = $maxAux = ceil(count($files) / $jsonParts);
    $j = 0;
    $filesPart = [];    
    for ($i = 0; $i < count($files); $i++) {
        echo PHP_EOL . "i: [$j]: $i | max: $max";
        $filesPart[] = $files[$i];
        if ($i == $max || $i == count($files)) {
            file_put_contents("file-".($j + 1).".json", json_encode($filesPart, JSON_PRETTY_PRINT));
            $j++;
            $max+= $maxAux;
            $filesPart = [];
        }
    }
}

/*foreach ($files as $file) {
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

echo PHP_EOL . "** END **";*/