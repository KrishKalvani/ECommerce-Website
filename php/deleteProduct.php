<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract ID from POST data
$custID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//Build PHP array with delete criteria 
$deleteCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($custID)
];

//Delete the customer document
$deleteRes = $db->JustShirts_Products->deleteOne($deleteCriteria);
    
//Echo result back to user
if($deleteRes->getDeletedCount() == 1){
    echo 'Product deleted successfully.';
}
else{
   echo 'Error deleting Product';
}

