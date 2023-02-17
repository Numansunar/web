<?php 
include('include/all.php');
if(($_SERVER['HTTPS'] =='off' || !$_SERVER['HTTPS']) && $siteConfig['httpsAktif']) 
{
	redirect('https://'.$_SERVER['HTTP_HOST'].$siteDizini.'login.php');
}
SEO::setIndexHeader();
$loginFile = $_SERVER['DOCUMENT_ROOT'].$siteDizini.'templates/'.$siteConfig['templateName'].'/login.php';
if(file_exists($loginFile))
{
	include($loginFile);
	exit();	
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs" >
<head>

  <?php echo generateTemplateHead(); ?>  
  <!-- Free google font -->
  <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,300,600' rel='stylesheet' type='text/css' />
  <link href="css/login-style.css" rel="stylesheet" type="text/css" />
  
  <script src="js/login.js"></script>
  
  <!-- CSS code for IE Browser -->
  <!--[if lt IE 10]>
    <link href="css/login-style-ie.css" rel="stylesheet" type="text/css" />  
  <![endif]-->
  <style>
  .generatedForm { display:none; }
  #sign-in-form { display:block; }
  </style>
  </head>
  <body>
  
    <!-- If you don't want a logo, delete all of these code -->
    <? if(siteConfig('templateLogo')) { ?>
    <div class='logo'>
      <a href="index.php"><img src="<?php echo slogoSrc('images/logo.png')?>" alt="<?php echo $siteConfig['seo_title']?>" class="logo"/></a>
    </div>
    <? } ?>
    <!-- Till here -->
    
    <div class='form'>
      <h1><?=_lang_titleLogin?></h1>
      <div class='line'></div>
      
      <!-- If you don't want a social buttons, delete all of these code -->
        <?	if (file_exists('include/mod_FacebookConnect.php'))
			{	
				include('include/mod_FacebookConnect.php');
				echo '<div style="margin-left:30px;">'.$facebookConnect.'</div>';
			}
		?>
      <!-- Till here -->
      <div style="clear:both"></div>
      
      <!-- Span class ie-placeholder is there for IE browser. IE doesn't support placeholder attribute -->
      <form class='input-form' id='sign-in-form' action='' method="post">
        <span class='ie-placeholders'><?='._lang_epostaAdresiniz.'?></span><input type='text' id='ipt-login' placeholder='Kullanıcı adı' name="username" value="<?php echo $_POST['username']?>" />
        <span class='ie-placeholders'><?=_lang_sifreniz?></span><input type='password' id='ipt-password' placeholder='Şifre' name="password"/>
        <div class="clear-space"></div>
        <a class='forgotten-password-link' href='#'><?=_lang_sifremiUnuttum?></a>
        <input type='submit' class='btn-sign-in btn-orange' value='<?=_lang_girisYap?>' />
      </form>
      
      <!-- FORGOTTEN PASSWORD -->
      <div class='forgotten-password-box' <?php if($_POST['data_email']) echo 'style="display:block;"'?>>
        <form class='input-form' id='forgotten-password-form' action='' method="post">
          <span class='ie-placeholders'><?=_lang_epostaAdresiniz?></span><input type='text' id='ipt-fp-email' class='forgotten-password-email' placeholder='E-posta' name="data_email" />
          <input type='submit' class='btn-orange' value='Gönder' /><br /><br />
          <?php if($_POST['data_email']) forgotPasswordSubmit()?>
          <?php if($_POST['data_email']) echo _lang_sifreGonderildi?>
        </form>
      </div>
      <div style="clear:both;"></div>
      
      <!-- ERROR STATE -->
      <div class='error-box red' <?php echo ($login_message?'style="display:block;"':'');?>>
        <span class='error-message'><?php echo $login_message;?></span>
      </div>
           
      <div class='sign-link'>
        <?=_lang_kayitBaslik?> <a href='<?php echo slink('register')?>'><?=_lang_kayitUcretsizKayit?></a>
      </div> 
    </div>
    
  </body>
</html>