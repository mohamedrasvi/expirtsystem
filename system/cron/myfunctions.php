<?php

function myStrReplace($str) {
    $order = array("Registrant Street: ","Registrant Street:", "Registrant City: ","Registrant City:", "Registrant State/Province: ","Registrant State/Province:", "Registrant Postal Code: ","Registrant Postal Code:", "Registrant Country: ","Registrant Country:","Registrant Country Code:","Registrant Country/Economy:","Country......:","Registant");
    $replace = '';
    $newstr = str_replace($order, $replace, $str);
    $newstr = trim($newstr);
    return $newstr;
}

function getDotComSiteAddress($domainName) {
    $addressString = "";
    $objDomainAddress = new stdClass();

    $whois = new Whois();
    $result = $whois->Lookup($domainName);
    $regrinfo = $result['regrinfo'];
    $domain_owner = $regrinfo['owner'];
    $domain_admin = $regrinfo['admin'];
    $domain_tech = $regrinfo['tech'];

    $domain_owner_address = $domain_owner['address'];
    $domain_admin_address = $domain_admin['address'];
    $domain_tech_address = $domain_tech['address'];

    $addressLine1 = "";
    $addressLine2 = "";
    $addressLine3 = "";
    $addressLine4 = "";
    $addressLine5 = "";
    if ($domain_owner_address) {
        if (isset($domain_owner_address[0])) {
            $addressLine1 = $domain_owner_address[0];
        }
        if (isset($domain_owner_address[1])) {
            $addressLine2 = $domain_owner_address[1];
        }
        if (isset($domain_owner_address[2])) {
            $addressLine3 = $domain_owner_address[2];
        }
        if (isset($domain_owner_address[3])) {
            $addressLine4 = $domain_owner_address[3];
        }
        if (isset($domain_owner_address[4])) {
            $addressLine5 = $domain_owner_address[4];
        }
    } elseif ($domain_admin_address) {
        if (isset($domain_admin_address[0])) {
            $addressLine1 = $domain_admin_address[0];
        }
        if (isset($domain_admin_address[1])) {
            $addressLine2 = $domain_admin_address[1];
        }
        if (isset($domain_admin_address[2])) {
            $addressLine3 = $domain_admin_address[2];
        }
        if (isset($domain_admin_address[3])) {
            $addressLine4 = $domain_admin_address[3];
        }
        if (isset($domain_admin_address[4])) {
            $addressLine5 = $domain_admin_address[4];
        }
    } elseif ($domain_tech_address) {

        if (isset($domain_tech_address[0])) {
            $addressLine1 = $domain_tech_address[0];
        }
        if (isset($domain_tech_address[1])) {
            $addressLine2 = $domain_tech_address[1];
        }
        if (isset($domain_tech_address[2])) {
            $addressLine3 = $domain_tech_address[2];
        }
        if (isset($domain_tech_address[3])) {
            $addressLine4 = $domain_tech_address[3];
        }
        if (isset($domain_tech_address[4])) {
            $addressLine5 = $domain_tech_address[4];
        }
    } else {



        $regrinfo = $result['rawdata'];

        $addressLine1 = myStrReplace($regrinfo[9]);
        $addressLine2 = myStrReplace($regrinfo[10]);
        $addressLine3 = myStrReplace($regrinfo[11]);
        $addressLine4 = myStrReplace($regrinfo[12]);
        $addressLine5 = myStrReplace($regrinfo[13]);
        $addressLine6 = myStrReplace($regrinfo[14]);
    }

    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $addressLine6;
    return $addressString;
}

function getDotInfoSiteAddress($domainName) {

    $whois = new Whois();
    $result = $whois->Lookup($domainName);
    $regrinfo = $result['regrinfo'];

    $domain_owner = $regrinfo['owner'];
    $domain_admin = $regrinfo['admin'];
    $domain_tech = $regrinfo['tech'];


    $domain_owner_address = $domain_owner['address'];
    $domain_admin_address = $domain_admin['address'];
    $domain_tech_address = $domain_tech['address'];

    $addressLine1 = "";
    $addressLine2 = "";
    $addressLine3 = "";
    $addressLine4 = "";
    $addressLine5 = "";


    if ($domain_owner_address) {
        if (isset($domain_owner_address['street'])) {
            $addressLine1 = $domain_owner_address['street'][0];
        }
        if (isset($domain_owner_address['city'])) {
            $addressLine2 = $domain_owner_address['city'];
        }
        if (isset($domain_owner_address['state'])) {
            $addressLine3 = $domain_owner_address['state'];
        }
        if (isset($domain_owner_address['pcode'])) {
            $addressLine4 = $domain_owner_address['pcode'];
        }
        if (isset($domain_owner_address['country'])) {
            $addressLine5 = $domain_owner_address['country'];
        }
    } elseif ($domain_admin_address) {
        if (isset($domain_admin_address['street'])) {
            $addressLine1 = $domain_admin_address['street'][0];
        }
        if (isset($domain_admin_address['city'])) {
            $addressLine2 = $domain_admin_address['city'];
        }
        if (isset($domain_admin_address['state'])) {
            $addressLine3 = $domain_admin_address['state'];
        }
        if (isset($domain_admin_address['pcode'])) {
            $addressLine4 = $domain_admin_address['pcode'];
        }
        if (isset($domain_admin_address['country'])) {
            $addressLine5 = $domain_admin_address['country'];
        }
    } else {

        if (isset($domain_tech_address['street'])) {
            $addressLine1 = $domain_tech_address['street'][0];
        }
        if (isset($domain_tech_address['city'])) {
            $addressLine2 = $domain_tech_address['city'];
        }
        if (isset($domain_tech_address['state'])) {
            $addressLine3 = $domain_tech_address['state'];
        }
        if (isset($domain_tech_address['pcode'])) {
            $addressLine4 = $domain_tech_address['pcode'];
        }
        if (isset($domain_tech_address['country'])) {
            $addressLine5 = $domain_tech_address['country'];
        }
    }

    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $addressLine6;
    return $addressString;
}

function getDefaultSiteAddress($domainName) {

    $whois = new Whois();
    $result = $whois->Lookup($domainName);
    $regrinfo = $result['regrinfo'];



    $domain_owner = $regrinfo['owner'];
    $domain_admin = $regrinfo['admin'];
    $domain_tech = $regrinfo['tech'];


    $domain_owner_address = $domain_owner['address'];
    $domain_admin_address = $domain_admin['address'];
    $domain_tech_address = $domain_tech['address'];

    $addressLine1 = "";
    $addressLine2 = "";
    $addressLine3 = "";
    $addressLine4 = "";
    $addressLine5 = "";


    if ($domain_owner_address) {
        if (isset($domain_owner_address['street'])) {
            $addressLine1 = $domain_owner_address['street'][0];
        }
        if (isset($domain_owner_address['city'])) {
            $addressLine2 = $domain_owner_address['city'];
        }
        if (isset($domain_owner_address['state'])) {
            $addressLine3 = $domain_owner_address['state'];
        }
        if (isset($domain_owner_address['pcode'])) {
            $addressLine4 = $domain_owner_address['pcode'];
        }
        if (isset($domain_owner_address['country'])) {
            $addressLine5 = $domain_owner_address['country'];
        }
    } elseif ($domain_admin_address) {
        if (isset($domain_admin_address['street'])) {
            $addressLine1 = $domain_admin_address['street'][0];
        }
        if (isset($domain_admin_address['city'])) {
            $addressLine2 = $domain_admin_address['city'];
        }
        if (isset($domain_admin_address['state'])) {
            $addressLine3 = $domain_admin_address['state'];
        }
        if (isset($domain_admin_address['pcode'])) {
            $addressLine4 = $domain_admin_address['pcode'];
        }
        if (isset($domain_admin_address['country'])) {
            $addressLine5 = $domain_admin_address['country'];
        }
    } else {

        if (isset($domain_tech_address['street'])) {
            $addressLine1 = $domain_tech_address['street'][0];
        }
        if (isset($domain_tech_address['city'])) {
            $addressLine2 = $domain_tech_address['city'];
        }
        if (isset($domain_tech_address['state'])) {
            $addressLine3 = $domain_tech_address['state'];
        }
        if (isset($domain_tech_address['pcode'])) {
            $addressLine4 = $domain_tech_address['pcode'];
        }
        if (isset($domain_tech_address['country'])) {
            $addressLine5 = $domain_tech_address['country'];
        }
    }

    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $addressLine6;
    return $addressString;
}

function getIntSiteAddress($domainName) {

    $whois = new Whois();
    $result = $whois->Lookup($domainName);
    $regrinfo = $result['regrinfo'];


    $domain_owner = $regrinfo['owner'];
    $domain_admin = $regrinfo['admin'];
    $domain_tech = $regrinfo['tech'];


    $domain_owner_address = $domain_owner['address'];
    $domain_admin_address = $domain_admin['address'];
    $domain_tech_address = $domain_tech['address'];

    $addressLine1 = "";
    $addressLine2 = "";
    $addressLine3 = "";
    $addressLine4 = "";
    $addressLine5 = "";



    if ($domain_owner_address) {
        if (isset($domain_owner_address['street'])) {
            $addressLine1 = $domain_owner_address['street'][0];
        }
        if (isset($domain_owner_address['street'])) {
            $addressLine2 = $domain_owner_address['street'][1];
        }
        if (isset($domain_owner_address['street'])) {
            $addressLine3 = $domain_owner_address['street'][2];
        }
        if (isset($domain_owner_address['street'])) {
            $addressLine4 = $domain_owner_address['street'][3];
        }
        if (isset($domain_owner_address['street'])) {
            $addressLine5 = $domain_owner_address['street'][4];
        }
    } elseif ($domain_admin_address) {
        if (isset($domain_admin_address['street'])) {
            $addressLine1 = $domain_admin_address['street'][0];
        }
        if (isset($domain_admin_address['street'])) {
            $addressLine2 = $domain_admin_address['street'][1];
        }
        if (isset($domain_admin_address['street'])) {
            $addressLine3 = $domain_admin_address['street'][2];
        }
        if (isset($domain_admin_address['street'])) {
            $addressLine4 = $domain_admin_address['street'][3];
        }
        if (isset($domain_admin_address['street'])) {
            $addressLine5 = $domain_admin_address['street'][4];
        }
    } else {

        if (isset($domain_tech_address['street'])) {
            $addressLine1 = $domain_tech_address['street'][0];
        }
        if (isset($domain_tech_address['street'])) {
            $addressLine2 = $domain_tech_address['street'][1];
        }
        if (isset($domain_tech_address['street'])) {
            $addressLine3 = $domain_tech_address['street'][2];
        }
        if (isset($domain_tech_address['street'])) {
            $addressLine4 = $domain_tech_address['street'][3];
        }
        if (isset($domain_tech_address['street'])) {
            $addressLine5 = $domain_tech_address['street'][4];
        }
    }

    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $addressLine6;
    return $addressString;
}

function getDotNetSiteAddress($domainName) {

    $whois = new Whois();
    $result = $whois->Lookup($domainName);
    $regrinfo = $result['rawdata'];



    $addressLine1 = $regrinfo[9];
    $addressLine2 = $regrinfo[10];
    $addressLine3 = $regrinfo[11];
    $addressLine4 = $regrinfo[12];
    $addressLine5 = $regrinfo[13];
    $addressLine6 = $regrinfo[14];




    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $addressLine6;
    return $addressString;
}

function get_domain($url) {
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function sendEmail($subject, $message) {
    $to = "iyngaran55@yahoo.com";
    $subject = $subject;
    $message = $message;
    $from = "hello@yegga.com";
    $headers = "From:" . $from;
    mail($to, $subject, $message, $headers);
}

function isFileExists($fileUrl) {
    $fileExists = false;
    $json = @file_get_contents($fileUrl, true);
    if ($json === false) {
// error handling
        $fileExists = false;
    } else {
// do something with $json
        $fileExists = true;
    }
    return $fileExists;
}

function isValiedUrl($websiteUrl) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $websiteUrl);
}

function isValidExtension($fileUrl) {
    $isValid = false;
    $fileExtension = end(explode(".", $fileUrl));
    if ($fileExtension == 'pdf' || $fileExtension == 'jpg' || $fileExtension == 'gif' || $fileExtension == 'png' || $fileExtension == 'txt' || $fileExtension =='mp4' || $fileExtension =='ppt' || $fileExtension =='zip' || $fileExtension =='tar' || $fileExtension =='gz' || $fileExtension =='png' || $fileExtension =='jpg' || $fileExtension =='gif' || $fileExtension =='mov' || $fileExtension =='mp3') {
        $isValid = false;
    } else {
        $isValid = true;
    }
    return $isValid;
}

function getFileExtension($filename) {
    return end(explode(".", $filename));
}

