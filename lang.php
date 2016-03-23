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
    $invalidchartitle   = "You can only use letters and numbers in your title"; //Invalid characters
    $waitTime           = 60;                                                    //Wait time in seconds
    $char               = 25;                                                   //Character minimum
    $pleaseWait         = "Please wait $waitTime seconds before posting again.";        //Please wait
    $messageTooShort    = "Your message needs to be at least $char characters long"; //Message too short

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
     $banned            = "You have been banned from this forum";               //Banned

     /**
     * Profile system
     **/

     $repError          = "You tried to add more or less reputation than you are allowed to.";  //User tried to add invalid amount for reputation
     $addRepToSelf      = "You can't add reputation to yourself";               //Self repping
     $repAdded          = "Reputation successfully added.";                     //Reputation was added
     $repUpdated        = "Reputation successfully updated.";                   //Reputation was updated
     $profileUpdated    = "Your profile was successfully updated.";             //Profile updated
     $notAWebsite       = "That is not a valid website.";                       //Invalid website

     /**
     * Avatar uploading
     **/

     $imageNotAllowed   = "That type of image is not allowed.";                 //Image not allowed
     $imageTooBig       = "Your avatar is too big.";                            //Avatar too big
     $couldNotMoveFile  = "There an an error moving the file, please try again.";   //Could not move file


     /**
      * Page handling
      **/

      $noaccess         = $pagedoesnotexist;                                    //No access to page
      $noSearchResults  = "There are no search results for that query";  //No search results

     /**
      * Pagination
      **/

      $perpage          = 9;                                                   //Maximum results per page
      $maxUsersPerPage  = 10;                                                  //Maximum users per page
      $noResultsDisplay = "There are no results on this page";                 //Invalid pagenumber
?>
