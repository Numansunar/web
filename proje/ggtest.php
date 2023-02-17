<?
include('include/all.php');
include('include/3rdparty/GittiGidiyor/client.php');
ini_set('display_errors', '1');
error_reporting(E_ALL);
//echo 'veri uzunlugu 1 : '.(int)strlen(file_get_contents('http://dev.gittigidiyor.com:8080/listingapi/ws/IndividualSaleService?wsdl'));
//echo 'veri uzunlugu 2 : '.(int)strlen(file_get_contents('https://dev.gittigidiyor.com:8443/listingapi/ws/IndividualProductService?wsdl'));
$gg = new ggClient();
$catList = $gg->getCategoryVariantSpecs('ck');
//$catList = $gg->getCategoriesHavingVariantSpecs('eua');
echo debugArray($catList);
?>