function strip_tags_content($text, $tags = '', $invert = FALSE) {
    /*
      This function removes all html tags and the contents within them
      unlike strip_tags which only removes the tags themselves.
     */
    //removes <br> often found in google result text, which is not handled below
    $text = str_ireplace('<br>', '', $text);

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if (is_array($tags) AND count($tags) > 0) {
        //if invert is false, it will remove all tags except those passed a
        if ($invert == FALSE) {
            return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            //if invert is true, it will remove only the tags passed to this function
        } else {
            return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
        //if no tags were passed to this function, simply remove all the tags
    } elseif ($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }

    return $text;
}

function file_get_contents_curl($url) {
    /*
      This is a file_get_contents replacement function using cURL
      One slight difference is that it uses your browser's idenity
      as it's own when contacting google.
     */
    $ch = curl_init();
    $HTTP_USER_AGENT = null;
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    }
    if (!$HTTP_USER_AGENT) {
        $HTTP_USER_AGENT = "Mozilla/5.0 (X11; Linux i686; rv:17.0) Gecko/20130402 Firefox/17.0";
    }

    curl_setopt($ch, CURLOPT_USERAGENT, $HTTP_USER_AGENT);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function getDomainCountry($domainName) {
    $addressLine1 = "";
    $addressLine2 = "";
    $addressLine3 = "";
    $addressLine4 = "";
    $addressLine5 = "";
    $addressLine6 = "";
    $domainCountry = "";
    $domainExt = getFileExtension($domainName);

    $UDomainExt = strtoupper($domainExt);


    $arrDomainCountry = array(
        'AC' => 'Ascension Island',
        'AD' => 'Andorra',
        'AE' => 'United Arab Emirates',
        'AF' => 'Afghanistan',
        'AG' => 'Antigua and Barbuda',
        'AI' => 'Anguilla',
        'AL' => 'Albania',
        'AM' => 'Armenia',
        'AN' => 'Antilles',
        'AP' => 'Asia Pacific',
        'AQ' => 'Antarctica',
        'AR' => 'Argentina',
        'AS' => 'American Samoa',
        'AT' => 'Austria',
        'AU' => 'Australia',
        'AZ' => 'Azerbaijan',
        'BA' => 'Bosnia and Herzegovina',
        'BB' => 'Barbados',
        'BE' => 'Belgium',
        'BF' => 'Burkina Faso',
        'BG' => 'Bulgaria',
        'BH' => 'Bahrain',
        'BI' => 'Burundi',
        'BM' => 'Bermuda',
        'BN' => 'Brunei Darussalam',
        'BO' => 'Bolivia',
        'BR' => 'Brazil',
        'BT' => 'Bhutan',
        'BY' => 'Belarus',
        'BZ' => 'Belize',
        'CA' => 'Canada',
        'CC' => 'Cocos Islands',
        'CD' => 'Republic of Congo',
        'CF' => 'Central African Republic',
        'CG' => 'Congo',
        'CH' => 'Switzerland',
        'CK' => 'Cook Islands',
        'CL' => 'Chile',
        'CM' => 'Cameroon',
        'CN' => 'China',
        'CO' => 'Colombia',
        'CR' => 'Costa Rica',
        'CU' => 'Cuba',
        'CX' => 'Christmas Island',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DE' => 'Germany',
        'DJ' => 'Djibouti',
        'DK' => 'Denmark',
        'DO' => 'Dominican Republic',
        'DZ' => 'Algeria',
        'EC' => 'Equador',
        'EE' => 'Estonia',
        'EG' => 'Egypt',
        'ES' => 'Spain',
        "FI" => "finland",
        "FJ" => "fiji",
        "FK" => "falkland",
        "FM" => "micronesia",
        "FR" => "france",
        "FO" => "Faroe Islands",
        "GB" => "Great Britain ",
        "GE" => "Georgia",
        "GF" => "French Guiana",
        "GG" => "Guernsey",
        "GG" => "Alderney",
        "GG" => "Sark",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GL" => "Greenland",
        "GM" => "Gambia",
        "GN" => "Guinea",
        "GR" => "Greece",
        "GS" => "Georgia",
        "GS" => "Sandwich",
        "GT" => "Guatemala",
        "GU" => "Guam",
        "HK" => "Hong Kong",
        "HM" => "Heard Island",
        "HN" => "Honduras",
        "HR" => "Croatia",
        "HU" => "Hungary",
        "ID" => "Indonesia",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IM" => "Isle of Man",
        "IN" => "India",
        "INT" => "International Treaties",
        "IO" => "British",
        "IR" => "Iran",
        "IS" => "Iceland",
        "IT" => "Italy",
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'JP' => 'Japan',
        'KE' => 'Kenya',
        'KG' => 'Kyrgyzstan',
        'KH' => 'Cambodia',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KY' => 'Cayman',
        'KZ' => 'Kazahstan',
        'LB' => 'Lebanon',
        'LC' => 'Saint Lucia',
        'LI' => 'Liechtenstein',
        'LK' => 'Sri Lanka',
        'LR' => 'Liberia',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'LV' => 'Latvia',
        'LY' => 'Libya',
        'MC' => 'Monaco',
        'MD' => 'Moldova',
        'MG' => 'Madagascar',
        'MH' => 'Marshall Islands',
        'MK' => 'Macedonia',
        'MM' => 'Myanmar',
        'MN' => 'Mongolia',
        'MO' => 'Macau',
        'MP' => 'Northern Mariana',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MS' => 'Montserrat',
        'MT' => 'Malta',
        'MU' => 'Mauritius',
        'MX' => 'Mexico',
        'MY' => 'Malaysia',
        'MW' => 'Malawi',
        'NA' => 'Namibia',
        'NC' => 'New Caledonia',
        'NF' => 'Norfolk Island',
        'NI' => 'Nicaragua',
        'NL' => 'Netherlands',
        'NO' => 'Norway',
        'NP' => 'Nepal',
        'NU' => 'Niue',
        'NZ' => 'New Zealand',
        'OM' => 'Oman',
        'PA' => 'Panama',
        'PE' => 'Peru',
        'PG' => 'Papua New Guinea',
        'PH' => 'Philippines',
        'PK' => 'Pakistan',
        'QA' => 'Qatar',
        'RE' => 'Reunion Island',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'SA' => 'Saudi Arabia',
        'SB' => 'Solomon Islands',
        'SE' => 'Sweden',
        'SG' => 'Singapore',
        'SH' => 'Saint Helena',
        'SI' => 'Slovenia',
        'SK' => 'Slovakia',
        'SM' => 'San Marino',
        'SN' => 'Senegal',
        'SO' => 'Somalia',
        'ST' => 'Sao Tome and Principe',
        'SU' => 'Russia',
        'SV' => 'El Salvador',
        'SZ' => 'Swaziland',
        'TC' => 'The Turks and Caicos Islands',
        'TD' => 'Tchad',
        'TF' => 'French Southern Territories',
        'TH' => 'Thailand',
        'TJ' => 'Tajikistan',
        'TM' => 'Turkmenistan',
        'TN' => 'Tunisia',
        'TO' => 'Kingdom of Tonga',
        'TP' => 'East Timor',
        'TR' => 'Turkey',
        'TT' => 'Trinidad and Tobago',
        'TV' => 'Tuvalu',
        'TW' => 'Taiwan',
        'TZ' => 'Tanzania',
        'UA' => 'Ukraine',
        'UG' => 'Uganda',
        'UK' => 'United Kingdom',
        'UM' => 'US Minor Outlying Islands',
        'US' => 'United States',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VE' => 'Venezuela',
        'VG' => 'British Virgin Islands',
        'VI' => 'US Virgin Islands',
        'VU' => 'Vanuatu',
        'WF' => 'Wallis and Futuna Islands',
        'WS' => 'Samoa',
        'YT' => 'Mayotte',
        'YU' => 'Yugoslavia',
        'ZA' => 'South Africa',
        'ZM' => 'Zambia'
    );

    if (isset($arrDomainCountry[$UDomainExt])) {
        $domainCountry = $arrDomainCountry[$UDomainExt];
    }

    $addressString = $addressLine1 . "," . $addressLine2 . "," . $addressLine3 . "," . $addressLine4 . "," . $addressLine5 . "," . $domainCountry;
    return $addressString;
}

function array_ksearch($array, $str) {
    $result = array();
    for ($i = 0; $i < count($array); next($array), $i++) {
        if (strtolower(current($array)) == strtolower($str)) {
            array_push($result, key($array));
        }
    }
    return $result;
}

function getTotalMatchingWordInStr($strString, $searchChar) {
    $totalNumber = 0;
    $arrWordsInTheString = str_word_count($strString, 1);
    $arrCountRes = array_ksearch($arrWordsInTheString, $searchChar);
    $totalNumber = count($arrCountRes);
    return $totalNumber;
}

function getGoogleLinks($serachStr, $brandId) {

    $q = isset($serachStr) ? urlencode(str_replace(' ', '+', $serachStr)) : 'none';

    print("Google Starting.....\n");
    $objLogger = new Logger();
    $objLogger->write("Google Starting for $q.....");
    $startNum = 0;
    $theData = array();

    $isNextFound = false;
    do {
        //print($startNum."\n");

        $pageData = file_get_contents_curl('https://www.google.com/search?hl=en&q=' . $q . "&start=" . $startNum);
        $pageHtml = str_get_html($pageData);

        // initialize empty array to store the data array from each row
        if (method_exists($pageHtml, "find")) {
            foreach ($pageHtml->find('#nav tr') as $row) {
                $isNextFound = false;


                if (method_exists($row, "find")) {
                    foreach ($row->find('td a') as $cell) {

                        if ($cell->plaintext != 'Previous' && $cell->plaintext != 'Next') {
                            if (!in_array($cell->plaintext, $theData)) {
                                array_push($theData, $cell->plaintext);
                                print("Page Number : " . $cell->plaintext . " added! \n");
                            }
                        }

                        if ($cell->plaintext == 'Next') {
                            $isNextFound = true;
                        }
                    }
                }
            }
        }

        if ($isNextFound == false) {
            print("Next page not found... breaking the loop");
            break;
        }

        $startNum = $startNum + 10;
    } while ($startNum < 500);


    usleep(GOOGLE_SLEEP_AFTER_GET_PAGES);


    foreach ($theData As $aIndex => $pageNum) {
        //Obtain the first page html with the formated url
        $stringUrl = 'http://www.google.com/search?hl=en&q=' . $q . "&start=" . $pageNum;
        //$stringUrl = "https://www.google.com/search?hl=en&psj=1&q=Coca-Cola#hl=en&psj=1&q=Coca-Cola&start=10";
        // $data = file_get_contents_curl($stringUrl);

        /*
          create a simple_html_dom object from the retreived string
          you could also perform file_get_html("http://...") instead of
          file_get_contents_curl above, but it wouldn't change the default
          User-Agent
         */

        // $html = str_get_html($data);

        $html = file_get_html($stringUrl);

        $result = array();
        $resultNum = 1;
        if (method_exists($html, "find")) {
            foreach ($html->find('li.g') as $g) {


                if (method_exists($g, "find")) {
                    $res_data_row_link_obj = $g->find('h3.r a');

                    foreach ($res_data_row_link_obj as $linkObj) {
                        $title = trim($linkObj->plaintext);
                        $link = trim($linkObj->href);

                        // if it is not a direct link but url reference found inside it, then extract
                        if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
                            $link = $matches[1];
                        } else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
                            continue;
                        }
                    }

                    $domainName = get_domain($link);

                    if ($domainName != "") {
                        print("Page Number : " . $pageNum);
                        print($resultNum . ".Title : " . $title);
                        print("\n");
                        print("Link from source : " . $link);
                        print("\n");
                        print("Domain Name : " . $domainName);

                        $resultNum = $resultNum + 1;

                        $SQL_INSERT = "INSERT INTO `tbl_search_links` (
                    `id`, 
                    `update_status`, 
                    `search_key`, 
                    `search_source`, 
                    `web_link`, 
                    `added_on`,
                    `tbl_brands_id`) VALUES (
                    NULL, 
                    'Waiting',
                    '" . $serachStr . "', 
                    'GOOGLE', 
                    '" . mysql_escape_string($link) . "', 
                    '" . getCurrentDate() . "',
                    '" . $brandId . "')";


                        $RS = mysql_query($SQL_INSERT, DB_CONNECTION) or die(mysql_error());
                        print("Record Inserted \n");
                        print("\n ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n");
                    }
                }
            }


//Cleans up the memory 
            if ($html) {
                $html->clear();
            }

            usleep(GOOGLE_SLEEP_BETWEENPAGES);
        }
    }

    usleep(SLEEP_BETWEEN_SEARCH_ENGINES);

    $objLogger->write("Google Completed for $q.....");
    print("Google Completed.....\n");
    print("\n");
    print("Yahoo Starting.....\n");
    $objLogger->write("Yahoo Starting for $q.....");
}

function getYahooLinks($serachStr, $brandId) {
    $objLogger = new Logger();
    $q = isset($serachStr) ? urlencode(str_replace(' ', '+', $serachStr)) : 'none';


    $startNum = 1;
    $theData = array();
    $isNextFound = false;
    $pageIndex = 1;
    do {
        $bValue = (($pageIndex * 10) - 10) + 1;
        //print($startNum."\n");
        $mainPageUrl = "http://search.yahoo.com/search;_ylt=A0oG7hGXhWxSpCAA2N1XNyoA?p=$q&ei=UTF-8&fr=yfp-t-122&b=$bValue&pstart=$startNum";
        $pageData = file_get_contents_curl($mainPageUrl);
        $pageHtml = str_get_html($pageData);
        //print($mainPageUrl."<BR/>");
        if (method_exists($pageHtml, "find")) {
            // initialize empty array to store the data array from each row
            foreach ($pageHtml->find('div[id=pg]') as $row) {
                $isNextFound = false;

                if (method_exists($row, "find")) {
                    foreach ($row->find('a') as $cell) {

                        if ($cell->plaintext != 'Prev' && $cell->plaintext != 'Next') {
                            if (!in_array($cell->plaintext, $theData)) {
                                array_push($theData, $cell->plaintext);
                                print("Page Number : " . $cell->plaintext . " added! \n");
                            }
                        }

                        if ($cell->plaintext == 'Next') {
                            $isNextFound = true;
                        }
                    }
                }
            }

            if ($isNextFound == false) {
                print("Next page not found... breaking the loop");
                break;
            }
        }


        $startNum = $startNum + 4;
        $pageIndex = $pageIndex + 1;
    } while ($startNum < 1000);

    usleep(YAHOO_SLEEP_AFTER_GET_PAGES);

    $startNum = 1;
    foreach ($theData As $aIndex => $pageNum) {

        $bValue = ((($aIndex + 1) * 10) - 10) + 1;
        //Obtain the first page html with the formated url
        $mainPageUrl = "http://search.yahoo.com/search;_ylt=A0oG7mNGp3lSbQkAQ0NXNyoA?p=$q&fr=yfp-t-122&fr2=sb-top&b=$bValue&pstart=$startNum";

        //d$ata = file_get_contents_curl($mainPageUrl);
        /*
          create a simple_html_dom object from the retreived string
          you could also perform file_get_html("http://...") instead of
          file_get_contents_curl above, but it wouldn't change the default
          User-Agent
         */

        $mainpageHtml = file_get_html($mainPageUrl);


        $result = array();
        $resultNum = 1;

        if (method_exists($mainpageHtml, "find")) {
            if ($mainpageHtml->find('div[id=results]')) {

                foreach ($mainpageHtml->find('div[id=web]') as $cIndex => $sub_data_row) {
                    $searchSourceLink = "";
                    $searchSourceLinkTitle = "";

                    if (method_exists($sub_data_row, "find")) {

                        foreach ($sub_data_row->find('div[class=res]') as $cIndex => $result_data_row) {
                            $searchSourceLink = "";
                            $searchSourceLinkTitle = "";
                            $row_data_results = str_get_html($result_data_row->innertext);
                            $mainSourceContentRow = trim($row_data_results->find('h3 a', 0));
                            $htmlResContentRow = str_get_html($mainSourceContentRow);
                            $sourceLink = "";
                            $sourceLinkTitle = "";
                            if (method_exists($htmlResContentRow, "find")) {
                                foreach ($htmlResContentRow->find('a') as $item) {
                                    if ($item->attr) {
                                        $sourceLink = $item->attr['href'];
                                        $sourceLinkTitle = $item->plaintext;
                                    }
                                }
                            }
                            $searchSourceLink = $sourceLink;
                            $searchSourceLinkTitle = $sourceLinkTitle;

                            $domainName = get_domain($searchSourceLink);
                            if ($domainName != "") {
                                print("Page Number : " . $pageNum . "\n");
                                print($resultNum . ".Title : " . $searchSourceLinkTitle);
                                print("\n");
                                print("Link from source : " . $searchSourceLink);
                                print("\n");
                                print("Domain Name : " . $domainName);
                                $resultNum = $resultNum + 1;
                                print("\n");

                                $SQL_INSERT = "INSERT INTO `tbl_search_links` (
                    `id`, 
                    `update_status`,
                    `search_key`, 
                    `search_source`, 
                    `web_link`, 
                    `added_on`,
                    `tbl_brands_id`
                    ) VALUES (
                    NULL, 
                    'Waiting',
                    '" . $serachStr . "', 
                    'YAHOO', 
                    '" . mysql_escape_string($searchSourceLink) . "', 
                    '" . getCurrentDate() . "',
                    '" . $brandId . "')";

                                $RS = mysql_query($SQL_INSERT, DB_CONNECTION) or die(mysql_error());
                                print("Record Inserted \n");
                                print("\n ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n");
                            }
                        }
                    }
                }
            }
        }





        $startNum = $startNum + 4;
//Cleans up the memory 
        if ($mainpageHtml) {
            $mainpageHtml->clear();
        }
        usleep(YAHOO_SLEEP_BETWEENPAGES);
    }
    $objLogger->write("Yahoo completed for $q.....");
//+++++++++++++++++++++++++++++++++++++++++++++++++
    print("Wait....Moving to the next brand tag");
    usleep(SLEEP_BETWEEN_BRANDS);
}

