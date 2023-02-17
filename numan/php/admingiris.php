<?php

	include "baglan.php";
	ob_start();
	session_start();
	 
	$kadi = $_POST['kadi'];
	$sifre = $_POST['sifre'];
	 
	$query = $db->query("select * from adminbilgi where kadi='".$kadi."'and sifre='".$sifre."' ", PDO::FETCH_ASSOC);

			if ( $query->rowCount() )
			{
    			 foreach( $query as $row )
		    	 {
					$_SESSION["login"] = "true";
				    $_SESSION["user"] = $kadi;
				    $_SESSION["pass"] = $sifre;
				    header("Location:yonetici.php");
        		 }
   			 }
	else {
	    if($kadi=="" or $sifre=="") {
	        echo "<center>Lutfen kullanici adi ya da sifreyi bos birakmayiniz..! <a href=javascript:history.back(-1)>Geri Don</a></center>";
	    }
	    else {
	        echo "<center>Kullanici Adi/Sifre Yanlis.<br><a href=javascript:history.back(-1)>Geri Don</a></center>";
	    }
	}
	 
	ob_end_flush();

?>

