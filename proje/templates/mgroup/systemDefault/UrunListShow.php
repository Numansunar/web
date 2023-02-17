								<li>
									<a href="index.php?urunID={%DB_ID%}"><img class="img bd-gray" src="include/resize.php?path=images/urunler/{%DB_RESIM%}&width=65" alt="{%URUN_BASLIK%}"/></a>
									<div class="text" style="padding-left:10px; cursor:pointer" onclick="window.location='index.php?urunID={%DB_ID%}';">
										<p>{%URUN_BASLIK%}</p>
										<strong class="price mini"><span class="gray">{%PIYASA_FIYAT%} {%URUN_FIYAT_BIRIM2%}</span> yerine <span class="orange">{%URUN_FIYAT_KDV_DAHIL%} {%URUN_FIYAT_BIRIM2%}!</span></strong>
									</div>
								</li>