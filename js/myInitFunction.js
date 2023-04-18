function init() {//this function will hold the profiles name of the user into that welcome guest box
    let profile = document.getElementById("profile");
    let profile2 = document.getElementById("profile2")//getting id
    if (localStorage.loggedInUser === undefined) {//if no logged in user then it will show guest
        localStorage.loggedInUser = "Guest";
    }
    let loggedInUser = localStorage.getItem("loggedInUser");//else it will show the logged in user's username in the nav bar
    profile.innerText = loggedInUser;
    profile2.innerText = loggedInUser;

}