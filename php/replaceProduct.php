<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract the data that was sent to the server and using filter_input to make sure it's securely done
$name = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
$cost = filter_input(INPUT_POST, 'productCost', FILTER_SANITIZE_NUMBER_INT);
$size = filter_input(INPUT_POST, 'productSize', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'productDescription', FILTER_SANITIZE_STRING);

//Find the product to update
$findCriteria = [
    'myProduct' => $name
];
$collection = $db->JustShirts_Products;
$product = $collection->findOne($findCriteria);

if ($product) {
    //Update the product in the database
    $updateResult = $collection->updateOne(
        ['_id' => $product['_id']],
        ['$set' => [
            'myCost' => $cost,
            'mySize' => $size,
            'myDescription' => $description
        ]]
    );
    if ($updateResult->getModifiedCount() == 1) {
        echo 'Product updated successfully';
    } else {
        echo 'Error updating product';
    }
} else {
    echo 'Product not found';
}
?>
<form method="get" action="searchProductsCMS.php">
  <button type="submit">Go Back To CMS</button>
</form>