<?php
include("Ayarlar/ayar.php");
require_once("Ayarlar/fonksiyonlar.php");
require_once("Ayarlar/SiteSayfalari.php");
if(isset($_REQUEST["SayfaKodu"]))
{
	$SayfaKoduDegeri = SayiliIcerikleriFiltrele($_REQUEST["SK"]);
}else{
	$SayfaKoduDegeri = 0;
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="tr">
<meta charset="utf-8">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<meta name="revisit-after" content="3 Days">
<title><?php echo DönüsümleriGeriDöndür($SiteTitle); ?></title>
<link type ="image/png" rel="icon" href="Resimler/icon.jpg">
<meta name="description" content="<?php echo DönüsümleriGeriDöndür($SiteDescription); ?>">
<meta name="keywords" content="<?php echo DönüsümleriGeriDöndür($SiteKeywords); ?>">
<script type="text/javascript" src="Frameworks/JQuery/jquery-3.5.1.min.js" language="javascript"></script>
<link type="text/css" rel="stylesheet" href="Ayarlar/stil.css">
<script type="text/javascript" src="Ayarlar/fonksiyolar.js" language="javascript"></script>
</head>

<body>
	<table width="1065" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="435px" bgcolor="#353745">
			<td><img src="Resimler/banner.jpg" border="0"></td>
		</tr>
		<tr height="110px">
		<td>
			<table width="1065" height="30"  align="center" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="#0088CC">
					<td>&nbsp;</td>
					<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin: 5px;"></a></td>
					<td width="70" class="MaviAlanMenusu"><a href="xxxxx" >Giriş yap</a></td>
					<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin: 5px;"></a></td>
					<td width="85" class="MaviAlanMenusu"><a href="xxxxx" >Yeni Üye ol</a></td>
					<td width="20"><a href="xxxxx"><img src="Resimler/icon.jpg" border="0" style="margin: 5px;"></a></td>
					<td width="103"class="MaviAlanMenusu"><a href="xxxxx" >Alışveriş sepeti</a></td>
				</tr>
			</table>			
			<table width="1065" height="80"  align="center" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="#0088CC">
					<td width="192"><a href="index.php"><img src="Resimler/<?php echo DonusumleriGeriDondur($SiteLogosu);?>" border="0"></a></td>
					<td>
				<table width="873" height="30"  align="center" border="0" cellpadding="0" cellspacing="0">
					<tr bgcolor="#0088CC">
						<td width="306">&nbsp;</td>
						<td width="107" class="AnaMenu"><a href="index.php">ANASAYFA</a></td>
						<td width="160" class="AnaMenu"><a href="erkekayakkabilari.php?SK=?">ERKEK AYAKKABILARI</a></td>
						<td width="160" class="AnaMenu"><a href="kadinayakkabilari.php?SK=?">KADIN AYAKKABILARI</a></td>
						<td width="140" class="AnaMenu"><a href="cocukayakkabileri.php?SK=?">ÇOCUK AYAKKABILARI</a></td>
					</tr>
				</table>				
				</td>
				</tr>
			</table>
			</td>
		</tr>	
		<tr>
			<td valign="top"><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<td align="center">
			<?php
			if((!$SayfaKoduDegeri) or ($SayfaKoduDegeri=="") or ($SayfaKoduDegeri==0)){
				include($Sayfa[0]);
			}else{
				include($Sayfa[$SayfaKoduDegeri]);
			}
			?><br/>	
			</td>
			</table></td>
		</tr>
		
		<tr height="210">
		<td>
			<table width="1065" height="30"  align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#F9F9F9">
				<tr height="30">
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;">&nbsp;<b>KURUMSAL</b></td>
					<td width="22">&nbsp;</td>
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;"><b>ÜYELİK & HİZMETLER</b></td>
					<td width="22">&nbsp;</td>
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;"><b>SÖZLEŞMELER</b></td>
					<td width="21">&nbsp;</td>
					<td width="250" style="border-bottom: 1px dashed #CCCCCC;"><b>BİZİ TAKİP EDİN</b></td>
				</tr>
				<tr height="30">
					<td class="AltMenu">&nbsp;<a href="index.php?SK=1">Hakkımızda</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">Giriş Yap</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=2>Üyelik Sözleşmesi</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkFacebook); ?>" target="_blank">Facebook</a></td>
						</tr>						
					</table>				
					</td>
				</tr>
				<tr height="30">
					<td class="AltMenu">&nbsp;<a href="xxxxx">BANKA HESAPLARIMIZ</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">YENİ ÜYE OL</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=3>KULLANIM KOŞULLARI</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkTwitter); ?>" target="_blank">Twitter</a></td>
						</tr>						
					</table>
					</td>
				</tr>
				<tr height="30">
					<td class="AltMenu">&nbsp;<a href="xxxxx">HAVALE BİLDİRİM FORMU</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="xxxxx">SIK SORULAN SORULAR</a></td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=4>GİZLİLİK SÖZLEŞMESİ</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkLinkedin); ?>" target="_blank">Linkedin</a></td>
						</tr>						
					</table>
					</td>
				</tr>
				<tr height="30">
					<td class="AltMenu">&nbsp;<a href="xxxxx">KARGO NEREDE</a></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=5>MESAFELİ SATIŞ SÖZLEŞMESİ</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkInstagram); ?>" target="_blank">İnstagram</a></td>
						</tr>						
					</table>
					</td>
				</tr>
				<tr>
					<td class="AltMenu">&nbsp;<a href="xxxxx">İLETİŞİM</a></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=6>TESLİMAT</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkPinterest); ?>" target="_blank">Pinterest</a></td>
						</tr>	
					</table>
					</td>
				</tr>
				<tr height="30">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="AltMenu"><a href="index.php"?SK=7>İPTAL & İADE & DEĞİŞİM</a></td>
					<td>&nbsp;</td>
					<td>
					<table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="20"><a href="xxxxx"><img src="Resimler/logo.PNG" border="0" style="margin-top: 5px;"></a></td>
							<td width="230" class="AltMenu"><a href="<?php echo DönüsümleriGeriDöndür($SosyalLinkYouTube); ?>" target="_blank">YouTube</a></td>
						</tr>
					</table>
					</td>
				</tr>
			</table>		
		</td>
		</tr>		
				<tr height="30">
					<td>
					<table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td aling="center"><?php echo DönüsümleriGeriDöndür($SiteCopyrightMetni);?></td>
						</tr>
					</table>
					</td>
				</tr>
		<tr height="30">
					<td>
					<table width="1065" height="30" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td aling="center">Kredi kartları tanımlanacak fotoğraf olarak</td>
						</tr>
					</table>
					</td>
				</tr>
	</table>
</body>
</html>

<?php
$VeritabaniBaglantisi =null;

?>