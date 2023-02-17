<?php
$out.='			<div class="promo">
				<div class="baner">
					<div id="slide">
						<div class="borderLeft"></div>
						<div class="borderRight"></div>
						<div class="slide">
							'.dstoreVitrin().'
						</div><!-- .slide END -->
						<div class="ps">
							<a href="#" class="p1">1</a>
							<a href="#" class="p2">2</a>
							<a href="#" class="p3">3</a>
							<a href="#" class="p4">4</a>
							<a href="#" class="p5">5</a>
						</div>
                	</div><!--#slide END--> 
				</div>
				<div class="news-gallery">
					<div class="gmask">
						<ul>
							<li>
								<img src="templates/dstore/images/img17.jpg" width="331" height="152" alt="description" />
								<a style="font-weight:bold;" class="title" href="'.($siteConfig['seoURL'] ? 'indirimde_sp.html':'page.php?act=indirimde').'">Tüm indirimli ürünleri listeleyin.</a>
							</li>
						</ul>
					</div>
					<div class="news">
						<a class="btn-prev" href="#">&lt;</a>
						<a class="btn-next" href="#">&gt;</a>
						<div id="dstorenews">
							'.dstoreHaber().'
						</div>
					</div>
				</div>
				<ul class="brands">
					<li><a href="#"><img src="templates/dstore/images/banner1.png" width="328" height="137" alt="description" /></a></li>
					<li><a href="#"><img src="templates/dstore/images/banner2.png" width="328" height="137" alt="description" /></a></li>
					<li><a href="#"><img src="templates/dstore/images/banner1.png" width="328" height="137" alt="description" /></a></li>
				</ul>
			</div>
			'.insertBanner('vitrin_ust').'
			<div class="specials">
				<div class="heading">
					<h2>İndirimdekiler</h2>
				</div>
				<div class="product-gallery product-gallery1">
					<a class="btn-prev" href="#">&lt;</a>
					<a class="btn-next" href="#">&gt;</a>
					<div class="gmask" id="product-gallery1">
						'.urunlist('select * from urun where indirimde =1 AND active=1 order by seq desc,ID desc limit 0,5','UrunListIndex').'
					</div>
				</div>
			</div>
			<div class="recommended">
				<div class="heading">
					<h2>Tavsiye ürünler</h2>
				</div>
				<div class="product-gallery product-gallery2">
					<a class="btn-prev" href="#">&lt;</a>
					<a class="btn-next" href="#">&gt;</a>
					<div class="gmask" id="product-gallery2">
				    	'.urunlist('select * from urun where anasayfa =1 AND active=1 order by seq desc,ID desc limit 0,10','UrunListIndex').'
					</div>
				</div>
			</div>'.insertBanner('vitrin_alt');
$PAGE_OUT = $out;
?>