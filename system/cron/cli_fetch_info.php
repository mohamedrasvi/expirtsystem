<?php
include('phpwhois/whois.main.php');
include('myfunctions.php');
include('simple_html_dom.php');
include('db_con.php');
include('Logger.php');
require 'facebook/facebookSearcher.class.php';
require_once 'twitter/twitter.class.php';

$objLogger = new Logger();
$monitor_file_path = "/tmp/monitor.txt";

if (file_exists($monitor_file_path)) {
    echo "The script is already running...\n";
    exit;
} else {

    sendEmail("Script Started", "Script Started");
    $fh = fopen($monitor_file_path, 'w') or die("can't open file");
    $stringData = "The script started to fetch the information....\n";
    fwrite($fh, $stringData);
    fclose($fh);
    print($stringData);
    

    $objLogger->write($stringData);


    $SQL_SEARCH_LINKS = "SELECT sl.id AS id,sl.search_key AS search_key,sl.search_source AS search_source,sl.web_link AS web_link,sl.added_on AS added_on,sl.tbl_brands_id AS tbl_brands_id,sl.update_status AS update_status FROM tbl_search_links as sl,tbl_brands b WHERE sl.tbl_brands_id = b.id AND sl.update_status = 'Waiting' AND b.is_new_brand != 'Yes'  LIMIT 0,50";
    $RS_SEARCH_LINKS = mysql_query($SQL_SEARCH_LINKS, $db_con) or die(mysql_error());
    while ($ROW_SEARCH_ROW = mysql_fetch_array($RS_SEARCH_LINKS)) {


        $row_id = $ROW_SEARCH_ROW['id'];
        $row_search_key = $ROW_SEARCH_ROW['search_key'];
        $row_search_source = $ROW_SEARCH_ROW['search_source'];
        $row_web_link = $ROW_SEARCH_ROW['web_link'];
        $row_added_on = $ROW_SEARCH_ROW['added_on'];
        $row_brandId = $ROW_SEARCH_ROW['tbl_brands_id'];


        doCounts($row_web_link, $row_search_key,$row_added_on,$row_brandId,$row_search_source);
        faceBookPlaceSearch($row_search_key,$row_added_on,$row_brandId);
        facebookPostSearch($row_search_key,$row_added_on,$row_brandId);
        facebookEventSearch($row_search_key,$row_added_on,$row_brandId);
       

        echo memory_get_usage() . "\n";
        usleep(50);
        $SQL_UPDATE_STATUS = "UPDATE tbl_search_links SET update_status = 'Completed' WHERE id='" . $row_id . "'";
        $RS_UPDATE_STATUS = mysql_query($SQL_UPDATE_STATUS) or die(mysql_error());
        print("Status Updated : " . $row_id . " Moving to next .....");
        $objLogger->write("Status Updated : " . $row_id . " Moving to next .....");
    }


    ob_flush();
    flush();
    print("Done succfully.");
    unlink($monitor_file_path);
    $objLogger->write("Script Completed");

}
?>
