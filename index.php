<?php
include 'init.php';
$mu = new Munin;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="jquery.js"></script>
<script language="javascript" type="text/javascript" src="jquery.jqplot.min.js"></script>

<title>Munin live updater</title>
</head>
<body>
  <div class="container">
      <div class="header">
        <h3 class="text-muted">Munin live updater</h3>
      </div>

      <div class="jumbotron">
	<form method="get">
	<select id="ip" name="ip" onchange="this.form.submit();">
	<?php
	$a = $mu->GetHosts();
	//var_dump($a);
	foreach ($a['name'] as $name => $host){
	  echo "\n\t".'<option '.($a['ip'][$name]==$_GET['ip'] ? 'selected':''). ' value="'.$a['ip'][$name].'">'.$host.'</option>';
	}
	?>
	</select>
	<?php
	if($_GET['ip'])
	{
		echo '<select id="plugin" name="plugin" onchange="this.form.submit();">';
		$p=explode(" ", $mu->GetPlugins($_GET['ip']));
		//var_dump($p);
		foreach ($p as $id => $plugin){
			echo "\n\t".'<option '.($plugin==$_GET['plugin'] ? 'selected':''). ' value="'.$plugin.'">'.$plugin.'</option>';
		}
		echo '</select>';
	}
	?>
	<?php
	if($_GET['ip'])
	{
		echo '<select id="rt" name="rt" onchange="this.form.submit();">';
		echo "\n\t".'<option '.(60==$_GET['rt'] ? 'selected':''). ' value="60">060 points</option>';
		echo "\n\t".'<option '.(120==$_GET['rt'] ? 'selected':''). ' value="120">120 points</option>';
		echo "\n\t".'<option '.(180==$_GET['rt'] ? 'selected':''). ' value="180">180 points</option>';
		echo "\n\t".'<option '.(300==$_GET['rt'] ? 'selected':''). ' value="300">300 points</option>';
		echo '</select>';
	}
	?>

        </form>

        	<h1>Graph:</h1>
	        <div class="demo-container">
        	                <div id="placeholder" class="demo-placeholder"></div>
	        </div>
	</div>
     </div> <!-- /container -->
<script type="text/javascript">
  var ip = $( "#ip" ).val();
  var plugin = $( "#plugin" ).val();
  var rt = $( "#rt" ).val();
  var url ="ajax.php?ip=" + ip + "&plugin=" + plugin;
  var gra = "Ploting  " + ip + " (" + plugin + ")";
  var stat = {};
  var points = rt;
  var plot = false;
  var fetchIndex = 1;

fetchData = function(){
 $.get( url, function( data ) {
	var i, plotData = [];
        fetchIndex++;
	for(i = 0; i < data.length; i++){
		if(!stat[data[i][0]]){
			stat[data[i][0]] = [];
		}
		//stat[data[i][0]].push(i,parseFloat(data[i][1]));
		stat[data[i][0]].push([fetchIndex,parseFloat(data[i][1])]);
		if(stat[data[i][0]].length>=points){
			stat[data[i][0]].shift();
		}
	}
	for(i in stat){
		if(!stat.hasOwnProperty(i)){
			continue;
		}
		plotData.push(stat[i]);
	}
   if(plot){
     plot.destroy();
   }
    plot = $.jqplot("placeholder", plotData, {
      title: gra,
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer
      },
      axes: {
        xaxis: {
          pad: 0,
          showTicks: false,
	  showTickMarks:false,
        },
        yaxis: {
          label: ""
        }
      }
    });
    setTimeout(fetchData, 1000);
 }, "json" );
};
fetchData(url);
</script>
</body>
