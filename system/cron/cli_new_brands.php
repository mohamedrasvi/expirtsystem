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

$currentDate = getCurrentDateOnly();

$row_added_on = ADDED_ON_DATE;


$monitor_file_path = "/tmp/monitor.txt";
if (file_exists($monitor_file_path)) {
    echo "The script is already running...\n";
    exit;
} else {

    $objLogger = new Logger();
    $objLogger->write("The new brand script started....");

    //$SQL_BRANDS = "SELECT * FROM tbl_brands WHERE is_status = 'Enabled' LIMIT 0,1"; -- original
    $SQL_BRANDS = "SELECT * FROM tbl_brands WHERE is_status = 'Enabled' AND is_new_brand = 'Yes' ORDER BY added_on Asc LIMIT 0,1";
    $RS_BRANDS = mysql_query($SQL_BRANDS, DB_CONNECTION) or die(mysql_error());



    while ($ROW_BRAND = mysql_fetch_array($RS_BRANDS)) {

        $brandId = $ROW_BRAND['id'];
        $brandName = $ROW_BRAND['brand_name'];
        $brandTags = $ROW_BRAND['brand_tags'];
        $isNewBrand = $ROW_BRAND['is_new_brand'];
        $memberId = $ROW_BRAND['tbl_member_id'];

        $objLogger->write("The new brand ID : " . $brandId);


        $brandTagsPieces = explode(",", $brandTags);
        $brandTagsPiecesForCount = explode(",", $brandTags);
        print("Featching search results for " . $brandName . ".....\n");



        foreach ($brandTagsPieces As $tIndex => $brandTag) {
            $serachStr = $brandTag;
            getGoogleLinks($serachStr, $brandId);
            getYahooLinks($serachStr, $brandId);
            faceBookPlaceSearch($serachStr, $row_added_on, $brandId);
            facebookPostSearch($serachStr, $row_added_on, $brandId);
            facebookEventSearch($serachStr, $row_added_on, $brandId);
        }


        print("Starting count for " . $brandName . ".....\n");
        $SQL_SEARCH_LINKS_COUNT = "SELECT count(sl.id) AS tot FROM tbl_search_links as sl,tbl_brands b WHERE sl.tbl_brands_id = b.id AND update_status = 'Waiting'  AND sl.tbl_brands_id = '" . $brandId . "'";
        $RS_SEARCH_LINK_COUNT = mysql_query($SQL_SEARCH_LINKS_COUNT, DB_CONNECTION) or die(mysql_error());
        $ROW_SEARCH_LINK_COUNT = mysql_fetch_assoc($RS_SEARCH_LINK_COUNT);

        $totalResults = $ROW_SEARCH_LINK_COUNT['tot'];

            $SQL_SEARCH_LINKS = "SELECT sl.id AS id,sl.search_key AS search_key,sl.search_source AS search_source,sl.web_link AS web_link,sl.added_on AS added_on,sl.tbl_brands_id AS tbl_brands_id,sl.update_status AS update_status FROM tbl_search_links as sl,tbl_brands b WHERE sl.tbl_brands_id = b.id AND update_status = 'Waiting'  AND sl.tbl_brands_id = '" . $brandId . "'";


            $RS_SEARCH_LINKS = mysql_query($SQL_SEARCH_LINKS, DB_CONNECTION) or die(mysql_error());
            while ($ROW_SEARCH_ROW = mysql_fetch_array($RS_SEARCH_LINKS)) {


                $row_id = $ROW_SEARCH_ROW['id'];
                $row_search_key = $ROW_SEARCH_ROW['search_key'];
                $row_search_source = $ROW_SEARCH_ROW['search_source'];
                $row_web_link = $ROW_SEARCH_ROW['web_link'];
                $row_added_on = $ROW_SEARCH_ROW['added_on'];
                $row_brandId = $ROW_SEARCH_ROW['tbl_brands_id'];
                
                print("The link : ".$row_web_link." \n");
                
                $SQL_UPDATE_STATUS = "UPDATE tbl_search_links SET update_status = 'Completed' WHERE id='" . $row_id . "'";
                $RS_UPDATE_STATUS = mysql_query($SQL_UPDATE_STATUS, DB_CONNECTION) or die(mysql_error());
                print("Status Updated : " . $row_id . " Moving to next .....");
                $objLogger->write("Status Updated : " . $row_id . " Moving to next .....");
                usleep(50);
                try{
                        //print_r($brandTagsPiecesForCount);
                        foreach ($brandTagsPiecesForCount As $tIndex => $brandTag) {
                            //print(row_web_link." / ".$brandTag."\n");
                            doCounts($row_web_link, $brandTag, $row_added_on, $row_brandId, $row_search_source);
                        }
                } catch (Exception $ex) {
                                            print("Error thrown , when count - ".$ex->getMessage());
                                            $objLogger->write("Error thrown, when count - ".$ex->getMessage());
                                            break;
                }
        

                echo memory_get_usage() . "\n";
                /*
                $SQL_UPDATE_STATUS = "UPDATE tbl_search_links SET update_status = 'Completed' WHERE id='" . $row_id . "'";
                $RS_UPDATE_STATUS = mysql_query($SQL_UPDATE_STATUS, DB_CONNECTION) or die(mysql_error());
                print("Status Updated : " . $row_id . " Moving to next .....");
                $objLogger->write("Status Updated : " . $row_id . " Moving to next .....");
                usleep(50);
                 * 
                 */
            }

            usleep(300);
        updateRankSummary($brandId, $row_added_on); // brand id starting from 7
        updateSocialMediaRankSummary($brandId, $row_added_on);


        $SQL_BRAND = "UPDATE tbl_brands SET last_update_on='" . $currentDate . "',first_update_on='" . $currentDate . "',is_new_brand='No' WHERE id = '" . $brandId . "'";
        $RS_BRAND_COMPLETED = mysql_query($SQL_BRAND, DB_CONNECTION) or die(mysql_error());

        $objLogger->write("Completed brand ID : " . $brandId . " and changed the status");
        

       // country missing
       $totalResult_country_missing = 0;
       $SQL_DOMAINS_COUNT = "SELECT count(id) as tot FROM tbl_domains WHERE country_id = '' OR country_id = '0' OR country_id IS NULL";
       $RS_DOMAINS_COUNT = mysql_query($SQL_DOMAINS_COUNT) or die(mysql_error());
       $ROW_DOMAIN_COUNT = mysql_fetch_assoc($RS_DOMAINS_COUNT);
       $totalResult_country_missing = $ROW_DOMAIN_COUNT['tot'];
                                
        // state missing....
       $totalResult_state_missing = 0;
       $SQL_DOMAINS_COUNT_STATES = "SELECT count(id) as tot FROM tbl_domains WHERE region_id = '' OR region_id = '0' OR region_id IS NULL";
       $RS_DOMAINS_COUNT_STATES = mysql_query($SQL_DOMAINS_COUNT_STATES) or die(mysql_error());
       $ROW_DOMAIN_COUNT_STATES = mysql_fetch_assoc($RS_DOMAINS_COUNT_STATES);
       $totalResult_state_missing = $ROW_DOMAIN_COUNT_STATES['tot'];
       $missingText  = "Needs Attention : Country missing in $totalResult_country_missing Domains , States missing in $totalResult_state_missing Domains . Please update the details ASAP to get the report properly.";                       
        
        // ------------------ send email to other system managers ---------
        $SQL_NOTIFICATION_EMAILS = "SELECT email_addresses FROM tbl_email_notifications WHERE notification_type = 'New_Brand'";
        $RS_NOTIFICATION_EMAILS  = mysql_query($SQL_NOTIFICATION_EMAILS) or die(mysql_error());
        $ROW_NOTIFICATION_EMAILS = mysql_fetch_assoc($RS_NOTIFICATION_EMAILS);
        $NOTIFICATION_EMAILS     = $ROW_NOTIFICATION_EMAILS['email_addresses'];
        $arrEmails  = explode(',', $NOTIFICATION_EMAILS);


        $mail = new PHPMailer();
        $mail->IsSendmail(); // telling the class to use SendMail transport
        $mail->AddReplyTo(SITE_EMAIL_ADDRESS, SITE_NAME);
        foreach($arrEmails As $eIndex=>$email){
        $mail->AddAddress($email);  
        }

        $mail->SetFrom(SITE_EMAIL_ADDRESS, SITE_NAME);
        $mail->Subject = "The report is ready for brand ".$brandName." - ".SITE_NAME;
        $msg = "The report is ready for your brand - ".$brandName." Login to the system and see your brands's popularity.<BR/><BR/>".$missingText."<BR/><BR/> Thanks<BR/>".SITE_NAME;
        $mail->MsgHTML($msg);

        $mail->Send();

       //***************************************
    }
    $objLogger->write("The new brand script completed....");
    unlink($monitor_file_path);
}
exit();
?>