function doCounts($row_web_link, $row_search_key, $row_added_on, $row_brandId, $row_search_source) {
    $objLogger = new Logger();
    $webSiteUrl = $row_web_link;
    $searchStringKey = $row_search_key;
   
    $domainName = '';
    if (isValiedUrl($webSiteUrl)) {
        $domainName = get_domain($webSiteUrl);
        print("Domain name : ".$domainName." \n");
        
        $arrUpdatedDomainInfo = updateDomain($domainName);
        $DOMAIN_ID = $arrUpdatedDomainInfo['DOMAIN_ID'];
        $CITY_ID = $arrUpdatedDomainInfo['CITY_ID'];
        $REGION_ID = $arrUpdatedDomainInfo['REGION_ID'];
        $COUNTRY_ID = $arrUpdatedDomainInfo['COUNTRY_ID'];
        
        if ($domainName != "") {
            
            try {
                
                print("Website Url : " . $webSiteUrl . "\n");
                $theParentLinkContents = file_get_contents_curl($webSiteUrl);
                $websitePageHtml = str_get_html($theParentLinkContents);
                if (method_exists($websitePageHtml, "find")) {
                    
                    $theSiteLinks = "";
                    $arrSiteLinks = array();
                    $totalLinksFounded = 0;
                    
   
                    if(isValidExtension($webSiteUrl)){
                        
                        if($websitePageHtml->find('a')){
                           foreach ($websitePageHtml->find('a') as $element) {
                                        $theSiteLinks = $element->href;
                                        $thsLinkDomainName = get_domain($theSiteLinks);
                                        if (isValidExtension($theSiteLinks)) {

                                           if ($thsLinkDomainName == $domainName) {
                                                if (!in_array($theSiteLinks, $arrSiteLinks, true)) {
                                                        array_push($arrSiteLinks, $theSiteLinks);
                                                        $totalLinksFounded = $totalLinksFounded + 1;
                                                    
                                                    if ($totalLinksFounded == PAGE_LIMIT) {
                                                        print("Limit found and getting break..");
                                                        break;
                                                    }
                                                }
                                            } else {
                                                print("The external link " . $theSiteLinks . " Skipping.... \n");
                                            }
                                        } else {
                                            print("The website link is not valied to proccess.... ".$webSiteUrl."\n");
                                        }
                           }
                        } 
                        if($websitePageHtml){
                            $websitePageHtml->clear();
                            unset($websitePageHtml);
                        }
                        // add the main url to the array with links....
                        array_push($arrSiteLinks, $webSiteUrl);
                        
                        $countedLinks = count($arrSiteLinks);
                        print("Total : ".$countedLinks." Links founded... \n");
                        if($countedLinks>0){
                           
                             foreach ($arrSiteLinks As $lIndex => $siteLink) {
                                 
                                 
                                  // check link, if that already exists in the database....
                                $SQL_LINK_EXISTS = "SELECT * FROM tbl_search_results WHERE search_key = '" . $searchStringKey . "' AND search_source = '" . $row_search_source . "' AND date_on = '" . $row_added_on . "' AND result_link = '" . mysql_real_escape_string($siteLink) . "'";
                                $RS_LINK_EXISTS = mysql_query($SQL_LINK_EXISTS, DB_CONNECTION) or die(mysql_error());
                                $ROW_LINK_EXISTS_ROW = mysql_fetch_array($RS_LINK_EXISTS);
                                
                                 if ($ROW_LINK_EXISTS_ROW) {
                                        print("The Link $siteLink already exits in database, Row ID - " . $ROW_LINK_EXISTS_ROW['id'] . " Skiping..... \n");
                                } else {

                                     $siteLink = $siteLink;
                        
                                    if (isValidExtension($siteLink)) {

                                         try {
                                             
                                             $totalCount = getTotalCountFromLinkForSearchKey($searchStringKey,$siteLink);                                             
                                             if ($totalCount > 0) {
                                                 
                                                 
                                                 $SQL_INSERT_RESULTS = "INSERT INTO `tbl_search_results` (
                                                                    `id`, 
                                                                    `search_key`, 
                                                                    `search_source`, 
                                                                    `result_from_link`, 
                                                                    `result_from_link_domain_name`, 
                                                                    `result_link`,
                                                                    `total_count`, 
                                                                    `date_on`, 
                                                                    `updated_on`, 
                                                                    `city_id`, 
                                                                    `region_id`, 
                                                                    `country_id`,
                                                                    `tbl_brands_id`) VALUES (
                                                                    NULL, 
                                                                    '" . $row_search_key . "', 
                                                                    '" . $row_search_source . "', 
                                                                    '" . mysql_real_escape_string(addslashes($row_web_link)) . "', 
                                                                    '" . $DOMAIN_ID . "', 
                                                                    '" . mysql_real_escape_string(addslashes($siteLink)) . "', 
                                                                    '" . $totalCount . "', 
                                                                    '" . $row_added_on . "', 
                                                                    '" . getCurrentDate() . "', 
                                                                    '" . $CITY_ID . "', 
                                                                    '" . $REGION_ID . "', 
                                                                    '" . $COUNTRY_ID . "',
                                                                    '" . $row_brandId . "')";

                                                    $RS_INSERT_SEARCH_RESULTS = mysql_query($SQL_INSERT_RESULTS, DB_CONNECTION) or die(mysql_error());
                                                    print("Update Completed " . "\n");
                                                    print("Web Site Link : " . $siteLink . "\n");
                                                    print("Total Count : " . $totalCount . "\n");
                                                    usleep(2);
                                                 
                                                 
                                             }
                                             
                                             
                                        } catch (Exception $ex) {
                                            print("Error, when count - ".$ex->getMessage());
                                            $objLogger->write("Error, when count - ".$ex->getMessage());
                                            break;
                                        }
                                        
                                        
                                    } else {
                                        print("The website link is not valied to count.... ".$siteLink."\n");
                                    }
                                    
                                    
                                }
                                
                                 
                             }
                            
                            
                        }
                    } else {
                            print("The website url is not valied to proccess.... ".$webSiteUrl."\n");
                    }  

  
                } else {
                    print("Not a valied HTML  \n");
                }
                if($websitePageHtml){
                    $websitePageHtml->clear();
                    unset($websitePageHtml);
                }
            } catch (Exception $ex) {
               $objLogger->write("Error - " . $ex->getMessage());
            }
        } else {
            print("Domain name is empty  \n");
        }
        
    } else {
        print("Invalied Url : " . $webSiteUrl . "\n");
    } 
}

function updateDomain($domainName) {

    $objLogger = new Logger();
    $DOMAIN_ID = '';
    $POST_CODE = '';
    $CITY_ID = '';
    $REGION_ID = '';
    $COUNTRY_ID = '';

    if ($domainName != "") {

        $SQL_DOMAIN_EXISTS = "SELECT * FROM tbl_domains WHERE domain_name LIKE '" . $domainName . "'";
        $RS_DOMAIN_EXISTS = mysql_query($SQL_DOMAIN_EXISTS, DB_CONNECTION) or die(mysql_error());
        $ROW_DOMAIN_EXISTS_ROW = mysql_fetch_array($RS_DOMAIN_EXISTS);
        if ($ROW_DOMAIN_EXISTS_ROW) {
            $DOMAIN_ID = $ROW_DOMAIN_EXISTS_ROW['id'];
            $POST_CODE = $ROW_DOMAIN_EXISTS_ROW['post_code'];
            $CITY_ID = $ROW_DOMAIN_EXISTS_ROW['city_id'];
            $REGION_ID = $ROW_DOMAIN_EXISTS_ROW['region_id'];
            $COUNTRY_ID = $ROW_DOMAIN_EXISTS_ROW['country_id'];
            print("Domain name '$domainName' already exists.... \n");
        } else {
            $SQL_INSERT = "INSERT INTO `tbl_domains` (
            `domain_name`) VALUES (
            '" . $domainName . "')";

            $RS_DOMAIN = mysql_query($SQL_INSERT, DB_CONNECTION) or die(mysql_error());
            $DOMAIN_ID = mysql_insert_id();
            print("The new domain name '$domainName' inserted.... \n");
            $objLogger->write("The new domain name '$domainName' inserted.... ");
        }

        $domainLocation = array();

        $domainLocation['DOMAIN_ID'] = $DOMAIN_ID;
        $domainLocation['CITY_ID'] = $CITY_ID;
        $domainLocation['REGION_ID'] = $REGION_ID;
        $domainLocation['COUNTRY_ID'] = $COUNTRY_ID;

        return $domainLocation;
    }
}

function faceBookPlaceSearch($searchStringKey, $row_added_on, $row_brandId) {


    $action = "https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&client_secret=" . APPSECRET . "&grant_type=client_credentials";
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
    $searcher->setQuery($searchStringKey)
            ->setType('place'); // post,event,page,group,checkin
    $graph_res = $searcher->fetchResults();


    $num = 1;
    foreach ($graph_res->data as $post) {
        //print_r($post);
        $num = $num + 1;
        $street = mysql_escape_string($post->location->street);
        $facebook_city = mysql_escape_string($post->location->city);
        $facebook_state = mysql_escape_string($post->location->state);
        $facebook_country = mysql_escape_string($post->location->country);
        $zip = $post->location->zip;
        $latitude = $post->location->latitude;
        $longitude = $post->location->longitude;


        $FACEBOOK_COUNTRY_ID = '';
        $FACEBOOK_REGION_ID = '';
        $FACEBOOK_CITY_ID = '';

        // ************************ get country id ************************
        if ($facebook_country != "") {
            $SQL_COUNTRY = "SELECT * FROM countries WHERE name LIKE '" . $facebook_country . "' OR code LIKE '" . $facebook_country . "' OR code3 LIKE '" . $facebook_country . "'";
            $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
            $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);

            if ($ROW_COUNTRY) {
                $FACEBOOK_COUNTRY_ID = $ROW_COUNTRY['id'];
                print("Country Found : $facebook_country  \n");
            } else {
                $SQL_INSERT = "INSERT INTO countries(name) values('" . $facebook_country . "')";
                $country_rs = mysql_query($SQL_INSERT, DB_CONNECTION);
                $FACEBOOK_COUNTRY_ID = mysql_insert_id();
                print("new Country added : $facebook_country  \n");
            }
        }
        // ************************ ends country id **********************
        //************ the region id starts *****************************


        if ($facebook_state != "") {
            $SQL_STATE = "SELECT * FROM regions WHERE (name LIKE '" . $facebook_state . "' OR code LIKE '" . $facebook_state . "') AND country_id = '" . $FACEBOOK_COUNTRY_ID . "'";
            $RS_STATE = mysql_query($SQL_STATE, DB_CONNECTION) or die(mysql_error());
            $ROW_STATE = mysql_fetch_assoc($RS_STATE);
            if ($ROW_STATE) {
                $FACEBOOK_REGION_ID = $ROW_STATE['id'];
                print("Region Found : $facebook_state \n");
            } else {
                $SQL_INSERT_REGION = "INSERT INTO regions(name,country_id) values('" . $facebook_state . "','" . $FACEBOOK_COUNTRY_ID . "')";
                $region_rs = mysql_query($SQL_INSERT_REGION, DB_CONNECTION) or die(mysql_error());
                $FACEBOOK_REGION_ID = mysql_insert_id();
                print("new Region added : $facebook_state \n");
            }
        }


        //*********** end the region id ********************************
        //**************************** city id ***********************************
        if ($facebook_city != "" && $facebook_state != "") {
            $SQL_CITY = "SELECT * FROM cities WHERE name LIKE '" . $facebook_city . "' AND region_id = '" . $FACEBOOK_REGION_ID . "' AND country_id = '" . $FACEBOOK_COUNTRY_ID . "'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            if ($ROW_CITY) {
                $FACEBOOK_CITY_ID = $ROW_CITY['id'];
                print("City Found : $facebook_city \n");
            } else {
                $SQL_INSERT_CITY = "INSERT INTO cities(name,region_id,country_id) values('" . $facebook_city . "','" . $FACEBOOK_REGION_ID . "','" . $FACEBOOK_COUNTRY_ID . "')";
                $city_rs = mysql_query($SQL_INSERT_CITY, DB_CONNECTION) or die(mysql_error());
                $FACEBOOK_CITY_ID = mysql_insert_id();
                print("new City added : $facebook_city \n");
            }
        }

        //************************** ends city id ********************************

        $row_search_source = "facebook.com";

        $SQL_INSERT_RESULTS = "INSERT INTO `tbl_search_results` (
                                                        `id`, 
                                                        `search_key`, 
                                                        `search_source`, 
                                                        `result_from_link`, 
                                                        `total_count`, 
                                                        `date_on`, 
                                                        `updated_on`, 
                                                        `city_id`, 
                                                        `region_id`, 
                                                        `country_id`,
                                                        `tbl_brands_id`) VALUES (
                                                        NULL, 
                                                        '" . $searchStringKey . "', 
                                                        '" . $row_search_source . "', 
                                                        'facebook-place', 
                                                        '1', 
                                                        '" . $row_added_on . "', 
                                                        '" . getCurrentDate() . "', 
                                                        '" . $FACEBOOK_CITY_ID . "', 
                                                        '" . $FACEBOOK_REGION_ID . "', 
                                                        '" . $FACEBOOK_COUNTRY_ID . "',
                                                        '" . $row_brandId . "')";

        $RS_INSERT_SEARCH_RESULTS = mysql_query($SQL_INSERT_RESULTS, DB_CONNECTION) or die(mysql_error());




        print("===============================\n");
        print("\n");
    }
}

function facebookPostSearch($searchStringKey, $row_added_on, $row_brandId) {

    $action = "https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&client_secret=" . APPSECRET . "&grant_type=client_credentials";
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
    $searcher->setQuery($searchStringKey)
            ->setType('post'); // post,event,page,group,checkin
    $graph_res = $searcher->fetchResults();

    $row_search_source = "facebook.com";
    $row_web_link = "facebook-post";

    $totalPost = 0;

    foreach ($graph_res->data as $post) {

        print("The post from " . $post->from->name . "\n");

        $totalPost = $totalPost + 1;
    }

    $COUNTRY_ID = '230';
    $REGION_ID = '4112';
    $CITY_ID = '105428';

    $SQL_INSERT_RESULTS = "INSERT INTO `tbl_search_results` (
                                                        `id`, 
                                                        `search_key`, 
                                                        `search_source`, 
                                                        `result_from_link`, 
                                                        `total_count`, 
                                                        `date_on`, 
                                                        `updated_on`, 
                                                        `city_id`, 
                                                        `region_id`, 
                                                        `country_id`,
                                                        `tbl_brands_id`) VALUES (
                                                        NULL, 
                                                        '" . $searchStringKey . "', 
                                                        '" . $row_search_source . "', 
                                                        '" . mysql_real_escape_string(addslashes($row_web_link)) . "', 
                                                        '" . $totalPost . "', 
                                                        '" . $row_added_on . "', 
                                                        '" . getCurrentDate() . "', 
                                                        '" . $CITY_ID . "', 
                                                        '" . $REGION_ID . "', 
                                                        '" . $COUNTRY_ID . "',
                                                        '" . $row_brandId . "')";

    $RS_INSERT_SEARCH_RESULTS = mysql_query($SQL_INSERT_RESULTS) or die(mysql_error());
}

