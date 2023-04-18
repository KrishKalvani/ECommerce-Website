<?php
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Select a collection 
$collection = $db->JustShirts_Customer;
    //Get name and address strings - need to filter input to reduce chances of SQL injection etc.
    $name= filter_input(INPUT_POST, 'myName', FILTER_SANITIZE_STRING);
    $DOB=filter_input(INPUT_POST, 'myDOB', FILTER_SANITIZE_STRING);
    $username=filter_input(INPUT_POST, 'myUsername', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'originalPwd', FILTER_SANITIZE_STRING);
    $confirmPwd=filter_input(INPUT_POST, 'confirmPwd', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $phone=filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
 

    
    if($name != "" && $DOB != "" && $username != "" && $password != "" && $confirmPwd!="" && $address != "" && $email != "" && $phone != "" ){//Check query parameters 
        //STORE REGISTRATION DATA IN MONGODB
        $dataArray = [
            "myName" => $name, 
            "myDOB" => $DOB,
            "myUsername" => $username,
            "originalPwd" => $password,
            "confirmPwd" => $confirmPwd,
            "address"=>$address,
            "email" => $email, 
            "phone" => $phone
         ];
        
        //Add the new product to the database
        $insertResult = $collection->insertOne($dataArray);
            
        //Echo result back to user
        if($insertResult->getInsertedCount()==1){
            echo 'Customer added.';
            echo ' New document id: ' . $insertResult->getInsertedId();
        }
        else {
            echo 'Error adding customer';
        }
        
    
        //Output message confirming registration
        echo 'Thank you for registering ' . $name;
    }
    else{//A query string parameter cannot be found
        echo 'Registration data missing';
    }

