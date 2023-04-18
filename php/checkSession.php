<?php
    //Start session management
    session_start();
    
    //Find out if session exists
    if( array_key_exists("username", $_SESSION) ){
        echo 'Session in progress. username=' . $_SESSION["username"];
    }
    else{
        echo 'Session not started';
    }
    
    