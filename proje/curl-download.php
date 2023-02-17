<?
//exit(file_get_contents('http://www.maxpera.com.tr/Uploads/UrunResimleri/buyuk/ef2139b9-d2e6-4909-8185-267b6f544b73.jpg'));
@set_time_limit(0);
ignore_user_abort(true);
include('include/all.php');
require_once('secure/include/xmlImport.php');
$q = my_mysql_query("select ID,name,resim,resim2,resim3,resim4,resim5,download1,download2,download3,download4,download5 from urun where download1 != '' OR download2 != '' OR download3 != '' OR download4 != '' OR download5 != ''");
echo "<strong>Toplam Row : ".my_mysql_num_rows($q).'</strong><br />';
$extArray = array('jpg','png');
//$downloadType = 'curl';
while($d = my_mysql_fetch_array($q))
{
	$d['resim1'] = $d['resim'];
	for($i=1;$i<=5;$i++)
	{
		if(!$d['download'.$i])
		{
			//echo ($d['ID'].' - '.$d['name'].' download'.$i.' URL boş.<br/>');	
			continue;
		}
		if($d['resim'.$i] && is_image('images/urunler/'.$d['resim'.$i]))
		{
			my_mysql_query("update urun set download$i = '' where ID='".$d['ID']."' limit 1");
			if($_SESSION['admin_isAdmin'])
				echo ($d['ID'].' - '.$d['name'].' resmi vardı, download'.$i.' URL boşaltıldı.<br/>'."\n");
		}
		else
		{
			$str = ($i==1?'':$i);
			list($name,$ext) = explode('.',basename($d['download'.$i]));
			if(!in_array(strtolower($ext),$extArray))
				$ext = 'jpg';
			$resimLocation = seoFix(substr(utf8fix($d['name']),0,10).'-'.$d['ID']).'_'.$i.'.'.$ext;
			// XMLdownloadFile($d['download'.$i], 'images/urunler/', $resimLocation);
			
			// file_put_contents('images/urunler/'.$resimLocation, fopen($d['download'.$i], 'r'));
			grab_image($d['download'.$i],'images/urunler/'.$resimLocation);
			my_mysql_query("update urun set resim$str = '$resimLocation' where ID='".$d['ID']."' limit 1");
			if($_SESSION['admin_isAdmin'])
			{
				echo ($d['ID'].' - '.$d['name'].' resim-'.$i.' için ,'.$d['download'.$i].' URL download edildi.<br />'."\n");
				echo ("update urun set resim$str = '$resimLocation' where ID='".$d['ID']."' limit 1<br /> \n");
			}
			
			//exit("File Size $resimLocation : ".filesize('images/urunler/'.$resimLocation)."\n");
		}
	}
}
exit('Bitti.');

function is_image($path)
{
    return (filesize($path) > 1000);
}

function grab_image($url,$saveto){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}
?>