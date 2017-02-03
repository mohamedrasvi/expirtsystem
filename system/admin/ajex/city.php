<?php
include '../../config/db_con.php';
$regionId = $_GET['rId'];
$country_id = $_GET['rId'];

$SQL_CITY = "SELECT * FROM cities WHERE region_id = '".$regionId."' OR country_id = '".$country_id."'";
$RS_CITY = mysql_query($SQL_CITY);
?>
<select id="cmbCity" name="cmbCity" class="input-xlarge">
                                         <option value=""></option>
                                         <?php while($city_row = mysql_fetch_array($RS_CITY)){?>
                                         <option value="<?php print($city_row['id']);?>"><?php print($city_row['name']);?></option>
                                         <?php } ?>
                                    </select>