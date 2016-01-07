<?php
    /**
    * This file is meant for all customizable variables
    **/

    /**
     * Core
     **/

    $error              = "Something went wrong, please try again.";            //Database error
    $categoryAdded      = "The category has been added.";                       //Category has successfully been made
    $categoryExists     = "A category with that name already exists";           //Category already exists
    $categoryDeleted    = "The category has been deleted";                      //Category had successfully been deleted
    $pagedoesnotexist   = "<h2>404 Error</h2>This page does not exist";         //404 Error
    $sectiondoesnotexist = "<h2>404 Error</h2>This section does not exist";     //404 Error
    $threaddoesnotexist = "<h2>404 Error</h2>This thread does not exist";       //404 Error
    $lastCategory       = "You can't delete the last category.";                //You can't delete the last category
    $invalidchartitle   = "You can only use letters and numbers in your title";  //Invalid characters

    /**
     * Login & Register
     **/

     $redirect          = $website_url;                                         //Redirect location
     $incorrectpw       = "That is not the correct password";                   //Incorrect password
     $emptyerror        = "You left a field empty :/";                          //Field was empty
     $regsuccess        = "You have successfully registered an account. Please activate your account"; //Registration was a success
     $catcherror        = "Something went wrong, please try again.";            //Database error
     $passworderror     = "The passwords did not match.";                       //The passwords did not match
     $nomail            = "That is not a valid email address";                  //Not a valid email address
     $nocaptcha         = "You did not fill in the captcha";                    //No captcha
     $existingusername  = "That username has already been taken.";              //Username has been taken
     $existingemail     = "That email address has already been used";           //Email has been taken
     $invalidchar       = "You can only use letters and numbers in your name";  //Invalid characters
     $tooshort          = "Your password need to be at least 5 characters long";    //Password too short
     $accountactivated  = "Your account has been activated.";                   //Account has been activated
     $notactive         = "Your account has not yet been activated.";           //Account not activated
     $doesnotexist      = "That code does not exist.";                          //Invalid code

     /**
      * Page handling
      **/

      $noaccess         = $pagedoesnotexist;                                     //No access to page

     /**
      * Pagination
      **/

      $perpage          = 25;                                                   //Maximum results per page
      $noResultsDisplay = "There are no results on this page";                  //Invalid pagenumber
?>
