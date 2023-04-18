<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract the customer details 
$name= filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$DOB=filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$username=filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$confirmPwd=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$phone=filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//Criteria for finding document to replace
$replaceCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($id)
];

//Data to replace
$customerData = [
    "myName" => $name, 
    "myDOB" => $DOB,
    "myUsername" => $username,
    "originalPwd" => $password,
    "confirmPwd" => $confirmPwd,
    "address"=>$address,
    "email" => $email, 
    "phone" => $phone
];

//Replace customer data for this ID
$updateRes = $db->JustShirts_Customer->replaceOne($replaceCriteria, $customerData);
    
//Echo result back to user
if($updateRes->getModifiedCount() == 1)
    echo 'Your details have been succesfully edited.';
    
else
    echo 'Customer replacement error.';

    echo '<a href = "../php/ProfileDetails.php";>Your Profile</a>';




