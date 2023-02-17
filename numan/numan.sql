# Host: localhost  (Version 5.7.17-log)
# Date: 2017-12-27 00:05:04
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "adminbilgi"
#

CREATE TABLE `adminbilgi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(255) DEFAULT NULL,
  `sifre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "adminbilgi"
#

INSERT INTO `adminbilgi` VALUES (1,'numan','1234');

#
# Structure for table "icerik"
#

CREATE TABLE `icerik` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) DEFAULT NULL,
  `yazi` varchar(9999) DEFAULT NULL,
  `baslik2` varchar(9999) DEFAULT NULL,
  `yazi2` varchar(999) DEFAULT NULL,
  `yanMenuId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "icerik"
#

INSERT INTO `icerik` VALUES (1,'PHP\'ye Giris','PHP sunucu taraflı (server side), HTML ile uyumlu bir betik dilidir. Daha önce kullandığım “programlama dili” ifadesi PHP için yüzde yüz açıklayıcı değildir. PHP, HTML de olduğu gibi bir derleyici tarafından derlenmez, sadece sunucudaki php programı tarafından yorumlanır. C bilen birisi için PHP öğrenmesi çok basit olan bir dildir, öyle ki dosya işlemleri gibi karışık konularda PHP, C’den çok daha basittir.\r\nYazdığınız PHP kodları hiçbir zaman sitenizin ziyaretçisine görüntülenmez. Ziyaretçi sayfanın kaynağını görüntülese bile göreceği sizin PHP kodlarınızın sunucu sistemdeki php programı tarafından HTML’ye çevrilmiş halidir. Aşağıdaki kod kümesini incelerseniz daha iyi anlayacağınızı sanıyorum (PHP’ye henüz bir giriş yapmadığım için kodları anlamayabilirsiniz, fakat yine de C’ye az da olsa aşina olanlar bir anlam çıkartacaktır).\r\n<?php\r\n  printf(“Bu bir PHP dosyasıdır.<br>\\n”);\r\n  print(“Bu bir PHP dosyasıdır.<br>\\n”);\r\n  echo (“Bu bir PHP dosyasıdır.<br>\\n”);\r\n  echo “Bu bir PHP dosyasıdır.<br>\\n”;\r\n?>\r\nYukarıdaki dört kod satırıda ekrana “Bu bir PHP dosyasıdır.” yazdıracaktır. Ve web istemcinizden sayfanın kaynağına baktığınız zaman sadece\r\nBu bir PHP dosyasıdır.<br>\r\nBu bir PHP dosyasıdır.<br>\r\nBu bir PHP dosyasıdır.<br>\r\nBu bir PHP dosyasıdır.<br>\r\ngibi bir içerik görürsünüz. Yazdığınız kodlar sunucu sistemdeki php programı tarafından normal HTML kodlarına çevrilmiştir ve ziyaretçi bu kodlardan başka herhangi bir içerik göremez.\r\nDikkat ettiyseniz sayfamızın kaynağındaki kodlar dört satır halinde yazılmış, eğer PHP programımızda her metinden sonra gelen “\\n” karakterini kaldırsaydık sayfamızın kaynağındaki komutlar tek satıra yerleşirdi.\r\nFakat bu sayfanın ziyaretçiye görünen kısmını değiştirmediği için üzerinde fazla durulması gereken bir konu değil.\r\nBir diğer husus da kodlarımızda kullandığımız <br> etiketi. Evet PHP içinde doğrudan doğruya HTML etiketleri kullanabilmemiz bize çok büyük kolaylıklar sağlayacak. PHP dosyaları sunucu sistemde .php ya da .php3 uzantısı ile saklanır (.php3, PHP’nin 3. Sürümü için kullanılmaktadır). Dosyamızda PHP kodlarını kullandığımız yeri göstermek için <?php ?> ya da <? ?> etiket aralıklarını kullanırız. Bu etiketlerin kullanıldığı yerden itibaren sunucu etiket aralığındaki komutları php yorumlayıcısına gönderir, php yorumlayıcısı da bu kodları düz HTML kodlarına çevirir.\r\nDenemelerinizi bir UNIX ya da türevi işletim sistemi üzerinde yapmanızı tavsiye ederim, çünkü PHP ile birlikte kullanılan bir çok işlev Windows altında çalışmamakta ya da sorun yaratmaktadır.\r\nElinizin altında PHP+MySQL desteği bulunan bir sistem olduğunu varsayarak bölüme başlıyorum.\r\nÖncelikle PHP’nin yazım kurallarından söz etmek istiyorum. Daha öncede belirttiğim gibi PHP kodları <?php ?> ya da <? ?> etiketleri arasında kullanılır. Yazdığımız her komuttan sonra ; işareti kullanırız (C’ye benziyor demiştim ;)). Bir web sayfasında veya formdan gelen değişkenleri adlarının başına $ işaret koyarak sembolize ederiz ve değişken adlarında Türkçe karakter kullanamayız.','','','1'),(2,'ECHO','Php ile yaptğımız projelerimiz ekrana herhangi bi türden yazı yazdırmak istediğimiz zaman echo() fonksiyonunu kullanırız. Kullanımı kolay ve akılda kalıcı olan bu fonksiyon sayesinde, yazılarımızı ekranda çıkartabilir ve değişkenlerin sonuçlarınızı yazdırabiliriz. Php\'de program yazacaksanız echo() fonksiyonunu çok kullanacaksınız. PHP- Kodu: $degisken = \"Mustafa Tanrıverdi\";   Yukarıdaki kodu sayfa.php adında kayıt edelim ve çalıştırdığımız zaman Mustafa Tanrıverdi değerini taşıyan bir adet değişken oluşturmuş olduk. Ama ekranda böyle bi yazı yok çünkü; biz sadece değişkene değer atadık ekranda göstermesi için herhangi bi komut yazmadık. Bu durumda echo() fonksiyonunu kullanarak ekranda yazımızı yazdırıyoruz.  PHP- Kodu: $degisken = \"Mustafa Tanrıverdi\";  echo\"$degisken\";   Yukarıdaki kodu çalıştırdığımız zaman ekranda \"Mustafa Tanrıverdi\" yazıldığını göreceksiniz. PHP- Kodu: $degisken = \"Mustafa Tanrıverdi\";                  echo\"Bu adamın adı $degisken\";   Yukarıdaki kodu çalıştırdığımız zaman ekranda \"Bu adamın adı Mustafa Tanrıverdi\" yazıldığını göreceksiniz. Bakınız Php ile değişkenin değerini alıyoruz. Zaten programlamanın temel mantığıda budur.  PHP- Kodu: $degisken = \"Mustafa Tanrıverdi\";  echo\"Adı kalın olacak, <strong>$degisken</strong>\";   Tabiki echo komutu içerisinde HTML etiketleri gösterebiliriz. Bu kodu ekrana yazdırdığımızda \"Adı kalın olacak Mustafa Tanrıverdi\" yazısı gelecektir.  Gördüğünüz gibi echo() komutunu kullanırken ekrana çıkmasını istediğimiz değerleri belirtmek için çift tırnak(\" \") karakterlerini kullanıyoruz. Ama isterseniz tek tırnak (\' \') karakterlerinide kullanabilirsiniz. Tabiki tek tırnak karakterini kullanırsanız $degisken değerini almayacak ve ekrana $degisken diye çıktı verecektir.  PHP- Kodu: $degisken = \"Mustafa Tanrıverdi\";                  echo\'$degisken\';   Bu kodu yazdırdığımız zaman karşımızı Mustafa Tanrıverdi değil de $degisken yazısının geldiğini göreceksiniz. Çünkü Php \"\" (çift tırnak) içinde ki veriyi yorumlamaya çalışır ama \' \' (tek tırnak) içinde ki veriyi ise yorumlamadan ekrana yazdırır.  Eğer ekrana çıkartmak istediğiniz değer de değişken yok ise \' \' (tek tırnak) kullanınız, çünkü Php bunu yorumlamadan ekrana dökecek ve sunucunuzu pek fazla yormayacaksınız. Büyük projelerde önemle dikkat edilmelidir.','','','2');

#
# Structure for table "ustmenu"
#

CREATE TABLE `ustmenu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "ustmenu"
#

INSERT INTO `ustmenu` VALUES (2,'PHP');

#
# Structure for table "yanmenu"
#

CREATE TABLE `yanmenu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `yanMenuAdi` varchar(255) DEFAULT NULL,
  `anaMenuId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "yanmenu"
#

INSERT INTO `yanmenu` VALUES (1,'Giris','2'),(2,'PHP ECHO YAZIMI','2');
