<?php
include 'config/db_con.php';

$SQL_REGIONS = "SELECT * FROM regions LIMIT 4500,500";
$RS_REGIONS = mysql_query($SQL_REGIONS) or die(mysql_error());


while($ROW_REGIONS = mysql_fetch_array($RS_REGIONS)){
    
    $region_id = $ROW_REGIONS['id'];
    $country_id = $ROW_REGIONS['country_id'];
    $SQL_COUNTRY = "SELECT * FROM countries WHERE id = '".$country_id."'";
    $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
    $ROW_COUNTRY_NAME = mysql_fetch_assoc($RS_COUNTRY);
    $COUNTRY_NAME = str_replace(' ','+',$ROW_COUNTRY_NAME['name']);
    
    $region_name = str_replace(' ','+',$ROW_REGIONS['name']);
    $address_string = $region_name.",".$COUNTRY_NAME;
    
$geo_url = "http://maps.google.com/maps/api/geocode/json?address=$address_string&sensor=false";
$url = file_get_contents($geo_url);
$response = json_decode($url);

$lat = $response->results[0]->geometry->location->lat;
$long = $response->results[0]->geometry->location->lng;	
if($lat != "" && $long != ""){
print($lat." / ".$long."\ln");
$SQL_UPDATE = "UPDATE regions SET latitude = '".$lat."',longitude = '".$long."' WHERE id = '".$region_id."'";
$RS_UPDATE = mysql_query($SQL_UPDATE) or die(mysql_error());
}
}

// get country .......................
/*
$SQL_COUNTRY = "SELECT * FROM countries";
$RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());

while($ROW_COUNTRY = mysql_fetch_array($RS_COUNTRY)){
    
    $country_code = $ROW_COUNTRY['code'];
    $country_id  = $ROW_COUNTRY['id'];
    
    
    //$url = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=UK+Hull&sensor=false&region=UK");
    $geo_url = "http://maps.google.com/maps/api/geocode/json?components=country:$country_code&sensor=false";
$url = file_get_contents($geo_url);
$response = json_decode($url);

$lat = $response->results[0]->geometry->location->lat;
$long = $response->results[0]->geometry->location->lng;	

if($lat != "" && $long != ""){
    
    print($lat." / ".$long."\ln");
    $SQL_UPDATE = "UPDATE countries SET latitude = '".$lat."',longitude = '".$long."' WHERE id = '".$country_id."'";
$RS_UPDATE = mysql_query($SQL_UPDATE) or die(mysql_error());
    
}


    
}
*/

?>
