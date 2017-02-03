<?php
include '../config/db_con.php';
include 'includes/auth.php';
include 'includes/Paggination.php';
include '../includes/class.phpmailer.php';
$brandId = $_GET['id'];

$SQL_BRAND = "SELECT * FROM tbl_brands WHERE id = '".$brandId."'";
$RS_BRAND = mysql_query($SQL_BRAND) or die(mysql_error());
$ROW_BRAND = mysql_fetch_assoc($RS_BRAND);
$brandId         = $ROW_BRAND['id'];
$brand_name     = $ROW_BRAND['brand_name'];
$brand_logo     = $ROW_BRAND['brand_logo'];
$brand_tags     = $ROW_BRAND['brand_tags'];
$added_on       = $ROW_BRAND['added_on'];
$modified_on    = $ROW_BRAND['modified_on'];
$country_name   = $ROW_BRAND['country_name'];
$sector         = $ROW_BRAND['sector'];
$is_status      = $ROW_BRAND['is_status'];
$theMemberId    = $ROW_BRAND['tbl_member_id'];

$notification_subject = "The report is ready for brand ".$brand_name;
$notification_msg = "The report is ready for your brand - ".$brand_name." You can see your brands's popularity";
$mysqldate = date( 'Y-m-d H:i:s');
$SQL_NOTIFICATION = "INSERT INTO `tbl_notifications` (
        `id`, 
        `title`, 
        `message`, 
        `added_on`, 
        `userId`) VALUES (
        NULL, 
        '".mysql_escape_string($notification_subject)."', 
        '".mysql_escape_string($notification_msg)."', 
        '".$mysqldate."', 
        '".$theMemberId."')";

$RS_NOTIFY  = mysql_query($SQL_NOTIFICATION) or die(mysql_error());

$SQL_MEMBER = "SELECT * FROM tbl_members WHERE id = '".$theMemberId."'";
$RS_MEMBER  = mysql_query($SQL_MEMBER) or die(mysql_error());
$ROW_MEMBER = mysql_fetch_assoc($RS_MEMBER);
$memberEmail  = $ROW_MEMBER['email_address'];

$mail = new PHPMailer();
$mail->IsSendmail(); // telling the class to use SendMail transport
$mail->AddReplyTo(SITE_EMAIL_ADDRESS, SITE_NAME);
$mail->AddAddress($memberEmail);  
$mail->SetFrom(SITE_EMAIL_ADDRESS, SITE_NAME);
$mail->Subject = "The report is ready for brand ".$brand_name." - ".SITE_NAME;
$msg = "The report is ready for your brand - ".$brand_name." Login to the system and see your brands's popularity.<BR/><BR/>".$missingText."<BR/><BR/> Thanks<BR/>".SITE_NAME;
$mail->MsgHTML($msg);
$mail->Send();
header("Location: brands.php?status=email-sent");
exit;
?>