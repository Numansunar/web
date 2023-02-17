<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php
$sayfa = "Takım";
include('../inc/vt.php');
include('inc/head.php');
include('inc/nav.php');
include('inc/sidebar.php');

$sorgu = $baglanti->prepare("SELECT * FROM takim Where id=:id");
$sorgu->execute(['id' => (int)$_GET["id"]]);
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor

       if ($_POST) { // Post olup olmadığını kontrol ediyoruz.
    $adSoyad = $_POST['adSoyad']; // Sayfa yenilendikten sonra post edilen değerleri değişkenlere atıyoruz
    $ustBaslik = $_POST['ustBaslik'];
	$ustIcerik = $_POST['ustIcerik'];
	$twitterLink = $_POST['twitterLink'];
	$facebookLink = $_POST['facebookLink'];
	$instagramLink = $_POST['instagramLink'];
	$linkedinLink = $_POST['linkedinLink'];
	$kis = $_POST['kis'];
    $sira = $_POST['sira'];
    $aktif = 0;
               if (isset($_POST['aktif'])) $aktif = 1;
               $hata = '';
               if ($_FILES["foto"]["name"] != "") {
                $foto = strtolower($_FILES['foto']['name']);
                if (file_exists('images/' . $foto)) {
                    $hata = "$foto diye bir dosya var";
                } else {
                    $boyut = $_FILES['foto']['size'];
                    if ($boyut > (1024 * 1024 * 2)) {
                        $hata = 'Dosya boyutu 2MB den büyük olamaz.';
                    } else {
                        $dosya_tipi = $_FILES['foto']['type'];
                        $dosya_uzanti = explode('.', $foto);
                        $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];

                        if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                            //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                            $hata = 'Hata, dosya türü JPEG veya PNG olmalı.';
                        } else {
                            $dosya = $_FILES["foto"]["tmp_name"];
                            copy($dosya, "../assets/img/" . $foto);
                           // unlink('../assets/img/' . $sonuc["foto"]); //eski dosya siliniyor.
                        }
                    }
                }
            } else {
                //Eğer kullanıcı fotoğraf seçmedi ise veri tabanındaki resimi değiştirmiyoruz
                $foto = $sonuc["foto"];
            }

            if ($adSoyad <> "" && $kis <> "" && $ustIcerik <> "" && $ustBaslik <> "" && $hata == "") { // Veri alanlarının boş olmadığını kontrol ettiriyoruz.
                //Değişecek veriler
                $satir = [
                            'id' => $_GET['id'],
                 			'foto' => $foto,
                            'adSoyad' => $adSoyad,
							'kis' => $kis,
                            'ustBaslik' => $ustBaslik,
							'ustIcerik' => $ustIcerik,
							'twitterLink' => $twitterLink,
							'facebookLink' => $facebookLink,
							'instagramLink' => $instagramLink,
							'linkedinLink' => $linkedinLink,
                            'sira' => $sira,
                            'aktif' => $aktif,                            
                        ];
                // Veri güncelleme sorgumuzu yazıyoruz.
             $sql = "UPDATE takim SET foto=:foto , ustIcerik=:ustIcerik , twitterLink=:twitterLink , facebookLink=:facebookLink , instagramLink=:instagramLink , linkedinLink=:linkedinLink , kis=:kis , adSoyad=:adSoyad , aktif=:aktif , sira=:sira , ustBaslik=:ustBaslik WHERE id=:id;";
             $durum = $baglanti->prepare($sql)->execute($satir);

             if ($durum)
             {
                echo '<script>swal("Başarılı","Takım güncellendi","success").then((value)=>{ window.location.href = "takim.php"});

                </script>';     // Eğer güncelleme sorgusu çalıştıysa takim.php sayfasına yönlendiriyoruz.
            } else {
                    echo 'Düzenleme hatası oluştu: '; // id bulunamadıysa veya sorguda hata varsa hata yazdırıyoruz.
                }
            } else {
                echo 'Hata oluştu: ' . $hata; // dosya hatası ve form elemanlarının boş olma durumunua göre hata döndürüyoruz.
            }
            if ($hata != "") {
        echo '<script>swal("Hata","' . $hata . '","error");</script>';
    }
        }
