<?php 
include 'init.php';
function formatBs($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');   
    return round(pow(1024, $base - floor($base)), $precision);
}

$i=0;
$arr1 = explode("\n", Munin::GetPluginStat($_GET['ip'],$_GET['plugin'])); 
foreach($arr1 as $value=>$k){
	if($k!=''){
		$k = str_replace('.value','',$k);
		$k=preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $k);
		$arr2[] =explode(" ",$k);
		$arr2[0][1]=formatBs($arr2[0][1]);
		$arr3[$i][0]=$arr2[0][0];
		$arr3[$i][1]=$arr2[0][1];
		unset($arr2);
	}else{
		unset($arr1[$k]);
	}
$i++;
}
echo json_encode($arr3);
?>

