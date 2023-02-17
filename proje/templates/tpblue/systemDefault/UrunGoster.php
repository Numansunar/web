<style>
.UrunSecenekleri { display:none; }
</style>
<div id="detail">
                	<div id="navigation">
                    	<div id="navLeft">
                            {%BREADCRUMB%}
                            <h2>{%URUN_BASLIK%}</h2>
						</div>
                        <div id="navRight">
                        	<p>Ürün Fiyatı : </p>
                            <p><b>{%URUN_FIYAT_KDV_HARIC%}</b> {%URUN_FIYAT_BIRIM%} + KDV </p>
                            <p><b>{%URUN_FIYAT_KDV_DAHIL_YTL%}</b> TL</p>
                        </div>
                    </div><!--#navigation END-->
                    
                    <div class="clear"></div>
                    <div id="detailLeft">
                    	<a class="lightbox" href="{%URUN_RESIM_SRC_FULLSIZE%}" title="{%DB_NAME%}"><img alt="{%URUN_BASLIK%}" style="cursor:pointer" src="{%URUN_RESIM_SRC%}"></a>
                        <div id="taksitler">
							<center>
							{%URUN_TAKSIT_SECENEKLERI%}
							</center>
                        </div>
                    </div><!--#detailLeft END-->
                    
                    <div id="detailRight">
                    	<div id="detailButtons">
							{%URUN_KULLANICI_SECENEKLERI%}
                        </div>
                        <div class="clear"></div>
                        
                        <div id="detailDesc">
                        	<h3>Ürün Açıklaması</h3>
                        	<p>{%URUN_KISA_ACIKLAMA%}</p>
                        </div>
                        <div class="clear"></div>
                        
                        <div id="options" class="options">
                        	<h3>Ürün Seçenekleri</h3>
                            {%URUN_SECIM%}                   
                        </div>
                        <div class="options">
                        	<h3>Ürün Etiket</h3>
                            {%ETIKET%}                   
                        </div>
                        <div class="clear"></div>
                        <div class="urunMesaj">{%URUN_MESAJ%}</div>
						<div class="clear"></div>
                        <a href="#" title="" id="sepet" onclick="{%SEPETE_EKLE_LINK%}">Sepete At</a>
                        <a href="#" title="" id="hemen" onclick="{%HEMEN_AL_LINK%}">Satın AL</a>						
						
                    </div><!--#detailRight END-->
                    <div class="clear"><br /></div>           
                    
                </div>
				<br /><br />{%TAB_MENU%}
				<div class="tabButtonsContainer">
				 <div onclick="{%ARKADASIMA_GONDER_CLICK%}" class="tabButtons">Arkadaşıma Gönder</div>
				 <div onclick="{%YAZDIR_CLICK%}" class="tabButtons">Sayfayı Yazdır</div>
				 </div>
