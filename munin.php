<?php
class Munin
{
	public function GetHosts() {
		$arr[] =  self::GetConfig();
		foreach ($arr as $v) {
			foreach ($v as $k => $h){
				if(filter_var($h['address'], FILTER_VALIDATE_IP)){
					$hosts['name'][] = $k;
					$hosts['ip'][] = $h['address'];
				}
			}
		}
		return $hosts;
	}
	public function GetConfig() {
		global $munin_conf;
		$f = file_get_contents($munin_conf);
		$f = str_replace(' ','=',$f); /* fix config problems */
		$ini_array = parse_ini_string($f, true, INI_SCANNER_RAW);
		return $ini_array;
	}
	public function GetPlugins($ip) {
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$result = socket_connect($socket, $ip, '4949');
		$out = socket_read($socket, 2048); //munin version
		$in = "list\n";
		socket_write($socket, $in, strlen($in));
		$out = socket_read($socket, 2048);
		socket_close($socket);
		return $out;
	}
}
?>
