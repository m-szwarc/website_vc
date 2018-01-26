<?php
/**
 * Website Version Control Script
 * User-defined functions and settings
 * 
 * Version 1.0
 * Released 2018-01-26
 * 
 * License: GNU GPLv3
 *
 * Copyright (c) 2018, Marcin Szwarc
 * 
 ********************************************************************************
 *                                                                              *
 * In this file, you should write code that integrates Version Controller with  *
 * your server environment (like connections with database).                    *
 * Please fill these functions with your code and set constants to values that  *
 * fit your system the best.                                                    *
 *                                                                              *
 ********************************************************************************
 */

define(DEFAULT_VERSION, 'default');           // Default version directory
define(VERSIONS_DIRECTORY, 'versions/');      // Directory containing versions, must end with slash
define(ROOT_FILE, 'index.php');               // Main file for each version

define(SERIAL_KEY_COOKIE_NAME, 'skey');       // Defines name of the serial key cookie
define(RANDOM_KEY_COOKIE_NAME, 'rkey');       // Defines name of the random key cookie

define(STATUS_PAGE_ENABLED, false);           // Defines if status page is enabled
define(STATUS_PAGE_URL, 'vc_status');         // Defines URL for status page

define(DISABLE_SITE, 'enable');               // Set to disable_all to disable whole site; set to disable_partial to disable users without special cookie; Anything else means 'enable'
define(DISABLE_PASS_COOKIE_NAME, 'dkey');     // Defines name of the cookie which gives access to site with disable_partial state
define(DISABLE_PASS_COOKIE_VALUE, '1234');    // Defines value that grants access to site with disable_partial state
define(DISABLE_REASON, '');                   // Defines reason for disabling this website

define(ENABLE_DEBUG, true);                  // Displays debug information (for example keys from cookies and selected version) on bottom of each site


// Returns website version for the key pair ([0] => serial, [1] => random)
function getVersionFromKeyPair($key_pair){
  return 'default';
}

// Returns next 32-byte serial key to use is sessions
// Delete this function to generate random key
// Return type: string of 64 hex chars
function getNextSerialKey(){
  return '0000000000000000000000000000000000000000000000000000000000000000';
}

// Saves session keys to database
function saveSessionKeyPair($key_pair){
  
}

// Checks if key pair is valid (eg. not expired)
// true = valid; false = invalid
function isSessionKeyPairValid($key_pair){
  return true;
}
?>