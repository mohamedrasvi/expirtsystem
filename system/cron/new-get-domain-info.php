<?php

include('db_con.php');
include('myfunctions.php');
include('simple_html_dom.php');
include('Logger.php');

$objLogger = new Logger();
$objLogger->write("new-get-domain-info.php started to update the domain details");


// update country id, if we have state....
$SQL_DOMAINS = "SELECT * FROM tbl_domains WHERE country_id = 0";
$RS_DOMAIN = mysql_query($SQL_DOMAINS,DB_CONNECTION) or die(mysql_error());
$row_id = 0;
while ($ROW_DOMAIN = mysql_fetch_assoc($RS_DOMAIN)) {
    
    $domainId = $ROW_DOMAIN['id'];
    $domainName = $ROW_DOMAIN['domain_name'];
    $ip = gethostbyname($domainName);
   
    $record = geoip_record_by_name($ip);


    $registrant_city = $record['city'];
    $registrant_state = $record['region'];
    $registrant_country = $record['country_name'];
    
    $registrant_city = mysql_escape_string($registrant_city);
    $registrant_state = mysql_escape_string($registrant_state);
    $registrant_country = mysql_escape_string($registrant_country);
    
    print($registrant_country." s ".$registrant_state." c ".$registrant_city."\n");
    

    if ($registrant_country != "") {
        $SQL_CITY = "SELECT * FROM countries WHERE name LIKE '" . $registrant_country . "' OR code LIKE '" . $registrant_country . "' OR code3 LIKE '" . $registrant_country . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);

        if ($ROW_CITY) {
            $COUNTRY_ID = $ROW_CITY['id'];
            print("Country Found : $registrant_country  \n");
        } else {
            $SQL_INSERT = "INSERT INTO countries(name) values('" . $registrant_country . "')";
            $country_rs = mysql_query($SQL_INSERT,DB_CONNECTION);
            $COUNTRY_ID = mysql_insert_id();
            print("new Country added : $registrant_country  \n");
        }
    }



    if ($registrant_state != "") {
        $SQL_CITY = "SELECT * FROM regions WHERE (name LIKE '" . $registrant_state . "' OR code LIKE '" . $registrant_state . "') AND country_id = '" . $COUNTRY_ID . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);
        if ($ROW_CITY) {
            $REGION_ID = $ROW_CITY['id'];
            print("Region Found : $registrant_state \n");
        } else {
            $SQL_INSERT_REGION = "INSERT INTO regions(name,country_id) values('" . $registrant_state . "','" . $COUNTRY_ID . "')";
            $region_rs = mysql_query($SQL_INSERT_REGION,DB_CONNECTION) or die(mysql_error());
            $REGION_ID = mysql_insert_id();
            print("new Region added : $registrant_state \n");
        }
    }




    if ($registrant_city != "") {
        $SQL_CITY = "SELECT * FROM cities WHERE name LIKE '" . $registrant_city . "' AND region_id = '" . $REGION_ID . "' AND country_id = '" . $COUNTRY_ID . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);
        if ($ROW_CITY) {
            $CITY_ID = $ROW_CITY['id'];
            print("City Found : $registrant_city \n");
        } else {
            $SQL_INSERT_CITY = "INSERT INTO cities(name,region_id,country_id) values('" . $registrant_city . "','" . $REGION_ID . "','" . $COUNTRY_ID . "')";
            $city_rs = mysql_query($SQL_INSERT_CITY,DB_CONNECTION) or die(mysql_error());
            $CITY_ID = mysql_insert_id();
            print("new City added : $registrant_city \n");
        }
    }


    $SQL_UPDATE = "UPDATE `tbl_domains` SET `post_code` = '" . $registrant_postal_code . "', `city_id` = '" . $CITY_ID . "', `region_id` = '" . $REGION_ID . "', `country_id` = '" . $COUNTRY_ID . "' WHERE `id` = '" . $domainId . "'";
    $RS_UPDATE = mysql_query($SQL_UPDATE,DB_CONNECTION) or die(mysql_error());
    print("The domain details updated \n");
    
}

exit;

$SQL_DOMAINS = "SELECT * FROM tbl_domains";
$RS_DOMAIN = mysql_query($SQL_DOMAINS,DB_CONNECTION) or die(mysql_error());

