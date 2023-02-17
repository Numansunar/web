<?php
if ($_POST) { //post var mı diye bakıyoruz
    include("../inc/vt.php"); //veri tabanına bağlanıyoruz

    //değişkenleri integer olarak alıyoruz
    $id = (int)$_POST['id'];
    $durum = (int)$_POST['durum'];
    $satir = array('id' => $id,
        'durum' => $durum,
    );
	$id1 = (int)$_POST['id'];
    $durum1 = (int)$_POST['durum'];
    $satir1 = array('id' => $id1,
        'durum' => $durum1,
    );
	$id2 = (int)$_POST['id'];
    $durum2 = (int)$_POST['durum'];
    $satir2 = array('id' => $id2,
        'durum' => $durum2,
    );
	$id3 = (int)$_POST['id'];
    $durum3= (int)$_POST['durum'];
    $satir3 = array('id' => $id3,
        'durum' => $durum3,
    );
	$id4 = (int)$_POST['id'];
    $durum4 = (int)$_POST['durum'];
    $satir4 = array('id' => $id4,
        'durum' => $durum4,
    );
    // Veri güncelleme sorgumuzu yazıyoruz.
    $sql = "UPDATE urunler SET aktif=:durum WHERE id=:id;";
    $durum = $baglanti->prepare($sql)->execute($satir);
	$sql1 = "UPDATE referanslar SET aktif=:durum WHERE id=:id;";
    $durum1 = $baglanti->prepare($sql)->execute($satir1);
	$sql2 = "UPDATE servisler SET aktif=:durum WHERE id=:id;";
    $durum2 = $baglanti->prepare($sql)->execute($satir2);
	$sql3 = "UPDATE portfolyo SET aktif=:durum WHERE id=:id;";
    $durum3 = $baglanti->prepare($sql)->execute($satir3);
	$sql4 = "UPDATE takim SET aktif=:durum WHERE id=:id;";
    $durum4 = $baglanti->prepare($sql)->execute($satir4);


    //gerekli ise geriye değer döndürüyoruz
    echo $id . " nolu kayıt değiştirildi";
}
?>