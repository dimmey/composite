<?php
define ('DS',DIRECTORY_SEPARATOR);
require_once 'Node.class.php';
require_once 'Helper.class.php';
    

try {
    $input = Helper::hadleInput();
    $output = Helper::createResponse($input);

    if ($output instanceof Node){
        echo $output->output(). "\n";
    }
    else
        echo $output. "\n";
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
}

?>