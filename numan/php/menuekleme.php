<?php 

include "baglan.php";
$menuad=$_POST['menuAd'];
	
$query1= $db->prepare("INSERT INTO 	ustmenu SET
										baslik = ?");									
										$insert = $query1->execute(array(
										     "$menuad"
										));
					if ( $insert )
					{
					    $last_id = $db->lastInsertId();			
					}
if($query1)
	echo "Başarıyla Kayıt Edildi";
else
	echo "Ekleme Yapılamadı Lütfen Tekrar Deneyiniz";
echo('<br>');

 ?>

 <a href="..//index.php">Ansayfa</a>



	