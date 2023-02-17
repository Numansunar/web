<?php 
 
include "baglan.php";
ob_start();
session_start();
 
if(!isset($_SESSION["login"])){
    header("Location:admingiris.php");
}
else {
 
    echo "<a href=logout.php class=\"baslik\">Güvenli Çıkış</a></center>";
}
?>
<div >
<ul class="sonarmenu">
<li><a href="yonetici.php">Konu Ekle</a></li>
<li><a href="menuekle.php"  >Menü Ekle</a></li>


</ul>
</div>
<div class="konuForm">
<form action="menuekleme.php" method="post">
<h2 class="baslik">Menü Ekleme</h2>

<table width="300px" >
	<tr>
			<td>
				<label>Menü Başlık</label>
			</td>
			<td>
				<input type="text" name="menuAd">
			</td>
		</tr>
</table>

<input class="subMenuEkle" type="submit" name="sub" value="Ekle">