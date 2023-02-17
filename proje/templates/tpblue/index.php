<?php
$out='         	<div id="slide">
                    <div class="borderLeft"></div>
                    <div class="borderRight"></div>
                    <div class="slide">
						'.tpVitrin().'
                    </div><!-- .slide END -->
                    <div class="ps">
                        <a href="#" class="p1">1</a>
                        <a href="#" class="p2">2</a>
                        <a href="#" class="p3">3</a>
                        <a href="#" class="p4">4</a>
                        <a href="#" class="p5">5</a>
                    </div>
                </div><!--#slide END--> 
            	'.insertBanner('vitrin_ust').'
                <div id="lastAdded" class="productList">
                	<div class="heading">
                		<h2>Son Eklenen Ürünler</h2>
                        <a href="page.php?act=sonEklenenler">Tümünü Gör &raquo;</a>
                	</div>
                	<div class="proWrap">
                        '.urunlist('select * from urun where active=1 order by ID desc').'
                	</div><!--.proWrap END-->
                </div><!--#lastAdded END-->
                
                <div id="popular" class="productList">
                	<div class="heading">
                		<h2>Sizin İçin Seçtiklerimiz</h2>
                	</div>
					<div class="proWrap">
                        '.urunlist('select * from urun where anasayfa=1 order by ID desc,seq desc').'
                	</div><!--.proWrap END-->
                </div><!--#popular END-->
            	<div style="clear:both">&nbsp;</div>'.insertBanner('vitrin_alt');
$PAGE_OUT = $out;
?>