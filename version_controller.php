<?php
/**
 * Website Version Control Script
 * for easy version management
 *
 * Version 1.0
 * Released 2018-01-26
 *
 * License: GNU GPLv3
 *
 * Copyright (c) 2018, Marcin Szwarc
 *
 */

include('random-compat/random.php');          // Random number generator for PHP 5; can be omitted in PHP 7
                                              // Random Compatibility Library by Paragon Initiative Enterprises

require('vc_user.php');                       // User-defined functions
require('mime.php');                          // MIME type recognition

define('VC_VERSION', '1.0');                  // Stores script version

// Check whether site should be disabled
if(DISABLE_SITE == 'disable_all'){
  echo('<h1>This website is disabled.</h1>');
  echo(DISABLE_REASON);
  exit;
}
if(DISABLE_SITE == 'disable_partial' && !isset($_COOKIE[DISABLE_PASS_COOKIE_NAME])){
  echo('<h1>This website is disabled.</h1>');
  echo(DISABLE_REASON);
  exit;
}else{
  if(DISABLE_SITE == 'disable_partial' && $_COOKIE[DISABLE_PASS_COOKIE_NAME] != DISABLE_PASS_COOKIE_VALUE){
    echo('<h1>This website is disabled.</h1>');
    echo(DISABLE_REASON);
    exit;
  }
}

// Check whether versions directory exist
if(!file_exists(VERSIONS_DIRECTORY)){
  echo("<h1>Version directory <code>'".VERSIONS_DIRECTORY."'</code> doesn't exist</h1>");
  echo('Please check your system and settings and try again.');
  echo('<hr /><i>Version Controller '.VC_VERSION.'</i> by Marcin Szwarc');
  exit;
}

// Check whether default version directory exist
if(!file_exists(VERSIONS_DIRECTORY.DEFAULT_VERSION)){
  echo("<h1>Default version <code>'".DEFAULT_VERSION."'</code> doesn't exist</h1>");
  echo('Please check your system and settings and try again.');
  echo('<hr /><i>Version Controller '.VC_VERSION.'</i> by Marcin Szwarc');
  exit;
}

// Check whether default version's root file exist
if(!file_exists(VERSIONS_DIRECTORY.DEFAULT_VERSION.'/'.ROOT_FILE)){
  echo("<h1>Root file <code>'".ROOT_FILE."'</code> for the default version <code>'".DEFAULT_VERSION."'</code> doesn't exist</h1>");
  echo('Please check your system and settings and try again.');
  echo('<hr /><i>Version Controller '.VC_VERSION.'</i> by Marcin Szwarc');
  exit;
}

// Show status page if requested
if(STATUS_PAGE_ENABLED == true && STATUS_PAGE_URL == $_GET['path']){
  include('vc_status.php');
  exit;
}

// Include root file of specified version
$key_pair = readSessionKeyPair();
$version = getVersionFromKeyPair($key_pair);
if(!file_exists(VERSIONS_DIRECTORY.$version)) $version = DEFAULT_VERSION;
if(!file_exists(VERSIONS_DIRECTORY.$version.'/'.ROOT_FILE)) $version = DEFAULT_VERSION;

if(isset($_GET['path'])) $get_path = $_GET['path']; else $get_path = '';

if(isAssetFile($get_path)){
  header('Content-Type: '.getMimeTypeByFileName($get_path));
  $path = VERSIONS_DIRECTORY.$version.'/'.$get_path;
}else{
  $path = VERSIONS_DIRECTORY.$version.'/'.ROOT_FILE;
}

define('CURRENT_VERSION', $version);
chdir(realpath(VERSIONS_DIRECTORY.$version));

include($path);



// Debug info
if(ENABLE_DEBUG){
  if(!isAssetFile($get_path)){
    echo('<h3>Version Controller debug info</h3>');
    echo('<code>Serial key: <b>'.$key_pair[0].'</b></code><br />');
    echo('<code>Random key: <b>'.$key_pair[1].'</b></code><br />');
    echo('<code>Loaded version: <b>'.$version.'</b></code><br />');
    echo('<code>Loaded file: <b>'.$path.'</b></code><br />');
    echo('<br /><code>$_GET array:</code><pre style="margin:0 2ch">');
    print_r($_GET);
    echo('</pre>');
    
    echo('<hr /><i>Version Controller '.VC_VERSION.'</i> by Marcin Szwarc');
  }
}




// Generates new key pair
// Returns array of two keys ([0] => serial, [1] => random)
function generateSessionKeyPair(){
  if(function_exists('getNextSerialKey')) $skey = getNextSerialKey();
  else $skey = getRandomKey();
  $rkey = getRandomKey();
  setcookie(SERIAL_KEY_COOKIE_NAME, $skey, 0);
  setcookie(RANDOM_KEY_COOKIE_NAME, $rkey, 0);
  $key_pair = array($skey, $rkey);
  saveSessionKeyPair($key_pair);
  return $key_pair;
}

// Returns random 32-byte key
// Returns string of 64 hex chars
function getRandomKey(){
  if(!function_exists('random_bytes')) return randomStr(64);
  try{
    $string = bin2hex(random_bytes(32));
  }catch(Exception $e){
    $string = randomStr(64);
  }
  return $string;
}

// Reads keys from cookies or creates a new pair if keys do not exist or are invalid
// Returns array of session keys
function readSessionKeyPair(){
  if(isset($_COOKIE[SERIAL_KEY_COOKIE_NAME]) && isset($_COOKIE[RANDOM_KEY_COOKIE_NAME])){
    $skey = $_COOKIE[SERIAL_KEY_COOKIE_NAME];
    $rkey = $_COOKIE[RANDOM_KEY_COOKIE_NAME];
    $key_pair = array($skey, $rkey);
    if(isSessionKeyPairValid($key_pair)) return $key_pair;
    else return generateSessionKeyPair();
  }else{
    return generateSessionKeyPair();
  }
}

// Fallback function for generating random key
// Returns pseudo-random string of hex chars
function randomStr($length){
  $str = '';
  $keyspace = '0123456789abcdef';
  $max = mb_strlen($keyspace, '8bit') - 1;
  for($i = 0; $i < $length; $i++){
    $str .= $keyspace[rand(0, $max)];
  }
  return $str;
}

// Check if file is an asset file (like graphics, CSS files or javascript files)
function isAssetFile($path){
  if(strpos($path, '.') === false) return false;
  $ext = substr($path, strrpos($path, '.') + 1);
  $non_asset = array('php', 'php3', 'php4', 'php5', 'phtml', 'html', 'inc');
  return !in_array($ext, $non_asset);
}
?>