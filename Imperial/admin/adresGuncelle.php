<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php
$sayfa = "Adres";
include('../inc/vt.php');
include('inc/head.php');
include('inc/nav.php');
include('inc/sidebar.php');

$sorgu = $baglanti->prepare("SELECT * FROM adres Where id=:id");
$sorgu->execute(['id' => (int)$_GET["id"]]);
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor

if ($_POST) { // Sayfada post olup olmadığını kontrol ediyoruz.

    $email = $_POST['email']; // Sayfa yenilendikten sonra post edilen değerleri değişkenlere atıyoruz
    $adres = $_POST['adres'];
    $telefon = $_POST['telefon'];
    $twitterLink = $_POST['twitterLink'];
	$facebookLink = $_POST['facebookLink'];
	$instagramLink = $_POST['instagramLink'];
	$magazaLink = $_POST['magazaLink'];
    $hata = "";

    // Veri alanlarının boş olmadığını kontrol ettiriyoruz. başka kontrollerde yapabilirsiniz.
    
    if ($email <> "" && $adres <> ""&& $telefon <>  ""&& $twitterLink <>  ""&& $facebookLink <>  ""&& $instagramLink <>  ""&& $magazaLink <> "" && $hata == "") { // Veri alanlarının boş olmadığını kontrol ettiriyoruz.
        //Değişecek veriler
        $satir = [
            'id' => $_GET['id'],
            'email' => $email,
            'adres' => $adres,
            'telefon' => $telefon,
			'twitterLink' => $twitterLink,
			'facebookLink' => $facebookLink,
			'instagramLink' => $instagramLink,
			'magazaLink' => $magazaLink,

        ];


        // Veri güncelleme sorgumuzu yazıyoruz.
        $sql = "UPDATE adres SET email=:email , adres=:adres , telefon=:telefon , twitterLink=:twitterLink , facebookLink=:facebookLink , instagramLink=:instagramLink , magazaLink=:magazaLink WHERE id=:id;";
        $durum = $baglanti->prepare($sql)->execute($satir);
        if ($durum) {
            echo '<script>swal("Başarılı","Güncellendi","success").then((value)=>{ window.location.href = "adres.php"});

            </script>';
            // Eğer güncelleme sorgusu çalıştıysa urunler.php sayfasına yönlendiriyoruz.
        } else {
            echo 'Düzenleme hatası oluştu: '; // id bulunamadıysa veya sorguda hata varsa hata yazdırıyoruz.
        }
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
            <li class="breadcrumb-item active">Adres Düzenle</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">

            <div class="card-body">

                <form method="post" action="" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Mail Adresiniz</label>
                        <input required type="text" value="<?= $sonuc["email"] ?>" class="form-control" name="email"
                        placeholder="email">
                    </div>
                    <div class="form-group">
                        <label for="adres">Adres</label>
                        <textarea  name="adres" id="adres">
                            <?= $sonuc["adres"] ?>
                        </textarea>

                        <script>
                            ClassicEditor
                            .create(document.querySelector('#adres'))
                            .then(editor => {
                                console.log(editor);
                            })
                            .catch(error => {
                                console.error(error);
                            });
                        </script>

                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input required type="text" value="<?= $sonuc["telefon"] ?>" class="form-control" name="telefon"
                        placeholder="telefon">
                    </div>
					<div class="form-group">
                        <label>Twitter Link</label>
                        <input required type="text" value="<?= $sonuc["twitterLink"] ?>" class="form-control" name="twitterLink"
                        placeholder="twitterLink">
                    </div>
					<div class="form-group">
                        <label>Facebook Link</label>
                        <input required type="text" value="<?= $sonuc["facebookLink"] ?>" class="form-control" name="facebookLink"
                        placeholder="facebookLink">
                    </div>
					<div class="form-group">
                        <label>İnstagram Link</label>
                        <input required type="text" value="<?= $sonuc["instagramLink"] ?>" class="form-control" name="instagramLink"
                        placeholder="instagramLink">
                    </div>
					<div class="form-group">
                        <label>Mağaza Link</label>
                        <input required type="text" value="<?= $sonuc["magazaLink"] ?>" class="form-control" name="magazaLink"
                        placeholder="magazaLink">
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