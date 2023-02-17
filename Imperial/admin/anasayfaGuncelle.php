<script type="text/javascript" src="../js/sweetalert.min.js"></script>
<?php
$sayfa = "Ana Sayfa";
include('../inc/vt.php');
include('inc/head.php');
include('inc/nav.php');
include('inc/sidebar.php');

$sorgu = $baglanti->prepare("SELECT * FROM anasayfa Where id=:id");
$sorgu->execute(['id' => (int)$_GET["id"]]);
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor



        if ($_POST) { // Post olup olmadığını kontrol ediyoruz.
             $ustBaslik = $_POST['ustBaslik']; // Sayfa yenilendikten sonra post edilen değerleri değişkenlere atıyoruz
             $link = $_POST['link'];
             $altBaslik = $_POST['altBaslik'];
             $altIcerik = $_POST['altIcerik'];
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

            if ($ustBaslik <> "" && $altBaslik <> "" && $link <> "" && $altIcerik <> "" && $hata == "") { // Veri alanlarının boş olmadığını kontrol ettiriyoruz.
                //Değişecek veriler
                $satir = [
                  'id' => $_GET['id'],
                  'foto' => $foto,
                  'ustBaslik' => $ustBaslik,
                  'altBaslik' => $altBaslik,
                  'link' => $link,
                  'altIcerik' => $altIcerik,
              ];
                // Veri güncelleme sorgumuzu yazıyoruz.
              $sql = "UPDATE anasayfa SET foto=:foto, ustBaslik=:ustBaslik,link=:link, altBaslik=:altBaslik, altIcerik=:altIcerik WHERE id=:id;";     
              $durum = $baglanti->prepare($sql)->execute($satir);

              if ($durum)
              {
               echo '<script>swal("Başarılı","Güncellendi","success").then((value)=>{ window.location.href = "index.php"});

               </script>';
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
                    <li class="breadcrumb-item active">Anasayfa Düzenle</li>
                </ol>

      
                
                       
                      
                          <div class="card mb-3">

                            <div class="card-body">

                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <!--form elemanı olarak file kullanıyoruz -->
                                      <input type="file" name="foto"/>
                                      <img width="150px" src="../assets/img/<?php echo $sonuc['foto']; ?>" alt="">
                                  </div>
                                  <div class="form-group">
                                    <label>Üst Başlık</label>
                                    <input required type="text" value="<?= $sonuc["ustBaslik"] ?>" class="form-control" name="ustBaslik"
                                    placeholder="Üst başlık">
                                </div>
                                <div class="form-group">
                                    <label>Link</label>
                                    <input required type="text" value="<?= $sonuc["link"] ?>" class="form-control" name="link"
                                    placeholder="LİNK">
                                </div>
                                <div class="form-group">
                                    <label>Alt Başlık</label>
                                    <input required type="text" value="<?= $sonuc["altBaslik"] ?>" class="form-control" name="altBaslik"
                                    placeholder="Alt Başlık">
                                </div>


                                <div class="form-group">
                                    <label for="altIcerik">Alt İçerik</label>
                                    <textarea  name="altIcerik" id="altIcerik">
                                        <?= $sonuc["altIcerik"] ?>
                                    </textarea>

                                    <script>
                                        ClassicEditor
                                        .create(document.querySelector('#altIcerik'))
                                        .then(editor => {
                                            console.log(editor);
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        });
                                    </script>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </div>

                            </form>


                        </div>
                    </div>
        <!-- DataTables Example -->

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