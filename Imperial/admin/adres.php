<?php
$sayfa = "Adres";
include('../inc/vt.php');
include('inc/head.php');
include('inc/nav.php');
include('inc/sidebar.php');

$sorgu = $baglanti->prepare("SELECT * FROM adres");
$sorgu->execute();
$sonuc = $sorgu->fetch();
?>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Adres</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>                           
                            <th>Email</th>
                            <th>Adres</th>
                            <th>Telefon</th>
                            <th>Twitter Link</th>
                            <th>Facebook Link</th>
                            <th>İnstagram Link</th>
                            <th>Online Mağaza Link</th>
							<th>Düzenle</th>
                        </tr>
                        </thead>

                        <tbody>                      
                            <tr>
                                <td><?= $sonuc["email"] ?></td>
								<td><?= $sonuc["adres"] ?></td>
                                <td><?= $sonuc["telefon"] ?></td>
								<td><?= $sonuc["twitterLink"] ?></td>
								<td><?= $sonuc["facebookLink"] ?></td>
								<td><?= $sonuc["instagramLink"] ?></td>
								<td><?= $sonuc["magazaLink"] ?></td>
                              <td><a class="btn btn" href="adresGuncelle.php?id=<?= $sonuc["id"] ?>"><span class="fa fa-edit fa-2x"></span></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Son Güncelleme <?php echo date('d/m/Y H:i:s')?></div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <?php
    include('inc/footer.php');
    ?>



    