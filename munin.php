<?php
class Munin
{
	public static function GetHosts() {
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
	public static function GetConfig() {
		global $munin_conf;
		$f = file_get_contents($munin_conf);
		$f = str_replace(' ','=',$f); /* fix config problems */
		$ini_array = parse_ini_string($f, true, INI_SCANNER_RAW);
		return $ini_array;
	}
	public static function GetPlugins($ip) {
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$result = socket_connect($socket, $ip, '4949');
		$out = socket_read($socket, 2048); //munin version
		$in = "list\n";
		socket_write($socket, $in, strlen($in));
		$out = socket_read($socket, 2048);
		socket_close($socket);
		return $out;
	}
        public static function GetPluginStat($ip,$plugin) {
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $result = socket_connect($socket, $ip, '4949');
                $out = socket_read($socket, 2048); //munin version
                $in = "fetch ".$plugin."\n";
                socket_write($socket, $in, strlen($in));
                //$out2 = socket_read($socket, 4096);
		while('.' != trim($out=@socket_read($socket,1024,PHP_NORMAL_READ))){
 			$out2 .= $out;
		}
                socket_close($socket);
                return $out2;
        }

}
?>
