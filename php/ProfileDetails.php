<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);
// $search_string = "{myName: ''}";

//Create a PHP array with our search criteria
if (!empty($search_string)) {
    $findCriteria = [
        '$text' => ['$search' => $search_string]
    ];
} else {
    $findCriteria = [];
}

//Find all of the customers that match  this criteria
$cursor = $db->JustShirts_Customer->find($findCriteria);

//Display all the orders from JustShirts_Order collection
$orderCursor = $db->JustShirts_Order->find();
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<link href="../css/styles.css" type="text/css" rel="stylesheet">';
echo '';
echo '<script src="../js/myInitFunction.js"></script>';
echo '<script src="../js/ajaxLogin.js"></script>';
echo '';
echo '';
echo '<title>JustShirts - Profile</title>';
echo '';
echo '</head>';
echo '';
echo '<body>';
echo '<div id="navigation">';
echo '';
echo '<a style="float:left; margin-top:-1.5%; margin-left:2%;" href="../pages/HomePage4.html"><img id="LogoSize"';
echo 'src="../imgs/logo4.png"></a>';
echo '';
echo '';
echo '<form id="searchBarContainer" action="../php/searchProducts.php" method="get"><input type="text" name="name"';
echo 'id="SearchBar" type="text" placeholder="Search.." required> <input id="SearchButton" type="submit" value="search">';
echo '<a href="../pages/cartPage.html" class="split"><img style="height:20%; width:20%;"';
echo 'src="../imgs/cartImg.png"></a><!--cart page link-->';
echo '<a style="font-size:small;" href="../pages/LoginPage.html" class="split">LOGIN</a><!--login page link-->';
echo '<a style="font-size:small;" href="../pages/RegisterPage.html" class="split">REGISTER</a><!--register page link-->';
echo '<a style="font-size:small;"  href="../php/ProfileDetails.php" class="split">My Profile</a><!--profile page link-->';
echo '';
echo '<div id="ProfileBox"><!--profile username (changeable according to loggedInUser)-->';
echo '<p style="color:black; margin-top: 20px; font-family: Arial, Helvetica, sans-serif;">Hello user <span id="profile"></span>';
echo '<button onclick="logout();">Logout</button>';
echo '</p>';
echo '</div>';
echo '</form>';
echo '';
echo '';
echo '';
echo '</div>';
echo '<br> <br>';
echo '';
echo '<button style="margin-top:-0.9%; margin-left:-15%;" class="homeViewProductsButton" onclick="searchBarCategories(&quot;TShirts&quot;)">VIEW OUR PRODUCTS</button>';
echo '<br><br>';
echo '<form id="customerSearchBar" style="float:left; margin-left:32%; margin-top: 5%;" action="../php/customerUpdate.php" method="post">';
echo 'Edit Details: <input type="text" name="search" placeholder="search username to edit" required><br><br>';
echo '<input style="margin-left:60%;" type="submit" value="Edit">';
echo '</form>';
echo '';
echo '<div class="ProfilePgBox"><!--profile box start-->';
echo '<h1 class="ProfileHeading">User Profile</h1>';
echo '<table class="ProfileTable" style="background-color:#B76262;"><!--putting contents in table to line them up-->';
echo '<div class="user-profile">';
echo '<div class="card"><!--div for the user profile-->';
echo '<div class="card-header bg-transparent text-center">';
echo '<img class="profile_img" src="https://source.unsplash.com/600x300/?student"';
echo 'alt="student dp"><!--adding a picture to the icon-->';

 echo '<div class="card-body"><!--contents-->';

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

foreach ($cursor as $cust){
   
 
    echo '<div style="margin-left:3%;" class="card">';
    
 
    
    echo "Name: ".$cust['myName'] ."<br>"; 
    echo "DOB: ".$cust['myDOB'] ."<br>"; 
    echo "Username: ".$cust['myUsername'] ."<br>";
    echo "Password: ".$cust['originalPwd'] ."<br>"; 
    echo "Re-entered Password: ".$cust['confirmPwd'] ."<br>";
    echo "address: ".$cust['address'] ."<br>"; 
    echo "email: ".$cust['email'] ."<br>";
    echo "phone: ".$cust['phone'] ."<br>"; 
   
    
 
 }

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '';
echo '</table>';
echo '<table class="ProfileTable" style="background-color:#B76262;">';
echo '';
echo '</table>';
echo '';
echo '<div style="margin-top:-40%;" class="OrderBox">';
echo '<h1 class="OrderHeading">Order History</h1><!--viewing the users orders-->';
echo '<table class="OrderTable" style="background-color: #B76262;"></table>';
foreach ($orderCursor as $document) {
    echo '<tr>';
    echo '<td>Product: ' . $document['name'] . '</td>';
    echo '&nbsp';
    echo '<td>Price: ' . $document['cost'] . 'AED</td>';
    echo '&nbsp';
     echo '<td>Size: ' . $document['size'] . '</td>';
     echo '&nbsp';
     echo '<br>';
    //echo '<td>' . $document['Status'] . '</td>';
    echo '</tr>';
}
echo '</div>';
echo '';
echo '<div>';
echo '<p class="ProfileFooter" style="color: white; width: 1535px; margin-left: -70%; ">Web Page made by Krish Kalvani &';
echo 'Ali Usman (1920x1080)</p>';
echo '</div>';
echo '<script>';
echo 'function searchBarCategories(category) {';
echo 'let form = document.getElementById("searchBarContainer")';
echo 'form.elements["SearchBar"].value = category;';
echo 'form.submit();';

echo '}';
// echo 'function searchBarCategories(TShirts) {';
//     echo '// Redirect to the searchProducts.php page with the category parameter';
//     echo 'window.location.href = "../php/searchProducts.php?category=" + category;';
//     echo '}';
// echo '</script>';

echo '</body>';
echo '';
echo '</html>';
?>