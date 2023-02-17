d			<div class="primary-box">
				<div class="pb-left-column hidden-xs col-lg-7 hidden-sm hidden-md">
					<div class="product-image">
						<div class="product-img-thumb">
							{%URUN_RESIM_LIST%}
							<div class="clearfix"></div>
						</div>
						<div class="product-full">
							<div class="catalog-item-ribbons">
								{%func-data_kargobeles%}
								{%func-data_tukendim%}
								{%func-data_indirimde%}
								{%func-data_yeniUrun%}
							</div>
							<div class="buttons">
								<a class="addtowishlist" href="#" onclick="{%ALARM_LISTEM_CLICK%}"><i class="material-icons">favorite_border</i></a>
							</div>

							 <a href="images/urunler/{%DB_RESIM%}" title="{%URUN_BASLIK%}" class="lightbox">
							 	{%func-data_tukendimBadge%}
							 	{%func-data_desktopProductImg%}
							 </a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<div class="pb-left-column col-xs-12 hidden-lg">
					<div class="product-image">
						<div class="product-full">
							<div class="catalog-item-ribbons">
								{%func-data_kargobeles%}
								{%func-data_tukendim%}
								{%func-data_indirimde%}
								{%func-data_yeniUrun%}
							</div>
							<div class="buttons">
								<a class="addtowishlist" href="#" onclick="{%ALARM_LISTEM_CLICK%}"><i class="material-icons">favorite_border</i></a>
							</div>
							
							<div class="mobileSliderwrap">{%func-data_mobileProductSlider%}</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<div class="pb-right-column col-xs-12 col-lg-5">
					<h1 class="product-name">{%DB_NAME%}</h1>
					{%func-data_urunDuzenleAdmin%}
					<div class="info-orther">
						<p>Ürün Kodu: <strong>{%func-data_urunKod%}</strong></p>
						<p>Marka: <strong><a href="page.php?act=kategoriGoster&markaID={%func-data_markaID%}">{%MARKA_ADI%}</a></strong></p>

						<div class="rating">
							<div class="stars">
								<i class="material-icons">star</i>
								<i class="material-icons">star</i>
								<i class="material-icons">star</i>
								<i class="material-icons">star</i>
								<i class="material-icons">star</i>
								<small>{%YORUM_SAYISI%}</small> <small>Müşterilerimizin Yorumu</small>
							</div>
						</div>

						<div class="clearfix"></div>

						{%func-data_minSiparisInfo%}
						
					</div>
					
					<div class="product-price-group">
					{%func-data_indirimOran%}
					<div class="pricex">
						<span class="old-price" data-oldprice='{%DB_PIYASAFIYAT%}'>{%URUN_PIYASA_FIYAT%}</span>
						<span class="price">{%URUN_FIYAT_KDV_DAHIL%} {%URUN_FIYAT_BIRIM%}</span>
					</div>
					<div class="clearfix"></div>
					</div>
					
					<div class="clearfix"></div>
					
					{%func-data_urunStockStatus%}

					<div class="clearfix"></div>
					
					<div class="urunSecimBlock form-option">
						{%URUN_SECIM_LISTE%}
					</div>
					
					<div class="clearfix"></div>

					<div class="durumlar">{%func-data_hizli_kargo%} {%func-data_ucretsiz_kargo%}</div>
															
					<div class="form-action">
						<div class="attributes">
							<div class="attribute-list product-qty">
								<div class="qty">
									{%ADET_FORM%}
								</div>
							</div>
						</div>
						<div class="button-group">
							<a class="btn-add-cart" href="#" onclick="{%SEPETE_EKLE_LINK%}"><i class="material-icons">shopping_cart</i> SEPETE EKLE</a>
							<a class="btn-add-cart hemanalbtn" href="#" onclick="{%HEMEN_AL_LINK%}"><i class="fa fa-share"></i> HEMEN AL</a>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="clearfix"></div>

					<div class="kargosayac">{%func-data_kargoSuresi%}</div>

					<div class="clearfix"></div>

					<div class="userTools margin-top-10">{%URUN_KULLANICI_SECENEKLERI%}</div>

					<!--div class="form-share"></div--->
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>

			</div>
			
			<div class="clearfix"></div>
			
			<div class="product-tab">
				<ul class="nav-tab">
					<li class="active">
						<a aria-expanded="false" data-toggle="tab" href="#aciklama"><span class="material-icons">receipt</span> ÜRÜN AÇIKLAMASI</a>
					</li>
					<li>
						<a data-toggle="tab" href="#odeme"><span class="material-icons">credit_card</span> ÖDEME BİLGİLERİ</a>
					</li>
					<li>
						<a data-toggle="tab" href="#teslimat"><span class="material-icons">local_shipping</span> TESLİMAT VE İADE</a>
					</li>
					<li>
						<a data-toggle="tab" href="#yorumlar"><span class="material-icons">comment</span> MÜŞTERİ YORUMLARI</a>
					</li>
				</ul>
				<div class="tab-container">
					
					<div id="aciklama" class="tab-panel tabdesc active">
						 {%DB_DETAY%}
					</div>
					
					<div id="odeme" class="tab-panel">
						{%TAB_TAKSIT%}
						<div class="clearfix"></div>
					</div>
					
					<div id="teslimat" class="tab-panel">
						<p>Temel kural olarak aldığınız ürünü teslimat tarihinden itibaren 14 iş günü içerisinde firmamızın düzenlemiş olduğu faturanız ve iade sebebinizi içeren bir not eki ile iade edebilirsiniz. </p>
						 <p>* İADE ÜRÜNLERİNİZİ MUTLAKA İADE SEBEBİNİZİ BİLDİREN BİR NOT EKİ VE FATURANIZ İLE GÖNDERİNİZ.
						* İade etmek istediğiniz ürünün faturası kurumsal ise, geri iade ederken kurumun düzenlemiş olduğu iade faturası ile birlikte göndermeniz gerekmektedir. İade faturası, kargo payı dahil edilmeden ( ürün birim fiyatı + KDV şeklinde ) kesilmelidir. Faturası kurumlar adına düzenlenen sipariş iadeleri İADE FATURASI kesilmediği takdirde tamamlanamayacaktır.</p>
						 <p>385 SAYILI VERGİ USUL KANUNU GENEL TEBLİĞİ UYARINCA YENİ UYGULAMA!</p>
						 <p>Eğer vergi mükellefi değilseniz, almış olduğunuz ürünü iade ederken elinizde bulunan firmamıza ait faturada ilgili iade bölümündeki bilgileri eksiksiz olarak doldurduktan sonra imzalayarak ürün ile birlikte bize geri göndermeniz gerekmektedir. Aksi takdirde iade işleminiz tamamlanmayacaktır. Genel iade şartları aşağıdaki gibidir; </p>
						 <p>* İadeler mutlak surette orjinal kutu veya ambalajı ile birlikte yapılmalıdır.
						* Tekrar satılabilirlik özelliğini kaybetmiş, başka bir müşteri tarafından satın alınamayacak durumda olan ürünlerin iadesi kabul edilmemektedir.
						* İade etmek istediğiniz ürün ile birlikte orijinal fatura (sizdeki bütün kopyaları) ve iade sebebini içeren bir dilekçe göndermeniz gerekmektedir.
						* İade etmek istediğiniz ürün/ürünlerin kargo ücreti firmamız tarafından karşılanmaktadır..
						</p>
					</div>
					
					<div id="yorumlar" class="tab-panel">
					   {%TAB_YORUM%}
					</div>

				</div>
			</div>