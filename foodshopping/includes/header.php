<?php 
 $baglan=mysqli_connect("localhost","root","","foodshopping");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Food Shopping</title>
<link rel="stylesheet" type="text/css" href="../css/stlye.css">
	</head>

<body>
	<div class="giris" style="background-color:#03F" >
	<?php
$sonuc=mysqli_query($baglan,"select * from ayarlar");
while($satir=mysqli_fetch_array($sonuc))
{
echo $satir['site_adi'];
 
}
	?>
	</div>