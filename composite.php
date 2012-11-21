<?php
define ('DS',DIRECTORY_SEPARATOR);
require_once 'classes/Composite/Folder.class.php';
require_once 'classes/Composite/File.class.php';
require_once 'classes/Helpers/Helper.class.php';
    

try {
    //Get user Input
    $input = Helper::hadleInput();
    //Create Tree structure of directory contents
    $response = Helper::createResponse($input);

    if ($response instanceof Node){
        $response->output(). "\n";
        //Get array of objects created
        //$response->getChildren();
    }
    else
        echo $response. "\n";
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
}

?>