function facebookEventSearch($searchStringKey, $row_added_on, $row_brandId) {
    $action = "https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&client_secret=" . APPSECRET . "&grant_type=client_credentials";
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
    $searcher->setQuery($searchStringKey)
            ->setType('page') // post,event,page,group,checkin
            ->setLimit(2000);
    $graph_res = $searcher->fetchResults();
    $totalPages = 0;

    $row_search_source = "facebook.com";
    $row_web_link = "facebook-page";


    foreach ($graph_res->data as $post) {

        print($post->name . "\n");

        $totalPages = $totalPages + 1;
    }

    $COUNTRY_ID = '230';
    $REGION_ID = '4112';
    $CITY_ID = '105428';

    $SQL_INSERT_RESULTS = "INSERT INTO `tbl_search_results` (
                                                        `id`, 
                                                        `search_key`, 
                                                        `search_source`, 
                                                        `result_from_link`, 
                                                        `total_count`, 
                                                        `date_on`, 
                                                        `updated_on`, 
                                                        `city_id`, 
                                                        `region_id`, 
                                                        `country_id`,
                                                        `tbl_brands_id`) VALUES (
                                                        NULL, 
                                                        '" . $searchStringKey . "', 
                                                        '" . $row_search_source . "', 
                                                        '" . mysql_real_escape_string(addslashes($row_web_link)) . "', 
                                                        '" . $totalPages . "', 
                                                        '" . $row_added_on . "', 
                                                        '" . getCurrentDate() . "', 
                                                        '" . $CITY_ID . "', 
                                                        '" . $REGION_ID . "', 
                                                        '" . $COUNTRY_ID . "',
                                                        '" . $row_brandId . "')";

    $RS_INSERT_SEARCH_RESULTS = mysql_query($SQL_INSERT_RESULTS) or die(mysql_error());
}

function getCurrentDate() {
    //$sysCurrentDate = date('Y-m-d H:i:s');
    $sysCurrentDate = '2014-01-25 10:15:35';
    return $sysCurrentDate;
}

function getCurrentDateOnly() {
    //$sysCurrentDate = date('Y-m-d');
    $sysCurrentDate = '2014-01-25';
    return $sysCurrentDate;
}

function updateDomainInfo() {



    $objLogger = new Logger();
    $objLogger->write("new-get-domain-info.php started to update the domain details");


    $SQL_DOMAINS = "SELECT * FROM tbl_domains WHERE country_id = 0 OR region_id = 0";
    $RS_DOMAIN = mysql_query($SQL_DOMAINS, DB_CONNECTION) or die(mysql_error());

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
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);

            if ($ROW_CITY) {
                $COUNTRY_ID = $ROW_CITY['id'];
                print("Country Found : $registrant_country  \n");
            } else {
                $SQL_INSERT = "INSERT INTO countries(name) values('" . $registrant_country . "')";
                $country_rs = mysql_query($SQL_INSERT, DB_CONNECTION);
                $COUNTRY_ID = mysql_insert_id();
                print("new Country added : $registrant_country  \n");
            }
        }


        if ($registrant_state != "") {
            $SQL_CITY = "SELECT * FROM regions WHERE (name LIKE '" . $registrant_state . "' OR code LIKE '" . $registrant_state . "') AND country_id = '" . $COUNTRY_ID . "'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            if ($ROW_CITY) {
                $REGION_ID = $ROW_CITY['id'];
                print("Region Found : $registrant_state \n");
            } else {
                $SQL_INSERT_REGION = "INSERT INTO regions(name,country_id) values('" . $registrant_state . "','" . $COUNTRY_ID . "')";
                $region_rs = mysql_query($SQL_INSERT_REGION, DB_CONNECTION) or die(mysql_error());
                $REGION_ID = mysql_insert_id();
                print("new Region added : $registrant_state \n");
            }
        }



        if ($registrant_city != "") {
            $SQL_CITY = "SELECT * FROM cities WHERE name LIKE '" . $registrant_city . "' AND region_id = '" . $REGION_ID . "' AND country_id = '" . $COUNTRY_ID . "'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            if ($ROW_CITY) {
                $CITY_ID = $ROW_CITY['id'];
                print("City Found : $registrant_city \n");
            } else {
                $SQL_INSERT_CITY = "INSERT INTO cities(name,region_id,country_id) values('" . $registrant_city . "','" . $REGION_ID . "','" . $COUNTRY_ID . "')";
                $city_rs = mysql_query($SQL_INSERT_CITY, DB_CONNECTION) or die(mysql_error());
                $CITY_ID = mysql_insert_id();
                print("new City added : $registrant_city \n");
            }
        }


        $SQL_UPDATE = "UPDATE `tbl_domains` SET `post_code` = '" . $registrant_postal_code . "', `city_id` = '" . $CITY_ID . "', `region_id` = '" . $REGION_ID . "', `country_id` = '" . $COUNTRY_ID . "' WHERE `id` = '" . $domain_id . "'";
        $RS_UPDATE = mysql_query($SQL_UPDATE, DB_CONNECTION) or die(mysql_error());
        print("The domain details updated \n");

        if ($row_id % 10 == 0) {
            usleep(600);
        } else {
            usleep(200);
        }

        $row_id = $row_id + 1;
    }





    $SQL_DOMAIN_COUNTRY = "SELECT * FROM tbl_domains WHERE country_id = 0";
    $RS_DOMAIN_COUNTRY = mysql_query($SQL_DOMAIN_COUNTRY, DB_CONNECTION) or die(mysql_error());

    while ($ROW_COUNTRY = mysql_fetch_array($RS_DOMAIN_COUNTRY)) {

        $domain_id = $ROW_COUNTRY['id'];
        $region_id = $ROW_COUNTRY['region_id'];
        $city_id = $ROW_COUNTRY['city_id'];
        print($region_id . "\n");
        $SQL_REGION = "SELECT * FROM regions WHERE id = '" . $region_id . "'";
        $RS_REGION = mysql_query($SQL_REGION, DB_CONNECTION) or die(mysql_error());
        $ROW_REGION = mysql_fetch_assoc($RS_REGION);
        $countryId = $ROW_REGION['country_id'];

        if ($countryId != "") {
            $SQL_UPDATE_COUNTRY = "UPDATE tbl_domains SET country_id = '" . $countryId . "' WHERE id = '" . $domain_id . "'";
            $RS_Country = mysql_query($SQL_UPDATE_COUNTRY, DB_CONNECTION) or die(mysql_error());
            print("Country id updated for domain " . $countryId . "\n");
        }
    }



    $SQL_SEARCH_RESULTS = "SELECT * FROM tbl_search_results WHERE country_id = 0 OR region_id = 0 OR city_id = 0";
    $RS_SEARCH_RESULTS = mysql_query($SQL_SEARCH_RESULTS, DB_CONNECTION) or die(mysql_error());
    while ($ROW_SEARCH_RES = mysql_fetch_array($RS_SEARCH_RESULTS)) {

        $RES_ID = $ROW_SEARCH_RES['id'];
        $DOMAIN_ID = $ROW_SEARCH_RES['result_from_link_domain_name'];

        $SQL_DOMAIN_INFO = "SELECT * FROM tbl_domains WHERE id = '" . $DOMAIN_ID . "'";
        $RS_DOMAIN_INFO = mysql_query($SQL_DOMAIN_INFO, DB_CONNECTION) or die(mysql_error());
        $ROW_DOMAIN_INFO = mysql_fetch_assoc($RS_DOMAIN_INFO);
        $DOMAIN_COUNTRY_ID = $ROW_DOMAIN_INFO['country_id'];
        $DOMAIN_REGION_ID = $ROW_DOMAIN_INFO['region_id'];
        $DOMAIN_CITY_ID = $ROW_DOMAIN_INFO['city_id'];

        $SQL_UPDATE_SEARCH_RES = "UPDATE tbl_search_results SET country_id = '" . $DOMAIN_COUNTRY_ID . "',region_id = '" . $DOMAIN_REGION_ID . "',city_id = '" . $DOMAIN_CITY_ID . "' WHERE id = '" . $RES_ID . "'";
        $RS_UPDATE_SEARCH_INFO = mysql_query($SQL_UPDATE_SEARCH_RES, DB_CONNECTION) or die(mysql_error());
    }


    $objLogger->write("new-get-domain-info.php completed");
}

function updateRankSummary($brandId, $dateOn) {

    $SQL_BRAND = "SELECT * FROM tbl_brands WHERE id = '" . $brandId . "'";
    $RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
    $BRAND_ROW = mysql_fetch_assoc($RS_BRAND);


    $brand_id = $BRAND_ROW['id'];
    $brand_name = mysql_escape_string($BRAND_ROW['brand_name']);
    $brand_logo = $BRAND_ROW['brand_logo'];
    $brand_tags = mysql_escape_string($BRAND_ROW['brand_tags']);
    $sector = $BRAND_ROW['sector'];
    $is_status = $BRAND_ROW['is_status'];
    $tbl_member_id = $BRAND_ROW['tbl_member_id'];
    $is_new_brand = $BRAND_ROW['is_new_brand'];

    print("Updating the results for : " . $brand_name . " report date " . $dateOn . "\n");

    // updating the results for country....................................................
    // get total count from all country....
    $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source NOT IN('facebook.com','twitter.com') AND date_on = '" . $dateOn . "'";
    $RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
    $ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
    $BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];


    // get all country id....
    $SQL_COUNTRY = "SELECT `id` As country_id FROM `countries`";
    $RS_COUNTRY_IDS = mysql_query($SQL_COUNTRY) or die(mysql_error());

    while ($ROW_COUNTRY_ID = mysql_fetch_assoc($RS_COUNTRY_IDS)) {
        usleep(300);
        $SQL_COUNTRY_INFO = "SELECT * FROM countries WHERE id = '" . $ROW_COUNTRY_ID['country_id'] . "'";
        $RS_COUNTRY_INFO = mysql_query($SQL_COUNTRY_INFO) or die(mysql_error());
        $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY_INFO);

        $country_id = $ROW_COUNTRY['id'];
        $country_name = mysql_escape_string($ROW_COUNTRY['name']);
        $country_latitude = $ROW_COUNTRY['latitude'];
        $country_longitude = $ROW_COUNTRY['longitude'];
        $country_logo = $ROW_COUNTRY['country_logo'];


        $SQL_TOP_COUNTRY = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source NOT IN('facebook.com','twitter.com') AND tbl_brands_id = '" . $brand_id . "' AND country_id = '" . $country_id . "' AND date_on = '" . $dateOn . "'";
        $RS_TOP_COUNTRY = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());
        $ROW_TOP_COUNTRY = mysql_fetch_assoc($RS_TOP_COUNTRY);
        $total_count = $ROW_TOP_COUNTRY['tot'];

        $count_in_persentage = round((($total_count / $BRAND_TOTAL_COUNT) * 100), 2);

        $report_date = $dateOn;

        if ($total_count > 0) {

            // check if record is exists....
            $SQL_COUNTRY_RESULTS_EXITS = "SELECT id FROM `tbl_search_result_country` WHERE `brand_id` = '" . $brand_id . "' AND `country_id` = '" . $country_id . "' AND `report_date` = '" . $report_date . "'";
            $RS_COUNTRY_RESULTS_EXITS = mysql_query($SQL_COUNTRY_RESULTS_EXITS) or die(mysql_error());
            $ROW_COUNTRY_RESULTS_EXITS = mysql_fetch_assoc($RS_COUNTRY_RESULTS_EXITS);
            $existRecordId = $ROW_COUNTRY_RESULTS_EXITS['id'];

            if ($existRecordId != "") {

                // update record....
                $SQL_INSERT_RESULT_COUNTRY = "UPDATE 
                    `tbl_search_result_country` SET 
                    `brand_id` = '" . $brand_id . "', 
                    `brand_name` = '" . $brand_name . "', 
                    `brand_logo` = '" . $brand_logo . "', 
                    `brand_tags` = '" . $brand_tags . "', 
                    `sector` = '" . $sector . "', 
                    `is_status` = '" . $is_status . "', 
                    `tbl_member_id` = '" . $tbl_member_id . "', 
                    `is_new_brand` = '" . $is_new_brand . "', 
                    `country_id` = '" . $country_id . "', 
                    `country_name` = '" . $country_name . "', 
                    `country_latitude` = '" . $country_latitude . "', 
                    `country_longitude` = '" . $country_longitude . "', 
                    `country_logo` = '" . $country_logo . "',
                    `total_count` = '" .$total_count."',
                    `count_in_persentage` = '" .$count_in_persentage. "' 
                    WHERE `id` = '" . $existRecordId . "'";
            } else {

                $SQL_INSERT_RESULT_COUNTRY = "INSERT INTO `tbl_search_result_country` (
                `id`, 
                `brand_id`, 
                `brand_name`, 
                `brand_logo`, 
                `brand_tags`, 
                `sector`, 
                `is_status`, 
                `tbl_member_id`, 
                `is_new_brand`, 
                `country_id`, 
                `country_name`, 
                `country_latitude`, 
                `country_longitude`, 
                `country_logo`, 
                `rank`, 
                `total_count`, 
                `count_in_persentage`, 
                `report_date`) VALUES (
                NULL, 
                '" . $brand_id . "', 
                '" . $brand_name . "', 
                '" . $brand_logo . "', 
                '" . $brand_tags . "', 
                '" . $sector . "', 
                '" . $is_status . "', 
                '" . $tbl_member_id . "', 
                '" . $is_new_brand . "', 
                '" . $country_id . "', 
                '" . $country_name . "', 
                '" . $country_latitude . "', 
                '" . $country_longitude . "', 
                '" . $country_logo . "', 
                NULL, 
                '" . $total_count . "', 
                '" . $count_in_persentage . "', 
                '" . $report_date . "')";
            }

            // print($SQL_INSERT_RESULT_COUNTRY."\n\n\n");
            
            $RS_INSERT_COUNTRY_RESULTS = mysql_query($SQL_INSERT_RESULT_COUNTRY) or die(mysql_error());
            print("Country name : ".$country_name." \n\n in Persentage : ".$count_in_persentage."\n\n");
            //print("Updated brand name : " . $brand_name . " country name : " . $country_name . "\n");
        } else {

           // print("Count not found fpr brand name : " . $brand_name . " country name : " . $country_name . "\n");
        }
    }



    // update the state results........
    $SQL_regions = "SELECT `id` As region_id  FROM `regions`";
    $RS_REGIONS_IDS = mysql_query($SQL_regions) or die(mysql_error());
    while ($ROW_REGIONS_IDS = mysql_fetch_assoc($RS_REGIONS_IDS)) {
        usleep(300);

        $SQL_REGION_INFO = "SELECT * FROM regions WHERE id = '" . $ROW_REGIONS_IDS['region_id'] . "'";
        $RS_REGION_INFO = mysql_query($SQL_REGION_INFO) or die(mysql_error());
        $ROW_REGIONS = mysql_fetch_assoc($RS_REGION_INFO);

        $region_id = $ROW_REGIONS['id'];
        $region_name = mysql_escape_string($ROW_REGIONS['name']);
        $region_latitude = $ROW_REGIONS['latitude'];
        $region_longitude = $ROW_REGIONS['longitude'];
        $country_id = $ROW_REGIONS['country_id'];


        // get total count from all country....
        $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source NOT IN('facebook.com','twitter.com') AND date_on = '" . $dateOn . "' AND country_id = '" . $country_id . "'";
        $RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
        $ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
        $BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];


        $SQL_TOP_REGION = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source NOT IN('facebook.com','twitter.com') AND tbl_brands_id = '" . $brand_id . "' AND country_id = '" . $country_id . "' AND region_id = '" . $region_id . "' AND date_on = '" . $dateOn . "'";
        $RS_TOP_REGION = mysql_query($SQL_TOP_REGION) or die(mysql_error());
        $ROW_TOP_REGION = mysql_fetch_assoc($RS_TOP_REGION);
        $total_count = $ROW_TOP_REGION['tot'];


        $report_date = $dateOn;


        if ($total_count > 0) {

            $count_in_persentage = round((($total_count / $BRAND_TOTAL_COUNT) * 100), 2);

            // check if record is exists....
            $SQL_REGION_RESULTS_EXITS = "SELECT id FROM `tbl_search_result_region` WHERE `brand_id` = '" . $brand_id . "' AND `country_id` = '" . $country_id . "' AND `region_id` = '" . $region_id . "' AND `report_date` = '" . $report_date . "'";
            $RS_REGION_RESULTS_EXITS = mysql_query($SQL_REGION_RESULTS_EXITS) or die(mysql_error());
            $ROW_REGION_RESULTS_EXITS = mysql_fetch_assoc($RS_REGION_RESULTS_EXITS);
            $existRecordId = $ROW_REGION_RESULTS_EXITS['id'];

            if ($existRecordId != "") {

                // update record....
                $SQL_INSERT_RESULT_REGION = "UPDATE 
                    `tbl_search_result_region` SET 
                    `brand_id` = '" . $brand_id . "', 
                    `brand_name` = '" . $brand_name . "', 
                    `brand_logo` = '" . $brand_logo . "', 
                    `brand_tags` = '" . $brand_tags . "', 
                    `sector` = '" . $sector . "', 
                    `is_status` = '" . $is_status . "', 
                    `tbl_member_id` = '" . $tbl_member_id . "', 
                    `is_new_brand` = '" . $is_new_brand . "', 
                    `country_id` = '" . $country_id . "', 
                    `region_id` = '" . $region_id . "', 
                    `region_name` = '" . $region_name . "', 
                    `region_latitude` = '" . $region_latitude . "', 
                    `region_longitude` = '" . $region_longitude . "', 
                    `total_count` = '" . $total_count . "', 
                    `count_in_persentage` = '" . $count_in_persentage . "' 
                    WHERE `id` = '" . $existRecordId . "'";
            } else {


                $SQL_INSERT_RESULT_REGION = "INSERT INTO `tbl_search_result_region` (
                `id`, 
                `brand_id`, 
                `brand_name`, 
                `brand_logo`, 
                `brand_tags`, 
                `sector`, 
                `is_status`, 
                `tbl_member_id`, 
                `is_new_brand`, 
                `region_id`, 
                `region_name`, 
                `region_latitude`, 
                `region_longitude`, 
                `country_id`, 
                `rank`, 
                `total_count`, 
                `count_in_persentage`, 
                `report_date`) VALUES (
                NULL, 
                '" . $brand_id . "', 
                '" . $brand_name . "', 
                '" . $brand_logo . "', 
                '" . $brand_tags . "', 
                '" . $sector . "', 
                '" . $is_status . "', 
                '" . $tbl_member_id . "', 
                '" . $is_new_brand . "', 
                '" . $region_id . "', 
                '" . $region_name . "', 
                '" . $region_latitude . "', 
                '" . $region_longitude . "', 
                '" . $country_id . "', 
                NULL, 
                '" . $total_count . "', 
                '" . $count_in_persentage . "', 
                '" . $report_date . "')";
            }


            $RS_INSERT_REGION_RESULTS = mysql_query($SQL_INSERT_RESULT_REGION) or die(mysql_error());
            print("Region name : ".$region_name." \n\n in Persentage : ".$count_in_persentage."\n\n");
            //print("Updated brand name : " . $brand_name . " country name : " . $country_name . " region name : " . $region_name . "\n");
        } else {

            //print("Count not found for brand name : " . $brand_name . " country name : " . $country_name . " state name " . $region_name . "\n");
        }
    }
}

