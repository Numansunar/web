<?php echo $transnum;
$search=$_POST['search'];
$len=strlen($search);
$sql="select * from product where product_name ='$search'";
$res=executequery($sql);
?>
<div class="search_first">
	<div class="filter">
		<h3>FILTER BY:</h3>
		<form name="" >
			<?php 
			while($data1=mysql_fetch_assoc($res)){
				$brand = $data1['brand'];
				$bsql = "SELECT brand_image FROM brand WHERE brand_name='$brand'";
				$bres = executequery($bsql);
				$bdata = mysql_fetch_object($bres);
				$bimg = $bdata->brand_image;?>
			<ul class="brand">BRAND
				<li><a href="index.php?page=brand&brandname=<?php echo  $data1['brand'];?>&brand_img=<?php echo $bimg;?>"><?php echo $data1['brand'];?></a></li>
			</ul>
			<?php }?>
		</form>
		<div class="first">
	<h3>PRICE SLIDER:</h3>
		<form action="index.php?page=product-single-rangesearch&transnum=<?php echo $transnum;?>" method="post">
			<div>
			<input type=range min=100 max=5000 value=100  step=10  onchange="outputUpdate(value)">
			</div>
			<div>
			<input type="text" id="volume" name="rangevalue" value="100">
			</div>
			<div>
			<input type="submit" value="Search Product">
			</div>
		</form>
		</div><!--end of first-->
	</div>
	<div class="sort">
		<ul>VIEW
			<li>Popular | New | Discount | Price: Low High</li>
		<ul>
	</div>
 	<div class="products" id="data_product">	
 		<div id="cbp-pgcontainer" class="cbp-pgcontainer">
			<ul class="cbp-pggrid">	
 			<?php 
			$sql1="select * from product where product_name ='$search'";
			$res1=executequery($sql1);
			$rows=mysql_num_rows($res1);
			if($rows>=1){
				while($data=mysql_fetch_assoc($res1)){?>
					<?php if(!empty($data['product_top'])) {?>
					<?php /* <img src="userfiles/catimages/productimg/<?php echo $data['product_top']; ?>" height="360" width="150"><br>
		                 <ul  class="prod"><li ><?php echo $data['product_name'];?></li>
		                	<li>Price=Rs.<?php echo $data['price'];?></li>
		                	<?php if($data['qty']>0){?>
		                	<li>Only<?php echo $data['qty'];?> available..<a href=""><h3>ADD TO CART</h3></a><?php }
		                	else {echo "Out of stock";}?></li>
		                </ul>
		                 */?>
							  <?php $prodid = $data['product_id'];
							  $prod_img = $data['product_top'];
							  $prod_img1 = $data['product_front'];
							  $price = $data['price'];
							  $prod_name = $data['product_name'];?>
								<li>
									<div class="cbp-pgcontent">
										<span class="cbp-pgrotate">Rotate Item</span>
										<div class="cbp-pgitem">
											<div class="cbp-pgitem-flip">
												<a href="store/index.php?pid=<?php echo $prodid; ?>">
													<img src="userfiles/catimages/productimg/<?php echo $prod_img;?>" width="360px" height="150px" />
													<?php if($prod_img1):?>
													<img src="userfiles/catimages/productimg/<?php echo $prod_img1;?>" width="360px" height="150px"/>
													<?php endif;?>
												</a>
											</div><!--cbp-pgitem-flip-->
										</div><!-- /cbp-pgitem -->
										<ul class="cbp-pgoptions">
			 								<li class="cbp-pgoptfav">Favorite</li>
											<?php echo '<a rel="facebox" href="store/orderpage.php?pid='.$prodid.'&trnasnum='.$transnum.'"><li class="cbp-pgoptcart"></li></a>';?>

										</ul><!-- cbp-pgoptions -->
									</div><!-- cbp-pgcontent -->
									<div class="pginfo"><a href="store/index.php?pid=<?php echo $prodid; ?>">
										<h3><?php echo $prod_name;?></h3>
										<span class="pgprice">$<?php echo $price;?></span></a>
									</div>
								</li>
				</ul><!-- /cbp-pggrid -->
		</div><!-- /cbp-pgcontainer -->
	</div><!--end of products-->
					<?php }//end of if
				}//end of while
				 	}//end of if
			 else{
				$arr=array($search);
				if($len==0){?>
					<script>
						// alert("Type To Search");
						window.location.replace("index.php");// this line redirects to index if search field is empty
					</script>	
				<?php }
				if($len==1){
					foreach($arr as $a){
						$firstletter=$a[0];
						$secondletter=null;
						$thirdletter= null;}
					}
				elseif($len==2){
					foreach($arr as $a){
						$firstletter=$a[0];
						$secondletter=$a[1];
						$thirdletter= null;}
					}
				elseif($len>=3){
					foreach($arr as $a){
						$firstletter=$a[0];
						$secondletter=$a[1];	
						$thirdletter= $a[2];}	
					}?>
					<div class="products" id="data_product">	
				 		<div id="cbp-pgcontainer" class="cbp-pgcontainer">
							<ul class="cbp-pggrid">	
								<?php $concat1=$firstletter.$secondletter.$thirdletter;
									  $sql1="select * from product where product_name like'$concat1%'";
									  $res1=executequery($sql1);
									  $rows1=mysql_num_rows($res1);
									if($rows1>=1){
										while($data1=mysql_fetch_assoc($res1)){
											if(!empty($data1['product_top'])){?>
								               <?php /*!--  <td><img src="userfiles/catimages/productimg/<?php echo $data1['product_top']; ?>" height="140" width="180"><br>
								                <ul  class="prod"><li><?php echo $data1['product_name'];?></li>
								                	<li>Price=Rs.<?php echo $data1['price'];?></li>
								                	<?php if($data1['qty']>0){?>
								                	<li>Only<?php echo $data1['qty'];?> available..<a href=""><h3>ADD TO CART</h3></a><?php }
								                	else {echo "Out of stock";}?></li></ul>
								                	</td> */?>
												<?php $prodid = $data['product_id'];
													  $prod_img = $data['product_top'];
													  $prod_img1 = $data['product_front'];
													  $price = $data['price'];
													  $prod_name = $data['product_name'];?>
												<li>
													<div class="cbp-pgcontent">
														<span class="cbp-pgrotate">Rotate Item</span>
														<div class="cbp-pgitem">
															<div class="cbp-pgitem-flip">
																<a href="store/index.php?pid=<?php echo $prodid; ?>">
																	<img src="userfiles/catimages/productimg/<?php echo $prod_img;?>" width="360px" height="150px" />
																	<?php if($prod_img1):?>
																	<img src="userfiles/catimages/productimg/<?php echo $prod_img1;?>" width="360px" height="150px"/>
																	<?php endif;?>
																</a>
															</div><!-- end of cbp-pgitem-flip-->
														</div><!-- /cbp-pgitem -->
														<ul class="cbp-pgoptions">
							 								<li class="cbp-pgoptfav">Favorite</li>
															<?php echo '<a rel="facebox" href="store/orderpage.php?pid='.$prodid.'&trnasnum='.$transnum.'"><li class="cbp-pgoptcart"></li></a>';?>
														</ul><!-- cbp-pgoptions -->
													</div><!-- cbp-pgcontent -->
													<div class="pginfo"><a href="store/index.php?pid=<?php echo $prodid; ?>">
														<h3><?php echo $prod_name;?></h3>
														<span class="pgprice">$<?php echo $price;?></span></a>
													</div>
												</li>
							</ul><!-- /cbp-pggrid -->
						</div><!-- /cbp-pgcontainer -->
					</div><!--end of products-->
					</div>
											<?php }//end of if
										}//end of while
									}//end of if
			
									else
										{
											echo "Search Result Not Found";
										}
				}?><!--end of else-->
