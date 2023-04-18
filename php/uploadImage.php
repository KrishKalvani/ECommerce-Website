<?php
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->ECommerce;

//Select a collection 
$collection = $db->JustShirts_Products;
$category=filter_input(INPUT_POST, 'myCategory', FILTER_SANITIZE_STRING);
$product=filter_input(INPUT_POST, 'myProduct', FILTER_SANITIZE_STRING);
$cost=filter_input(INPUT_POST, 'myCost', FILTER_SANITIZE_STRING);
$sizes = filter_input(INPUT_POST, 'mySize', FILTER_SANITIZE_STRING);
$description=filter_input(INPUT_POST, 'myDescription', FILTER_SANITIZE_STRING);


    //Check file data has been sent
    if(!array_key_exists("imageToUpload", $_FILES)){
        echo 'File missing.';
        return;
    }
    if($_FILES["imageToUpload"]["name"] == "" || $_FILES["imageToUpload"]["name"] == null){
        echo 'File missing.';
        return;
    }
    $uploadFileName = $_FILES["imageToUpload"]["name"];

    /*  Check if image file is a actual image or fake image
        tmp_name is the temporary path to the uploaded file. */
    if(getimagesize($_FILES["imageToUpload"]["tmp_name"]) === false) {
        echo "File is not an image.";
        return;
    }
    
    // Check that the file is the correct type
    $imageFileType = pathinfo($uploadFileName, PATHINFO_EXTENSION);
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return;
    }
    
    //Specify where file will be stored
    $target_file = 'images/' . $uploadFileName;
    
    /* Files are uploaded to a temporary location. 
        Need to move file to the location that was set earlier in the script */
    if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imageToUpload"]["name"]). " has been uploaded.";
        echo '<p>Uploaded image: <img src="' . $target_file . '"></p>';//Include uploaded image on page
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
    if($target_file != "" &&  $product != "" &&  $category != ""  && $cost != "" && $sizes != "" && $description != "" ){//Check query parameters 
        //STORE REGISTRATION DATA IN MONGODB
        $dataArray = [
            "imageToUpload" => $target_file,
            "myCategory" => $category,
            "myProduct" => $product,
            "myCost" => $cost,
             "mySize" => $sizes,
            "myDescription" => $description

            
         ];
        
        //Add the new product to the database
        $insertResult = $collection->insertOne($dataArray);
            
        //Echo result back to user
        if($insertResult->getInsertedCount()==1){
            echo 'Product added.';
            echo ' New document id: ' . $insertResult->getInsertedId();
        }
        else {
            echo 'Error adding Product';
        }
        
    
        //Output message confirming registration
        echo 'Thank you for adding product ' . $product;
    }
    else{//A query string parameter cannot be found
        echo 'Registration data missing';
        echo $product ."<br>";  
        echo $description ."<br>";
        echo $cost ."<br>";
        echo $sizes ."<br>";
        echo $category ."<br>";
       
    }





