			<div class="productdetay">
				<div class="visual">
                				<!-- valign start -->
                                  <div style="display: table; height: 338px; width:340px; #position: relative; overflow: hidden;">
                                    <div style=" #position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
                                      <div style=" #position: relative; #top: -50%">
                                        <center><a class="lightbox" href="images/urunler/{%DB_RESIM%}"><img alt="{%URUN_BASLIK%}" src="{%URUN_RESIM_SRC%}"></a></center>
                                      </div>
                                    </div>
                                  </div>                              
                               	<!-- valign finish --> 
					
				</div>
				<div class="holder">
                	<h1>{%DB_NAME%}</h1>
					<h2>{%DB_ONDETAY%}</h2>
					<form class="add-form" action="#">
						<fieldset>
							{%URUN_SECIM_LISTE%}
							<div class="buy">
								<dl>
									<dt>Piyasa fiyatı :</dt>
									<dd>{%PIYASA_FIYAT%} {%URUN_FIYAT_BIRIM2%}</dd>
									<dt>Satış fiyatı :</dt>
									<dd>{%URUN_FIYAT_KDV_DAHIL%} {%URUN_FIYAT_BIRIM2%}</dd>
									<dt>Havale ile  :</dt>
									<dd>{%URUN_HAVALE_FIYAT_YTL%} TL</dd>
								</dl>
								<div class="add">
									<div class="text">
										<input type="text" id="adet_1" urunID="{%DB_ID%}" value="1" max="{%DB_STOK%}"/>
									</div>
									<label for="adet_1">adet</label>
									<div style="white-space: nowrap; display: inline;"><input class="btn-add-to-cart" type="button" value="Sepete ekle" onclick="return multiSepetEkle(this);" /></div>
								</div>
							</div>
                             <div style="clear:both">&nbsp;</div>
                        	{%URUN_KULLANICI_SECENEKLERI%}
                            <div style="clear:both"></div>
						</fieldset>
					</form>
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
			{%TAB_MENU%}
            	<input type="hidden" id="relUrunID" value="{%DB_ID%}" />