$row_id = 0;
while ($ROW_DOMAIN = mysql_fetch_assoc($RS_DOMAIN)) {
    $domain_id = $ROW_DOMAIN['id'];
    $domain_name = $ROW_DOMAIN['domain_name'];

    print($domain_name . "\n");






    $domain_name = $domain_name;
    $domain_ext = getFileExtension($domain_name);


    $domain_url = "http://who.is/whois/" . $domain_name;


    $registrant_city = "";
    $registrant_state = "";
    $registrant_postal_code = "";
    $registrant_country = "";



    $pageData = file_get_contents_curl($domain_url);
    $pageHtml = str_get_html($pageData);
    if (method_exists($pageHtml, "find")) {

        if ($pageHtml->find('span[data-bind-domain=raw_registrar_lookup]')) {
            foreach ($pageHtml->find('span[data-bind-domain=raw_registrar_lookup]') as $row) {

                if ($domain_ext == 'info' || $domain_ext == 'biz' || $domain_ext == 'mobi') {
                    $rawRegistrarData = $row->plaintext;
                    $strRegistrarData = explode("&nbsp;&nbsp;&nbsp;&nbsp;", $rawRegistrarData);

                    foreach ($strRegistrarData As $rIndex => $registrarData) {

                        if (preg_match('/City:/', $registrarData)) {
                            $registrant_city = trim(str_replace('City: ', '', $registrarData));
                            $registrant_city = trim(str_replace('City:', '', $registrant_city));
                            $registrant_city = trim(str_replace('&nbsp;', '', $registrant_city));
                        }

                        if (preg_match('/State:/', $registrarData)) {
                            $registrant_state = trim(str_replace('State: ', '', $registrarData));
                            $registrant_state = trim(str_replace('State:', '', $registrant_state));
                            $registrant_state = trim(str_replace('&nbsp;', '', $registrant_state));
                        }

                        if (preg_match('/Zip:/', $registrarData)) {
                            $registrant_postal_code = trim(str_replace('Zip: ', '', $registrarData));
                            $registrant_postal_code = trim(str_replace('Zip:', '', $registrant_postal_code));
                            $registrant_postal_code = trim(str_replace('&nbsp;', '', $registrant_postal_code));
                        }

                        if (preg_match('/Country:/', $registrarData)) {
                            $registrant_country = trim(str_replace('Country: ', '', $registrarData));
                            $registrant_country = trim(str_replace('Country:', '', $registrant_country));
                            $registrant_country = trim(str_replace('&nbsp;', '', $registrant_country));
                        }

                        if (preg_match('/Administrative Contact Information:/', $registrarData)) {
                            break;
                        }
                    }
                } elseif ($domain_ext == 'com' || $domain_ext == 'aero' || $domain_ext == 'net') {
                    $rawRegistrarData = $row->innertext;
                    $strRegistrarData = explode("<br>", $rawRegistrarData);
                    foreach ($strRegistrarData As $rIndex => $registrarData) {

                        if (preg_match('/Registrant City:/', $registrarData)) {
                            $registrant_city = trim(str_replace('Registrant City: ', '', $registrarData));
                            $registrant_city = trim(str_replace('Registrant City:', '', $registrant_city));
                            $registrant_city = trim(str_replace('&nbsp;', '', $registrant_city));
                        }

                        if (preg_match('/Registrant State/', $registrarData)) {
                            $registrant_state = trim(str_replace('Registrant State/Province: ', '', $registrarData));
                            $registrant_state = trim(str_replace('Registrant State/Province:', '', $registrant_state));
                            $registrant_state = trim(str_replace('&nbsp;', '', $registrant_state));
                        }

                        if (preg_match('/Registrant Postal Code:/', $registrarData)) {
                            $registrant_postal_code = trim(str_replace('Registrant Postal Code: ', '', $registrarData));
                        }

                        if (preg_match('/Registrant Country:/', $registrarData)) {
                            $registrant_country = trim(str_replace('Registrant Country: ', '', $registrarData));
                            $registrant_country = trim(str_replace('Registrant Country:', '', $registrant_country));
                            $registrant_country = trim(str_replace('&nbsp;', '', $registrant_country));
                        }

                        if (preg_match('/Admin Name:/', $registrarData)) {
                            break;
                        }
                    }
                } else {
                    print("Who is not found for the domain : " . $domain_name . "\n");
                }
            }
        } elseif ($pageHtml->find('div[class=registrar-information domain-data]')) {

            foreach ($pageHtml->find('div[class=registrar-information domain-data]') as $row) {

                if ($domain_ext == 'com' || $domain_ext == 'aero' || $domain_ext == 'asia' || $domain_ext == 'coop' || $domain_ext == 'int') {
                    $rawRegistrarData = $row->plaintext;

                    $rawRegistrarData = $row->innertext;
                    $strRegistrarData = explode("<br>", $rawRegistrarData);

                    foreach ($strRegistrarData As $rIndex => $registrarData) {

                        if (preg_match('/Registrant City:/', $registrarData)) {
                            $registrant_city = trim(str_replace('Registrant City:', '', $registrarData));
                            $registrant_city = trim(str_replace('Registrant City: ', '', $registrant_city));
                            $registrant_city = trim(str_replace('&nbsp;', '', $registrant_city));
                        }

                        if (preg_match('/Registrant State/', $registrarData)) {
                            $registrant_state = trim(str_replace('Registrant State/Province:', '', $registrarData));
                            $registrant_state = trim(str_replace('Registrant State/Province: ', '', $registrant_state));
                            $registrant_state = trim(str_replace('&nbsp;', '', $registrant_state));
                        }

                        if (preg_match('/Registrant Postal Code:/', $registrarData)) {
                            $registrant_postal_code = trim(str_replace('Registrant Postal Code:', '', $registrarData));
                        }

                        if (preg_match('/Registrant Country:/', $registrarData)) {
                            $registrant_country = trim(str_replace('Registrant Country:', '', $registrarData));
                            $registrant_country = trim(str_replace('Registrant Country: ', '', $registrant_country));
                            $registrant_country = trim(str_replace('&nbsp;', '', $registrant_country));
                        }

                        if (preg_match('/Admin Name:/', $registrarData)) {
                            break;
                        }
                    }


                    if ($registrant_country == "" && $registrant_state == "") {



                        foreach ($strRegistrarData As $rIndex => $registrarData) {

                            if (preg_match('/City:/', $registrarData)) {
                                $registrant_city = trim(str_replace('City:', '', $registrarData));
                                $registrant_city = trim(str_replace('&nbsp;', '', $registrant_city));
                            }

                            if (preg_match('/Province:/', $registrarData)) {
                                $registrant_state = trim(str_replace('State/Province:', '', $registrarData));
                                $registrant_state = trim(str_replace('&nbsp;', '', $registrant_state));
                                $registrant_state = trim(str_replace('District of ', '', $registrant_state));
                            }

                            if (preg_match('/Postal code:/', $registrarData)) {
                                $registrant_postal_code = trim(str_replace('Postal code:', '', $registrarData));
                                $registrant_postal_code = trim(str_replace('&nbsp;', '', $registrant_postal_code));
                            }

                            if (preg_match('/Country:/', $registrarData)) {
                                $registrant_country = trim(str_replace('Country:', '', $registrarData));
                                $registrant_country = trim(str_replace('&nbsp;', '', $registrant_country));
                            }

                            if (preg_match('/admin:/', $registrarData)) {
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

    $registrant_city = mysql_escape_string($registrant_city);
    $registrant_state = mysql_escape_string($registrant_state);
    $registrant_country = mysql_escape_string($registrant_country);





    if ($registrant_country != "") {
        $SQL_CITY = "SELECT * FROM countries WHERE name LIKE '" . $registrant_country . "' OR code LIKE '" . $registrant_country . "' OR code3 LIKE '" . $registrant_country . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);

        if ($ROW_CITY) {
            $COUNTRY_ID = $ROW_CITY['id'];
            print("Country Found : $registrant_country  \n");
        } else {
            $SQL_INSERT = "INSERT INTO countries(name) values('" . $registrant_country . "')";
            $country_rs = mysql_query($SQL_INSERT,DB_CONNECTION);
            $COUNTRY_ID = mysql_insert_id();
            print("new Country added : $registrant_country  \n");
        }
    }


    if ($registrant_state != "") {
        $SQL_CITY = "SELECT * FROM regions WHERE (name LIKE '" . $registrant_state . "' OR code LIKE '" . $registrant_state . "') AND country_id = '" . $COUNTRY_ID . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);
        if ($ROW_CITY) {
            $REGION_ID = $ROW_CITY['id'];
            print("Region Found : $registrant_state \n");
        } else {
            $SQL_INSERT_REGION = "INSERT INTO regions(name,country_id) values('" . $registrant_state . "','" . $COUNTRY_ID . "')";
            $region_rs = mysql_query($SQL_INSERT_REGION,DB_CONNECTION) or die(mysql_error());
            $REGION_ID = mysql_insert_id();
            print("new Region added : $registrant_state \n");
        }
    }



    if ($registrant_city != "") {
        $SQL_CITY = "SELECT * FROM cities WHERE name LIKE '" . $registrant_city . "' AND region_id = '" . $REGION_ID . "' AND country_id = '" . $COUNTRY_ID . "'";
        $RS_CITY = mysql_query($SQL_CITY,DB_CONNECTION) or die(mysql_error());
        $ROW_CITY = mysql_fetch_assoc($RS_CITY);
        if ($ROW_CITY) {
            $CITY_ID = $ROW_CITY['id'];
            print("City Found : $registrant_city \n");
        } else {
            $SQL_INSERT_CITY = "INSERT INTO cities(name,region_id,country_id) values('" . $registrant_city . "','" . $REGION_ID . "','" . $COUNTRY_ID . "')";
            $city_rs = mysql_query($SQL_INSERT_CITY,DB_CONNECTION) or die(mysql_error());
            $CITY_ID = mysql_insert_id();
            print("new City added : $registrant_city \n");
        }
    }


    $SQL_UPDATE = "UPDATE `tbl_domains` SET `post_code` = '" . $registrant_postal_code . "', `city_id` = '" . $CITY_ID . "', `region_id` = '" . $REGION_ID . "', `country_id` = '" . $COUNTRY_ID . "' WHERE `id` = '" . $domain_id . "'";
    $RS_UPDATE = mysql_query($SQL_UPDATE,DB_CONNECTION) or die(mysql_error());
    print("The domain details updated \n");

    if ($row_id % 10 == 0) {
        usleep(600);
    } else {
        usleep(200);
    }

    $row_id = $row_id + 1;
}





$SQL_DOMAIN_COUNTRY = "SELECT * FROM tbl_domains WHERE country_id = 0";
$RS_DOMAIN_COUNTRY = mysql_query($SQL_DOMAIN_COUNTRY,DB_CONNECTION) or die(mysql_error());

while ($ROW_COUNTRY = mysql_fetch_array($RS_DOMAIN_COUNTRY)) {

    $domain_id = $ROW_COUNTRY['id'];
    $region_id = $ROW_COUNTRY['region_id'];
    $city_id = $ROW_COUNTRY['city_id'];
    print($region_id . "\n");
    $SQL_REGION = "SELECT * FROM regions WHERE id = '" . $region_id . "'";
    $RS_REGION = mysql_query($SQL_REGION,DB_CONNECTION) or die(mysql_error());
    $ROW_REGION = mysql_fetch_assoc($RS_REGION);
    $countryId = $ROW_REGION['country_id'];

    if ($countryId != "") {
        $SQL_UPDATE_COUNTRY = "UPDATE tbl_domains SET country_id = '" . $countryId . "' WHERE id = '" . $domain_id . "'";
        $RS_Country = mysql_query($SQL_UPDATE_COUNTRY,DB_CONNECTION) or die(mysql_error());
        print("Country id updated for domain " . $countryId . "\n");
    }
}



$SQL_SEARCH_RESULTS = "SELECT * FROM tbl_search_results WHERE country_id = 0 OR region_id = 0 OR city_id = 0";
$RS_SEARCH_RESULTS = mysql_query($SQL_SEARCH_RESULTS,DB_CONNECTION) or die(mysql_error());
while($ROW_SEARCH_RES = mysql_fetch_array($RS_SEARCH_RESULTS)){
    
    $RES_ID = $ROW_SEARCH_RES['id'];
    $DOMAIN_ID = $ROW_SEARCH_RES['result_from_link_domain_name'];
    
    $SQL_DOMAIN_INFO =  "SELECT * FROM tbl_domains WHERE id = '".$DOMAIN_ID."'";
    $RS_DOMAIN_INFO = mysql_query($SQL_DOMAIN_INFO,DB_CONNECTION) or die(mysql_error());
    $ROW_DOMAIN_INFO = mysql_fetch_assoc($RS_DOMAIN_INFO);
    $DOMAIN_COUNTRY_ID = $ROW_DOMAIN_INFO['country_id'];
    $DOMAIN_REGION_ID = $ROW_DOMAIN_INFO['region_id'];
    $DOMAIN_CITY_ID = $ROW_DOMAIN_INFO['city_id'];
    
    $SQL_UPDATE_SEARCH_RES = "UPDATE tbl_search_results SET country_id = '".$DOMAIN_COUNTRY_ID."',region_id = '".$DOMAIN_REGION_ID."',city_id = '".$DOMAIN_CITY_ID."' WHERE id = '".$RES_ID."'";
    $RS_UPDATE_SEARCH_INFO = mysql_query($SQL_UPDATE_SEARCH_RES,DB_CONNECTION) or die(mysql_error());
    
}


$objLogger->write("new-get-domain-info.php completed");
print("City -" . $registrant_city . "\n");
print("State -" . $registrant_state . "\n");
print("Zip -" . $registrant_postal_code . "\n");
print("Country -" . $registrant_country . "\n");
?>
