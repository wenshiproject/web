<div class="sdk_zhuce">
	<form id="login_form" action="login?do=login" method="post">
    <div class="sdk_zhucecon">
        <div class="sdk_zczh"><span>账号：</span><input type="text" class="sdk_zhucetext" id="" name="uname" value="" /></div>
        <div class="sdk_zcmm"><span>密码：</span><input type="password" class="sdk_zhucetext" id="" name="passwd" value="" /></div>
        <div class="sdk_zcyz"><span>验证码：</span><input type="text" class="sdk_zhucetext" style="width: 45px;" id="" name="yanz" value="" />&nbsp;&nbsp;&nbsp;&nbsp;<img id="code" src="/admin/yanz" alt="看不清楚，换一张" style="cursor: pointer; vertical-align:middle;" onClick="newgdcode(this,'/admin/yanz')"/>
        </div>
        <div class="sdk_zcbtn"><input type="submit" class="sdk_zhucebtn" id="" name="" value="登陆" /></div>
    </div>
    </form>
</div>
<script language="javascript">
function newgdcode(obj,url) {  
	obj.src = url+ '?nowtime=' + new Date().getTime();  
	//后面传递一个随机参数，否则在IE7和火狐下，不刷新图片  
	}  
</script>