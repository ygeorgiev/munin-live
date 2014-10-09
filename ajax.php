<?php 
include 'init.php';
$mu = new Munin;
$arr1 = explode("\n", $mu->GetPluginStat($_GET['ip'],$_GET['plugin'])); 
foreach($arr1 as $value=>$k){
	if($k!=''){
		$k = str_replace('.value','',$k);
		$arr2[] =explode(" ",$k);
	}else{
		unset($arr1[$k]);
	}
}
//print_r(array_filter($arr2));// = array_filter($arr2);
echo json_encode($arr2);

?>

