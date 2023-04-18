<?php
//Include libraries
require __DIR__ . '/vendor/autoload.php';
    

// establish MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");

// select the database and collection
$collection = $client->ECommerce->JustShirts_CMS;

// check if the login form is submitted. line 13 is mainly checking if the request is post or not
if ($_SERVER['REQUEST_METHOD'] == 'POST') { //server is a superglobal variable, which is an array containing info about server and stufff
    // retrieve the staff name and password data from the form
    $name = $_POST['name'];
    $password = $_POST['password'];

    // query the collection for a document that matches the staff name and password
    $document = $collection->findOne(['name' => $name, 'password' => $password]);

    // check if a document is found
    if ($document) {
        // redirect to the CMS page
        header('Location: ../php/searchProductsCMS.php');
        exit();
    } else {
        // display an error message
        echo '<p style="color: red; text-align: center;">Invalid staff name or password</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/cmsStyle.css" type="text/css" rel="stylesheet">
    <title>CMS - LOGIN</title>
</head>
<body>
    <div id="CMSnav"><!--cms nav bar-->
        <!--nav bar content for home page link-->
        <a style="color:white; float:left; margin-top: 1.5%; margin-left: 1%; text-decoration: none; font-size: large; font-family: Arial, Helvetica, sans-serif;" href="../php/cmsLogin.php">Home</a>
      
        <h2 style="color:white; font-family:Arial, Helvetica, sans-serif">JustShirts Content Management System (CMS)</h2>
    </div>
    <h2>Please login to access our products</h2>
    <form method="post">
        <table style="text-align: center; margin-left: 40%;">
            <tr>
                <td><label>Staff Name:</label></td>
                <td><input name="name" type="text"></td>
            </tr>
            <tr>
                <td><label>Password:</label></td>
                <td><input name="password" type="password"></td>
            </tr>
        </table>
        <br>
        <button type="submit">LOGIN</button>
    </form>
</body>
</html>
