<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd"><?php
require('config.php');
function displayDropdownList($current = 4) {

	$sql = "SELECT typ.datatype_id, typ.datatype_name
	FROM data_types typ
	WHERE typ.datatype_name IS NOT NULL
	";
	$result = dbQuery($sql);
	if(dbNumRows($result) > 0)
	{
		echo '<select id="datatype_dropdown" name="datatype">';
		while($row = mysql_fetch_object($result))
		{
			echo '<option value="'.$row->datatype_id.'" ';
			if  ($current==$row->datatype_id)
				echo 'selected="selected"';
			echo '>';
			echo $row->datatype_name;
			echo '</option>';
		}
		echo '</select>';
	}  
}

function getDatatypeName($datatype_id) {

	$datatypeName = '';
	$sql = "SELECT typ.datatype_id, typ.datatype_name
	FROM data_types typ
	WHERE typ.datatype_id = $datatype_id
	";
	$result = dbQuery($sql);
	if(dbNumRows($result) > 0)
	{
		while($row = mysql_fetch_object($result))
		{
			$datatypeName = $row->datatype_name;
		}
	}
	
	return $datatypeName;  
}

$datatype = 4;
if (isset($_REQUEST['datatype'])) {
	$datatype = $_REQUEST['datatype'];
}
$period = 2;
if (isset($_REQUEST['period'])) {
	$period = $_REQUEST['period'];
}

$currentDatatypeName = getDatatypeName($datatype);
$currentYear = ($period == 1)?'2009':'2010';

?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>data visualisation ~ Bubble Chart</title>
    <script type="text/javascript" src="js/d3.v2.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <style type="text/css">
		@import url("css/style.css");
		@import url("css/syntax.css");
		@import url("css/bubble.css");
    </style>
  </head>
  <body>
    <div class="body">
      <div class="content">
        <div class="sidebar2">
          <!-- <h1>d3.js</h1> -->
			<?php displayDropdownList($datatype); ?>
			<br/>
			<select id="period_dropdown" name="period">
				<option value="1"<?php echo ($period==1)?' selected="selected" ':''; ?>>2009</option>
				<option value="2"<?php echo ($period==2)?' selected="selected" ':''; ?>>2010</option>
			</select>
        </div>

<h1 id='bubble_chart'>Chiffres-clés des hôpitaux suisses</h1>
<h2><?php echo $currentDatatypeName; ?></h2>
<p>Année: <?php echo $currentYear; ?></p>
<p>source: <a href="http://www.bag.admin.ch/hospital/index.html?webgrab_path=aHR0cDovL3d3dy5iYWctYW53LmFkbWluLmNoL2t1di9zcGl0YWxzdGF0aXN0aWsvcG9ydGFsX2ZyLnBocD9sYW5nPWZyJmFtcDtuYXZpZD1renNz&lang=fr">Statistiques hospitalières de l'OFSP</a></p>
<div class='gallery' id='chart'> </div>
<script type="text/javascript" charset="utf-8">
	var datatype = <?php echo $datatype; ?>;
	var period = <?php echo $period; ?>;
</script>
<script src='bubble.js' type='text/javascript'></script>
<p>Bubble charts encode data in the area of circles. Although less perceptually-accurate than bar charts, they can pack hundreds of values into a small space. Implementation based on work by <a href='http://jheer.org/'>Jeff Heer</a>.</p>
      </div>
    </div>
  </div>
<script type="text/javascript" charset="utf-8">
	$.noConflict();
	
	var filterHandle = function(){
		if(jQuery("#datatype_dropdown"))
		{
			datatype = jQuery("#datatype_dropdown").val();
		}
		if(jQuery("#period_dropdown"))
		{
			period = jQuery("#period_dropdown").val();
		}
		window.location.href = '?datatype=' + datatype + '&period=' + period;
	};
	
	jQuery(document).ready(function($) {
		
		// hook up dropdown change
		$('#datatype_dropdown').change(filterHandle);
		$('#period_dropdown').change(filterHandle);
		
	});
</script>
  </body>
</html>