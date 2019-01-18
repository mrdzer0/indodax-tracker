<?php  
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
ini_set('display_errors', 0);
function curl ($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: en-US,en;q=0.9';
	$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 OPR/57.0.3098.106';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	return $result;
}
echo "============================================\n";
echo "         Crypto Ticker By \033[92mMr.Dzer0\033[0m\n";
echo "============================================\n";
echo "Input Coin_pair: ";
$referrer = trim(fgets(STDIN));
list($coin,$pair)=explode('_',$referrer);	
if ($referrer == "") {
	die ("Referrer cannot be blank!\n");
} else {	// ["high"]=> // ["low"]=>  // ["vol_btc"]=>  // ["vol_idr"]=>  // ["last"]=>  // ["buy"]=>  // ["sell"]=> // ["server_time"]=>
		$regis = curl("https://indodax.com/api/$referrer/ticker");
		// echo $regis;
		$result= json_decode($regis,true);
		// var_dump($result, true);
		foreach($result as $key=>$value){
		$seconds = $value["server_time"];
		$persen  = (($value['high']-$value['low'])/$value['low'])*100;
		$persenn = substr($persen,0,4);
echo "============================================\n";
echo "             Coin \033[92m$coin\033[0m Pair \033[92m$pair\033[0m\n";		
	    echo "Tertinggi   : \033[93m".$value['high']."\n\033[0m";
		echo "Persentase  : \033[92m".$persenn." %\n\033[0m";
		echo "Terendah    : \033[91m".$value['low']."\n\033[0m";
		echo "Volume /$coin : \033[0m".$value["vol_$coin"]."\n\033[0m";
		echo "Volume /$pair : \033[0m".$value["vol_$pair"]."\n\033[0m";
		echo "Price Now   : \033[92m".$value['last']."\n\033[0m";
		echo "Last Buy    : \033[96m".$value['buy']."\n\033[0m";
		echo "Last Sell   : \033[97m".$value['sell']."\n\033[0m";
		echo "Waktu       : \033[92m".date("d/m/Y H:i:s", $seconds)."\n\033[0m";
echo "============================================\n";		
		}
}

?>
