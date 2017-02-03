<?php

ini_set('display_errors', 0);
//error_reporting(E_ALL);
require 'facebook/facebookSearcher.class.php';
$APPID = '237820963058461';
$APPSECRET = '7984f054de9faf468c7cd83889bd5d40';
$action = "https://graph.facebook.com/oauth/access_token?client_id=" . $APPID . "&client_secret=" . $APPSECRET . "&grant_type=client_credentials";
$ch = curl_init($action);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.9.1.1) Gecko/20090715 Firefox/3.5.1');
$r = curl_exec($ch);
$access_token = substr($r, 13);

$searcher = new facebookSearcher();
$searcher->setAccessToken($access_token);


//*********** Place Search ***************************************
/*
$searcher->setQuery('coca cola')
        ->setType('place') // post,event,page,group,checkin
        ->setLimit(50);
$graph_res = $searcher->fetchResults();

foreach ($graph_res->data as $post) {


    $street = $post->location->street;
    $city = $post->location->city;
    $state = $post->location->state;
    $country = $post->location->country;
    $zip = $post->location->zip;
    $latitude = $post->location->latitude;
    $longitude = $post->location->longitude;
    
    
    print("Street : " . $street . "\n");
    print("City : " . $city . "\n");
    print("State : " . $state . "\n");
    print("Country : " . $country . "\n");
    print("Zip : " . $zip . "\n");
    print("Latitude : " . $latitude . "\n");
    print("Longitude : " . $longitude . "\n");
    
    
    

    print("===============================\n");
    print("\n");
}
 
 */
//***************************************************************


//============= post search ==========================

/*
$searcher->setQuery('coca cola')
        ->setType('post') // post,event,page,group,checkin
        ->setLimit(100000);
$graph_res = $searcher->fetchResults();

$totalPost = 0;

foreach($graph_res->data as $post){
    
    print("The post from ".$post->from->name."\n");
    
  $totalPost = $totalPost + 1;
            
        } 

print("Total Post : $totalPost");
 * 
 */
//====================================================



//============= facebook event search ==========================
/*

$searcher->setQuery('coca cola')
        ->setType('page') // post,event,page,group,checkin
        ->setLimit(2000);
$graph_res = $searcher->fetchResults();
$totalPages = 0;

foreach($graph_res->data as $post){
    
    print($post->name."\n");
    
  $totalPages = $totalPages + 1;
            
        } 

print("Total Pages : $totalPages");
 * 
 */
//=============== Ends facebook event search =====================================



//============= facebook group search ==========================


$searcher->setQuery('coca cola')
        ->setType('checkin') // post,event,page,group,checkin
        ->setLimit(2000);
$graph_res = $searcher->fetchResults();
$totalPages = 0;
print_r($graph_res);exit;
foreach($graph_res->data as $post){
    
    //print($post->name."\n");
    
  $totalPages = $totalPages + 1;
            
        } 

print("Total Pages : $totalPages");
//=============== Ends facebook group search =====================================

?>
