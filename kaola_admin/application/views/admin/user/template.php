<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<?php foreach ($styles as $style => $media) echo HTML::style($style, array('media' => $media), NULL, TRUE), "\n" ?>

<?php foreach ($scripts as $script) echo HTML::script($script, NULL, NULL, TRUE), "\n" ?>
<script>
	$(function(){
		$a= document.documentElement.clientHeight;
		$b = document.body.clientHeight;
		if($b>$a)
		{
			$c= $b-59;
		}
		else{
			$c= $a-59;
		}
		$(".sdk_conleft").css("height",$c+"px");
	})
</script>
</head>

<body>
<?php echo $content_view;?> 
<!--底部-->
</body>
</html>
