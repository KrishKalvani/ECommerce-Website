<?php

//Start the session, which allows the script to store and retrieve info
session_start();

?>
<!-- Create the product update form with pre-filled textboxes -->
<form method="post" action="replaceProduct.php">
  <label for="productName">Product Name:</label>
  <input type="text" name="productName" id="productName" value="<?php echo $_SESSION["productName"]; ?>"><br> <!-- Session is the superglobal array to retrieve info from previous page -->
  <label for="productSize">Product Size:</label>
  <input type="text" name="productSize" id="productSize" value="<?php echo $_SESSION["productSize"]; ?>"><br>
  <label for="productCost">Product Cost:</label>
  <input type="text" name="productCost" id="productCost" value="<?php echo $_SESSION["productCost"]; ?>"><br>
  <label for="productDescription">Product Description:</label>
  <input type="text" name="productDescription" id="productDescription" value="<?php echo $_SESSION["productDescription"]; ?>"><br>
  <input type="submit" value="Update Product">
</form>
<?php
// Clear the session variables, to make sure the next time the user accesses the website, the text fields are empty.
session_unset();
?>