<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria
$findCriteria = [
    '$text' => [ '$search' => $search_string ] 
 ];

//Find all of the customers that match  this criteria
$cursor = $db->JustShirts_Customer->find($findCriteria);

//Output the results as forms
echo "<h1>Customers</h1>";   
foreach ($cursor as $cust){
    echo '<form action="../php/replaceCustomer.php" method="post">';
    echo 'Name: <input type="text" name="name" value="' . $cust['myName'] . '" required><br>';
    echo 'DOB: <input type="date" name="date" value="' . $cust['myDOB'] . '" required><br>';
    echo 'Username: <input type="text" name="username" value="' . $cust['myUsername'] . '" required><br>';
    echo 'Password: <input type="text" name="password" value="' . $cust['originalPwd'] . '" required><br>';
    echo 'Confirmed Password: <input type="text" name="password" value="' . $cust['confirmPwd'] . '" required><br>';
    echo 'Address: <input type="text" name="address" value="' . $cust['address'] . '" required><br>';
    echo 'Email: <input type="text" name="email" value="' . $cust['email'] . '" required><br>';
    echo 'Phone: <input type="text" name="phone" value="' . $cust['phone'] . '" required><br>';
    echo '<input type="hidden" name="id" value="' . $cust['_id'] . '" required>'; 
    echo '<input type="submit">';
    echo '</form><br>';
}



 