?>
<script src="vendor/CKEditor5/ckeditor.js"></script>
<div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Takım Ekle</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">

            <div class="card-body">

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <img src="../assets/img/<?= $sonuc["foto"] ?>" width="150" alt="">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="foto">
                    </div>
                    <div class="form-group">
                        <label>Üst Başlık</label>
                        <input required type="text" value="<?= $sonuc["ustBaslik"] ?>" class="form-control" name="ustBaslik"
                        placeholder="Üst başlık">
                    </div>
					<div class="form-group">
                        <label>Üst İçerik</label>
                        <input required type="text" value="<?= $sonuc["ustIcerik"] ?>" class="form-control" name="ustIcerik"
                        placeholder="Üst İçerik">
                    </div>
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input required type="text" value="<?= $sonuc["adSoyad"] ?>" class="form-control" name="adSoyad"
                        placeholder="Ad Soyad">
                    </div>
					<div class="form-group">
                        <label>İş</label>
                        <input required type="text" value="<?= $sonuc["kis"] ?>" class="form-control" name="kis"
                        placeholder="İş">
                    </div>
					<div class="form-group">
                        <label>Twitter Link</label>
                        <input required type="text" value="<?= $sonuc["twitterLink"] ?>" class="form-control" name="twitterLink"
                        placeholder="Twitter Link">
                    </div>
					<div class="form-group">
                        <label>Facebook Link</label>
                        <input required type="text" value="<?= $sonuc["facebookLink"] ?>" class="form-control" name="facebookLink"
                        placeholder="Facebook Link">
                    </div>
					<div class="form-group">
                        <label>İnstagram Link</label>
                        <input required type="text" value="<?= $sonuc["instagramLink"] ?>" class="form-control" name="instagramLink"
                        placeholder="İnstagram Link">
                    </div>
					<div class="form-group">
                        <label>Linkedin Link</label>
                        <input required type="text" value="<?= $sonuc["linkedinLink"] ?>" class="form-control" name="linkedinLink"
                        placeholder="Linkedin Link">
                    </div>
                    <div class="form-group">
                        <label>Sıra</label>
                        <input required type="text" value="<?= $sonuc["sira"] ?>" class="form-control" name="sira"
                        placeholder="Sıra">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="aktif" id="aktif"
                        <?php
                        if ($sonuc["aktif"] == 1) echo "checked";
                        ?>
                        >
                        <label class="form-check-label" for="aktif">Aktif mi?</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer small text-muted">Son Güncelleme <?php echo date('d/m/Y H:i:s')?></div>
        <!-- /.container-fluid -->
        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    language: {
                        info: "_TOTAL_ kayıttan _START_ - _END_ kayıt gösteriliyor.",
                        infoEmpty: "Gösterilecek hiç kayıt yok.",
                        loadingRecords: "Kayıtlar yükleniyor.",
                        zeroRecords: "Tablo boş",
                        search: "Arama:",
                        sLengthMenu: "Sayfada _MENU_ kayıt göster",
                        infoFiltered: "(toplam _MAX_ kayıttan filtrelenenler)",
                        buttons: {
                            copyTitle: "Panoya kopyalandı.",
                            copySuccess: "Panoya %d satır kopyalandı",
                            copy: "Kopyala",
                            print: "Yazdır",
                        },
                        paginate: {
                            first: "İlk",
                            previous: "Önceki",
                            next: "Sonraki",
                            last: "Son"
                        },
                    }
                });
            });
        </script>
        <script src="js/aktifcustom.js"></script>
        <link rel="stylesheet" type="text/css" href="css/switch.css">