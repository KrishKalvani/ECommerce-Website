<?php
    //Start session management
    session_start();

    //Get name and address strings - need to filter input to reduce chances of SQL injection etc.
    // $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $name= filter_input(INPUT_POST, 'myUsername', FILTER_SANITIZE_STRING);

    $password = filter_input(INPUT_POST, 'originalPwd', FILTER_SANITIZE_STRING);    

    //Connect to MongoDB and select database
	require __DIR__ . '/vendor/autoload.php';//Include libraries
	$mongoClient = (new MongoDB\Client);//Create instance of MongoDB client
	$db = $mongoClient->ECommerce;
	
    //Create a PHP array with our search criteria
    $findCriteria = [ "myUsername" => $name ];

    //Find all of the customers that match  this criteria
    $resultArray = $db->JustShirts_Customer->find($findCriteria)->toArray();

    //Check that there is exactly one customer
    if(count($resultArray) == 0){
        echo 'Customer name not found';
        return;
    }
    else if(count($resultArray) > 1){
        echo 'Database error: Multiple customers have same name.';
        return;
    }
   
    //Get customer and check password
    $customer = $resultArray[0];
    if($customer['originalPwd'] != $password){
        echo 'Password incorrect.';
        return;
    }
        
    //Start session for this user
    $_SESSION['loggedInUserEmail'] = $name;
    
    //Inform web page that login is successful
    echo 'ok';  
   
	
    