<?php
$out.=opSlide().insertBanner('vitrin_ust').'
					<div class="productTabs">
						<div class="tabLinks">
							<ul>
								<li><a href="#t1">Vitrin Ürünlerimiz</a></li>
								<li><a href="#t2">Çok Satanlar</a></li>
								<li><a href="#t3">Kampanyalı Ürünler</a></li>
							</ul>
						</div><!-- /.tabLinks-->
						<div class="tabs">
							<div class="tab productList" id="t1">
								'.urunlist('select * from urun where anasayfa = 1 order by seq desc,ID desc').'	
							</div>
							<div class="tab productList" id="t2">
								'.urunlist('select * from urun where active = 1 order by sold desc,ID desc').'
							</div>
							<div class="tab productList" id="t3">
								'.urunlist('select * from urun where indirimde = 1 order by seq desc,ID desc').'
							</div>
						</div>
					</div><!-- /.productTabs -->'.insertBanner('vitrin_alt');
$PAGE_OUT = $out;
?>