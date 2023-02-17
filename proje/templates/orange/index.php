<?php
$adet = 4;
$siteConfig['captchaClose'] = 0;
if (!$_GET['basla']) $adet = 8;
$out.=insertBanner('vitrin_ust');
$out = '<div class="products urunAjax">';
$out.= urunlist('select * from urun where anasayfa=1 order by seq desc,ID desc limit '.((int)$_GET['basla']).",$adet");
$out.='</div>'.insertBanner('vitrin_alt');
$PAGE_OUT = $out;
?>