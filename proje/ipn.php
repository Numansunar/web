<?php
$POST = $_POST;
$GET = $_GET;

include('include/all.php');

switch ($_GET['bank']) {
	case 'iyzico':
		$data = $_SESSION['randStr']."\n".$_SERVER['REMOTE_ADDR']."\n".date('m-d-Y H:i:s')."\nGET : \n". print_r($_GET,1)."\n JSON : ".debugArray(json_decode(file_get_contents('php://input'), true))." POST : \n". print_r($_POST,1)."\n\n";
		file_put_contents("iyzico-".date("y-m-d").".txt",$data,FILE_APPEND);
		$r = json_decode(file_get_contents('php://input'), true);

		$mID = hq("select ID from banka where modData1 = '".addslashes($r['merchantId'])."'");
		if(!$mid)
			exit('Hatalı Merchant ID');
		if($r['status'] != 'SUCCESS')
			exit('Başarısız İşlem');

		$durum = (int) hq("select durum from siparis where randStr like '" . addslashes($r['paymentConversationId']) . "'");
		if (!$durum || $durum == 1) {
			$_SESSION['randStr'] = $r['paymentConversationId'];
			$_GET['success'] = 1;
			$_GET['act'] = 'satinal';
			$_GET['op'] = 'odeme';
			$tamamlandi = true;
			$sepetTemizle = true;
			$odemeDurum = 2;
			$modulDosya = hq("select paymentModulURL from banka where paymentModulURL like '%iyzico%' AND active = 1 order by ID desc");
			$odemeTipi = hq("select bankaAdi from banka where paymentModulURL like '%iyzico%' AND active = 1 order by ID desc");
			spPayment::finalizePayment();
		}
		mysql_query("update siparis set notYonetici = concat(notYonetici,'Notify : ".debugArray(json_decode(file_get_contents('php://input'), true))."' where randStr = '". addslashes($r['paymentConversationId']) ."'");
		exit('200');
	break;
	case 'gpay':
			if((sizeof($_GET) || sizeof($_POST)) && basename($_SERVER['SCRIPT_FILENAME']) != 'resize.php') file_put_contents("files/ipn-log-".date("y-m-d").".txt",$data,FILE_APPEND);

			$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%payment_gpay%'");
			$bayiiKey = hq("select password from banka where ID='" . $_GET['paytype'] . "'");		
			$callback_ip = ["185.197.196.99","185.197.196.51"];

			$has_ip = false;

			/**
			 * Gelen verileri değişkene atıyoruz. Lütfen test ederken ve hatta üretimde dahi bu gelen verilerin logunu tutunuz.
			 */

			$callback_data = $_POST;
			$siparis_id = $callback_data['siparis_id'];
			$tutar = $callback_data['tutar'];
			$islem_sonucu = $callback_data['islem_sonucu'];
			$tutarSite = hq("select toplamTutarTL from siparis where data1 = '$siparis_id' OR randStr = '$siparis_id'");

			if($islem_sonucu == 2)
				my_mysql_query("update siparis set data2='OK' where data1 = '$siparis_id'");
			else
				my_mysql_query("update siparis set data2='".addslashes(($callback_data['islem_mesaji']))."' where data1 = '$siparis_id'");

			$hash = md5(base64_encode(substr($bayiiKey, 0, 7) . substr($siparis_id, 0, 5) . strval($tutar) . $islem_sonucu));

			if (getenv("HTTP_CLIENT_IP")) {
				$ip = getenv("HTTP_CLIENT_IP");
			} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if (strstr($ip, ',')) {
					$tmp = explode(',', $ip);
					$ip = trim($tmp[0]);
				}
			} else {
				$ip = getenv("REMOTE_ADDR");
			}

			foreach ($callback_ip as $c_ip) {
				if ($ip === $c_ip) {
					$has_ip = true;
					break;
				}
			}

			if( $hash != $callback_data['hash']){
				exit('4 - '.$hash.':'.$callback_data['hash']);
			}

			// burada siparis id ye göre diğer verileri çekeceğiz. örn $res = mysql_fetch_object(mysql_query("select * from table where siparis_id='$siparis_id'"))
			// burada örnek bir row yapıyorum burasını yukarıdaki gibi değiştirebilirsiniz
			$res = (object) array('tutar' => "3.50");
			if(!$res->tutar){
				die('2'); 
				
			}
			if((int)$tutarSite > (int)$tutar){
				die('5');   
			}
			// burada kendinize özel bir kontrol yapıp eğer hatalı sonuç döndürürse ekrana 3 yazabilirsiniz. örn: die('3') gibi...
			// ...
		//	my_mysql_query("update siparis set durum = 2 where data1 = '$siparis_id' OR randStr = '$siparis_id'");
			// eğer tüm kontroller tamamsa
			echo "1";
			exit();
	break;
	case "paytr":
		$merchant_oid = addslashes(substr($_POST['merchant_oid'], -9));
		$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%paytr%' AND active = 1");
		$merchant_salt = hq("select password from banka where ID='" . $_GET['paytype'] . "'");
		$payment_status = $_POST['status'];
		$total_amount = $_POST['total_amount'];
		$merchant_key = hq("select username from banka where ID='" . $_GET['paytype'] . "'");


		if ($_SERVER['REMOTE_ADDR'] != '31.6.84.90' && $_SERVER['REMOTE_ADDR'] != '185.198.199.171' && $_SERVER['REMOTE_ADDR'] != '89.106.21.178' && $_SERVER['REMOTE_ADDR'] != '195.244.55.195' && $_SERVER['REMOTE_ADDR'] != '') {
			my_mysql_query("update siparis set notYonetici = 'Dikkat : PayTR Hatalı IP " . addslashes($_SERVER['REMOTE_ADDR']) . " den talep geldi. " . addslashes(print_r($_POST, 1)) . "' where randStr = '" . addslashes(substr($_POST['merchant_oid'], -9)) . "'");
			//exit('OK');
		}

		$hash = base64_encode(hash_hmac('sha256', $_POST['merchant_oid'] . $merchant_salt . $payment_status . $total_amount, $merchant_key, true));

		if ($_POST['hash'] == $hash && (int) $total_amount > 1 && $_POST['status'] == 'success') {
			// Hash Hesaplaması
			//my_mysql_query("update siparis set durum = 2 where randStr = '" . addslashes(substr($_POST['merchant_oid'], -9)) . "'");
			$durum = (int) hq("select durum from siparis where randStr like '" . $merchant_oid . "'");
			if (!$durum || $durum == 1) {
				$_SESSION['randStr'] = $merchant_oid;
				$_GET['success'] = 1;
				$_GET['act'] = 'satinal';
				$_GET['op'] = 'odeme';
				$tamamlandi = true;
				$sepetTemizle = true;
				$odemeDurum = 2;
				$modulDosya = hq("select paymentModulURL from banka where paymentModulURL like '%paytr%' AND active = 1 order by ID desc");
				$odemeTipi = hq("select bankaAdi from banka where paymentModulURL like '%paytr%' AND active = 1 order by ID desc");
				spPayment::finalizePayment();
			}
			//
			mysql_query("update siparis set notYonetici = concat(notYonetici,' PayTR Ödeme Yapılan Tutar : " . (float) ((float) $_POST['total_amount'] / 100) . " " . print_r($_POST, 1) . "'),odemeTipi= '$odemeTipi' where randStr = '" . addslashes(substr($_POST['merchant_oid'], -9)) . "'");
			exit('OK');
		} else if ($_POST['status'] != 'failed' && $_POST['status']) {
			mysql_query("update siparis set durum=1, notYonetici = 'Dikkat : PayTR Hash uyuşmazlığı var. " . addslashes(print_r($_POST, 1)) . " : " . $hash . "' where randStr = '" . addslashes(substr($_POST['merchant_oid'], -9)) . "'");
			exit('OK');
			$_SESSION['randStr'] = $merchant_oid;
			$_GET['success'] = 1;
			$_GET['act'] = 'satinal';
			$_GET['op'] = 'odeme';
			$tamamlandi = true;
			$sepetTemizle = true;
			$odemeDurum = 1;
			$modulDosya = hq("select paymentModulURL from banka where active = 1 AND paymentModulURL like '%paytr%'");
			include('lib.php');
			include('lib-email.php');
			include('lib-sepet.php');
			include('lib-payment.php');
			include('user_library.php');
			include($modulDosya);
			if (!hq("select durum from siparis where randStr like '" . $merchant_oid . "'"))
				payment();
			else
				my_mysql_query("update siparis set durum=1 where randStr = '" . $merchant_oid . "'");

			my_mysql_query("update siparis set notYonetici = '" . addslashes(print_r($_POST, 1)) . " Hash : " . addslashes($_POST['hash']) . ":" . $hash . " : " . "$merchant_oid.$merchant_salt.$payment_status.$total_amount,$merchant_key," . "' where randStr = '" . $merchant_oid . "'");
			//my_mysql_query("update siparis set durum = 1 where randStr = '".$merchant_oid."' AND durum =0");
			exit('Error');
		} else {
			my_mysql_query("update siparis set notYonetici = 'Dikkat : Status failed veya hash (" . $hash . " : " . $_POST['hash'] . ") uyuşmadı. " . addslashes(print_r($_POST, 1)) . "' where randStr = '" . addslashes(substr($_POST['merchant_oid'], -9)) . "'");
			exit('OK');
		}
		break;

	case 'payu':
		ini_set("mbstring.func_overload", 0);
		if (ini_get("mbstring.func_overload") > 2) {   /* check if mbstring.func_overload is still set to overload strings(2)*/
			echo "WARNING: mbstring.func_overload is set to overload strings and might cause problems\n";
		}

		/* Internet Payment Notification */

		$pass       = hq("select password from banka where password != '' AND active = 1 AND paymentModulURL like '%payu%'");   /* pass to compute HASH */
		$result     = "";               /* string for compute HASH for received data */
		$return     = "";               /* string to compute HASH for return result */
		$signature  = $_POST["HASH"];   /* HASH received */
		$body       = "";

		/* read info received */
		ob_start();
		foreach ($POST as $key => $val) {
			$$key = $val;

			/* get values */
			if ($key != "HASH") {

				if (is_array($val)) $result .= ArrayExpand($val);
				else {
					$size       = strlen(StripSlashes($val));
					$result .= $size . StripSlashes($val);
				}
			}
		}
		$body = ob_get_contents();
		ob_end_flush();

		$date_return = date("YmdGis");

		$return = strlen($_POST["IPN_PID"][0]) . $_POST["IPN_PID"][0] . strlen($_POST["IPN_PNAME"][0]) . $_POST["IPN_PNAME"][0];
		$return .= strlen($_POST["IPN_DATE"]) . $_POST["IPN_DATE"] . strlen($date_return) . $date_return;



		$hash =  hmac($pass, $result); /* HASH for data received */

		$body .= $result . "\r\n\r\nHash: " . $hash . "\r\n\r\nSignature: " . $signature . "\r\n\r\nReturnSTR: " . $return;

		if ($hash == $signature) {
			$_SESSION['randStr'] = $_POST['REFNOEXT'];
			$_GET['success'] = 1;
			$_GET['act'] = 'satinal';
			$_GET['op'] = 'odeme';
			$tamamlandi = true;
			$sepetTemizle = true;
			$odemeDurum = 2;
			$modulDosya = hq("select paymentModulURL from banka where paymentModulURL like '%payu%' AND active = 1 order by ID desc");
			$odemeTipi = hq("select bankaAdi from banka where paymentModulURL like '%payu%' AND active = 1 order by ID desc");
			spPayment::finalizePayment();
			echo "Verified OK!";
			$result_hash =  hmac($pass, $return);
			echo "<EPAYMENT>" . $date_return . "|" . $result_hash . "</EPAYMENT>";
			exit();
		} else
			exit('Error| Hash != Signature Pass ' . $pass . '.' . $hash . ' : ' . $signature . "\n" . debugArray($POST) . $body);

		break;
}

function ArrayExpand($array)
{
	$retval = "";
	for ($i = 0; $i < sizeof($array); $i++) {
		$size       = strlen(StripSlashes($array[$i]));
		$retval .= $size . StripSlashes($array[$i]);
	}

	return $retval;
}

function hmac($key, $data)
{
	$b = 64; // byte length for md5
	if (strlen($key) > $b) {
		$key = pack("H*", md5($key));
	}
	$key  = str_pad($key, $b, chr(0x00));
	$ipad = str_pad('', $b, chr(0x36));
	$opad = str_pad('', $b, chr(0x5c));
	$k_ipad = $key ^ $ipad;
	$k_opad = $key ^ $opad;
	return md5($k_opad  . pack("H*", md5($k_ipad . $data)));
}
