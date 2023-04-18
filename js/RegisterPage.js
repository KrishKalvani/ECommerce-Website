let button;
let passwordInput;//input that the user puts
let strongRegEx = new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{7,}$");//conditions for a strong password




function clearInput() {//clears all inputs when we press the cancel button
    document.getElementById("form").reset();
}
window.onload = init;


function init() {//obtaining and setting up the local storage and also updating the profile name icon.

    button = document.getElementsByClassName("RegisterBoxButton");

    passwordInput = document.getElementById("originalPwd");



    if (localStorage.users === undefined) {
        localStorage.users = "[]";
    }

    let profile = document.getElementById("profile");
    if (localStorage.loggedInUser === undefined) {
        localStorage.loggedInUser = "Guest";
    }
    let loggedInUser = localStorage.getItem("loggedInUser");
    profile.innerText = loggedInUser;
    
}
function checkPassword() {// checks if the password is strong or not

    let password = document.getElementById("originalPwd").value;
    let result = strongRegEx.test(password);


    if (result) {
        passwordInput.style.color = "green";
        return true;

    } else {
        passwordInput.style.color = "red";
        alert("password not strong");
        return false;
    }

}
function checkConfirmPassword() {//checks if the password is the same as confirm password
    let password = document.getElementById("originalPwd").value;
    let confirmPassword = document.getElementById("confirmPwd").value;
    console.log(password);
    console.log(confirmPassword);

    if (password == confirmPassword) {
        alert("registration pending...please click ok.");
        return true;
    } else {
        alert("password not same");
        return false;
    }


}
function validateEmail(email) { //checks if the email is in the correct format
    
    let regexEmail = new RegExp("^([a-zA-Z0-9_\\-\\.]+)@([a-zA-Z0-9_\\-\\.]+)\\.([a-zA-Z]{2,5})$");
    console.log("email check");
    console.log(regexEmail.test(email));
    return (regexEmail.test(email));


}
function validatePhone(phone) { //checks if the phone is in correct according to UAE format
    let regexPhone = new RegExp("^(?:00971|\\+971|0)?(?:50|51|52|55|56|58|2|3|4|6|7|9)\\d{7}$");
    console.log("phone check");
    console.log(regexPhone.test(phone));
    return (regexPhone.test(phone))
}

function Validate(){
    //Create request object 
    let request = new XMLHttpRequest();

    //Create event handler that specifies what should happen when server responds
    request.onload = () => {
        //Check HTTP status code
        if(request.status === 200){
            //Get data from server
            let responseData = request.responseText;

            //Add data to page
            document.getElementById("ServerResponse").innerHTML = responseData;
        }
        else
            alert("Error communicating with server: " + request.status);
    };

    //Set up request with HTTP method and URL 
    request.open("POST", "../php/RegisterPage.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    //Extract registration data
    let name = document.getElementById("myName").value;
    let DOB = document.getElementById("myDOB").value;

    let username = document.getElementById("myUsername").value;
    let password = document.getElementById("originalPwd").value;
    let confirmPassword = document.getElementById("confirmPwd").value;
    let address = document.getElementById("address").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    
    //Send request
    request.send("myName=" + name + "&myDOB=" + DOB + "&myUsername=" +username+ "&originalPwd=" +password+ "&confirmPwd=" +confirmPassword+
    "&address=" + address + "&email=" + email + "&phone=" +phone);
}

function register() {//getting the values of all the user inputs 
    
    
    let name = document.getElementById("myName").value;
    let DOB = document.getElementById("myDOB").value;

    let username = document.getElementById("myUsername").value;
    let password = document.getElementById("originalPwd").value;
    let confirmPassword = document.getElementById("confirmPwd").value;
    let address = document.getElementById("address").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    
    if (name == "" || DOB == "" || username == "" || password == "" || confirmPassword == "" || address == "" || email == "" || phone == "") {//validating to make sure the user doesn't miss anything
        alert("fill in all the details");
        return false;
    }

    if (!(checkPassword() && checkConfirmPassword())) {
        return;
    }
    let newUser = {//user array which is stored in the local storage. All registered users stored here.
        myName: name,
        myDOB: DOB,
        myUsername: username,
        myPassword: password,
        myConfirmedPassword: confirmPassword,
        myAddress: address,
        myEmail: email,
        myPhone: phone
    }

    if (!validateEmail(newUser.myEmail)) { //if email NOT correct, alert invalid

        alert("The email you entered is not correct. Please enter a valid email.");
        
    }
    if (!validatePhone(newUser.myPhone)) { //if phone NOT correct, alert invalid
        alert("phone number invalid (dont forget the + sign before entering your number)");
        

    }
    if(!validateEmail(newUser.myEmail)||!validatePhone(newUser.myPhone)){ //if both NOT correct then end registration check
        return;


    }
    
   


    if (validateEmail(newUser.myEmail) && validatePhone(newUser.myPhone)) {
        Validate();
        
    }
    


}
function showHide() { //to view the orginial password
    let pass = document.getElementById("originalPwd");
    if (pass.type == "password") {
        pass.type = "text";
    } else {
        pass.type = "password"
    }
}
function showHide2() { //to view the re-typed password

    let confirmPass = document.getElementById("confirmPwd");
    if (confirmPass.type == "password") {
        confirmPass.type = "text";
    } else {
        confirmPass.type = "password"
    }


}




