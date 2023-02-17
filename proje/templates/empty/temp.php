<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo generateTemplateHead(); ?>  
</head> 
<body onload="<?=$siteConfig['onLoad'];?>">
<?php echo $PAGE_OUT; ?>

<?=scriptmenu();?>
<?php echo sepetGoster()?>
<script>tempStart();</script>
</body>
</html>
