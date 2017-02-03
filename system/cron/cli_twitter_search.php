<?php

ini_set('display_errors', 0);
//error_reporting(E_ALL);
require 'twitter/TwitterSearch.php';

$search = new TwitterSearch('monkey');
$results = $search->results();

print_r($results);
?>
