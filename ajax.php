<pre>
<?php 
include 'init.php';
function formatBs($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');   
    return round(pow(1024, $base - floor($base)), $precision);
//    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}


$mu = new Munin;
$arr1 = explode("\n", $mu->GetPluginStat($_GET['ip'],$_GET['plugin'])); 
foreach($arr1 as $value=>$k){
	if($k!=''){
		$k = str_replace('.value','',$k);
		$k=preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $k);
		$arr2[] =explode(" ",$k);
		$arr2[0][1]=formatBs($arr2[0][1]);
		$arr3[]=$arr2;
		unset($arr2);
	}else{
		unset($arr1[$k]);
	}
}
echo json_encode($arr3);

?>

