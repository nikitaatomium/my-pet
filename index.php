<?php

require "pet.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /pets, everything else results in a 404
if ($uri[1] !== 'pets') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// pet id must be a number (new pet will be created if pet id is not provided)
$petId = null;
if (isset($uri[2])) {
    $petId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == 'PUT') {
$action = parse_str(file_get_contents('php://input'), $_PUT);  
} 

// pass the request method, pet ID, action and other data to the controller and process the HTTP request:
$pet = new Pet();
switch($requestMethod){
    case 'GET':
      $pet->show($petId);  
    break;  
    case 'POST':
      $pet->create($petId);  
    break; 
    case 'PUT':
      $pet->update($petId, $action);  
    break;   
    case 'DELETE':
     $pet->burn($petId);   
    break;           
}
exit();

?>
