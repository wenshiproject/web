<script type="text/javascript">
$(document).ready(function(){
	$("#id").focus(function(){
		$("#keyword").val('');
	});
	$("#keyword").focus(function(){
		$("#id").val('');
	});
})
</script>
<!--右侧-->
	<div class="sdk_right">
		<div class="sdk_rightnav">当前位置：系统消息-大礼包  > 未推送信息</div>
		<div class="sdk_righcon">
			<form action="" method="get">
			<div class="sdk_rightsearch">
				<span>ID：<input type="text" class="sdk_zhucetext" name="id" id="id" style="width:80px" value="<?php echo $search['id']?>"/></span>
				<span>关键字：<input type="text" class="sdk_zhucetext" name="keyword" id="keyword" style="width:80px" value="<?php echo $search['keyword']?>"/></span>
				<input type="submit" name="" class="sdk_rsbtn" id="" value="查看" />
			</div>
			</form>
			<table cellspacing="0" cellpadding="0" border="0" width="100%" class="sdk_table">
				<tr>
					<th>ID</th>
					<th>图片</th>
					<th>标题</th>
					<th>消息全文</th>
					<th>添加时间</th>
					<th>管理</th>
				</tr>
				<?php if($rs): ?>
				<?php foreach($rs as $key => $val):?>
				<tr>
					<td><?php echo $val['id']?></td>
					<td>
						<?php if($val['image_path']):?>
						<img src="<?php echo $val['image_path']?>">
						<?php else:?>
						/
						<?php endif;?>	
					<td><?php echo $val['title']?></td>
					<td><?php echo $val['content']?></td>
					<td><?php echo $val['add_time'];?></td>
					<td>
					<a href="/admin/sysmsg/edit?id=<?php echo $val['id'] ?>">编辑</a><br>
					<a href="javascript:void(0);" onclick="op('<?php echo $val['id']?>','del')">删除</a><br>
					<a href="javascript:void(0);" onclick="op('<?php echo $val['id']?>','push')">推送</a><br>
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
<script>
function op(id,op){
	$.ajax({
	    url:'/admin/sysmsg/op',// 跳转到 action  
	    data:{
	        id : id,
	        op : op
	    },
	    type:'POST',    
	    cache:false,    
	    dataType:'json',    
	    success:function(data){   
	        if(data.msg == 1){
		        window.location.reload();
	        }else{
		        alert("操作失败");
		        return false;
	        }
	     },
	     error : function() {    
	         alert("异常！");    
	     }    
	});
}
</script>