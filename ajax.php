<?php 
include 'init.php';
$mu = new Munin;
$arr1 = explode("\n", $mu->GetPluginStat($_GET['ip'],$_GET['plugin'])); 
foreach($arr1 as $value=>$k)
	$arr2[] =explode(" ",$k);
echo json_encode($arr2);

?>

