<?php
include('include/all.php');
//if($_SESSION['admin_isAdmin'] && $_GET['err'])
{
	ini_set('display_errors', '1');
	error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
}
unset($_SESSION['urun-arama']);
//$_SESSION['vCheck'] = 0;
if(!$_SESSION['verCheck'])
{
	$v = file_get_contents('../doc/v.txt');
	
	if(!$v)
	{
		echo "
			<script language='javascript'>
				alert('Versiyon text dosyası okunamadı. Lütfen /doc/v.txt dosyasının sunucunuzda olduğunu kontrol edin. Dosyayı kopyaladıktan sonra, \"Yönetim Menü\" > \"Teknik İşlemler\" altındaki \"Sürüm güncelleme kontrolü\" seçmini çalıştırın .');
			</script>
		";
		$_SESSION['verCheck'] = 1;		
	}
	else if($v != (string)siteConfig('version') && $_GET['act'] != 'update')
	{	
		echo "
			<script language='javascript'>
				if(confirm('Veritabanı sürüm güncellemesi tespit edildi. [ ".(string)siteConfig('version')." - ".$v." ]. Tamam tuşuna tıklayıp gerekli sorguları otomatik çalıştırmanız gerekmektedir. '))
					window.location.href = 's.php?f=teknik.php&act=update';
			</script>
		";
	}
	else if($_GET['act'] != 'temp-2-utf8' && siteConfig('templateName') && (!isUTF8(file_get_contents('../templates/'.siteConfig('templateName').'/temp.php')) || !isUTF8(file_get_contents('../templates/'.siteConfig('templateName').'/systemDefult/urunGoster.php'))))
	{	
		echo "
			<script>
				if(confirm('Şablon encode farklılığı tespit edildi. Tamam tuşuna tıklayıp, site şablonunuzu otomatik olarak utf-8 \'e güncellemeniz gerekmektedir. '))
					window.location.href = 's.php?f=teknik.php&act=temp-2-utf8';
			</script>
		";
	}
	else
	{
		$_SESSION['verCheck'] = 1;	
	}
	
}
if(!$_SESSION['tCheck_'.$siteConfig['templateName']])
{
	if(file_exists('../templates/'.$siteConfig['templateName'].'/ayarlar.php') && !hq("select ID from adminmenu where Dosya like 'sablonAyarlari.php'"))
	{
		my_mysql_query("INSERT INTO `adminmenu` (`ID`, `parentID`, `Adi`, `Icon`, `Dosya`, `Aktif`, `Sira`, `SiteTipi`) VALUES ('0', '1', 'Şablon Ayarları', '', 'sablonAyarlari.php', '1', '45', '');");
	}
	my_mysql_query("update adminmenu set Aktif = '".(bool)file_exists('../templates/'.$siteConfig['templateName'].'/ayarlar.php')."' where dosya like 'sablonAyarlari.php'");
	$_SESSION['tCheck_'.$siteConfig['templateName']] = true;
}

if(!$_SESSION['nCheck'])
{
	$v4Chart = new v4Chart();	
	$_SESSION['nCheck'] = true;
	if($_GET['f'] != 'shopphpnews.php' && (int)$v4Chart->shopphpHaberOkunmayan)	
	{	
		echo "
			<script>
				if(confirm('Okunmamış (".(int)$v4Chart->shopphpHaberOkunmayan.") haber girişi var. Gözatmak için Tamam tuşuna tıklayın. '))
					window.location.href = 's.php?f=shopphpnews.php';
			</script>
		";
	}
}

$v3Admin = new v3Admin();
if (!$_GET['xmlUpdate'])
		   include('../templates/system/admin/temp_header.php');
		   
$siteConfigQry = my_mysql_query('select * from siteConfig limit 0,1');
$siteConfig = my_mysql_fetch_array($siteConfigQry);

?>
     <div id="page">
                <!-- START CONTENT -->
                     
					<? 
					if($_GET['srr'])
					{
						error_reporting(E_ALL);
						ini_set('display_errors',1);
					}
                    if (!$_GET['f']) $_GET['f'] = 'dashboard.php';
					if($_GET['f'] == 'profile.php' && $_SESSION['admin_UserID'] && $_SESSION['admin_UserID'] && $_SESSION['admin_isMod']) 
						$pageLoginDisabled = false;
					if(substr($_GET['f'],0,4) == 'XML/' && hq("select isAdmin from user where username = '".$_GET['username']."' AND (password = '".md5($_GET['password'])."') "))
						$pageLoginDisabled = false;
                    if ($pageLoginDisabled) 
                        echo(v4Admin::messageBlock('Hata','Yetkisiz kullanıcı.','<strong>HATA : </strong> Bu içeriği görüntüleme yetkiniz bulunmamaktadır.'));
                    else 
                    {
                       $file = $_SERVER['DOCUMENT_ROOT'].$siteDizini.'/'.$yonetimDizini.str_replace('&#47;','/',$_GET['f']);
					   $file = str_replace('//','/',$file);
                       $fileUpdated = str_replace('.','-edit.',$file);
					   if (file_exists($fileUpdated)) 
					   	include($fileUpdated);
					   else
					   	if (file_exists($file)) include($file);
                       else 
						echo(v4Admin::messageBlock('Hata','Mod Bulunamadı.','<strong>HATA : </strong> Paketinizde bu özellik bulunmamaktadır. ('.$file.')'));
                    }
                    ?>       	                      
                <!-- END CONTENT -->
          </div>
        <!-- END PAGE -->
<?php if (!$_GET['xmlUpdate']) include('../templates/system/admin/temp_footer.php'); 
my_mysql_close($baglanti);?>