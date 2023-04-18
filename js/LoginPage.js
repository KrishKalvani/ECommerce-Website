function Login() {

    
    console.log("before parsing users");
    let users = JSON.parse(localStorage.getItem("users"));//users array
    console.log("after parsing users");
    console.log("before checking username in users");
    let inputUsername = document.getElementById("username").value; //getting inputs
    let inputPassword = document.getElementById("Loginpwd").value;
    //User does not have an account
    let usernameNotFound=true;//we use a flag/toggle/sentinal variable called usernameNotFound which makes sure that 
    //user login credential checking is continued rather than ended after first login. so its set to true cause no name was found
    for(let i=0; i<users.length; i++){
        if(users[i].myUsername==inputUsername){
            usernameNotFound=false;//its then set to false as we found it
            alert("username found");
            break;
        }
    }
    if(usernameNotFound){
        alert("Username not Found. Please Register!");
            console.log("username not in users");
            return; //Do nothing else
    }
    
        
        let selectedUser;
        users.forEach(user => {
            if(user.myUsername==inputUsername && user.myPassword==inputPassword){
                selectedUser=user;
                
                
            }
            
            
        });
        if(selectedUser===undefined){//if user doesnt exist or password is wrong
            alert("Login failed, Password Incorrect. Please try again.")
        }else{
            alert("Login successful");
            sessionStorage.loggedInUser=selectedUser.myUsername;

                location.href="../pages/TShirtsPage.html";
        }
        
    }

     function logOut() {//for the logout button
         localStorage.loggedInUser="Guest";
         window.location.reload();
    
    
     }