function countryRank() {

    // get all brands....
    $SQL_BRAND = "SELECT * FROM tbl_brands";
    $RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
    while ($BRAND_ROW = mysql_fetch_array($RS_BRAND)) {

        $brand_id = $BRAND_ROW['id'];
        $brand_name = $BRAND_ROW['brand_name'];
        $brand_logo = $BRAND_ROW['brand_logo'];
        $brand_tags = $BRAND_ROW['brand_tags'];
        $sector = $BRAND_ROW['sector'];
        $is_status = $BRAND_ROW['is_status'];
        $tbl_member_id = $BRAND_ROW['tbl_member_id'];
        $is_new_brand = $BRAND_ROW['is_new_brand'];

        print("Updating the results for : " . $brand_name . " report date " . ADDED_ON_DATE . "\n");

        // get total count from all country....
        $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source NOT IN('facebook.com','twitter.com') AND date_on = '" . ADDED_ON_DATE . "'";
        $RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
        $ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
        $BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];

        // get all country id....
        $SQL_COUNTRY = "SELECT * FROM countries";
        $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
        while ($ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY)) {

            $country_id = $ROW_COUNTRY['id'];
            $country_name = $ROW_COUNTRY['name'];
            $country_latitude = $ROW_COUNTRY['latitude'];
            $country_longitude = $ROW_COUNTRY['longitude'];
            $country_logo = $ROW_COUNTRY['country_logo'];


            $SQL_TOP_COUNTRY = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source NOT IN('facebook.com','twitter.com') AND tbl_brands_id = '" . $brand_id . "' AND country_id = '" . $country_id . "' AND date_on = '" . ADDED_ON_DATE . "'";
            $RS_TOP_COUNTRY = mysql_query($SQL_TOP_COUNTRY) or die(mysql_error());
            $ROW_TOP_COUNTRY = mysql_fetch_assoc($RS_TOP_COUNTRY);
            $total_count = $ROW_TOP_COUNTRY['tot'];

            $count_in_persentage = round((($total_count / $BRAND_TOTAL_COUNT) * 100), 2);

            $report_date = ADDED_ON_DATE;

            if ($total_count > 0) {

                // check if record is exists....
                $SQL_COUNTRY_RESULTS_EXITS = "SELECT id FROM `tbl_search_result_country` WHERE `brand_id` = '" . $brand_id . "' AND `country_id` = '" . $country_id . "' AND `report_date` = '" . $report_date . "'";
                $RS_COUNTRY_RESULTS_EXITS = mysql_query($SQL_COUNTRY_RESULTS_EXITS) or die(mysql_error());
                $ROW_COUNTRY_RESULTS_EXITS = mysql_fetch_assoc($RS_COUNTRY_RESULTS_EXITS);
                $existRecordId = $ROW_COUNTRY_RESULTS_EXITS['id'];

                if ($existRecordId != "") {

                    // update record....
                    $SQL_INSERT_RESULT_COUNTRY = "UPDATE 
                    `tbl_search_result_country` SET 
                    `brand_id` = '" . $brand_id . "', 
                    `brand_name` = '" . $brand_name . "', 
                    `brand_logo` = '" . $brand_logo . "', 
                    `brand_tags` = '" . $brand_tags . "', 
                    `sector` = '" . $sector . "', 
                    `is_status` = '" . $is_status . "', 
                    `tbl_member_id` = '" . $tbl_member_id . "', 
                    `is_new_brand` = '" . $is_new_brand . "', 
                    `country_id` = '" . $country_id . "', 
                    `country_name` = '" . $country_name . "', 
                    `country_latitude` = '" . $country_latitude . "', 
                    `country_longitude` = '" . $country_longitude . "', 
                    `country_logo` = '" . $country_logo . "' 
                    WHERE `id` = '" . $existRecordId . "'";
                } else {

                    $SQL_INSERT_RESULT_COUNTRY = "INSERT INTO `tbl_search_result_country` (
                `id`, 
                `brand_id`, 
                `brand_name`, 
                `brand_logo`, 
                `brand_tags`, 
                `sector`, 
                `is_status`, 
                `tbl_member_id`, 
                `is_new_brand`, 
                `country_id`, 
                `country_name`, 
                `country_latitude`, 
                `country_longitude`, 
                `country_logo`, 
                `rank`, 
                `total_count`, 
                `count_in_persentage`, 
                `report_date`) VALUES (
                NULL, 
                '" . $brand_id . "', 
                '" . $brand_name . "', 
                '" . $brand_logo . "', 
                '" . $brand_tags . "', 
                '" . $sector . "', 
                '" . $is_status . "', 
                '" . $tbl_member_id . "', 
                '" . $is_new_brand . "', 
                '" . $country_id . "', 
                '" . $country_name . "', 
                '" . $country_latitude . "', 
                '" . $country_longitude . "', 
                '" . $country_logo . "', 
                NULL, 
                '" . $total_count . "', 
                '" . $count_in_persentage . "', 
                '" . $report_date . "')";
                }


                $RS_INSERT_COUNTRY_RESULTS = mysql_query($SQL_INSERT_RESULT_COUNTRY) or die(mysql_error());

                print("Updated brand name : " . $brand_name . " country name : " . $country_name . "\n");
            } else {

                print("Count not found fpr brand name : " . $brand_name . " country name : " . $country_name . "\n");
            }
        }
    }



    // update country rang for the result...
    $SQL_UPDATE_COUNTRY_RANK = "SELECT * FROM tbl_search_result_country WHERE report_date = '" . ADDED_ON_DATE . "' ORDER BY total_count Desc";
    $RS_UPDATE_COUNTRY_RANK = mysql_query($SQL_UPDATE_COUNTRY_RANK) or die(mysql_error());
    $RANK_NUMBER = 1;
    while ($ROW_COUNTRY_RANK = mysql_fetch_assoc($RS_UPDATE_COUNTRY_RANK)) {
        $brand_country_res_id = $ROW_COUNTRY_RANK['id'];
        $SQL_UPDATE_RANK = "UPDATE tbl_search_result_country SET rank = '" . $RANK_NUMBER . "' WHERE id = '" . $brand_country_res_id . "'";
        $RS_UPDATE_RANK = mysql_query($SQL_UPDATE_RANK) or die(mysql_error());
        print("Rank updated for " . $ROW_COUNTRY_RANK['brand_name'] . " Rank number : " . $RANK_NUMBER . "\n");
        $RANK_NUMBER = $RANK_NUMBER + 1;
    }

    // update sector rang....
    $SQL_SECTOR_IDS = "SELECT DISTINCT sector FROM tbl_search_result_country WHERE report_date = '" . ADDED_ON_DATE . "'";
    $RS_SECTOR_IDS = mysql_query($SQL_SECTOR_IDS) or die(mysql_error());
    while ($ROW_SCTOR_ID = mysql_fetch_assoc($RS_SECTOR_IDS)) {

        $SECTOR_ID = $ROW_SCTOR_ID['sector'];

        // update country rang for the result...
        $SQL_UPDATE_COUNTRY_RANK = "SELECT * FROM tbl_search_result_country WHERE sector = '" . $SECTOR_ID . "' AND report_date = '" . ADDED_ON_DATE . "' ORDER BY total_count Desc";
        $RS_UPDATE_COUNTRY_RANK = mysql_query($SQL_UPDATE_COUNTRY_RANK) or die(mysql_error());
        $SECTOR_RANK_NUMBER = 1;
        while ($ROW_COUNTRY_RANK = mysql_fetch_assoc($RS_UPDATE_COUNTRY_RANK)) {
            $brand_country_res_id = $ROW_COUNTRY_RANK['id'];
            $SQL_UPDATE_RANK = "UPDATE tbl_search_result_country SET sector_rank = '" . $SECTOR_RANK_NUMBER . "' WHERE id = '" . $brand_country_res_id . "'";
            $RS_UPDATE_RANK = mysql_query($SQL_UPDATE_RANK) or die(mysql_error());
            print("Sector Rank updated for " . $ROW_COUNTRY_RANK['brand_name'] . " Sector Rank number : " . $SECTOR_RANK_NUMBER . "\n");
            $SECTOR_RANK_NUMBER = $SECTOR_RANK_NUMBER + 1;
        }
    }
}

