<?php
$sayfa = 'İletişim';
$sorgu = $baglanti->prepare("SELECT * FROM magaza where id='1'");
$sorgu->execute();
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor
$sorgu2 = $baglanti->prepare("SELECT * FROM hakkimizda where id='1'");
$sorgu2->execute();
$sonuc2 = $sorgu2->fetch();//sorgu çalıştırılıp veriler alınıyor
?>
<!--==========================
      Contact Section
    ============================-->
    <section id="contact">
      <div class="container-fluid">

        <div class="section-header">
          <h3>İLETİŞİM</h3>
        </div>

        <div class="row wow fadeInUp">

          <div class="col-lg-6">
            <div class="map mb-4 mb-lg-0">
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12271.184080729507!2d37.031988!3d39.7442326!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xe2085095251ae698!2zxZ5BTiBHUlVQIEVMRUsuRUxLUlRPLiBCxLBMLiDEsE7Fni4gS1VZLlTEsEMuIExURC7FnlTEsC4!5e0!3m2!1str!2str!4v1656483562058!5m2!1str!2str" frameborder="0" style="border:0; width: 100%; height: 312px;" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="col-md-5 info">
                <i class="ion-ios-location-outline"></i>
                <p><?= $sonuc['adres'] ?></p>
              </div>
              <div class="col-md-4 info">
                <i class="ion-ios-email-outline"></i>
                <p><?= $sonuc['ustBaslik'] ?></p>
              </div>
              <div class="col-md-3 info">
                <i class="ion-ios-telephone-outline"></i>
                <p><?= $sonuc['telefon'] ?></p>
              </div>
            </div>

            <div class="form">
              <div id="sendmessage">Mesajınız Gönderilmiştir</div>
              <div id="errormessage"></div>
              <form action="iletisim" method="post" role="form" class="contactForm">
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <input type="text" name="ad" class="form-control" id="ad" placeholder="Adınız" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                    <div class="validation"></div>
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Mailiniz" data-rule="email" data-msg="Please enter a valid email" />
                    <div class="validation"></div>
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="mesaj" id="mesaj" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Mesajınız"></textarea>
                  <div class="validation"></div>
                </div>
                <div class="text-center"><button type="submit" title="Send Message">Gönder</button></div>
				  				<script type="text/javascript" src="js/sweetalert.min.js"></script>
                                    <?php

                                    if ($_POST) {

                                        $kaydet = $baglanti->prepare("INSERT INTO iletisim SET ad=:ad, email=:email, mesaj=:mesaj");
                                        $insert = $kaydet->execute(array(
                                            'ad' => htmlspecialchars($_POST['ad']),
                                            'email' => htmlspecialchars($_POST['email']),
                                            'mesaj' => htmlspecialchars($_POST['mesaj']),
                                        ));
                                        if ($insert) {

                                            echo '<script>swal("Başarılı","Mesajınız bize ulaştı","success");</script>';
                                        } else {
                                            echo '<script>swal("Hata","Daha sonra tekrar deneyin","error");</script>';
                                        }
                                    }

                                    ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- #contact -->
  </main>
 <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-info">
            <h3><?= $sonuc2['baslik'] ?></h3>
            <p><?= $sonuc2['icerik'] ?>.</p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Politikalarımız</h4>
            <ul>
              <li><a href="#">Anasayfa</a></li>
              <li><a href="#">Hakkımızda</a></li>
              <li><a href="#">Servisler</a></li>
              <li><a href="#">Hizmet Şartları</a></li>
              <li><a href="#">Gizlilik Politikası</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>İletişim</h4>
            <p><?= $sonuc['adres'] ?> <br>
              <strong>Telefon:</strong> <?= $sonuc['telefon'] ?><br>
              <strong>Email:</strong> <?= $sonuc['ustBaslik'] ?><br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4>Bülten</h4>
            <p>Bültenimiz Hakkında Daha Fazla Bilgi Almak İçin</p>
            <form action="" method="post">
              <input type="email" name="email" placeholder="Mail Adresinizi Giriniz"><input type="submit"  value="Abone Ol">

            </form>
          </div>
        </div>
      </div>
    </div>