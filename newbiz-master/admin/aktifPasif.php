<?php
if ($_POST) { //post var mı diye bakıyoruz
    include("../inc/vt.php"); //veri tabanına bağlanıyoruz

    //değişkenleri integer olarak alıyoruz
    $id = (int)$_POST['id'];
    $durum = (int)$_POST['durum'];

    $id1 = (int)$_POST['id'];
    $durum1 = (int)$_POST['durum'];
	$id2 = (int)$_POST['id'];
    $durum2 = (int)$_POST['durum'];
	$id3 = (int)$_POST['id'];
    $durum3 = (int)$_POST['durum'];

    $satir = array('id' => $id,
        'durum' => $durum,
    );
	    $satir1 = array('id' => $id1,
        'durum' => $durum1,
    );
	    $satir2 = array('id' => $id2,
        'durum' => $durum2,
    );
	    $satir3 = array('id' => $id3,
        'durum' => $durum3,
    );
    // Veri güncelleme sorgumuzu yazıyoruz.
    $sql = "UPDATE katalog SET aktif=:durum WHERE id=:id;";
    $durum = $baglanti->prepare($sql)->execute($satir);
	$sql1 = "UPDATE ortaklar SET aktif=:durum WHERE id=:id;";
    $durum1 = $baglanti->prepare($sql1)->execute($satir1);
	$sql2 = "UPDATE portfolyo SET aktif=:durum WHERE id=:id;";
    $durum2 = $baglanti->prepare($sql3)->execute($satir2);
	$sql3 = "UPDATE takim SET aktif=:durum WHERE id=:id;";
    $durum3 = $baglanti->prepare($sql3)->execute($satir3);

    //gerekli ise geriye değer döndürüyoruz
    echo $id . " nolu kayıt değiştirildiz";
	echo $id1 . " nolu kayıt değiştirildiz";
	echo $id2 . " nolu kayıt değiştirildiz";
	echo $id3 . " nolu kayıt değiştirildiz";
}
?>