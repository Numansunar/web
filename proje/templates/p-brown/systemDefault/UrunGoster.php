<div id="proDetails">
				<div id="pdLeft">

					<div class="productBig">
						<a class="lightbox" href="images/urunler/{%DB_RESIM%}" title="{%URUN_BASLIK%}"><img alt="{%URUN_BASLIK%}" style="cursor:pointer; width:270px;" src="{%URUN_RESIM_SRC%}"></a>
					</div><!--#.productBig END-->
					
					<div class="productSmall">
						<ul>
						{%URUN_RESIM_LIST%}
						</ul>
					</div><!--#.productSmall END-->
				
				
				</div><!--#pdLeft END-->
				<div id="pdRight">
					<h1>{%DB_NAME%}</h1>
					<div class="price">
						<p><span>{%PIYASA_FIYAT%}</span></p>
						<p>{%URUN_FIYAT%}</p>
					</div><!-- .price END -->
					<div class="clear"></div>
					
					<div id="others">
						{%FUNC_oncekiUrun%}
					</div><!--#others END-->
					
					<div class="description">
						<p>{%DB_ONDETAY%}</p>
					</div>
					
					
					
					{%URUN_SECIM_LISTE%}
					
					<div class="option">
						<label>Adet</label>
						{%ADET_FORM%}
					</div><!-- .option END -->
					
					<a href="#" class="addBasket" style="float:left" onclick="{%SEPETE_EKLE_LINK%}">Sepete Ekle</a>
					
					<div class="clear"></div>
					
					<!---div class="share">
						<a href="#" class="friend" onclick="{%ARKADASIMA_GONDER_CLICK%}">Arkadaşınla Paylaş</a>
						<a href="#" class="sFacebook">Facebook'ta Paylaş</a>
						<a href="#" class="sTwitter">Twitter'da Paylaş</a>
					</div---><!-- .share END -->



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
					
					
					
					<!--div class="info">
						<h4>Teslimat Şartları</h4>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum hasbeen the industry's standard dummy text ever since the 1500s, when an unknown printer took  a galley of type and scrambled it to make a type specimen book.  </p>
					</div---><!-- .info END -->
					
					<!--div class="info">
						<h4>İade</h4>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum hasbeen the industry's standard dummy text ever since the 1500s, when an unknown printer took  a galley of type and scrambled it to make a type specimen book.  </p>
					</div---><!-- .info END -->

<!-- Tabs --->

                	<!--div id="details" class="details">
                        {%DB_DETAY%}
                        </div--->
{%TAB_MENU%} 
                       
<!-- Tabs end--->


				</div><!--#pdRight END-->
				<div class="clear"></div>
			</div><!--#proDetails END-->