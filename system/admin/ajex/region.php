<?php
include '../../config/db_con.php';
$countryId = $_GET['cId'];

$SQL_REGION = "SELECT * FROM regions WHERE country_id = '".$countryId."'";
$RS_REGION = mysql_query($SQL_REGION);
?>
<select id="cmbRegion" name="cmbRegion" class="input-xlarge" onchange="showCity();">
                                         <option value=""></option>
                                         <?php while($region_row = mysql_fetch_array($RS_REGION)){?>
                                         <option value="<?php print($region_row['id']);?>"><?php print($region_row['name']);?></option>
                                         <?php } ?>
                                    </select>