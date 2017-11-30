<?php
    class Authentication {
        public static function authenticate() {
            if ( ! self::loggedin() ) {
                Flash::set_alert("You must be logged in to access that page");
                header("location: authentication/login.php");
                exit;
            } //end of if statement
        } //end of authenticate function
        public static function loggedin() {
            return isset( $_SESSION['loggedin']) && $_SESSION['loggedin'] == true; 
        } //end loggedin function
    } //end of the class
?>