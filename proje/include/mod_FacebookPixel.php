<?
if (!$_SESSION['orandStr'])
    $_SESSION['orandStr'] = $_SESSION['randStr'];
$orandStr = $_SESSION['orandStr'];

function facebookPixelSearchID()
{
    $q = getSearchQuery($_GET['str']);
    while ($d = my_mysql_fetch_array($q)) {
            $ID[] = "'" . $d['ID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixelCatID()
{
    $q = my_mysql_query("select * from urun where (catID='" . $_GET['catID'] . "' OR showCatIDs like '%|" . $_GET['catID'] . "|%') AND active = 1");
    while ($d = my_mysql_fetch_array($q)) {
            $ID[] = "'" . $d['ID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixelBasket($randStr)
{
    $q = my_mysql_query("select urunID from sepet where randStr = '" . $randStr . "' AND adet > 0");
    while ($d = my_mysql_fetch_array($q)) {
            $ID[] = "'" . $d['urunID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixel()
{
    global $tamamlandi, $orandStr;
    $out = '';
    switch ($_GET['act']) {
        case 'urunDetay':
            $out .= "<script type='text/javascript'>
						fbq('track', 'ViewContent', {
						content_ids: ['" . urun('ID') . "'],
						content_type: 'product',
						value: " . str_replace(',', '', my_money_format('', YTLfiyat(urun('fiyat'), urun('fiyatBirim')))) . ",
						currency: 'TRY'
						});
						</script>";
            break;
        case 'kategoriGoster':
            $out .= "<script type='text/javascript'>
					fbq('track', 'ViewCategory', {
					content_category: '" . str_replace('&raquo;', '>', strip_tags(breadCrumb())) . "',
					content_ids: [" . facebookPixelCatID() . "],
					content_type: 'product',
					});
					</script>";
            break;
        case 'sepet':
            //	if($_GET['op'] == 'ekle')
            {
                $out .= "<script type='text/javascript'>
						fbq('track', 'AddToCart', {
						content_ids: [" . facebookPixelBasket($_SESSION['randStr']) . "],
						content_type: 'product',
						value: " . str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $_SESSION['randStr']))) . ",
						currency: 'TRY'
						});
						</script>";
            }
            break;
        case 'arama':
            if ($_GET['str']) {
                    $out .= "
					<script type='text/javascript'>
					fbq('track', 'Search', {
					search_string: '" . addslashes(strip_tags($_GET['str'])) . "',
					content_ids: [" . facebookPixelSearchID() . "],
					content_type: 'product'
					});
					</script>";
                }
            break;
        case 'register':
            if (!$_POST['data_name'])
                $out .= "<script type='text/javascript'>
					fbq('track', 'Lead');
					</script>
					 ";
            else
                $out .= "<script type='text/javascript'>
					fbq('track', 'CompleteRegistration');
					</script>
					 ";
            break;
        case 'satinal':
            if ($_GET['op'] == 'odeme' && !$tamamlandi) {
                    $out .= "<script type='text/javascript'>
						fbq('track', 'InitiateCheckout');
						</script>";
                }
            if ($_GET['op'] == 'odeme' && $tamamlandi) {

                    $out .= "<script type='text/javascript'>
					fbq('track', 'Purchase', {
					content_ids: [" . facebookPixelBasket($orandStr) . "],
					content_type: 'product',
					value: " . str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $orandStr))) . ",
					currency: 'TRY'
					});
					</script>
					
					";
                }
            break;
    }
    return $out;
}
?>