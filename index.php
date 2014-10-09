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

	<link href="./flot/examples/examples.css" rel="stylesheet" type="text/css">
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="flot/excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
	<script language="javascript" type="text/javascript" src="flot/updater.js"></script>


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
  var url ="ajax.php?ip=" + ip + "&plugin=" + plugin;
  var stat = [];
  var points = 60*15;
function fetchData(){
 $.get( url, function( data ) {
  data = "<br>" + data[0][1];
  if(stat.length>=points){
	stat.shift();
  }
  stat.push(data);
  $( "div.demo-container" )
    .html( "<br>" +stat);
    setTimeout(fetchData, 1000);
 }, "json" );
};
fetchData(url);
</script>
</body>
