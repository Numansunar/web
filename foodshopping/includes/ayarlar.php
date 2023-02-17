<?php
$servername = "localhost";
$database = "foodshopping";
$username = "root";
$password = "";
// Create connection
$baglan=mysqli_connect("localhost","root","","foodshopping");
// Check connection
if (!$baglan) {
    die("Bağlantı Başarısız " . 
mysqli_connect_error());
}
echo "Bağlantı Başarılı";
mysqli_close($baglan);

?>