function countryStatesRank() {

    // get all brands....
    $SQL_BRAND = "SELECT * FROM tbl_brands";
    $RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
    while ($BRAND_ROW = mysql_fetch_array($RS_BRAND)) {

        $brand_id = $BRAND_ROW['id'];
        $brand_name = $BRAND_ROW['brand_name'];
        $brand_logo = $BRAND_ROW['brand_logo'];
        $brand_tags = $BRAND_ROW['brand_tags'];
        $sector = $BRAND_ROW['sector'];
        $is_status = $BRAND_ROW['is_status'];
        $tbl_member_id = $BRAND_ROW['tbl_member_id'];
        $is_new_brand = $BRAND_ROW['is_new_brand'];

        print("Updating the results for : " . $brand_name . " report date " . ADDED_ON_DATE . "\n");



        // get all country id....
        $SQL_COUNTRY = "SELECT * FROM countries";
        $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die(mysql_error());
        while ($ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY)) {

            $country_id = $ROW_COUNTRY['id'];
            $country_name = $ROW_COUNTRY['name'];
            $country_latitude = $ROW_COUNTRY['latitude'];
            $country_longitude = $ROW_COUNTRY['longitude'];
            $country_logo = $ROW_COUNTRY['country_logo'];



            // get total count from all country....
            $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source NOT IN('facebook.com','twitter.com') AND date_on = '" . ADDED_ON_DATE . "' AND country_id = '" . $country_id . "'";
            $RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
            $ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
            $BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];


            // get all the states in that country....
            $SQL_regions = "SELECT * FROM regions WHERE country_id = '" . $country_id . "'";
            $RS_REGIONS = mysql_query($SQL_regions) or die(mysql_error());
            while ($ROW_REGIONS = mysql_fetch_assoc($RS_REGIONS)) {

                $region_id = $ROW_REGIONS['id'];
                $region_name = $ROW_REGIONS['name'];
                $region_latitude = $ROW_REGIONS['latitude'];
                $region_longitude = $ROW_REGIONS['longitude'];


                $SQL_TOP_REGION = "SELECT sum(total_count) As tot FROM tbl_search_results WHERE search_source NOT IN('facebook.com','twitter.com') AND tbl_brands_id = '" . $brand_id . "' AND country_id = '" . $country_id . "' AND region_id = '" . $region_id . "' AND date_on = '" . ADDED_ON_DATE . "'";
                $RS_TOP_REGION = mysql_query($SQL_TOP_REGION) or die(mysql_error());
                $ROW_TOP_REGION = mysql_fetch_assoc($RS_TOP_REGION);
                $total_count = $ROW_TOP_REGION['tot'];



                $report_date = ADDED_ON_DATE;


                if ($total_count > 0) {

                    $count_in_persentage = round((($total_count / $BRAND_TOTAL_COUNT) * 100), 2);

                    // check if record is exists....
                    $SQL_REGION_RESULTS_EXITS = "SELECT id FROM `tbl_search_result_region` WHERE `brand_id` = '" . $brand_id . "' AND `country_id` = '" . $country_id . "' AND `region_id` = '" . $region_id . "' AND `report_date` = '" . $report_date . "'";
                    $RS_REGION_RESULTS_EXITS = mysql_query($SQL_REGION_RESULTS_EXITS) or die(mysql_error());
                    $ROW_REGION_RESULTS_EXITS = mysql_fetch_assoc($RS_REGION_RESULTS_EXITS);
                    $existRecordId = $ROW_REGION_RESULTS_EXITS['id'];

                    if ($existRecordId != "") {

                        // update record....
                        $SQL_INSERT_RESULT_REGION = "UPDATE 
                    `tbl_search_result_region` SET 
                    `brand_id` = '" . $brand_id . "', 
                    `brand_name` = '" . $brand_name . "', 
                    `brand_logo` = '" . $brand_logo . "', 
                    `brand_tags` = '" . $brand_tags . "', 
                    `sector` = '" . $sector . "', 
                    `is_status` = '" . $is_status . "', 
                    `tbl_member_id` = '" . $tbl_member_id . "', 
                    `is_new_brand` = '" . $is_new_brand . "', 
                    `country_id` = '" . $country_id . "', 
                    `region_id` = '" . $region_id . "', 
                    `region_name` = '" . $region_name . "', 
                    `region_latitude` = '" . $region_latitude . "', 
                    `region_longitude` = '" . $region_longitude . "', 
                    `total_count` = '" . $total_count . "', 
                    `count_in_persentage` = '" . $count_in_persentage . "' 
                    WHERE `id` = '" . $existRecordId . "'";
                    } else {


                        $SQL_INSERT_RESULT_REGION = "INSERT INTO `tbl_search_result_region` (
                `id`, 
                `brand_id`, 
                `brand_name`, 
                `brand_logo`, 
                `brand_tags`, 
                `sector`, 
                `is_status`, 
                `tbl_member_id`, 
                `is_new_brand`, 
                `region_id`, 
                `region_name`, 
                `region_latitude`, 
                `region_longitude`, 
                `country_id`, 
                `rank`, 
                `total_count`, 
                `count_in_persentage`, 
                `report_date`) VALUES (
                NULL, 
                '" . $brand_id . "', 
                '" . $brand_name . "', 
                '" . $brand_logo . "', 
                '" . $brand_tags . "', 
                '" . $sector . "', 
                '" . $is_status . "', 
                '" . $tbl_member_id . "', 
                '" . $is_new_brand . "', 
                '" . $region_id . "', 
                '" . $region_name . "', 
                '" . $region_latitude . "', 
                '" . $region_longitude . "', 
                '" . $country_id . "', 
                NULL, 
                '" . $total_count . "', 
                '" . $count_in_persentage . "', 
                '" . $report_date . "')";
                    }


                    $RS_INSERT_REGION_RESULTS = mysql_query($SQL_INSERT_RESULT_REGION) or die(mysql_error());

                    print("Updated brand name : " . $brand_name . " country name : " . $country_name . " region name : " . $region_name . "\n");
                } else {

                    print("Count not found for brand name : " . $brand_name . " country name : " . $country_name . " state name " . $region_name . "\n");
                }
            }
        }
    }



    // update country rang for the result...
    $SQL_UPDATE_COUNTRY_RANK = "SELECT * FROM tbl_search_result_region WHERE report_date = '" . ADDED_ON_DATE . "' ORDER BY total_count Desc";
    $RS_UPDATE_COUNTRY_RANK = mysql_query($SQL_UPDATE_COUNTRY_RANK) or die(mysql_error());
    $RANK_NUMBER = 1;
    while ($ROW_COUNTRY_RANK = mysql_fetch_assoc($RS_UPDATE_COUNTRY_RANK)) {
        $brand_country_res_id = $ROW_COUNTRY_RANK['id'];
        $SQL_UPDATE_RANK = "UPDATE tbl_search_result_region SET rank = '" . $RANK_NUMBER . "' WHERE id = '" . $brand_country_res_id . "'";
        $RS_UPDATE_RANK = mysql_query($SQL_UPDATE_RANK) or die(mysql_error());
        print("Rank updated for " . $ROW_COUNTRY_RANK['brand_name'] . " Rank number : " . $RANK_NUMBER . "\n");
        $RANK_NUMBER = $RANK_NUMBER + 1;
    }

    // update sector rang....
    $SQL_SECTOR_IDS = "SELECT DISTINCT sector FROM tbl_search_result_region WHERE report_date = '" . ADDED_ON_DATE . "'";
    $RS_SECTOR_IDS = mysql_query($SQL_SECTOR_IDS) or die(mysql_error());
    while ($ROW_SCTOR_ID = mysql_fetch_assoc($RS_SECTOR_IDS)) {

        $SECTOR_ID = $ROW_SCTOR_ID['sector'];

        // update country rang for the result...
        $SQL_UPDATE_COUNTRY_RANK = "SELECT * FROM tbl_search_result_region WHERE sector = '" . $SECTOR_ID . "' AND report_date = '" . ADDED_ON_DATE . "' ORDER BY total_count Desc";
        $RS_UPDATE_COUNTRY_RANK = mysql_query($SQL_UPDATE_COUNTRY_RANK) or die(mysql_error());
        $SECTOR_RANK_NUMBER = 1;
        while ($ROW_COUNTRY_RANK = mysql_fetch_assoc($RS_UPDATE_COUNTRY_RANK)) {
            $brand_country_res_id = $ROW_COUNTRY_RANK['id'];
            $SQL_UPDATE_RANK = "UPDATE tbl_search_result_region SET sector_rank = '" . $SECTOR_RANK_NUMBER . "' WHERE id = '" . $brand_country_res_id . "'";
            $RS_UPDATE_RANK = mysql_query($SQL_UPDATE_RANK) or die(mysql_error());
            print("Sector Rank updated for " . $ROW_COUNTRY_RANK['brand_name'] . " Sector Rank number : " . $SECTOR_RANK_NUMBER . "\n");
            $SECTOR_RANK_NUMBER = $SECTOR_RANK_NUMBER + 1;
        }
    }
}


function getDomainInfoVer2($domainName){
 
    
        
        $domain_name = $domainName;
        $domain_ext = getFileExtension($domain_name);
        print("Domain name : ".$domain_name."\n");
        sleep(5);
        $domain_url = "http://who.is/whois/" . $domain_name;


        $registrant_city = "";
        $registrant_state = "";
        $registrant_postal_code = "";
        $registrant_country = "";


        usleep(30);
        $pageData = file_get_html($domain_url);
        $pageHtml = str_get_html($pageData);
        if (method_exists($pageHtml, "find")) {

            if ($pageHtml->find('div[id=registry_whois]')) {
                foreach ($pageHtml->find('div[id=registry_whois]') as $row) {

                   //print($domain_name."1 came here....\n");
                   
                   $rawRegistrarData =  str_get_html($row);
                   foreach($rawRegistrarData->find('table') as $element){
                       
                       //print($domain_name."2 came here....\n");
                       
                       $tableHtml = str_get_html($element);
                       // get tr....
                       foreach($tableHtml->find('td') as $tdIndex=>$tdElement){
                           
                           //print($domain_name."3 came here....\n");
                           if($tdIndex == 0){
                           $tableTdHtml = str_get_html($tdElement);
                           $strRegistrarData = explode("<br>", $tableTdHtml);
                           
                           //print($strRegistrarData[18]."\n");
                           
                        
                                foreach($strRegistrarData As $rowIndex=>$dataRow){
                                    if($rowIndex<20){
                                        //print($domain_name."4 came here....\n");
                                        print($rowIndex.") ".$dataRow."\n\n\n");
                                    }
                                }
                          
                           }
                           
                       }
                   }
                   
                }
            } else {
                print($domain_name." div[id=registry_whois] not found \n");
            }
        } else {
            print($domain_name." html not found \n");
        }

//        print("City : ".$registrant_city."\n");
//         print("State : ".$registrant_state."\n");
//         print("Postal Code : ".$registrant_postal_code."\n");
//         print("Country : ".$registrant_country."\n");
//
//         usleep(10);
    
}



function getDomainInfoWhois_Com($domainName){
        $strRegistrarData = "";
        $domain_name = $domainName;
        $domain_ext = getFileExtension($domain_name);
        $domain_url = "http://www.whois.com/whois/" . $domain_name;
        $pageData = file_get_html($domain_url);
        $pageHtml = str_get_html($pageData);
        if (method_exists($pageHtml, "find")) {
            if ($pageHtml->find('div[id=registryData]')) {
                foreach ($pageHtml->find('div[id=registryData]') as $row) {
                  $strRegistrarData = explode("<br>", $row);
                  return $strRegistrarData;
                }
            } else {
               return false; 
            }
        } else {
           return false; 
        }
}



function getDomainInfoWho_Is($domainName){
        usleep(3000);
        $strRegistrarDataInfo = "";
        $domain_name = $domainName;
        $domain_ext = getFileExtension($domain_name);
        $domain_url = "http://who.is/whois/" . $domain_name;

        $pageData = file_get_html($domain_url);
        $pageHtml = str_get_html($pageData);
        if (method_exists($pageHtml, "find")) {

            if($domain_ext == "info"){
                        if ($pageHtml->find('div[id=registry_whois]')) {
                            foreach ($pageHtml->find('div[id=registry_whois]') as $row) {

                            //print($domain_name."1 came here....\n");

                            $rawRegistrarData =  str_get_html($row);
                            foreach($rawRegistrarData->find('table') as $element){

                                //print($domain_name."2 came here....\n");

                                $tableHtml = str_get_html($element);
                                // get tr....
                                foreach($tableHtml->find('td') as $tdIndex=>$tdElement){

                                    //print($domain_name."3 came here....\n");
                                    if($tdIndex == 0){
                                            $tableTdHtml = str_get_html($tdElement);
                                            $strRegistrarData = explode("<br>", $tableTdHtml);
                                            if(count($strRegistrarData)>5){
                                                $strRegistrarDataInfo = $strRegistrarData;
                                            } else {
                                                return false;
                                            }
                                    }

                                }
                            }

                            }
                        } else {
                            return false;
                        }
            } elseif($domain_ext == "com" || $domain_ext == "biz" || $domain_ext == "net"){
                
                    if ($pageHtml->find('div[class=raw_data]')) {
                            foreach ($pageHtml->find('div[class=raw_data]') as $row) {
                                
                                $rawRegistrarData =  str_get_html($row);
                                
                                
                                foreach($rawRegistrarData->find('span') as $element){

                                        //print($domain_name."2 came here....\n");

                                        $tableHtml = str_get_html($element);
                                        // get tr....
                                        $strRegistrarData = explode("<br>", $tableHtml);
                                        if(count($strRegistrarData)>5){
                                           $strRegistrarDataInfo = $strRegistrarData;
                                        } else {
                                            return false;
                                        }
                                       
                                    }
                                
                            }
                    } else {
                        return false;
                    }
                
            }
            
            if(!$strRegistrarDataInfo){
                
                 if ($pageHtml->find('div[class=box-inset]')) {
                     
                     foreach ($pageHtml->find('div[class=box-inset]') as $row) {
                         
                         $rawRegistrarData =  str_get_html($row);
                         
                         foreach($rawRegistrarData->find('table') as $element){
                             
                               $tableHtml = str_get_html($element);
                                // get tr....
                                foreach($tableHtml->find('td') as $tdIndex=>$tdElement){
         
                                    if($tdIndex == 0){
                                            $tableTdHtml = str_get_html($tdElement);
                                            $strRegistrarData = explode("<br>", $tableTdHtml);
                                            if(count($strRegistrarData)>5){
                                                $strRegistrarDataInfo = $strRegistrarData;
                                            } else {
                                                return false;
                                            }
                                    }

                                }
                             
                         }
                     }
                 }
            }
            
            
            
            
        } else {
            false;
        }
        return $strRegistrarDataInfo;
}


function formateRegistrarData($city){
    $registrant_city = trim(str_replace('City:', '',$city));
    $registrant_city = trim(str_replace('&nbsp;', '', $registrant_city));
    $registrant_city = trim(str_replace('Registrant', '', $registrant_city));
    $registrant_city = trim(str_replace('Registrant', '', $registrant_city));
    return $registrant_city;
}


function formateRegistrarDataState($state){
    $registrant_state = trim(str_replace('Registrant State/Province:', '',$state));
    $registrant_state = trim(str_replace('&nbsp;', '', $registrant_state));
    $registrant_state = trim(str_replace('Registrant', '', $registrant_state));
    $registrant_state = trim(str_replace('Registrant', '', $registrant_state));
    $registrant_state = trim(str_replace('State', '', $registrant_state));
    $registrant_state = trim(str_replace('Province:', '', $registrant_state));
    return $registrant_state;
}


function formateRegistrarDataCountry($country){
    $registrant_country = trim(str_replace('Country:', '',$country));
    $registrant_country = trim(str_replace('&nbsp;', '', $registrant_country));
    $registrant_country = trim(str_replace('Registrant Country:', '', $registrant_country));
    $registrant_country = trim(str_replace('Registrant', '', $registrant_country));
    return $registrant_country;
}

function formateRegistrarDataRow($dataRow){
    $registrant_data_row = trim(str_replace('&nbsp;', '', $dataRow));
    $registrant_data_row = trim(str_replace('&nbsp;', '', $registrant_data_row));
    $registrant_data_row = trim(str_replace('&nbsp;', '', $registrant_data_row));
    $registrant_data_row = trim(str_replace('&nbsp;', '', $registrant_data_row));
    //$registrant_data_row = trim(str_replace(':', '', $registrant_data_row));
    $registrant_data_row = trim($registrant_data_row);
    $registrant_data_row = trim($registrant_data_row);
    return $registrant_data_row;
}


function formateToSQL($theData){
    $theData = trim(str_replace('SET', '', $theData));
    return $theData;
}

