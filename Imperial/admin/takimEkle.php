<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php
$sayfa = "Takım";
include('../inc/vt.php');
include('inc/head.php');
include('inc/nav.php');
include('inc/sidebar.php');
if ($_POST) { // Sayfada post olup olmadığını kontrol ediyoruz.

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
    $hata = "";
	
    // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
    if ($adSoyad <> "" && $ustBaslik <> "" && isset($_FILES['foto'])) {

        if ($_FILES['foto']['error'] != 0) {
            $hata .= 'Dosya yüklenirken hata gerçekleşti lütfen daha sonra tekrar deneyiniz.';
        } else {

            $dosya_adi = strtolower($_FILES['foto']['name']);
            if (file_exists('images/' . $dosya_adi)) {
                $hata .= " $dosya_adi diye bir dosya var";
            } else {
                $boyut = $_FILES['foto']['size'];
                if ($boyut > (1024 * 1024 * 2)) {
                    $hata .= ' Dosya boyutu 2MB den büyük olamaz.';
                } else {
                    $dosya_tipi = $_FILES['foto']['type'];
                    $dosya_uzanti = explode('.', $dosya_adi);
                    $dosya_uzanti = $dosya_uzanti[count($dosya_uzanti) - 1];

                    if (!in_array($dosya_tipi, ['image/png', 'image/jpeg']) || !in_array($dosya_uzanti, ['png', 'jpg'])) {
                        //if (($dosya_tipi != 'image/png' || $dosya_uzanti != 'png' )&&( $dosya_tipi != 'image/jpeg' || $dosya_uzanti != 'jpg')) {
                        $hata .= ' Hata, dosya türü JPEG veya PNG olmalı.';
                    } else {
                        $foto = $_FILES['foto']['tmp_name'];
                        copy($foto, '../assets/img/' . $dosya_adi);


                        //Eklencek veriler diziye ekleniyor
                        $satir = [
                            'foto' => $dosya_adi,
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

                        // Veri ekleme sorgumuzu yazıyoruz.
                        $sql = "INSERT INTO takim SET foto=:foto , ustIcerik=:ustIcerik , twitterLink=:twitterLink , facebookLink=:facebookLink , instagramLink=:instagramLink , linkedinLink=:linkedinLink , kis=:kis , adSoyad=:adSoyad , aktif=:aktif , sira=:sira , ustBaslik=:ustBaslik;";
                        $durum = $baglanti->prepare($sql)->execute($satir);

                        if ($durum) {
                            echo '<script>swal("Başarılı","Takım Eklendi","success").then((value)=>{ window.location.href = "takim.php"});

</script>';
                        }


                    }
                }
            }
        }
    }
    if($hata!=""){
        echo '<script>swal("Hata","'.$hata.'","error");</script>';
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

                <form method="post" action="takimEkle.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input required type="file" name="foto" class="form-control-file" id="foto">
                    </div>
                    <div class="form-group">
                        <label>Üst Başlık</label>
                        <input required type="text" class="form-control" name="ustBaslik" placeholder="Üst Başlık">
                    </div>
					<div class="form-group">
                        <label>Üst İçerik</label>
                        <input required type="text" class="form-control" name="ustIcerik" placeholder="Üst İçerik">
                    </div>
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input required type="text" class="form-control" name="adSoyad" placeholder="Ad Soyad">
                    </div>
					<div class="form-group">
                        <label>İş</label>
                        <input required type="text" class="form-control" name="kis" placeholder="İş">
                    </div>
					<div class="form-group">
                        <label>Twitter Link</label>
                        <input required type="text" class="form-control" name="twitterLink" placeholder="Twitter Link">
                    </div>
					<div class="form-group">
                        <label>Facebook Link</label>
                        <input required type="text" class="form-control" name="facebookLink" placeholder="Facebook Link">
                    </div>
					<div class="form-group">
                        <label>İnstagram Link</label>
                        <input required type="text" class="form-control" name="instagramLink" placeholder="İnstagram Link">
                    </div>
					<div class="form-group">
                        <label>Linkedin Link</label>
                        <input required type="text" class="form-control" name="linkedinLink" placeholder="Linkedin Link">
                    </div>

                    <div class="form-group">
                        <label>Sıra</label>
                        <input required type="text" class="form-control" name="sira" placeholder="Sıra">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="aktif" id="aktif">
                        <label class="form-check-label" for="aktif">Aktif mi?</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>

                </form>


            </div>
        </div>
        <div class="card-footer small text-muted">Son Güncelleme <?php echo date('d/m/Y H:i:s')?></div>


        <!-- /.container-fluid -->


        <?php
        include('inc/footer.php');
        ?>
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