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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title>Munin live updater</title>
</head>
<body>
  <div class="container">
      <div class="header">
        <h3 class="text-muted">Munin live updater</h3>
      </div>

      <div class="jumbotron">
	<form method="get">
	<select name="ip" onchange="this.form.submit();">
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
		echo '<select name="plugin" onchange="this.form.submit();">';
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
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
        <p>.....................................................................................................</p>
      </div>
    </div> <!-- /container -->
</body>
