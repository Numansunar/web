				<div class="promo">
					<div class="opportunity-box siparis_ver">
						<strong class="title">Günün Fırsatı</strong>
						<h2>Fırsatın Bitmesine <span class="sayac_{%DB_ID%}" id="sayac"><strong>0</strong> saat <strong>0</strong> dakika <strong>0</strong> saniye</span> kaldı</h2>
					</div>
					<div class="text-post">
						<p>{%DB_NAME%}<br />{%DB_ONDETAY%}</p>
					</div>
					<div class="visul-container">
						<img alt="{%URUN_BASLIK%}" style="cursor:pointer; width:450px;" src="images/urunler/{%DB_RESIM%}">
						<div class="aside">
							<div class="green-box siparis_ver" onclick="{%HEMEN_AL_LINK%}">
								<strong>{%URUN_FIYAT_KDV_DAHIL%} <sup style=" font-size:15px;">{%URUN_FIYAT_BIRIM2%}</sup></strong><span>SATIN AL</span>
							</div>
							<div class="friend-box" style="display:none;">
								<a href="#">ARKADAŞINA HEDİYE ET</a>
							</div>
							<div class="brown-box">
								<div class="box-holder">
									<table>
										<tr>
											<th>Değeri</th>
											<th>İndirim</th>
											<th>Kazanç</th>
										</tr>
										<tr>
											<td class="red">{%PIYASA_FIYAT%} {%URUN_FIYAT_BIRIM2%}</td>
											<td class="blue">%{%PIYASA_INDIRIM_ORANI%}</td>
											<td class="green">{%KAZANC%} {%URUN_FIYAT_BIRIM2%}</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="blue-box">
								<div class="box-holder">
									<span ID="SatisYok" style="display:none; font-weight:normal;">
										<h3>Fırsatın gerçekleşebilmesi için <span>{%GRUP_SATIS_KALAN%}</span> kişinin daha alması gerekir.</h3>
									</span>
									<span ID="SatisVar" style="display:none; font-weight:normal;">
										<h3>Bu fırsatı <span>{%GRUP_SATIS_ADEDI%}</span> kişi satın aldı.</h3>
										<div class="text">
											<p>{%DB_MINSATIS%} satış ile fırsat gerçekleşti.</p>
										</div>
									</span>
								</div>
								{%GRUP_SATIS_STYLE%}
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="container-holder">
						<div class="column">
							<div class="title">
								<div class="title-holder">
									<h2 class="text-details">Bu Fırsata Ait Detaylar</h2>
								</div>
							</div>
							{%DB_DATA2%}
						</div>
						<div class="column">
							<div class="title">
								<div class="title-holder">
									<h2 class="text-spotlights">Öne Çıkanlar</h2>
								</div>
							</div>
							{%DB_DATA1%}
						</div>
					</div>
				</div>
				<div class="columns">
					<div class="columns-holder">
						<div class="columns-frame">
							<div class="text">
								{%DB_DETAY%}
							</div>
							<div class="info">
								<div class="cell">
									{%DB_DATA3%}
								</div>
							</div>
						</div>
					</div>
				</div>
                <!-- _ORAN -->
