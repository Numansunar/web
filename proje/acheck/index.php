<? 
/*
user_lib

	$_SESSION['yasOnay'] = 1;
if ($_SESSION['yasOnay'] && !$_SESSION['ageconfirm'] && (stristr($_SERVER['PHP_SELF'],'/'.$yonetimDizini) === false) && (stristr($_SERVER['PHP_SELF'],'/acheck') === false) && !$_SESSION['admin_isAdmin']) 
	redirect('acheck/');
	
*/
include('../include/all.php'); 
    if($_GET['ageconfirm'])
    { 
        if($_POST['yil'] > (date('Y') - 18)) 
        { 
            exit(header('location:http://www.google.com.tr/')); 
        }   

        $_SESSION['ageconfirm'] = 1; 
        redirect('./');    
    } 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>+18 Giriş Onay Ekranı</title>
<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style type="text/css">
body {
	background: #900 url(images/girisbg.jpg) center center fixed;
	background-size:100%;
	font-size: 13px;
	font-family: 'Ubuntu', sans-serif;
	margin: 0px;
	padding: 0px;
	color: #fff;
	-webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
.s_wrapper {
	width: 700px;
	margin-left: auto;
	margin-right: auto;
	text-align: center
}
.logo {
	height: 140px;
	margin-top:150px;
	
}
.s_baslik h2 {
	font-weight: bold;
	font-size: 17px;
	color: #fff;
	margin-top: 50px;
	text-shadow: 1px 2px #000;
}
.s_aciklama {
	font-size: 12px;
	line-height:19px;
}
.tarihsec{margin-top:40px; margin-bottom:20px;}

.myButton {
	float:left;
	background-color:#2c8c46;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;
	border:1px solid #158c21;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-size:18px;
	padding:9px 26px;
	text-decoration:none;
	text-shadow:0px 0px 0px #2f6627;
}

.myButton:active {
	position:relative;
	top:1px;
}

.myButtonout {
	float:right;
	background-color:#333;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;
	border:1px solid #222;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-size:18px;
	padding:9px 26px;
	text-decoration:none;
	text-shadow:0px 0px 0px #283966;
}

.myButtonout:active {
	position:relative;
	top:1px;
}
.s_btn{width:350px; margin-left:auto; margin-right:auto; margin-top:35px;}

@media only screen and (max-width: 480px) {

#gun, #ay, #yil {width:80px; height:60px; font-size:x-large;}
#onay {font-size:34px !important; width:50px; height:50px;}
label {font-size:34px}
}

@media only screen and (max-width: 667px) {

#gun, #ay, #yil {width:80px; height:60px; font-size:x-large;}
#onay {font-size:34px !important; width:50px; height:50px;}
label {font-size:34px}
}

@media only screen and (max-width: 1025px) {

#gun, #ay, #yil {width:80px; height:60px; font-size:x-large;}
#onay {font-size:34px !important; width:50px; height:50px;}
label {font-size:34px}
}



</style>
</head>

<body>
<div class="s_wrapper">
  <div class="logo"><img src="<?=slogoSrc('templates/workshop/img/logo.png')?>" alt="<?=siteConfig('seo_title')?>" /></div>
  <div class="s_baslik">
    <h2>18 YASINDAN KÜÇÜKLERIN BU SITEYE GIRMESI YASAKTIR.</h2>
  </div>
  <div class="s_aciklama">Türk Ceza Kanunu'nun 226. maddesi uyarinca 18 yasindan küçüklerin bu siteyi gezmeleri ve alisveris yapmalari yasaktir.
    Websitemiz T.C.K'nin 226. maddesi D bendinde yer alan müstehcen ürünlerin satisina mahsus alisveris yeri kapsamindadir.
    </div>
 
 <!--tarih seçimi-->
 
  <div class="tarihsec">
    <select name="gun" id="gun" style="color:#000;">
      <option value="0" style="color:#000;">GÜN</option>
      <option value="1"> 1</option>
      <option value="2"> 2</option>
      <option value="3"> 3</option>
      <option value="4"> 4</option>
      <option value="5"> 5</option>
      <option value="6"> 6</option>
      <option value="7"> 7</option>
      <option value="8"> 8</option>
      <option value="9"> 9</option>
      <option value="10"> 10</option>
      <option value="11"> 11</option>
      <option value="12"> 12</option>
      <option value="13"> 13</option>
      <option value="14"> 14</option>
      <option value="15"> 15</option>
      <option value="16"> 16</option>
      <option value="17"> 17</option>
      <option value="18"> 18</option>
      <option value="19"> 19</option>
      <option value="20"> 20</option>
      <option value="21"> 21</option>
      <option value="22"> 22</option>
      <option value="23"> 23</option>
      <option value="24"> 24</option>
      <option value="25"> 25</option>
      <option value="26"> 26</option>
      <option value="27"> 27</option>
      <option value="28"> 28</option>
      <option value="29"> 29</option>
      <option value="30"> 30</option>
      <option value="31"> 31</option>
    </select>
    <select name="ay" id="ay" style="color:#000;">
      <option value="0" style="color:#000;">AY</option>
      <option value="1" style="color:#000;"> 1</option>
      <option value="2" style="color:#000;"> 2</option>
      <option value="3" style="color:#000;"> 3</option>
      <option value="4" style="color:#000;"> 4</option>
      <option value="5" style="color:#000;"> 5</option>
      <option value="6" style="color:#000;"> 6</option>
      <option value="7" style="color:#000;"> 7</option>
      <option value="8" style="color:#000;"> 8</option>
      <option value="9" style="color:#000;"> 9</option>
      <option value="10" style="color:#000;"> 10</option>
      <option value="11" style="color:#000;"> 11</option>
      <option value="12" style="color:#000;"> 12</option>
    </select>
    <select name="yil" id="yil" style="color:#000;">
      <option value="0" style="color:#000;">YIL</option>
      <?
	  	for($i=(date('Y') - 0);$i>=(date('Y') - 65);$i--)
		{
			echo "<option>$i</option>\n";
		}
	  ?>
    </select>
  </div>
  
 <!--tarih seçimi-->
  
  <div>
  		<input type="checkbox" name="onay" id="onay"><label for="onay">18 yasindan büyük oldugumu ve bu sitede sergilenen ürünlerin 18 yasindan küçükler<br>tarafindan görüntülenmemesi için gereken özeni gösterecegimi beyan ederim.</label>
  </div>
  
  <!--onay bitiş-->
  
  <div class="s_btn">
  <a href="#" class="myButton"><i class="fa fa-sign-out" aria-hidden="true"></i> SİTEYE GİRİŞ</a>
  <a href="https://www.google.com.tr/" target="_blank" class="myButtonout"><i class="fa fa-sign-out" aria-hidden="true"></i> SİTEDEN ÇIKIŞ</a>
  </div>
  <div style="clear:both"></div>

<!-- FİRMA BİLGİLERİ -->
  
  <div class="s_baslik">
    <h2><?=siteConfig('firma_adi')?></h2>
  </div>
  
  <div class="s_aciklama">
  <p><?=siteConfig('firma_adres')?><br>
Telefon: <strong> <?=siteConfig('firma_tel')?></strong></p>
    </div>
    
    <div class="s_aciklama">
    <p>Magazamiz hafta içi ve cumartesi günleri <strong>10:00 - 18:00</strong><br>
 Pazar günleri ise <strong>13:00 - 16:00</strong> saatleri arasinda açiktir.</p>
    </div>
  
</div>
<script>
	$('.myButton').click(function() { 
	
		if(!$("#onay").is(':checked'))
		{
			alert('Lütfen onay seçeneğini işaretleyin.');
			return;
		}
		else 
			if($("#gun").val()==0 || $("#ay").val()==0 || $("#yil").val()==0)
		{
			alert("Lütfen tarih seçimi yapiniz!");
			return;
		}
		else
			window.location.href = '?ageconfirm=true&yil=' + $("#yil").val();
	});
</script>
</body>
</html>