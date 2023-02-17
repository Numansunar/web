<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
 <?php  echo generateTemplateHead().'<link rel="stylesheet" href="templates/'.$siteConfig['templateName'].'/login.css" />';?>
 <style type="text/css" media="screen">
  body, html {height: 100%; padding: 0px; margin: 0px;} 
  #outer {width: 100%; height: 100%; overflow: visible; padding: 0px; margin: 0px;} 
  #middle {vertical-align: middle} 
  #centered {width: 100%; margin-left: auto; margin-right: auto; text-align:center;} 
  img { border:0; }
  #forgotPassDiv .td1,.td2,.td3 { text-align:left; }
 </style>  
</head> 
<body> 

 <table id="outer" cellpadding="0" cellspacing="0"> 

  <tr><td id="middle"> 

   <div id="centered"> 

<center>
			<?
				if ($_GET['act']=='register')
				{
				
			if ($_SESSION['userID']) {
				header('location:index.php');
				exit('<script>window.location="index.php";</script>');
			} 
			$out .= generateTableBox('Üyelik Formu',($_POST['data_name']?registerSubmit():generateForm(getRegisterForm(),'','','')),tempConfig('formlar'));
			$out .= "<script>$('.generatedForm').submit(checkRegisterStatus);</script>";	
			echo $out;
				}
				else {
			?>
			<? if ($_GET['cerror']) $login_message = '<div class="error" style="color:white;">Onaylanmamış Kullanıcı Girişi</div>';?>
    		<?=loginScreen($login_message,false);?>
			
			<div style="clear:both;">&nbsp;</div>
			<a href="page.php?act=register" >Üye olmak istiyorum</a> | <a href="#" id="forgotPassLabel">Şifremi unuttum</a>
			<div id="forgotPassDiv">
				<?=($_POST['data_email']?forgotPasswordSubmit():forgotPasswordForm());?>
			</div> <script>
				$('#forgotPassLabel').toggle(function() { $('#forgotPassDiv').show('fast'); return false; },function() { $('#forgotPassDiv').hide('fast'); return false; });
				<?=($_POST['data_email']?"":"$('#forgotPassDiv').hide();");?>
			</script><br></b></td></tr></table>
			</td></tr></table>
			<? } ?>
			<br>
&nbsp;</center>

   </div> 

  </td></tr> 

 </table> 
<script>
 $('.loginForm input').keypress(function(e) {
        if(e.which == 13) {
            jQuery('.loginForm form').submit();
        }
    });
</script>
</body> 
</html>