<!DOCTYPE html>
<html>
    <head>
        <title>Basket</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="basket.js"></script>
        <script src="../js/basket.js"></script>
    </head>
    <body>
        <h1>Shopping Website</h1>

        <!-- PHP loads product information -->        
        <?php

        //Connect to MongoDB and select database
        require __DIR__ . '/vendor/autoload.php';
        $mongoClient = (new MongoDB\Client);
        $db = $mongoClient->ECommerce;
        
        //Find all products
        $products = $db->JustShirts_Products->find();

        //Output results onto page
        echo '<table>';
        echo '<tr><th>ID</th><th>Name</th><th>Description</th><th></th></tr>';
        foreach ($products as $document) {
            echo '<tr>';
            echo '<td>' . $document["_id"] . "</td>";
            echo '<td> <img class="card-image" style="width:100%; height: 63%;" src="'. $document["imageToUpload"] . '"</td>"';
            echo '<td>' . $document["myProduct"] . "</td>";
            echo '<td>' . $document["myDescription"] . "</td>";
            echo '<td><button onclick=\'addToBasket("' . $document["_id"] . '", "' . $document["myProduct"] . '")\'>';
            echo '<img class="addButtonImg" width=20 src="basket-add-icon.png"></button></td>';
            echo '</tr>';
        }
        echo '</table>';

        ?>
        
        <!-- Displays contents of basket -->    
        <h2>Basket</h2>
        <div id="basketDiv"></div>
    
    </body>
</html>
        