function getGeoFromRegistrarData($registrarData){
     $registrarDataBackUpForState = $registrarData;
     $registrarDataBackUpForCountry = $registrarData;
     $registrarDataBackVer1 = $registrarData;
     $registrarDataBackVer2 = $registrarData;
     
     $registrant_city = "";
     $registrant_state = "";
     $registrant_country = "";
     
     $founded_registrant_city = "";
     $founded_registrant_state = "";
     $founded_registrant_country = "";
     

     if($registrarData){
        foreach($registrarData As $rowIndex=>$dataRow){
            if($registrant_city == ""){
                    if (preg_match('/City/',$dataRow)) {
                        $registrant_city = formateRegistrarData($dataRow);
                    }elseif (preg_match('/registrant-city:/',$dataRow)) {
                        $registrant_city = formateRegistrarData($dataRow);
                    }
            }
        }
     }
     
     
     if($registrarDataBackUpForState){
        foreach($registrarDataBackUpForState As $rowIndex=>$dataRow){
            if($registrant_state == ""){
                    if (preg_match('/State/',$dataRow)) {
                        $registrant_state = formateRegistrarDataState($dataRow);
                    }elseif (preg_match('/Province:/',$dataRow)) {
                        $registrant_state = formateRegistrarDataState($dataRow);
                    }
            }
        }
     }
     
     
     if($registrarDataBackUpForCountry){
        foreach($registrarDataBackUpForCountry As $rowIndex=>$dataRow){
            if($registrant_country == ""){
                    if (preg_match('/Country/',$dataRow)) {
                        $registrant_country = formateRegistrarDataCountry($dataRow);
                    }elseif (preg_match('/Country:/',$dataRow)) {
                        $registrant_country = formateRegistrarDataCountry($dataRow);
                    }
            }
        }
     }
 
     
    if($registrant_state == "" && $registrant_country == ""){
        $arrRows = array();
        foreach($registrarDataBackVer1 As $row_index=>$dataRow){
            $currentRowData = formateRegistrarDataRow($dataRow);
            array_push($arrRows, $currentRowData);
        } 
        $registrantIndex = '';
     
        foreach($arrRows As $aIndex=>$contentRow){
            if (preg_match('/Registrant Contact:/',$contentRow)) {
                $registrantIndex = $aIndex;
            }elseif (preg_match('/Registrant:/',$contentRow)) {
                $registrantIndex = $aIndex;
            }elseif (preg_match('/Registrant/',$contentRow)) {
                $registrantIndex = $aIndex;
            }elseif (preg_match('/Administrative Contact/',$contentRow)) {
                $registrantIndex = $aIndex;
            }
        }
        $registrantIndex = 0;
        $arrRegisterGeoData = array();
        for($row_data_index = $registrantIndex+1;$row_data_index<=($registrantIndex+10);$row_data_index++){
            array_push($arrRegisterGeoData, formateRegistrarDataRow($registrarDataBackVer1[$row_data_index]));
        }

        $countryName = "";
        $rowCountryID = "";
        $stateName = "";
        $cityName = "";
        
        foreach($arrRegisterGeoData As $rIndex=>$registerGeoData){
            
            $registerGeoData = formateToSQL($registerGeoData);
            
            if (!preg_match('/Name Server/',$registerGeoData)) {
                
            
            // get the country name from db.....
            $theDataRow = $registerGeoData;//mysql_escape_string($registerGeoData);
            //$theDataRow = trim(str_replace(',', '', $theDataRow));
            //$theDataRow = trim(str_replace('.', '', $theDataRow));
            $SQL_COUNTRY = "SELECT id,name FROM countries WHERE code LIKE '".mysql_escape_string($theDataRow)."' OR  code3 LIKE '".mysql_escape_string($theDataRow)."' OR name LIKE '".mysql_escape_string($theDataRow)."'";
            $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die($SQL_COUNTRY);
            $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
            $row_country_name = $ROW_COUNTRY['name'];
            $row_country_id = $ROW_COUNTRY['id'];
            if($row_country_name != ""){
                $countryName = $row_country_name;
                $rowCountryID = $row_country_id;
            }
            
            // get state and city....
            $stateCity = explode(",", $registerGeoData);
           // print_r($stateCity);
            if(count($stateCity)==2){
                
                $row_city_name = $stateCity[0];
                $row_state_contents = explode(" ",trim($stateCity[1]));
                $row_state_name = $row_state_contents[0];
               // print("\n");
               // print("city : ".$row_city_name." state : ".$row_state_name." country id ".$rowCountryID."\n");

                $row_city_name = mysql_escape_string($row_city_name);
                $row_state_name = mysql_escape_string($row_state_name);
                
                // get the state name .....
                if($row_state_name != ""){
                    $SQL_STATE = "SELECT name FROM regions WHERE name LIKE '".mysql_escape_string($row_state_name)."'";
                    $RS_STATE = mysql_query($SQL_STATE) or die($SQL_STATE);
                    $ROW_STATE = mysql_fetch_assoc($RS_STATE);
                    if($ROW_STATE['name'] != ""){
                        $stateName = $ROW_STATE['name'];
                    }
                }
                

                if($row_city_name != ""){
                    $SQL_CITY = "SELECT name FROM cities WHERE name LIKE '".mysql_escape_string($row_city_name)."'";
                    $RS_CITY = mysql_query($SQL_CITY) or die($SQL_CITY);
                    $ROW_CITY = mysql_fetch_assoc($RS_CITY);
                    if($ROW_CITY['name'] != ""){
                        $cityName = $ROW_CITY['name'];
                    }
                }
                
            } else {
                
                
                $row_data_value = mysql_escape_string($theDataRow);
                
                // get the state name .....
                if($row_data_value != ""){
                    if($stateName == ""){
                        $SQL_STATE = "SELECT name FROM regions WHERE name LIKE '".mysql_escape_string($row_data_value)."' OR code LIKE '".mysql_escape_string($row_data_value)."' OR name_option_1 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_2 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_3 LIKE '".mysql_escape_string($row_data_value)."'";
                        $RS_STATE = mysql_query($SQL_STATE) or die($SQL_STATE);
                        $ROW_STATE = mysql_fetch_assoc($RS_STATE);
                        if($ROW_STATE['name'] != ""){
                            $stateName = $ROW_STATE['name'];
                        }
                    }
                }
                
                
                
                if($row_data_value != ""){
                    if($cityName == ""){
                            $SQL_CITY = "SELECT name FROM cities WHERE name LIKE '".mysql_escape_string($row_data_value)."'";
                            $RS_CITY = mysql_query($SQL_CITY) or die($SQL_CITY);
                            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
                            if($ROW_CITY['name'] != ""){
                                $cityName = $ROW_CITY['name'];
                            }
                    }
                    
                }
                
                
                
            }
            
            }
            
        }
        
        
        if($countryName == "" && $stateName == ""){
                rsort($arrRows);
                $stateArrayRows = array();
                $stateArrayRows = $arrRows;
                $countryCode = "";
               foreach($arrRows As $aIndex=>$arrRow){
                   // get the country from the row data....
                   if($countryName == ""){
                        $SQL_COUNTRY = "SELECT id,name FROM countries WHERE code LIKE '".mysql_escape_string($arrRow)."' OR  code3 LIKE '".mysql_escape_string($arrRow)."' OR name LIKE '".mysql_escape_string($arrRow)."'";
                        $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die($SQL_COUNTRY);
                        $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
                        $row_country_name = $ROW_COUNTRY['name'];
                        $row_country_id = $ROW_COUNTRY['id'];
                        if($row_country_name != ""){
                            $countryName = $row_country_name;
                            $rowCountryID = $row_country_id;
                            $countryCode = $arrRow;
                        }
                       
                   } 
               }
               
                   // get the state from the row data...
                   foreach($stateArrayRows As $aIndex=>$arrRow){
                       
                        if($stateName == ""){
                            
                            if($countryCode != $arrRow){
                                
                                if($arrRow != ""){
                                    $SQL_STATE = "SELECT name FROM regions WHERE name LIKE '".mysql_escape_string($arrRow)."' OR code LIKE '".mysql_escape_string($arrRow)."' OR name_option_1 LIKE '".mysql_escape_string($arrRow)."' OR name_option_2 LIKE '".mysql_escape_string($arrRow)."' OR name_option_3 LIKE '".mysql_escape_string($arrRow)."'";
                                    $RS_STATE = mysql_query($SQL_STATE) or die($SQL_STATE);
                                    $ROW_STATE = mysql_fetch_assoc($RS_STATE);
                                    if($ROW_STATE['name'] != ""){
                                        $stateName = $ROW_STATE['name'];
                                    }
                                }
                            }
                            
                            
                        }
                       
                   } 
        } 
        
        

       $founded_registrant_city = $cityName;
       $founded_registrant_state = $stateName;
       $founded_registrant_country = $countryName;
        
    }
    
    // if $registrant_country,$registrant_state are empty, try again...
     if($founded_registrant_state == "" && $founded_registrant_country == ""){
        $arrRows = array();
        foreach($registrarDataBackVer2 As $row_index=>$dataRow){
            $currentRowData = formateRegistrarDataRow($dataRow);
            array_push($arrRows, $currentRowData);
        } 
        
        foreach($arrRows As $aIndex=>$dataRow){
            
            if (preg_match("/Registrant's address/",$dataRow)) {
                $registrantIndex = $aIndex;
            }
           
        }
        
        
        $arrRegisterGeoData = array();
        for($row_data_index = $registrantIndex+1;$row_data_index<=($registrantIndex+10);$row_data_index++){
            array_push($arrRegisterGeoData, formateRegistrarDataRow($registrarDataBackVer1[$row_data_index]));
        }

        foreach($arrRegisterGeoData As $rIndex=>$geoDataRow){
            $theDataRow = $geoDataRow;
            
              //$theDataRow = trim(str_replace('.', '', $theDataRow));
            $SQL_COUNTRY = "SELECT id,name FROM countries WHERE code LIKE '".mysql_escape_string($theDataRow)."' OR  code3 LIKE '".mysql_escape_string($theDataRow)."' OR name LIKE '".mysql_escape_string($theDataRow)."'";
            $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die($SQL_COUNTRY);
            $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
            $row_country_name = $ROW_COUNTRY['name'];
            $row_country_id = $ROW_COUNTRY['id'];
            if($row_country_name != ""){
                $countryName = $row_country_name;
                $rowCountryID = $row_country_id;
            }
            
           
            //====================
              
                $row_data_value = mysql_escape_string($theDataRow);
                
                // get the state name .....
                if($row_data_value != ""){
                    if($stateName == ""){
                        $SQL_STATE = "SELECT name FROM regions WHERE name LIKE '".mysql_escape_string($row_data_value)."' OR code LIKE '".mysql_escape_string($row_data_value)."' OR name_option_1 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_2 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_3 LIKE '".mysql_escape_string($row_data_value)."'";
                        $RS_STATE = mysql_query($SQL_STATE) or die($SQL_STATE);
                        $ROW_STATE = mysql_fetch_assoc($RS_STATE);
                        if($ROW_STATE['name'] != ""){
                            $stateName = $ROW_STATE['name'];
                        }
                    }
                }
                
                
                
                if($row_data_value != ""){
                    if($cityName == ""){
                            $SQL_CITY = "SELECT name FROM cities WHERE name LIKE '".mysql_escape_string($row_data_value)."'";
                            $RS_CITY = mysql_query($SQL_CITY) or die($SQL_CITY);
                            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
                            if($ROW_CITY['name'] != ""){
                                $cityName = $ROW_CITY['name'];
                            }
                    }
                    
                }
            //===================
            
        }
        
        $founded_registrant_city = $cityName;
        $founded_registrant_state = $stateName;
        $founded_registrant_country = $countryName;


     }
    
    
    
    
    
    $objCountrData = new stdClass();
    $objCountrData->city = $founded_registrant_city;
    $objCountrData->state = $founded_registrant_state;
    $objCountrData->country = $founded_registrant_country;
    
    return $objCountrData;
        
}


function updateDomainGeo(){
    
    $SQL_DOMAIN_COUNTRY = "SELECT * FROM `tbl_domains` WHERE `country_id` IS NULL OR region_id = NULL";
    $RS_DOMAIN_COUNTRY = mysql_query($SQL_DOMAIN_COUNTRY, DB_CONNECTION) or die(mysql_error());
    while ($ROW_COUNTRY = mysql_fetch_array($RS_DOMAIN_COUNTRY)) {
        $domainId = $ROW_COUNTRY['id'];
        $domainName = $ROW_COUNTRY['domain_name'];
        print("Domain name - ".$domainName."\n");
        $strRegistrarDataInfo = "";
        $registrarInfo = getDomainInfoWho_Is($domainName);
     
        if($registrarInfo){
            $strRegistrarDataInfo = $registrarInfo;
        } else {

            $registrarInfo = getDomainInfoWho_Is($domainName);
            if($registrarInfo){
                $strRegistrarDataInfo = $registrarInfo;
            } else {
                $strRegistrarDataInfo = $registrarInfo;
            }
         
        }
    
        $cityId = "";
        $stateId = "";
        $countryId = "";
        
        $domainGeo = getGeoFromRegistrarData($strRegistrarDataInfo);
        $city_name = $domainGeo->city;
        $state_name = $domainGeo->state;
        $country_name = $domainGeo->country;
        
        if($country_name != ""){
             $SQL_COUNTRY = "SELECT * FROM countries WHERE name LIKE '" .'%'.$country_name.'%'. "'  OR code LIKE '" .'%'.$country_name.'%'. "' OR code3 LIKE '" .'%'.$country_name.'%'. "'";
             $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
             $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
             $countryId = $ROW_COUNTRY['id'];
             if($countryId != ""){
                 $RS_COUNTRY_DOMAIN = mysql_query("UPDATE tbl_domains SET country_id = '".$countryId."' WHERE id = '".$domainId."'") or die(mysql_error());
                 print("Country ID ".$countryId." Updated");
                 print("\n");
             }
        } 
        
        if($state_name != ""){
             $SQL_STATE = "SELECT * FROM regions WHERE (name LIKE '" .'%'.$state_name.'%'. "'  OR code LIKE '" .'%'.$state_name.'%'. "') AND country_id = '".$countryId."'";
             $RS_STATE = mysql_query($SQL_STATE, DB_CONNECTION) or die(mysql_error());
             $ROW_STATE = mysql_fetch_assoc($RS_STATE);
             $stateId = $ROW_STATE['id'];
             if($stateId != ""){
                 $RS_STATE_DOMAIN = mysql_query("UPDATE tbl_domains SET region_id = '".$stateId."' WHERE id = '".$domainId."'") or die(mysql_error());
                 print("State ID ".$stateId." Updated");
                 print("\n");
             }
        } 
        
        
        // city id...
        if($city_name != ""){
            $SQL_CITY = "SELECT * FROM cities WHERE (name LIKE '" .'%'.$city_name.'%'. "' AND country_id = '".$countryId."') AND region_id = '".$stateId."'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            $cityId = $ROW_CITY['id'];
            if($cityId != ""){
                 $RS_CITY_DOMAIN = mysql_query("UPDATE tbl_domains SET city_id = '".$cityId."' WHERE id = '".$domainId."'") or die(mysql_error());
                 print("City ID ".$cityId." Updated");
                 print("\n");
             }
        } 
    }
    
}


function getDomainAddressInfo($domainName){
    
    
    $objDomainAddress = new stdClass();
    $whois = new Whois();
    $query = $domainName;
    $whois->deep_whois=TRUE;
    $result = $whois->Lookup($query, false);
    
    $regrinfo = $result['regrinfo'];
    $regyinfo = $result['regyinfo'];
    $addressCity        = "";
    $addressState       = "";
    $addressCountry     = "";

    
    if($regrinfo['owner']){
        $owner = $regrinfo['owner'];
        $domain_owner_address = $owner['address'];
        $addressCity        = $domain_owner_address['city'];
        $addressState       = $domain_owner_address['state'];
        $addressCountry     = $domain_owner_address['country'];
    }elseif($regrinfo['admin']){
        $admin = $regrinfo['admin'];
        $domain_admin_address = $admin['address'];
        $addressCity        = $domain_admin_address['city'];
        $addressState       = $domain_admin_address['state'];
        $addressCountry     = $domain_admin_address['country'];
    }elseif($regrinfo['tech']){
        $tech = $regrinfo['tech'];
        $domain_tech_address = $tech['address'];
        $addressCity        = $domain_tech_address['city'];
        $addressState       = $domain_tech_address['state'];
        $addressCountry     = $domain_tech_address['country'];
    }
    
    //print_r($result['rawdata']);
    //exit
//    $owneremail = $owner['email'];
//    $techemail = $tech['email'];
//    $adminemail = $admin['email'];

    if($result['rawdata']){
        $rawdata = $result['rawdata'];
        $registrant_city = "";
        $registrant_state = "";
        $registrant_country = "";
        foreach($rawdata as $rowIndex=>$registrarData){
            
            if (preg_match('/Registrant/', $registrarData)) {
                                $registrarData = trim($registrarData);
                                if (preg_match('/City:/', $registrarData)) {
                                    $registrant_city = trim($registrarData);
                                }

                                if (preg_match('/Province:/', $registrarData)) {
                                    $registrant_state = trim($registrarData);
                                }

                                if (preg_match('/Code:/', $registrarData)) {
                                    $registrant_postal_code = trim($registrarData);
                                }

                                if (preg_match('/Country/', $registrarData)) {
                                    $registrant_country = trim($registrarData);
                                }
            }
        }
        
        $addressCity = myStrReplace($registrant_city);
        $addressState = myStrReplace($registrant_state);
        $addressCountry = myStrReplace($registrant_country);
        
    }
    /* The following three fields are returned when deep_whois=FALSE (or TRUE) */
//    $regyinfo = $result['regyinfo'];
//    $registrar = $regyinfo['registrar'];
//    $regurl = $regyinfo['referrer'];
    
 $objDomainAddress->city = myStrReplace($addressCity);
 $objDomainAddress->state = myStrReplace($addressState);
 $objDomainAddress->country = myStrReplace($addressCountry);
 
 
    
    return $objDomainAddress;
}


