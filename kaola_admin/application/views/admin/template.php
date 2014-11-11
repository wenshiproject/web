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
<div class="sdk_topcon">
	<div class="sdk_logo">
		当前用户：<b><font color="blue">admin</font></b>
		<a href="<?php echo URL::site('/admin/user/logout');?>"><b><font color="red">退出</font></b></a>
	</div>
</div>
<div class="">
<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr><td width="186" height="100%" valign="top">
<!--左侧-->
	<div class="sdk_conleft">
		<ul class="sdk_cfmenu">
			<?php foreach ($menu as $key => $val): ?>
				<?php if($val['items']):?>
				<li>
					<span><a <?php if($controller == $key){?> class="set" <?php }?> href="javascript:void(0);"><?php echo $val['name'];?></a></span>
					<ul <?php if($controller != $key){?> style="display:none" <?php }?>>
						<?php foreach ($val['items'] as $key1 => $val1):?>
						<?php if($val1['show'] == 1):?>
						<li><a href="<?php echo URL::site('/admin/'.$key.'/'.$key1);?>"><?php echo $val1['name']?></a></li>
						<?php endif;?>
						<?php endforeach;?>
					</ul>
				<li>
				<?php endif;?>
			<?php endforeach; ?>
		</ul>
		<script>
			$(function(){
				$(".sdk_cfmenu > li > span").click(function(){
					var dis = $(this).siblings("ul").css("display");
					if(dis == "block"){
						$(this).siblings("ul").hide();
						$("a",this).removeClass("set");
						$(this).parent().siblings().children("ul").hide();
						$(this).parent().siblings().children("span").children("a").removeClass("set");
						
					}else{
						$(this).siblings("ul").show();
						$("a",this).addClass("set");
						$(this).parent().siblings().children("ul").hide();
						$(this).parent().siblings().children("span").children("a").removeClass("set");
					}
				})
				
				$(".sdk_cfmenu > li > ul a").click(function(){
					$(".sdk_cfmenu > li > ul a").removeClass("action");
					$(this).addClass("action");
				})
			})
		</script>
	</div>
<!--左侧-->
</td>
<td valign="top">
<!--右侧-->
<?php echo $content_view;?>
<!--右侧-->
</td>
</tr>
</table>
</div>
</body>
</html>