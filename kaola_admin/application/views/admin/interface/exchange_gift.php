<!--右侧-->
<style>
<?php if($type == 1):?>
table {font-size:30px;}
.search_input{ width:550px; height:100px;padding-left:10px;}
.search_input button{ float:left;width:171px; height:86px; border:none; background:url(/media/images/get_gift_ipad.png) no-repeat; color:#fff; font-size:30px; font-weight:bold}
.search_input input{ float:left; width:350px; height:86px; background:url(/media/images/input_ipad.png) no-repeat; border:none; padding:0 0 0 5px;font-size:30px;}
<?php else:?>
.search_input{ width:225px; height:50px; padding-left:0px;}
.search_input button{ float:left;width:70px; height:35px; border:none; background:url(/media/images/get_gift.png) no-repeat; color:#fff; font-size:14px; font-weight:bold}
.search_input input{ float:left; width:145px; height:35px; background:url(/media/images/input.png) no-repeat; border:none; padding:0 0 0 5px;}
<?php endif;?>
</style>
<script type="text/javascript">
;(function() {
	if (window.WebViewJavascriptBridge) { return }
	var messagingIframe
	var sendMessageQueue = []
	var receiveMessageQueue = []
	var messageHandlers = {}
	
	var CUSTOM_PROTOCOL_SCHEME = 'wvjbscheme'
	var QUEUE_HAS_MESSAGE = '__WVJB_QUEUE_MESSAGE__'
	
	var responseCallbacks = {}
	var uniqueId = 1
	
	function _createQueueReadyIframe(doc) {
		messagingIframe = doc.createElement('iframe')
		messagingIframe.style.display = 'none'
		messagingIframe.src = CUSTOM_PROTOCOL_SCHEME + '://' + QUEUE_HAS_MESSAGE
		doc.documentElement.appendChild(messagingIframe)
	}

	function init(messageHandler) {
		if (WebViewJavascriptBridge._messageHandler) { throw new Error('WebViewJavascriptBridge.init called twice') }
		WebViewJavascriptBridge._messageHandler = messageHandler
		var receivedMessages = receiveMessageQueue
		receiveMessageQueue = null
		for (var i=0; i<receivedMessages.length; i++) {
			_dispatchMessageFromObjC(receivedMessages[i])
		}
	}

	function send(data, responseCallback) {
		_doSend({ data:data }, responseCallback)
	}
	
	function registerHandler(handlerName, handler) {
		messageHandlers[handlerName] = handler
	}
	
	function callHandler(handlerName, data, responseCallback) {
		_doSend({ handlerName:handlerName, data:data }, responseCallback)
	}
	
	function _doSend(message, responseCallback) {
		if (responseCallback) {
			var callbackId = 'cb_'+(uniqueId++)+'_'+new Date().getTime()
			responseCallbacks[callbackId] = responseCallback
			message['callbackId'] = callbackId
		}
		sendMessageQueue.push(message)
		messagingIframe.src = CUSTOM_PROTOCOL_SCHEME + '://' + QUEUE_HAS_MESSAGE
	}

	function _fetchQueue() {
		var messageQueueString = JSON.stringify(sendMessageQueue)
		sendMessageQueue = []
		return messageQueueString
	}

	function _dispatchMessageFromObjC(messageJSON) {
		setTimeout(function _timeoutDispatchMessageFromObjC() {
			var message = JSON.parse(messageJSON)
			var messageHandler
			
			if (message.responseId) {
				var responseCallback = responseCallbacks[message.responseId]
				if (!responseCallback) { return; }
				responseCallback(message.responseData)
				delete responseCallbacks[message.responseId]
			} else {
				var responseCallback
				if (message.callbackId) {
					var callbackResponseId = message.callbackId
					responseCallback = function(responseData) {
						_doSend({ responseId:callbackResponseId, responseData:responseData })
					}
				}
				
				var handler = WebViewJavascriptBridge._messageHandler
				if (message.handlerName) {
					handler = messageHandlers[message.handlerName]
				}
				
				try {
					handler(message.data, responseCallback)
				} catch(exception) {
					if (typeof console != 'undefined') {
						console.log("WebViewJavascriptBridge: WARNING: javascript handler threw.", message, exception)
					}
				}
			}
		})
	}
	
	function _handleMessageFromObjC(messageJSON) {
		if (receiveMessageQueue) {
			receiveMessageQueue.push(messageJSON)
		} else {
			_dispatchMessageFromObjC(messageJSON)
		}
	}

	window.WebViewJavascriptBridge = {
		init: init,
		send: send,
		registerHandler: registerHandler,
		callHandler: callHandler,
		_fetchQueue: _fetchQueue,
		_handleMessageFromObjC: _handleMessageFromObjC
	}

	var doc = document
	_createQueueReadyIframe(doc)
	var readyEvent = doc.createEvent('Events')
	readyEvent.initEvent('WebViewJavascriptBridgeReady')
	readyEvent.bridge = WebViewJavascriptBridge
	doc.dispatchEvent(readyEvent)
})();


function connectWebViewJavascriptBridge(callback) {
	if (window.WebViewJavascriptBridge) {
		callback(WebViewJavascriptBridge)
	} else {
		document.addEventListener('WebViewJavascriptBridgeReady', function() {
			callback(WebViewJavascriptBridge)
		}, false)
	}
}

var bridgejs = null;
connectWebViewJavascriptBridge(function(bridge) {
	var uniqueId = 1;
	bridgejs = bridge;
	bridge.init(function(message, responseCallback) {
		var data = { 'Javascript Responds':'Wee!' }
		responseCallback(data)
	})
	bridge.registerHandler('testJavascriptHandler', function(data, responseCallback) {
		var responseData = { 'Javascript Says':'Right back atcha!' }
		responseCallback(responseData)
	})
})
	
    var xmlHttpRequest = null;
    function ajaxRequest()
    {
        if(window.ActiveXObject) // IE浏览器
        {
            xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else if(window.XMLHttpRequest) // 除IE以外的其他浏览器
        {
            xmlHttpRequest = new XMLHttpRequest();
        }
        if(null != xmlHttpRequest)
        {
            var game_id = document.getElementById("game_id").value;
            var gift_id = document.getElementById("gift_id").value;
            var phone = document.getElementById("phone").value;
            xmlHttpRequest.open("POST", "/admin/interface/exchange_rs", true);
            xmlHttpRequest.onreadystatechange = ajaxCallBack;
            xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xmlHttpRequest.send("game_id=" + game_id + "&gift_id=" + gift_id + "&phone=" + phone);    
        }
    }
    function ajaxCallBack()
    {
        if(xmlHttpRequest.readyState == 4)
        {
            if(xmlHttpRequest.status == 200)
            {
                var data1 = xmlHttpRequest.responseText;
                bridgejs.send(data1, function(responseData) {
				})
            }
        }
    }
</script>
	<div style="border: 0;">
	<form action="" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr><td><img src="<?php echo $rs['broadcast_img_path'];?>"></td></tr>
			<tr align="center"><td class="search_input">
			<input type="hidden" id="game_id" name="game_id" value="<?php echo $game_id;?>"/><input id="gift_id" type="hidden" name="gift_id" value="<?php echo $gift_id;?>"/>
			<input type="text" name="phone" id="phone"  placeholder="输入手机号码" /><button type="button" id="button" value="" onclick="ajaxRequest()">获取</button></td>
			</tr>
		</table>
	</form>
	</div><div id='log'></div>
<!--右侧-->