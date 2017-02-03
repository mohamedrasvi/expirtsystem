<?php
include('db_con.php');
include('phpwhois/whois.main.php');
include('simple_html_dom.php');
include('Logger.php');
include('myfunctions.php');
include 'includes/Paggination.php';
include 'includes/class.phpmailer.php';
require 'facebook/facebookSearcher.class.php';
date_default_timezone_set('Asia/Colombo');

$SQL_DOMAIN_COUNTRY = "SELECT * FROM `tbl_domains` WHERE country_id is NULL and region_id IS NULL ORDER BY id Asc";
$RS_DOMAIN_COUNTRY = mysql_query($SQL_DOMAIN_COUNTRY, DB_CONNECTION) or die(mysql_error());

while ($ROW_COUNTRY = mysql_fetch_array($RS_DOMAIN_COUNTRY)) {
    $domainName = $ROW_COUNTRY['domain_name'];
    $domainId = $ROW_COUNTRY['id'];
    
    $domainGeo = getDomainInfo($domainName);
    $cityId = $domainGeo->cityId;
    $stateId = $domainGeo->stateId;
    $countryId = $domainGeo->countryId;
    print($domainId.")Domain name : ".$domainName."\n");
    
     if($cityId != ""){
         $RS_CITY_DOMAIN = mysql_query("UPDATE tbl_domains SET city_id = '".$cityId."' WHERE id = '".$domainId."'") or die(mysql_error());
         $RS_CITY_DOMAIN_SEARCH_RES = mysql_query("UPDATE tbl_search_results SET city_id = '".$cityId."' WHERE result_from_link_domain_name = '".$domainId."'") or die(mysql_error());
         print("City ID ".$cityId." Updated");
         
         print("\n");
     }
    
    if($stateId != ""){
         $RS_STATE_DOMAIN = mysql_query("UPDATE tbl_domains SET region_id = '".$stateId."' WHERE id = '".$domainId."'") or die(mysql_error());
         $RS_CITY_DOMAIN_SEARCH_RES = mysql_query("UPDATE tbl_search_results SET region_id = '".$stateId."' WHERE result_from_link_domain_name = '".$domainId."'") or die(mysql_error());
         print("State ID ".$stateId." Updated");
         print("\n");
     }
     
     
     if($countryId != ""){
             $RS_COUNTRY_DOMAIN = mysql_query("UPDATE tbl_domains SET country_id = '".$countryId."' WHERE id = '".$domainId."'") or die(mysql_error());
             $RS_CITY_DOMAIN_SEARCH_RES = mysql_query("UPDATE tbl_search_results SET country_id = '".$countryId."' WHERE result_from_link_domain_name = '".$domainId."'") or die(mysql_error());
             print("Country ID ".$countryId." Updated");
             print("\n");
      }
    
}

print("completed...");
exit;



