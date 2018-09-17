#!/usr/bin/env php
<?php

require_once  __DIR__ . '/../vendor/autoload.php';

use GetOpt\GetOpt;
use GetOpt\Option;
use GetOpt\ArgumentException;
use GetOpt\ArgumentException\Missing;
use Gumlet\ImageResize;
use Exception;

$getOpt = new GetOpt();
$getOpt->addOptions([
    Option::create('i', 'input-image', GetOpt::REQUIRED_ARGUMENT)
        ->setDescription('File with image to resize'),
    Option::create('o', 'output-image', GetOpt::REQUIRED_ARGUMENT)
        ->setDescription('File to store resized image'),
    Option::create('H', 'height', GetOpt::OPTIONAL_ARGUMENT)
        ->setDescription('Height to resize image'),
    Option::create('W', 'width', GetOpt::OPTIONAL_ARGUMENT)
        ->setDescription('Width to resize image'),
    Option::create('h', 'help', GetOpt::NO_ARGUMENT)
        ->setDescription('Show help and quit'),    
]);

try {
    $getOpt->process();
} catch (Missing $e) {
    if (!$getOpt->getOption('help')) {
        echo "Cannot process command line parameters: " . $e->getMessage() . PHP_EOL;
    }
}

foreach (['input-image', 'output-image'] as $opt) {
    if (!$getOpt->getOption($opt)) {
        help();
    }
}

if (!$getOpt->getOption('width') && !$getOpt->getOption('height')) {
    help();
}

echo sprintf(
    'Resizing image %s: %s %s and store to %s' . PHP_EOL, 
    $getOpt->getOption('input-image'), 
    $getOpt->getOption('height') ? 'to height ' . $getOpt->getOption('height') : '',
    $getOpt->getOption('width') ? 'to width ' . $getOpt->getOption('width') : '',
    $getOpt->getOption('output-image')
);

try {
    $img = new ImageResize($getOpt->getOption('input-image'));

    if ($getOpt->getOption('height')) {
        $img->resizeToHeight($getOpt->getOption('height'));
    }

    if ($getOpt->getOption('width')) {
        $img->resizeToWidth($getOpt->getOption('width'));
    }

    $img->save($getOpt->getOption('output-image'));
} catch (Exception $e) {
    echo "Cannot resize iamge: " . $e->getMessage() . PHP_EOL;
}

if ($getOpt->getOption('help')) {
    help();
}

function help()
{
    echo <<<END
    Image resizer

    Usage: php src/image_resizer.php [OPTIONS] -i|--input-image <INPUT IMAGE> -o|--output-image <OUTPUT IMAGE>

        Options:
            -W, --width - new width to resize image
            -H, --height - new height to resize image

END;
    
    exit(0);
}
