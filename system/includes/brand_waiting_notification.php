<?php
$currentUserId = $_SESSION['userId'];
$SQL_NEW_BRAND = "SELECT * FROM tbl_brands WHERE tbl_member_id = '" . $currentUserId . "' AND is_new_brand = 'Yes'";
$RS_NEW_BRAND = mysql_query($SQL_NEW_BRAND) or die(mysql_error());

$arrBrands = array();
$new_brand_str = "";
while ($ROW_BRAND = mysql_fetch_assoc($RS_NEW_BRAND)) {
    $brandName = $ROW_BRAND['brand_name'];
    $new_brand_str = $new_brand_str.",".$brandName;
    array_push($arrBrands, $brandName);
}
if (count($arrBrands) > 0) {
    ?>
<?php foreach($arrBrands As $brand){?>
    <div class="push">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Note :</strong> Your brand "<?php print($brand);?>" in waiting status. The report will be ready for this brands soon! 
        </div>

    </div>
<?php } ?>
<?php } ?>

