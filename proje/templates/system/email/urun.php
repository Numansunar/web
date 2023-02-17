<style>
.urunDetay { clear:both; margin-bottom:12px; }
.urunDetay a { color:#333; text-decoration:none; }
.urunDetay .incele { float:right; }
</style>
<div class="urunDetay">
    <h1><a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank">{%DB_NAME%}</a></h1>
    <table>
        <tr><td valign="top">
                <a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank"><img src="{%siteAdresiFull%}/include/resize.php?path=images/urunler/{%DB_RESIM%}&width=200" /></a>
            </td>
            <td valign="top"> 
             	
                <a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank">{%DB_ONDETAY%}</a>
                <hr size="1" style="color:#ccc;" />
                <h2>SADECE <b>{%URUN_FIYAT_KDV_HARIC%}</b> {%URUN_FIYAT_BIRIM%} + KDV</h2>   
                <div class="incele">
                	<a href="{%siteAdresiFull%}/page.php?act=urunDetay&urunID={%DB_ID%}" target="_blank"><img src="{%siteAdresiFull%}/templates/system/email/incele.png" /></a>
                </div>      
            </td>
         </tr>
    </table>
</div>