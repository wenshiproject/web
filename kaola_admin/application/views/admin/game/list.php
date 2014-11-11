<script type="text/javascript">
$(document).ready(function(){
	$("#name").focus(function(){
		$("#id").val('');
	});
	$("#id").focus(function(){
		$("#name").val('');
	});
	$("#tc_quxiao,#tc_close").click(function(){
		$("#tanceng").hide();
	});
})

function giftinfo(game_id){
	var _height=  document.body.clientHeight;
	var _width = document.body.clientWidth;
	$(".bobg").css({"width":_width,"height":_height,"opacity":"0.5"});
	$(".tanceng").show();
	var _top =Math.floor((_height-$(".tc_con").height()-$(document).scrollTop())/2);
	var _left = Math.floor((_width-$(".tc_con").width())/2);
	$(".tc_con").css({"top":_top,"left":_left});
	$("#info").html("");
	$.ajax({
	    url:'/admin/gift/game_gift',// 跳转到 action  
	    data:{
	        game_id : game_id,
	    },
	    type:'POST',    
	    cache:false,    
	    dataType:'json',    
	    success:function(data) {    
	        if(data.code == 1){
		        var str = '';
	        	var json = eval(data.msg);
	        	for(var i=0; i<json.length; i++){
		        	str += '<tr><td>' + json[i].id +'</td><td>' + json[i].name +'</td><td>' + json[i].number +'</td><td>' + json[i].order_num +'</td></tr>'
	        	}
	        	$("#info").html(str);
	        }
	     },
	     error : function() {    
	         alert("异常！");    
	     }    
	});
}
</script>
<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：游戏管理  > 游戏列表</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>名称：<input type="text" class="sdk_zhucetext" name="name" id="name" style="width:80px" value="<?php echo $game_arr['name']?>"/></span>
				<span>ID：<input type="text" class="sdk_zhucetext" name="id" id="id" style="width:80px" value="<?php echo $game_arr['id']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>ID</th>
					<th>名称</th>
					<th>游戏key</th>
					<th>游戏icon</th>
					<th>开发商</th>
					<th>状态</th>
					<th>管理</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td><?php echo $val['name']?></td>
					<td><?php echo $val['key']?></td>
					<td><?php echo $val['key']?></td>
					<td><?php echo $companys[$val['company_id']]['name']?></td>
					<td><?php echo $game_status[$val['game_status']];?></td>
					<td><a href="/admin/game/edit?id=<?php echo $val['id'] ?>">编辑</a><br>
						<a href="javascript:void();" onclick="giftinfo('<?php echo $val['id']?>')">关联奖品信息</a>
					</td>
				</tr>
				<?php endforeach;?>
				<?php endif;?>
			</table>
			<table width="100%">
			<tr align="center">
			<td width="16%" align="center" valign="top">总共有 <b><?php echo $total;?></b> 条数据</td>
			<td align="left" valign="top"><?php echo $pageview;?>&nbsp;</td>
			</tr>
			</table>
			</div>
		</div>
		<div id="code_background"></div>
<!--右侧-->

<div class="tanceng" id="tanceng" style="display:none">
	<div class="tc_con" id="tc_con">
		<div class="tc_contitle"><a href="javascript:void(0);" id="tc_close">关闭</a><h3>关联奖品信息</h3></div>
		<div style="margin: 0 20px;">
			<table cellpadding="0" cellspacing="0" border="0" width="500px" class="sdk_table">
				<tr>
					<th>奖品ID</th>
					<th>奖品名称</th>
					<th>总量</th>
					<th>有效订单数</th>
				</tr>
				<tbody id="info">
				</tbody>
			</table>
		</div>
	</div>
</div>