<?php
require('config.php');
echo 'dataset test<br/>';

// sum(datanumber_value) as total
// GROUP BY loc_regions.region_abbr

$datatype = 4;
$period = 2;
$sql = "SELECT reg.region_abbr, SUM(num.datanumber_value) AS datanumber_value
FROM data_numbers num
INNER JOIN loc_entities ent ON num.datanumber_ent_id = ent.ent_id
INNER JOIN loc_regions reg ON ent.ent_region_id = reg.region_id
WHERE (num.datanumber_datatype_id = $datatype 
	AND num.datanumber_period_id = $period)
GROUP BY reg.region_abbr

";
$result = dbQuery($sql);
if(dbNumRows($result) > 0)
{
	echo "<br/>datatype : $datatype";
	while($row = mysql_fetch_object($result)) 
	{
		echo "<br/>$row->region_abbr : $row->datanumber_value";
	}
}

?>