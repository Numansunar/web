
                <div class="product">
					<div class="proHeading">
						<h3>{%KATEGORI_ADI%}</h3>
						<div class="phInner">
							{%URUN_ADI%}
						</div><!-- /.phInner -->
					</div><!-- /.proHeading -->

					<div class="productDetails">
						<h1>{%URUN_ADI%}</h1>
						<div class="price">
							<span>{%STOK_VARMI%}</span> <span id="shopPHPUrunFiyatYTL">{%URUN_FIYAT_KDV_DAHIL_YTL%}</span> TL
						</div><!-- /.price -->
						<a href="#" onclick="{%SEPETE_EKLE_LINK%}" class="buy">ÜRÜNÜ SATIN ALIN</a>
						<h3>Teknik Özellikler</h3>
						<div class="text">
							<p>{%DB_ONDETAY%}</p>
						</div><!-- /.text -->
						<h3>Ebatlar</h3>
						<div class="text">
							{%DB_DATA1%}
						</div><!-- /.text -->
					</div><!-- /.productDetails -->
					{%FUNC_proImg%}
					<div class="clear"></div><!-- /.clear -->

					<div class="steps">
						<div class="step">
							<h4>ADET SEÇİNİZ</h4>
							{%ADET_FORM%}
						</div><!-- /.step -->
						<div class="step">
							<a class="addBasket" href="#" onclick="{%SEPETE_EKLE_LINK%}">ÜRÜNÜ SEPETE AT</a><!-- /.addBasket -->
						</div><!-- /.step -->
						<div class="social">
                        	<div class="facebook">
                                <!-- AddThis Button BEGIN -->
                                <div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_preferred_1"></a>
                                <a class="addthis_button_preferred_2"></a>
                                <a class="addthis_button_preferred_3"></a>
                                <a class="addthis_button_preferred_4"></a>
                                <a class="addthis_button_compact"></a>
                                <a class="addthis_counter addthis_bubble_style"></a>
                                </div>
                            </div>
                            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5051a3af2a1574b5"></script>
                            <!-- AddThis Button END -->
						</div><!-- /.social -->
					</div><!-- /.steps -->

					<div class="others">
						<div class="tabLinks">
							<ul>
								<li><a href="#o1">Ürün Genel Özellikleri</a></li>
								<li><a href="#o2">Taksit Seçenekleri</a></li>
								<li><a href="#o3">Ürün Yorumları</a></li>
                                <li><a href="#o5">Ürün Soru-Cevap</a></li>
								<li><a href="#o4">Video</a></li>
							</ul>
						</div><!-- /.tabLinks-->

						<div class="tabs">
							<div class="tab" id="o1">
								{%TAB_DETAY%}
							</div>
							<div class="tab" id="o2">
								{%FUNC_showTaksit%}
							</div>
							<div class="tab" id="o3">
								{%TAB_YORUM%}
							</div>
							<div class="tab" id="o4">
								{%DB_VIDEO%}
							</div>
                            <div class="tab" id="o5">
								{%TAB_SORU%}
							</div>
						</div>
					</div>

				</div>