function getDomainGeoInfo($domainName){
    
    $domainAddressInfo = getDomainAddressInfo($domainName);
    $city_name = mysql_escape_string($domainAddressInfo->city);
    $state_name = mysql_escape_string($domainAddressInfo->state);
    $country = mysql_escape_string($domainAddressInfo->country);
    $countryId = "";
    $stateId = "";
    $cityId = "";
    
        if($country != ""){
                $SQL_COUNTRY = "SELECT * FROM countries WHERE name LIKE '" .$country. "'  OR code LIKE '" .$country. "' OR code3 LIKE '" .$country. "' OR name_option_1 LIKE '" .$country. "' OR name_option_2 LIKE '" .$country. "' OR name_option_3 LIKE '" .$country. "'";
                $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
                $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
                $countryId = $ROW_COUNTRY['id'];
                if($countryId == ""){
                    $insert_country = mysql_query("INSERT INTO tbl_not_founded_country(name) values('".  mysql_escape_string($country)."')") or die(mysql_error());
                }
        } 
    
    
       if($state_name != ""){
             $SQL_STATE = "SELECT * FROM regions WHERE (name LIKE '" .$state_name. "'  OR code LIKE '" .$state_name. "' OR name_option_1 LIKE '" .$state_name. "' OR name_option_2 LIKE '" .$state_name. "' OR name_option_3 LIKE '" .$state_name. "') AND country_id = '".$countryId."'";
             $RS_STATE = mysql_query($SQL_STATE, DB_CONNECTION) or die(mysql_error());
             $ROW_STATE = mysql_fetch_assoc($RS_STATE);
             $stateId = $ROW_STATE['id'];
             if($stateId == ""){
                 $insert_state = mysql_query("INSERT INTO tbl_not_founded_regions(name,country) values('".  mysql_escape_string($state_name)."','".mysql_escape_string($country)."')") or die(mysql_error());
                 //print($SQL_STATE);exit;
                 
             }
             
        } 
        
        
       if($city_name != ""){
            $SQL_CITY = "SELECT * FROM cities WHERE (name LIKE '" .$city_name. "'  OR name_option_1 LIKE '" .$city_name. "' OR name_option_2 LIKE '" .$city_name. "' OR name_option_3 LIKE '" .$city_name. "') AND country_id = '".$countryId."' AND region_id = '".$stateId."'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            $cityId = $ROW_CITY['id'];
            if($cityId == ""){
                 $insert_city = mysql_query("INSERT INTO tbl_not_founded_city(name,region,country) values('".  mysql_escape_string($city_name)."','".mysql_escape_string($state_name)."','".mysql_escape_string($country)."')") or die(mysql_error());
             }
            
        } 
        
        if($countryId == ""){
            
                $domainExt = getFileExtension($domainName);
                $SQL_COUNTRY = "SELECT * FROM countries WHERE domain_extensions = '".$domainExt."'";
                $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
                $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
                if($ROW_COUNTRY){
                    $countryId = $ROW_COUNTRY['id'];
                }
            
        }
    
        $objDomainGeo = new stdClass();
        $objDomainGeo->countryId = $countryId;
        $objDomainGeo->stateId = $stateId;
        $objDomainGeo->cityId = $cityId;
        
        return $objDomainGeo;
    
}




function getDomainGeoInfoForWhoIs($domainName){
    
    $domainInfo = getDomainInfoWho_Is($domainName);
    $domainAddressInfo = getGeoFromRegistrarData($domainInfo);
    $city_name = mysql_escape_string($domainAddressInfo->city);
    $state_name = mysql_escape_string($domainAddressInfo->state);
    $country = mysql_escape_string($domainAddressInfo->country);
    $countryId = "";
    $stateId = "";
    $cityId = "";
    
        if($country != ""){
                $SQL_COUNTRY = "SELECT * FROM countries WHERE name LIKE '" .$country. "'  OR code LIKE '" .$country. "' OR code3 LIKE '" .$country. "' OR name_option_1 LIKE '" .$country. "' OR name_option_2 LIKE '" .$country. "' OR name_option_3 LIKE '" .$country. "'";
                $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
                $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
                $countryId = $ROW_COUNTRY['id'];
                if($countryId == ""){
                    $insert_country = mysql_query("INSERT INTO tbl_not_founded_country(name) values('".  mysql_escape_string($country)."')") or die(mysql_error());
                }
        } 
    
    
       if($state_name != ""){
             $SQL_STATE = "SELECT * FROM regions WHERE (name LIKE '" .$state_name. "'  OR code LIKE '" .$state_name. "' OR name_option_1 LIKE '" .$state_name. "' OR name_option_2 LIKE '" .$state_name. "' OR name_option_3 LIKE '" .$state_name. "') AND country_id = '".$countryId."'";
             $RS_STATE = mysql_query($SQL_STATE, DB_CONNECTION) or die(mysql_error());
             $ROW_STATE = mysql_fetch_assoc($RS_STATE);
             $stateId = $ROW_STATE['id'];
             if($stateId == ""){
                 $insert_state = mysql_query("INSERT INTO tbl_not_founded_regions(name,country) values('".  mysql_escape_string($state_name)."','".mysql_escape_string($country)."')") or die(mysql_error());
                 //print($SQL_STATE);exit;
                 
             }
             
        } 
        
        
       if($city_name != ""){
            $SQL_CITY = "SELECT * FROM cities WHERE (name LIKE '" .$city_name. "'  OR name_option_1 LIKE '" .$city_name. "' OR name_option_2 LIKE '" .$city_name. "' OR name_option_3 LIKE '" .$city_name. "') AND country_id = '".$countryId."' AND region_id = '".$stateId."'";
            $RS_CITY = mysql_query($SQL_CITY, DB_CONNECTION) or die(mysql_error());
            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
            $cityId = $ROW_CITY['id'];
            if($cityId == ""){
                 $insert_city = mysql_query("INSERT INTO tbl_not_founded_city(name,region,country) values('".  mysql_escape_string($city_name)."','".mysql_escape_string($state_name)."','".mysql_escape_string($country)."')") or die(mysql_error());
             }
            
        } 
        
        if($countryId == ""){
            
                $domainExt = getFileExtension($domainName);
                $SQL_COUNTRY = "SELECT * FROM countries WHERE domain_extensions = '".$domainExt."'";
                $RS_COUNTRY = mysql_query($SQL_COUNTRY, DB_CONNECTION) or die(mysql_error());
                $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
                if($ROW_COUNTRY){
                    $countryId = $ROW_COUNTRY['id'];
                }
            
        }
    
        $objDomainGeo = new stdClass();
        $objDomainGeo->countryId = $countryId;
        $objDomainGeo->stateId = $stateId;
        $objDomainGeo->cityId = $cityId;
        
        return $objDomainGeo;
    
}

function getTotalCountFromLinkForSearchKey($searchStringKey,$websiteLink){
    print($websiteLink." - ".$searchStringKey."\n");
    $searchStringKey = $searchStringKey;
    $websiteLink = $websiteLink;
    $searchString = $searchStringKey;
    $theParentLinkContents = file_get_contents_curl($websiteLink);
    $websitePageHtml = str_get_html($theParentLinkContents);
    $totalCount = 0;
    if (method_exists($websitePageHtml, "find")) {
            $bodyContnets = $websitePageHtml->getElementsByTagName("body", 0)->plaintext;
            $theSiteInnerContents = $bodyContnets;
            $num1 = getTotalMatchingWordInStr($theSiteInnerContents, $searchString); // 1 - the HTML String, 2 - Search Text
            $totalCount = $num1;
    } 
    
    if($websitePageHtml){
        $websitePageHtml->clear();
        unset($websitePageHtml);
    }
    
    return $totalCount;
}



function updateSocialMediaRankSummary($brandId, $dateOn) {

        $SQL_BRAND = "SELECT * FROM tbl_brands WHERE id = '" . $brandId . "'";
        $RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
        $BRAND_ROW = mysql_fetch_assoc($RS_BRAND);


        $brand_id = $BRAND_ROW['id'];
        $brand_name = mysql_escape_string($BRAND_ROW['brand_name']);


        print("Updating the results for : " . $brand_name . " report date " . $dateOn . "\n");

        
        $SQL_BRAND_SUM = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source IN('facebook.com') AND date_on = '" . $dateOn . "'";
        $RS_BRAND_SUM = mysql_query($SQL_BRAND_SUM) or die(mysql_error());
        $ROW_BRAND = mysql_fetch_assoc($RS_BRAND_SUM);
        $BRAND_TOTAL_COUNT = $ROW_BRAND['total_count'];

        $SQL_CHECK_BRAND = "SELECT id As id FROM `tbl_search_result_social_media` WHERE `media_source` = 'Facebook' AND `brand_id` = '".$brand_id."' AND `report_date` = '".$dateOn."'";
        $RS_BRAND_CHECK = mysql_query($SQL_CHECK_BRAND) or die(mysql_error());
        $ROW_BRAND_CHECK = mysql_fetch_assoc($RS_BRAND_CHECK);
        $BRAND_CHECK_ID = $ROW_BRAND_CHECK['id'];
        
        if($BRAND_CHECK_ID == ""){
             //sql insert......
        $SQL_SOCIALMEDIA_FACEBOOK = "INSERT INTO `tbl_search_result_social_media` (
            `id`, 
            `brand_id`, 
            `media_source`, 
            `total_count`, 
            `report_date`) VALUES (
            NULL, 
            '".$brand_id."', 
            'Facebook', 
            '".$BRAND_TOTAL_COUNT."', 
            '".$dateOn."')";
        } else {
             //sql insert......
            $SQL_SOCIALMEDIA_FACEBOOK = "UPDATE `tbl_search_result_social_media` SET `total_count` = '".$BRAND_TOTAL_COUNT."' WHERE `id` = '".$BRAND_CHECK_ID."'";
        }
       

        $RS_FACEBOOK = mysql_query($SQL_SOCIALMEDIA_FACEBOOK) or die(mysql_error());


    // get all country id....
    $SQL_COUNTRY = "SELECT `id` As country_id FROM `countries`";
    $RS_COUNTRY_IDS = mysql_query($SQL_COUNTRY) or die(mysql_error());

    while ($ROW_COUNTRY_ID = mysql_fetch_assoc($RS_COUNTRY_IDS)) {
        usleep(300);
        $SQL_COUNTRY_INFO = "SELECT * FROM countries WHERE id = '" . $ROW_COUNTRY_ID['country_id'] . "'";
        $RS_COUNTRY_INFO = mysql_query($SQL_COUNTRY_INFO) or die(mysql_error());
        $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY_INFO);

        $country_id = $ROW_COUNTRY['id'];

        // facebook....
        $SQL_BRAND_SUM_COUNTRY = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source IN('facebook.com') AND date_on = '" . $dateOn . "' AND country_id = '".$country_id."'";
        $RS_BRAND_SUM_COUNTRY = mysql_query($SQL_BRAND_SUM_COUNTRY) or die(mysql_error());
        $ROW_BRAND_COUNTRY = mysql_fetch_assoc($RS_BRAND_SUM_COUNTRY);
        $BRAND_TOTAL_COUNT_COUNTRY = $ROW_BRAND_COUNTRY['total_count'];
        
        if($BRAND_TOTAL_COUNT_COUNTRY>0){
            
             $SQL_CHECK_BRAND_COUNTRY = "SELECT id As id FROM `tbl_search_result_social_media_country` WHERE `media_source` = 'Facebook' AND `brand_id` = '".$brand_id."' AND `report_date` = '".$dateOn."' AND country_id = '".$country_id."'";
        $RS_BRAND_CHECK_COUNTRY = mysql_query($SQL_CHECK_BRAND_COUNTRY) or die(mysql_error());
        $ROW_BRAND_CHECK_COUNTRY = mysql_fetch_assoc($RS_BRAND_CHECK_COUNTRY);
        $BRAND_CHECK_ID_COUNTRY = $ROW_BRAND_CHECK_COUNTRY['id'];
        
        if($BRAND_CHECK_ID_COUNTRY == ''){
            $SQL_COUNTRY_SOCIAL_MEDIA = "INSERT INTO `tbl_search_result_social_media_country` (
                `id`, 
                `brand_id`, 
                `media_source`, 
                `country_id`, 
                `total_count`, 
                `report_date`) VALUES (
                NULL, 
                '".$brand_id."', 
                'Facebook', 
                '".$country_id."', 
                '".$BRAND_TOTAL_COUNT_COUNTRY."', 
                '".$dateOn."')";
        } else {
            $SQL_COUNTRY_SOCIAL_MEDIA = "UPDATE `tbl_search_result_social_media_country` SET `total_count` = '".$BRAND_TOTAL_COUNT_COUNTRY."' WHERE `id` = '".$BRAND_CHECK_ID_COUNTRY."'";
        }
        $RS_FACEBOOK = mysql_query($SQL_COUNTRY_SOCIAL_MEDIA) or die(mysql_error());
            
            
        }
        
    }


    // update the state results........
    $SQL_regions = "SELECT `id` As region_id  FROM `regions`";
    $RS_REGIONS_IDS = mysql_query($SQL_regions) or die(mysql_error());
    while ($ROW_REGIONS_IDS = mysql_fetch_assoc($RS_REGIONS_IDS)) {
        usleep(300);

        $SQL_REGION_INFO = "SELECT * FROM regions WHERE id = '" . $ROW_REGIONS_IDS['region_id'] . "'";
        $RS_REGION_INFO = mysql_query($SQL_REGION_INFO) or die(mysql_error());
        $ROW_REGIONS = mysql_fetch_assoc($RS_REGION_INFO);

        $region_id = $ROW_REGIONS['id'];
   
        // facebook....
        $SQL_BRAND_SUM_REGION = "SELECT sum(total_count) As total_count FROM tbl_search_results WHERE tbl_brands_id = '" . $brand_id . "' AND search_source IN('facebook.com') AND date_on = '" . $dateOn . "' AND region_id = '".$region_id."'";
        $RS_BRAND_SUM_REGION = mysql_query($SQL_BRAND_SUM_REGION) or die(mysql_error());
        $ROW_BRAND_REGION = mysql_fetch_assoc($RS_BRAND_SUM_REGION);
        $BRAND_TOTAL_COUNT_REGION = $ROW_BRAND_REGION['total_count'];
        
        if($BRAND_TOTAL_COUNT_REGION>0){
            
                 $SQL_CHECK_BRAND_REGION = "SELECT id As id FROM `tbl_search_result_social_media_region` WHERE `media_source` = 'Facebook' AND `brand_id` = '".$brand_id."' AND `report_date` = '".$dateOn."' AND region_id = '".$region_id."'";
        $RS_BRAND_CHECK_REGION = mysql_query($SQL_CHECK_BRAND_REGION) or die(mysql_error());
        $ROW_BRAND_CHECK_REGION = mysql_fetch_assoc($RS_BRAND_CHECK_REGION);
        $BRAND_CHECK_ID_REGION = $ROW_BRAND_CHECK_REGION['id'];
        
        if($BRAND_CHECK_ID_REGION == ""){
            $SQL_REGION_SOCIAL_MEDIA = "INSERT INTO `tbl_search_result_social_media_region` (
                `id`, 
                `brand_id`, 
                `media_source`, 
                `region_id`, 
                `total_count`, 
                `report_date`) VALUES (
                NULL, 
                '".$brand_id."', 
                'Facebook', 
                '".$region_id."', 
                '".$BRAND_TOTAL_COUNT_REGION."', 
                '".$dateOn."')";
        }else{
            $SQL_REGION_SOCIAL_MEDIA = "UPDATE `tbl_search_result_social_media_region` SET `total_count` = '".$BRAND_TOTAL_COUNT_REGION."' WHERE `id` = '".$BRAND_CHECK_ID_REGION."'";
        }
        
        $RS_FACEBOOK = mysql_query($SQL_REGION_SOCIAL_MEDIA) or die(mysql_error());
            
        }
        
    }
}

?>