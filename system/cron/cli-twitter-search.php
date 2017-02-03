<?php
require_once 'twitter/twitter.class.php';

$date = "2014-01-23";
$search_query = "#".'coca cola';

$consumerKey = "MWW0gxvfZvvKgUGUdndA";
$consumerSecret = "6rjmCQKNMjFiR0qHHLF7KACT0Z2Pd5XQ99LWcScEk";
$accessToken = "189920488-6Z4f3zt6BQiFZYqVxRUX8VwCHsgD9mNhxelqg3ML";
$accessTokenSecret = "Ofvv3VFrDs45hAxqVHvhmnOwrW6hC4FxP7KXeEPahl8";
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
//$twitter->twitter = 1000000000000000000000000000000000000000000000000;
$twittesIds = array();
for($dateStart = 0;$dateStart<8;$dateStart++){
    
    $dayNum = '-'.$dateStart." day";
    $dateUntil = date('Y-m-d',(strtotime ($dayNum,strtotime($date))));
    print($dateUntil." \n");
    
    $results = $twitter->search(array('q' => $search_query,'count'=>100,'until'=>$dateUntil)); // 2014-01-16
    // or use hashmap: $results = $twitter->search(array('q' => '#nette', 'geocode' => '50.088224,15.975611,20km'));
    foreach ($results as $status){

    if (!in_array($status->id_str, $twittesIds)) {
        array_push($twittesIds,$status->id_str);
        print($status->id_str." Added \n");
    }
    }
}

print("Total counts : ".count($twittesIds));

?>