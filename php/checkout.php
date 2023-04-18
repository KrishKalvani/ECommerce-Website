<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Get the JSON string of product IDs from the form data
$prodIDsJSON = $_POST['prodIDs'];

//Decode the JSON string into an array of product IDs
$prodIDs = json_decode($prodIDsJSON, true);

//Loop through the product IDs and insert each product into the JustShirts_Orders collection
foreach ($prodIDs as $prodID) {
  $order = [
    'name' => $prodID['name'],
    'cost' => $prodID['myCost'],
    'size' => $prodID['mySize']
  ];
  $result = $db->JustShirts_Order->insertOne($order);
}

//Redirect to a confirmation page
header('Location: ../pages/HomePage4.html');
exit;
?>