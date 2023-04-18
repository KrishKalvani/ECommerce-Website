"use strict";

//Globals
window.onload = loadBasket;

//Get basket from session storage or create one if it does not exist
function getBasket(){
    let basket;
    if(sessionStorage.basket === undefined || sessionStorage.basket === ""){
        basket = [];
    }
    else {
        basket = JSON.parse(sessionStorage.basket);
    }
    return basket;
}


//Displays basket in page.
function loadBasket(){
    let basket = getBasket();//Load or create basket
    
    //Build string with basket HTML
    let htmlStr = "<form action='../php/checkout.php' method='post'>";
    let prodIDs = [];
    for(let i=0; i<basket.length; ++i){
        htmlStr += "Product name: " + basket[i].name + "<br>";
        htmlStr += "Cost: " + basket[i].myCost + "<br>";
        htmlStr += "Size: " + basket[i].mySize + "<br>";
        let prodID = basket[i].id;
        let prodName = basket[i].name;
        let prodCost = basket[i].myCost;
        let prodSize = basket[i].mySize;


        let prodCount = 1;
        prodIDs.push({ id: prodID, name: prodName, myCost: prodCost, mySize: prodSize,count: prodCount });//Add to product array
        // htmlStr += "<img src='" + basket[i].image + "'>" + "<br>"; // Use imageToUpload field from MongoDB
        // prodIDs.push({id: basket[i].id, count: 1});//Add to product array
    }
    //Add hidden field to form that contains stringified version of product ids.
    htmlStr += "<input type='hidden' name='prodIDs' value='" + JSON.stringify(prodIDs) + "'>";
    
    //Add checkout and empty basket buttons
    htmlStr += "<input type='submit' value='Checkout' onclick='checkout()'></form>";
    htmlStr += "<br><button onclick='emptyBasket()'>Empty Basket</button>";
    
    //Display number of products in basket
    document.getElementById("basketDiv").innerHTML = htmlStr;
}

function checkout() {
    if (confirm("Are you sure you want to checkout?")) {
      alert("Redirecting to home page...");
      // Redirect to checkout.php
      window.location.href = "../php/checkout.php";
    }
  }
  

function addToBasket(prodID, prodName, prodCost, prodSize){
    let basket = getBasket();//Load or create basket
    
    //Add product to basket
    basket.push({id: prodID, name: prodName, myCost: prodCost, mySize: prodSize});
    
    //Store in session storage
    sessionStorage.basket = JSON.stringify(basket);
    
    //Display basket in page.
    loadBasket();      
    
}
   



//Deletes all products from basket
function emptyBasket(){
    sessionStorage.clear();
    loadBasket();
}


