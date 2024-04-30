
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

?>