<?php
$search=$_POST['search'];
$len=strlen($search);
$sql="select * from product where product_name ='$search'";
$res=executequery($sql);
?>
<div class="search_first">
	<div class="filter">
		<h2>FILTER BY</h2>
		<form name="" >
			<?php 
			while($data1=mysql_fetch_assoc($res)){?>
			<ul class="brand">BRAND
				<li><input type="checkbox" name="brand" value="<?php echo $data1['brand'];?>"><?php echo $data1['brand'];?></li>
			</ul>
			<h5>PRICE:Rs.<?php echo $data1['price'];?></h5>
			<?php }?>
		</form>
	</div>
	<div class="sort">
		<ul>VIEW
			<li>Popular | New | Discount | Price: Low High</li>
		<ul>
	</div>
 	<div class="products">	
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
					<div class="products">	
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
<div class="clear"></div>
</div><!--end of search_first-->
<div class="price-sider">
	<div class="first">
		<p>price slider:</p>
		<!-- <label for=fader>Volume</label>-->
		<form action="index.php?page=product-single-rangesearch" method="post">
			<input type=range min=100 max=5000 value=100 id=fader step=10 onchange="outputUpdate(value)">
			<input type="text" id="volume" name="rangevalue" value="100">
			<!-- <output for=fader name=rangevalue id=volume>100</output> -->
			<input type="submit" value="Search Product">
		</form>

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
	margin: auto;
	border-style: solid;
}
.first p{
	font-size: 15px;
	color: blue;
	width: 100px;
	margin-left: 0px;
}
.first{
	float:left;
	width:40%;

}
form{
	width:250px;
	margin: auto;
}
input[type=range], ::-moz-range-track, ::-ms-track {
-webkit-appearance: none;
background-color: #3f91e5;
width: 120px;
height:20px;
}
</style>
	</div><!--end of first-->
</div><!--end of price-slider-->
<div class="clear"></div>


New code for price slider:::::
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>  
 <script src="js/script.js"></script>
<div>
	<span id="app_min_price" ></span> 
	<input type="hidden" name="min_price" id="min_price"> <input type="hidden" name="max_price" id="max_price" >
	<span id="app_max_price" style="float: right"></span>
	<br /><br />
	<div id="slider_price"></div>
	<br />
	<span id="number_results"></span> results found.
</div>
<style>
.ui-slider-horizontal .ui-slider-range{width: 10%;}
</style>

<div class="clear"></div>
