<?php
require('config.php');

$datatype = 0;
if (isset($_REQUEST['datatype'])) {
	$datatype = $_REQUEST['datatype'];
}
$period = 0;
if (isset($_REQUEST['period'])) {
	$period = $_REQUEST['period'];
}
	
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
	echo '{
		"name": "data_health",
		 "children": [
		    {
		     "name": "graph",
		     "children": [';
	$separator = "\n";
	while($row = mysql_fetch_object($result)) 
	{
		echo $separator.'{"name": "'.$row->region_abbr.'", "size": '.$row->datanumber_value.'}';
		$separator = ",\n";
	}
	echo '
				]
			}
		]
	}';
}

?>