function getDomainInfo($domainName){
    

//////////////////////////
// Fill in your details //
//////////////////////////
$username = "bcas12345";
$password = "bcas12345";
$domain = $domainName;//"csuchico.edu";
$format = "XML";//"JSON"; //or XML

$url = 'http://www.whoisxmlapi.com/whoisserver/WhoisService?domainName='. $domain .'&username='. $username .'&password='. $password .'&outputFormat='. $format;
if($format=='JSON'){
  /////////////////////////
  // Use a JSON resource //
  /////////////////////////
  // Get and build the JSON object
  $result = json_decode(file_get_contents($url));

  // Print out a nice informative string
  print ("<div>JSON:</div>" . RecursivePrettyPrint($result));
}
else{
  ////////////////////////
  // Use a XML resource //
  ////////////////////////

  $url = 'http://www.whoisxmlapi.com/whoisserver/WhoisService?domainName='. $domain .'&username='. $username .'&password='. $password .'&outputFormat='. $format;
  // Get and build the XML associative array
  $parser = new XMLtoArray();
  $result = array("WhoisRecord" =>$parser->ParseXML($url));
  $rowCountryID = "";
  $rowStateID = "";
  $rowCityID = "";

 
    $city = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registrant']['city']));
    $state = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registrant']['state']));
    $country = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registrant']['country']));  
  if($country == "" && $state == ""){
     $city = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['registrant']['city']));
     $state = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['registrant']['state']));
     $country = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['registrant']['country']));
  }
  
  
  if($country == "" && $state == ""){
     $city = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['administrativeContact']['city']));
     $state = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['administrativeContact']['state']));
     $country = trim(str_replace('(Gandi)', '',$result['WhoisRecord']['registryData']['administrativeContact']['country']));
  }


   $SQL_COUNTRY = "SELECT id,name FROM countries WHERE code LIKE '".mysql_escape_string($country)."' OR  code3 LIKE '".mysql_escape_string($country)."' OR name LIKE '".mysql_escape_string($country)."'";
   $RS_COUNTRY = mysql_query($SQL_COUNTRY) or die($SQL_COUNTRY);
   $ROW_COUNTRY = mysql_fetch_assoc($RS_COUNTRY);
   $row_country_id = $ROW_COUNTRY['id'];
   if($row_country_id != ""){
            $rowCountryID = $row_country_id;
    }
    
     // get the state name .....
    $row_data_value = $state;
                if($row_data_value != ""){
                    if($rowStateID == ""){
                        $SQL_STATE = "SELECT id FROM regions WHERE name LIKE '".mysql_escape_string($row_data_value)."' OR code LIKE '".mysql_escape_string($row_data_value)."' OR name_option_1 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_2 LIKE '".mysql_escape_string($row_data_value)."' OR name_option_3 LIKE '".mysql_escape_string($row_data_value)."' AND country_id = '".$rowCountryID."'";
                        $RS_STATE = mysql_query($SQL_STATE) or die($SQL_STATE);
                        $ROW_STATE = mysql_fetch_assoc($RS_STATE);
                        if($ROW_STATE['id'] != ""){
                            $rowStateID = $ROW_STATE['id'];
                        } else {
                            $state_name = $row_data_value;
                            $insert_state = mysql_query("INSERT INTO tbl_not_founded_regions(name,country) values('".  mysql_escape_string($row_data_value)."','".mysql_escape_string($country)."')") or die(mysql_error());
                            print("A new state inserted \n");
                            
                        }
                    }
                }
                
                
                $row_data_value = $city;
                if($row_data_value != ""){
                    if($rowCityID == ""){
                            $SQL_CITY = "SELECT id FROM cities WHERE name LIKE '".mysql_escape_string($row_data_value)."' AND country_id = '".$rowCountryID."' AND region_id = '".$rowStateID."'";
                            $RS_CITY = mysql_query($SQL_CITY) or die($SQL_CITY);
                            $ROW_CITY = mysql_fetch_assoc($RS_CITY);
                            if($ROW_CITY['id'] != ""){
                                $rowCityID = $ROW_CITY['id'];
                            } else {
                                $insert_city = mysql_query("INSERT INTO tbl_not_founded_city(name,region,country) values('".  mysql_escape_string($city_name)."','".mysql_escape_string($state_name)."','".mysql_escape_string($country)."')") or die(mysql_error());
                                 print("A new city inserted \n");
                                
                            }
                    }
                    
                }
    
    
  
  
    $objGeo = new stdClass();
    $objGeo->countryId = $rowCountryID;
    $objGeo->stateId = $rowStateID;
    $objGeo->cityId = $rowCityID;
    
    return $objGeo;

}

}


// Function to recursively print all properties of an object and their values
function RecursivePrettyPrint($obj)
{
  $str = "";
  foreach ((array)$obj as $key => $value)
  {
    if (!is_string($key)) // XML parsing leaves a little to be desired as it fills our obj with key/values with just whitespace, ignore that whitespace at the cost of losing hostNames and ips in the final printed result
      continue;
    $str .= '<div style="margin-left: 25px;border-left:1px solid black">' . $key . ": ";
    if (is_string($value))
      $str .= $value;
    else
      $str .= RecursivePrettyPrint($value);
    $str .= "</div>";
  }
  
  return $str;
}

// Class that simply turns an xml tree into a multilevel associative array
class XMLtoArray 
{
  private $root;
  private $stack;

  public function __construct()
  {
    $this->root = null;
    $this->stack = array();
  }
  
  function ParseXML($feed_url)
  {
    $xml_parser = xml_parser_create(); 
    
    xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);// or throw new Exception('Unable to Set Case Folding option on XML Parser!');
    xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1);// or throw new Exception('Unable to Set Skip Whitespace option on XML Parser!');
    xml_set_object($xml_parser, $this); 
    xml_set_element_handler($xml_parser, "startElement", "endElement"); 
    xml_set_character_data_handler($xml_parser, "characterData"); 

    $fp = fopen($feed_url,"r");// or throw new Exception("Unable to read URL!"); 

    while ($data = fread($fp, 4096)) 
      xml_parse($xml_parser, $data, feof($fp));// or throw new Exception(sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser))); 

    fclose($fp); 

    xml_parser_free($xml_parser);
    
    return $this->root;
  }
  
  public function startElement($parser, $tagName, $attrs) 
  {
    if ($this->root == null)
    {
      $this->root = array();
      $this->stack[] = &$this->root;
    }
    else
    {
      $parent = &$this->stack[count($this->stack)-1];
      if (!is_array($parent))
        $parent = array($parent);
      if (isset($parent[$tagName]))
      {
        if (!is_array($parent[$tagName]))
          $parent[$tagName] = array($parent[$tagName]);
      }
      else
        $parent[$tagName] = null;
      
      $this->stack[] = &$parent[$tagName];
    }
  }

  public function endElement($parser, $tagName)
  {
    array_pop($this->stack);
  }

  public function characterData($parser, $data) 
  {
    $data = trim($data);
      
    $current = &$this->stack[count($this->stack)-1];
    if (is_array($current))
      $current[] = $data;
    else
      $current = $data;
  }
}

?>
