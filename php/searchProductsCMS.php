<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Select a collection
$collection = $db->JustShirts_Products;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria if search string is not empty
if (!empty($search_string)) { //reference for this if statement: chatGBT
    $findCriteria = [
        '$text' => ['$search' => $search_string]
    ];
} else {
    $findCriteria = [];
}
//Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   //Get the product name entered by the user
   $productName = $_POST["productName"];
 
   //Find the product in the collection that matches the name entered by the user
   $query = array('myProduct' => $productName);
   $product = $collection->findOne($query);
 
   //If the product is found, store its details in the session and redirect to productUpdate.php
   if (!empty($product)) {
     session_start();
     $_SESSION["productName"] = $product["myProduct"];
     $_SESSION["productCost"] = $product["myCost"];
     $_SESSION["productSize"] = $product["mySize"];
     $_SESSION["productDescription"] = $product["myDescription"];
 
     // Redirect to the product update page
     header("Location: cmsTest2.php");
     exit();
   }
 }
//Find all of the customers that match this criteria
$cursor = $db->JustShirts_Products->find($findCriteria);
//Output the results
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<link href="../css/cmsStyle.css" type="text/css" rel="stylesheet">';


echo '<title>CMS - PRODUCTS</title>';
echo '<style>';

echo '</style>';
echo '<script>';
 echo 'function searchBarCategories(category){';
 echo 'let form = document.getElementById("searchBarContainer");';
 echo 'form.elements["SearchBar"].value=category;'; 
 echo 'form.submit();';
 echo '}';
 echo '</script>';
echo '</head>';
echo '<body>';
echo '<div id="CMSnav">';
echo '';
echo '<a style="color:white; float:left; margin-top :1.5%; margin-left: 2%; text-decoration: none; font-size: large; font-family: Arial, Helvetica, sans-serif; cursor:pointer;" onclick="searchBarCategories("TShirts");">CMS</a>';
echo '<a style="color:white; float:left; margin-top :1.5%; margin-left: 2%; text-decoration: none; font-size: large; font-family: Arial, Helvetica, sans-serif;" href="../pages/addProductsCMS.html">Add Product</a>';
echo '<a style="color:white; float:left; margin-top :1.5%; margin-left: 2%; text-decoration: none; font-size: large; font-family: Arial, Helvetica, sans-serif;" href="../pages/orderPage.html">Customer Orders</a>';
echo '<a style="color:white; float:left; margin-top: 1.5%; margin-left: 1%; text-decoration: none; font-size: large; font-family: Arial, Helvetica, sans-serif; float:right; margin-right:2%;" href="../php/cmsLogin.php">Logout</a>';
echo '<h2 style="color:white; font-family:Arial, Helvetica, sans-serif; ">JustShirts Content Management System (CMS)</h2>';
echo '</div>';
echo '';
echo '<br><br>';
echo '<form id="searchBarContainer" action="../php/searchProductsCMS.php" method="get"><input type="text" name="name" id="SearchBar" type="text" placeholder="search available products"" required> <input type="submit"  value="search">';
echo '</form>';
echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
echo '<label for="productName">Product Name:</label>';
echo '<input placeholder="edit products here" type="text" name="productName" id="productName">';
echo '<input type="submit" value="Search">';
echo '</form>';

echo '<form action="../php/deleteProduct.php" method="post">';
echo 'Product ID: <input placeholder="delete products here"  type="text" name="id" required>';
echo '<input type="submit">';
echo '</form>';

echo '';
echo '<br><br>';
echo '';
echo '<div class="dropdown"><!--menu-->';
echo '<button style="margin-left: 5%;" class="dropbtn">CATEGORIES</button>';
echo '<br><br>';
echo '<div style="margin-left: 5%;" class="dropdown-content"><!--menu content-->';
echo '<a style="cursor:pointer;" onclick="window.location.href=\'searchProductsCMS.php\'">All</a><br>';
echo '<a style="cursor:pointer;" onclick="searchBarCategories(&quot;TShirts&quot;)">T-Shirts</a><br>';
echo '<a style="cursor:pointer;" onclick="searchBarCategories(&quot;Collared&quot;)">Collared</a><br>';
echo '<a style="cursor:pointer;" onclick="searchBarCategories(&quot;Full-Sleeve&quot;)">Full-Sleeve</a><br>';
echo '<a style="cursor:pointer;" onclick="searchBarCategories(&quot;Sleeveless&quot;)">Sleeveless</a><br>';
echo '<a style="cursor:pointer;" onclick="searchBarCategories(&quot;Polo&quot;)">Polo</a>';
echo '</div>';
echo '</div>';

echo '<br><br>';
echo '';
echo '';
echo '';
echo '';
echo '';
echo "<h1 style='text-align: center;'>Results for $search_string</h1>";
foreach ($cursor as $cust){
    echo '<style>';
    echo 'table {';
    echo 'font-family: arial, sans-serif;';
    echo 'border-collapse: collapse;';
    echo 'width: 100%;';
    echo '}';
    echo '';
    echo 'td, th {';
    echo 'border: 1px solid #dddddd;';
    echo 'text-align: left;';
    echo 'padding: 8px;';
    echo '}';
    echo '';
    echo 'tr:nth-child(even) {';
    echo 'background-color: #dddddd;';
    echo '}';
    echo '</style>';
   

echo '<table style="width:80%; margin-left: 10%;" >';

   echo '<tr>';
   echo '<td>';
   echo "<p> Product ID: " . $cust['_id'] ."<br></p>";
   echo '</td>';
   
   
    echo '<td>';
   echo '<img class="card-image" style="width: 150px;" src="'. $cust["imageToUpload"] . '"><br>' ;
   echo '</td>';
   echo '<td>';
   echo "<p style='text-align: center;'>category: ".$cust['myCategory'] ."<br></p>"; 
   echo '</td>';
   echo '<td>';
   echo '<p style="text-align: center;">Name: ' . $cust['myProduct'] ."<br></p>";
   echo '</td>';
   echo '<td>';
   echo '<p >Price: AED</p> '. $cust['myCost'] ."<br>";
   echo '</td>';
   echo '<td>';
   echo "<p style='text-align: center;'>Sizes: " .$cust['mySize'] ."<br></p>";
   echo '</td>';
   echo '<td>';
   echo '<p style="text-align: center;"> Description: ' .$cust['myDescription'] ."<br>";
   echo '</td>';


   echo "</tr>";
   echo '</table>';
   
  
   

}
echo '<br><br>';
echo '<a href="../pages/addProductsCMS.html"><button style="margin-left: 75%; font-size: larger; font-family: Arial, Helvetica, sans-serif;">Add to Products</button></a>';

echo '<div id="CMSfooterDiv">';
echo '<br>';
echo '<p id="CMSfooterText">Web Page made by Krish Kalvani & Ali Usman (1920x1080)</p>';
echo '';
echo '</div>';
echo '';
echo '</body>';
echo '</html>';
?>