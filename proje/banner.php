<?
include('include/all.php');
my_mysql_query("update bannerlar set hit = (hit + 1) where ID='".$_GET['ID']."'");
$url = hq("select url from bannerlar where ID='".$_GET['ID']."'");
header('location:'.$url);
?>