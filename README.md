# Image resizer

## Installing

    git clone git@github.com:stepanov/wh-test-image-resizer.git
    cd wh-test-image-resizer
    composer install

## Usage 

    php src/image_resizer.php [OPTIONS] -i|--input-image <INPUT IMAGE> -o|--output-image <OUTPUT IMAGE>

    Options:
        -W, --width - new width to resize image
        -H, --height - new height to resize image

## Example

    php src/image_resizer.php -i input.jpg -o output.jpg -H 300

## Authors

* Mikhail Stepanov
