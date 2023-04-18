<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);

//Create a PHP array with our search criteria
$findCriteria = [
    '$text' => ['$search' => $search_string]
 ];

//Find all of the customers that match  this criteria
$cursor = $db->JustShirts_Products->find($findCriteria);

//Output the results

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<link href="../css/styles.css" type="text/css" rel="stylesheet">';
echo '<script src="../js/myInitFunction.js"></script>';
echo '<script src="../js/ajaxLogin.js"></script>';
echo '<script src="../js/basket.js"></script>';




echo '';
echo '<title>JustShirts- TShirts Page</title>';
echo '<script>';
 echo 'function searchBarCategories(category){';
 echo 'let form = document.getElementById("searchBarContainer");';
 echo 'form.elements["SearchBar"].value=category;'; 
 echo 'form.submit();';
 echo '}';
 echo '</script>';

 


echo '</head>';
echo '';
echo '<body>';
echo '<div id="navigation">';
echo '';
echo '<a style="float:left; margin-top:-1.5%; margin-left:2%;" href="../pages/HomePage4.html"><img id="LogoSize" src="../imgs/logo4.png"></a>';
echo '';
echo '';
echo '<form id="searchBarContainer" action="../php/searchProducts.php" method="get"><input type="text" name="name" id="SearchBar" placeholder="Search.." required> <input id="SearchButton" type="submit" value="search">';
echo '<a href="../pages/cartPage.html" class="split"><img style="height:20%; width:20%;" src="../imgs/cartImg.png"></a>';
echo '<a style="font-size:small;" href="../pages/LoginPage.html" class="split">LOGIN</a>';
echo '<a style="font-size:small;" href="../pages/RegisterPage.html" class="split">REGISTER</a>';
echo '<a style="font-size:small;" href="../php/ProfileDetails.php" class="split">My Profile</a>';
echo '';
echo '<div id="ProfileBox">';
echo '<p style="color:black; margin-top: 20px; font-family: Arial, Helvetica, sans-serif;">Hello user <span id="profile"></span>';
echo '<button onclick="logout()">Logout</button></p>';
echo '</div>';
echo '</form>';
echo '';
echo '';
echo '';
echo '</div>';
echo '';
echo '<div class="go left"><!--class to keep the left div for the categories and sizes-->';

echo '<div>';
echo '<br>';

echo '<div class="dropdown"><!--menu-->';
echo '<button class="dropbtn">CATEGORIES</button>';
echo '<br><br>';
echo '<div class="dropdown-content"><!--menu content-->';
echo '<a onclick="searchBarCategories(&quot;TShirts&quot;)">T-Shirts</a>';
echo '<a  onclick="searchBarCategories(&quot;Collared&quot;)">Collared</a>';
echo '<a onclick="searchBarCategories(&quot;Full-Sleeve&quot;)">Full-Sleeve</a>';
echo '<a onclick="searchBarCategories(&quot;Sleeveless&quot;)">Sleeveless</a>';
echo '<a  onclick="searchBarCategories(&quot;Polo&quot;)">Polo</a>';
echo '</div>';
echo '</div>';


echo '</div>';
echo '';
echo '</div>';
echo '';
echo'
<script  type="module">
"use strict";

//Import recommender class
import {Recommender} from "../js/recommendor.js";

//Create recommender object - it loads its state from local storage
let recommender = new Recommender();

/* Set up button to call search function. We have to do it here 
    because search() is not visible outside the module. */
document.getElementById("SearchButton").onclick = search;

//Display recommendation
window.onload = showRecommendation;

//Searches for products in database
function search(){
    //Extract the search text
    let searchText = document.getElementById("SearchBar").value;
    
    //Add the search keyword to the recommender
    recommender.addKeyword(searchText);
    showRecommendation();
    
    
    //#FIXME# PERFORM SEARCH FOR PRODUCTS
}

//Display the recommendation in the document
function showRecommendation(){
   

    document.getElementById("RecomendationDiv").innerHTML = recommender.getTopKeyword();
    
    
}
</script>';


echo "<h1> Results for $search_string</h1>";
foreach ($cursor as $cust){
   echo '<style>';
echo '.card {';
echo 'box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);';
echo 'max-width: 300px;';
echo 'font-family: arial;';
echo 'margin-left: 22%;';
echo '}';
echo '';
echo '';
echo '.price {';
echo 'color: black;';
echo 'font-size: 22px;';
echo '}';
echo '';
echo '.card button {';
echo 'border: none;';
echo 'outline: 0;';
echo 'padding: 12px;';
echo 'color: white;';
echo 'background-color: #000;';
echo 'text-align: center;';
echo 'cursor: pointer;';
echo 'width: 100%;';
echo 'font-size: 18px;';
echo '}';
echo '';
echo '.card button:hover {';
echo 'opacity: 0.7;';
echo '}';
echo '</style>';

   echo '<div style="float:left" class="card">';
   

   echo '<img class="card-image" style="width:100%; height: 63%;" src="'. $cust["imageToUpload"] . '"><br>' ;
   echo "category: ".$cust['myCategory'] ."<br>"; 
   echo '<h1 class="card-title"> ' . $cust['myProduct'] ."<br></h1>";
   echo '<p class="card-price">AED</p> '. $cust['myCost'] ."<br>";
   echo "Sizes: " .$cust['mySize'] ."<br>";
   echo '<p class="card-details">' .$cust['myDescription'] ."<br>";
   echo '<td><button onclick=\'addToBasket("' . $cust["_id"] . '", "' . $cust["myProduct"] . '", "' . $cust["myCost"] . '" , "' . $cust["mySize"] . '" )\'>Add to Cart</button></td>';   
   echo "</div>";
  
   

}
 echo '<div style="margin-top:85%;">';
 echo '<p class="shirtsFooter" style="color: white;">Web Page made by Krish Kalvani & Ali Usman (1920x1080)</p>';
 echo '</div>';
 


?>


