			<div class="product">
				<div class="visual">
               	<div class="nofade">{%ICON_LISTE%}</div>
                				<!-- valign start -->
                                  <div style="display: table; height: 338px; width:432px; #position: relative;">
                                    <div style=" #position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
                                      <div style=" #position: relative; #top: -50%">
                                        <a class="lightbox" href="images/urunler/{%DB_RESIM%}" title="{%URUN_BASLIK%}"><img alt="{%URUN_BASLIK%}" style="cursor:pointer" src="{%URUN_RESIM_SRC%}"></a>
                                      </div>
                                    </div>
                                  </div>                              
                               	<!-- valign finish --> 
							{%URUN_RESIM_LIST%}
				</div>
				<div class="holder">
                	<h1>{%DB_NAME%}</h1>
                    <div style="clear:both">&nbsp;</div>
					<h2>{%DB_ONDETAY%}
                    <div style="clear:both">&nbsp;</div>
                    {%URUN_SECIM_LISTE%}
                    </h2>
                    
					<form class="add-form" action="#">
						<fieldset>
		
							<div class="buy">
								<dl>
                                    <dt>Piyasa fiyatı :</dt>
        <dd>{%PIYASA_FIYAT%} {%URUN_FIYAT_BIRIM2%}</dd>
        <dt>Satış fiyatı :</dt>
        <dd><span id="shopPHPUrunFiyatOrg">{%URUN_FIYAT_KDV_DAHIL%}</span> {%URUN_FIYAT_BIRIM2%}</dd>
        <dt>Satış (TL) :</dt>
        <dd><span id="shopPHPUrunFiyatYTL">{%URUN_FIYAT_KDV_DAHIL_YTL%}</span> TL</dd>
        <dt>Havale ile  :</dt>
        <dd><span id="shopPHPHavaleIndirim">{%URUN_HAVALE_FIYAT_YTL%}</span> TL</dd>


								</dl>
								<div class="add">
									<div class="text">
										<input type="text" id="adet" class="sepeteEkleAdet" value="1" max="{%DB_STOK%}"/>
									</div>
									<label for="adet">adet</label>
									<input class="btn-add-to-cart" type="button" value="Sepete ekle" onclick="{%SEPETE_EKLE_LINK%}" />
								</div>
							</div>
                         </fieldset>
					</form>
                             <div style="clear:both">&nbsp;</div>
                            {%URUN_KULLANICI_SECENEKLERI%}
                            <div style="clear:both"></div>

                    
					<div class="social-networking">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                        <a class="addthis_button_preferred_1"></a>
                        <a class="addthis_button_preferred_2"></a>
                        <a class="addthis_button_preferred_3"></a>
                        <a class="addthis_button_preferred_4"></a>
                        <a class="addthis_button_compact"></a>
                        <a class="addthis_counter addthis_bubble_style"></a>
                        </div>
                        <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fac1abe0d0e6aeb"></script>
                        <!-- AddThis Button END -->					
					</div>
 				</div>
			</div>
            <div style="clear:both"></div>
			<div class="tabs">
				<ul class="tabset">
					<li class="active" open-tab="dstoretab1"><a href="#">Özellikler</a></li>
					<li open-tab="dstoretab2"><a href="#">Ürün resimleri</a></li>
					<li open-tab="dstoretab3"><a href="#">Taksit seçenekleri</a></li>
					<li open-tab="dstoretab4"><a href="#">Yorumlar</a></li>
                    <li open-tab="dstoretab6"><a href="#">Soru-Cevap</a></li>
					<li open-tab="dstoretab5"><a href="#">Geri bildirim</a></li>
				</ul>
                <div style="clear:both"></div>
				<div class="tab-list">
                	<div id="dstoretab1" class="dstoretab">
                       {%DB_DETAY%}
                       <div style="clear:both"></div>
                    </div>
                    <div id="dstoretab2" class="dstoretab">
                       {%TAB_RESIM%}
                       <div style="clear:both"></div>
                    </div>
                    <div id="dstoretab3" class="dstoretab">
                       {%func_showTaksit%}
                       <div style="clear:both"></div>
                    </div>
                    <div id="dstoretab4" class="dstoretab">
                       {%TAB_YORUM%}
                       <div style="clear:both"></div>
                    </div>
                     <div id="dstoretab5" class="dstoretab">
                       {%TAB_MESAJ%}
                       <div style="clear:both"></div>
                    </div>
                    <div id="dstoretab6" class="dstoretab">
                       {%TAB_SORU%}
                       <div style="clear:both"></div>
                    </div>
				</div>
			</div>
            <script>$('.dstoretab:first').show();</script>
            <div stlye="clear:both"></div>
			<div class="products">
                <div class="similar-products">
					<h2><a href="#">Birlikte alabileceğiniz indirimli ürünler</a></h2>
					{%func_dstorecaprazPromosyonUrunList%}
				</div>
				<div class="similar-products">
					<h2><a href="#">Benzer ürünler</a></h2>
					{%func_dstoreilgiliUrunList%}
				</div>
			</div>