<div class="clear"></div>

</div><!--end of search_first-->
<div class="price-slider">
		<script>
		function outputUpdate(vol) {
		  var a;
		  a = vol;
		  //document.write(a);
		  document.querySelector('#volume').value = vol;
		  //document.getElementById('total').innerHTML = vol;
		}
		</script>

<style>
.price-slider{
	width:980px;
	height: 120px;
	margin: auto;
	border-style: solid;
}
.first div {
margin: 5px;
height: 30px;
width: 200px;

}
.first h3{
	color:#07839f;
	margin-left: 0px; 
	line-height:0.1em;
	*text-align: center;

}
.first{
	float:left;
	width:200px;
	height:auto;
	margin-top: 15px;
	
}
 .price{
	font-size: 15px;
	color: blue;
	width: 100px;
	margin-left: 0px;
}

.filter .first form{
	width:200px;
	margin: 25px 15px 15px 5px;
}
.first input[type=range], ::-moz-range-track, ::-ms-track {
	-webkit-appearance: none;
	background-color: #3f91e5;
	width: 150px;
	height:80px;
	padding: 4px;
}
.first input[type="text"]{
	margin: 0 0 5px 0;
	width:140px;
	height:30px;
	padding: 4px;
	background:#fff;
	border-radius: 5px;
	border-color: black;}
	
.first_popup input[type="text"]:hover{
	background: #fff;
	border: 1px solid #000;
	border-color: #FFA800;
}
 .first input[type="submit"] {
	background: #FFA800;
	color: #fff;
	font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
	font-size: 14px;
	font-weight: bold;
	padding: 5px;
	text-align: center;
	width: 120px;
	height: 30px;
	cursor:pointer;
	margin:15px 2px 10px 5px;
	border:medium;
	border-radius: 5px;
	outline:none;}
.first input[type="submit"]:hover {
	background: #FFA800;
	border:none;
	outline:none;}
</style>
	


<h3>Search Product By Price</h3>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>  
 <script src="js/script.js"></script>
<div>
	<span id="app_min_price" ></span> 
	<input type="hidden" name="min_price" id="min_price"> 
	<input type="hidden" name="max_price" id="max_price" >
	<input type="hidden" name="transnum" id="transnum" >
	<span id="app_max_price" style="float: right"></span>
	<br /><br />
	<div id="slider_price"></div>
	<br />
<!-- 	<span id="number_results"></span> results found.
 --></div>

<style>
.ui-slider-horizontal .ui-slider-range{width: 10%;}
</style>
</div><!--end of price-slider-->
<div class="clear"></div>
