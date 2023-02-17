<?php 
include("../inc/vt.php"); // veritabanı bağlantımızı sayfamıza ekliyoruz.
if ($_POST) { // Post olup olmadığını kontrol ediyoruz.
	
	$alan = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger = str_replace('{0}','+',$deger); 
	$id = $_POST['id'];
	
	$alan1 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger1 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger1 = str_replace('{0}','+',$deger1); 
	$id1 = $_POST['id'];
	
	$alan2 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger2 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger2 = str_replace('{0}','+',$deger2); 
	$id2 = $_POST['id'];
	
	$alan3 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger3 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger3 = str_replace('{0}','+',$deger3); 
	$id3 = $_POST['id'];
	
	$alan4 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger4 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger4 = str_replace('{0}','+',$deger4); 
	$id4 = $_POST['id'];
	
	$alan5 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger5 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger5 = str_replace('{0}','+',$deger5); 
	$id5 = $_POST['id'];
	
	$alan6 = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger6 = $_POST['deger'];
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger6 = str_replace('{0}','+',$deger6); 
	$id6 = $_POST['id'];
	
		if ($baglanti->query("UPDATE referanslar SET $alan = '$deger' WHERE id =$id")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
				if ($baglanti->query("UPDATE servisler SET $alan1 = '$deger1' WHERE id =$id1")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
			if ($baglanti->query("UPDATE portfolyo SET $alan2 = '$deger2' WHERE id =$id2")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
			if ($baglanti->query("UPDATE anasayfa SET $alan3 = '$deger3' WHERE id =$id3")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
			if ($baglanti->query("UPDATE hakkimizda SET $alan4 = '$deger4' WHERE id =$id4")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
			if ($baglanti->query("UPDATE kullanicilar SET $alan5 = '$deger5' WHERE id =$id5")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
	if ($baglanti->query("UPDATE takim SET $alan6 = '$deger6' WHERE id =$id6")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}
}
?>
