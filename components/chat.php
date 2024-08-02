<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Chat</title>
    <style>
        * {
    margin: 0px;
    padding: 0px;
        }
h1,
h2,
h3,
h4,
h5,
h6 {
    font-weight: normal;
}

body {
    font-family: 'Lato', sans-serif;
}

.ui-chat-container {
    position: fixed;
    right: 0px;
    bottom: 0px;
    z-index: 9999;
    border: 1px solid black;
}

.ui-chat-container .btn_chat_lancher {
    display: block;
    width: 61px;
    height: 61px;
    background-color: #c40f22;
    position: absolute;
    right: 20px;
    bottom: 20px;
    z-index: 999;
    border-radius: 40px;
    border: none;
    cursor: pointer;
    outline: none;
    border: 1px solid black;
}
.ui-chat-container .btn_chat_lancher span.open_me {
	display: block;
    width: 100%;
    height: 100%;
    background-size: 35px;
    position: absolute;
    right: 0px;
    bottom: 0px;
    border-radius: 40px;
    cursor: pointer;
    transition: all ease 400ms;
    transform: scale(0) rotate(40deg);
    opacity: 0;
}

.ui-chat-container .btn_chat_lancher span.open_me.active {
	transform: scale(1) rotate(0deg);
    opacity: 1;	
}

.ui-chat-container .btn_chat_lancher span.close_me {
	display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    right: 0px;
    bottom: 0px;
    border-radius: 40px;
    cursor: pointer;
    transition: all ease 400ms;
    transform: scale(0) rotate(40deg);
    opacity: 0;
}

.ui-chat-container .btn_chat_lancher span.close_me:before {
    content: "";
    width: 4px;
    height: 25px;
    background-color: rgba(255, 255, 255, 1);
    border-radius: 4px;
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
}

.ui-chat-container .btn_chat_lancher span.close_me:after {
    content: "";
    width: 4px;
    height: 25px;
    background-color: rgba(255, 255, 255, 1);
    border-radius: 4px;
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
}
.ui-chat-container .btn_chat_lancher span.close_me.active {
	transform: scale(1) rotate(0deg);
    opacity: 1;	
}

.ui-chat-container .btn_chat_lancher:hover,
.ui-chat-container .btn_chat_lancher:focus {
    background:#ea0019;
}

.ui-chat-container .step1_wrapper .close {
    position: absolute;
    width: 25px;
    height: 25px;
    background-color: rgba(0, 0, 0, .1);
    right: 10px;
    top: 10px;
    border-radius: 25px;
    border: none;
    outline: none;
    cursor: pointer;
    z-index: 9999;
}

.ui-chat-container .step1_wrapper .close:before {
    content: "";
    width: 2px;
    height: 15px;
    background-color: rgba(0, 0, 0, .3);
    border-radius: 2px;
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 9999;
    transform: translate(-50%, -50%) rotate(-45deg);
}

.ui-chat-container .step1_wrapper .close:after {
    content: "";
    width: 2px;
    height: 15px;
    background-color: rgba(0, 0, 0, .3);
    border-radius: 2px;
    display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
}

.ui-chat-container .step1_wrapper .close:hover,
.ui-chat-container .step1_wrapper .close:focus {
    background-color: rgba(0, 0, 0, .15);
}

.ui-chat-container .step1_wrapper {
    width: calc(100% - 50px);
    max-width: 385px;
    height: 199px;
    position: fixed;
    bottom: 100px;
    right: 25px;
    background: #fbfbfb;
    border-radius: 10px 10px 12px 12px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.06);
    transition: ease all 300ms;
    transform: translate(0px, 20px);
    pointer-events: none;
    opacity: 0;
}

.ui-chat-container .step1_wrapper.active {
    transform: translate(0px, 0px);
    pointer-events: all;
    opacity: 1;
}

.ui-chat-container .step1_wrapper.active.step2 {
    transform: translate(-20px, 0px);
    pointer-events: none;
    opacity: 0;
}

.ui-chat-container .step1_wrapper .instruction {
    position: relative;
    top: 35px;
}

.ui-chat-container .step1_wrapper .instruction h2 {
    font-family: 'Lato', sans-serif;
    padding-left: 100px;
    font-size: 23px;
    color: rgba(18, 26, 49, 0.91);
}

.ui-chat-container .step1_wrapper .instruction h3 {
    font-family: 'Lato', sans-serif;
    padding-left: 100px;
    font-size: 18px;
    padding-right: 70px;
    padding-top: 5px;
    color: rgba(18, 26, 49, 0.81);
}

.ui-chat-container .step1_wrapper .instruction .contact_logo {
    position: absolute;
    left: 20px;
    top: 7px;
    width: 60px;
    height: 60px;
    border: 1px solid #CCC;
    overflow: hidden;
    border-radius: 50px;
}

.ui-chat-container .step1_wrapper .instruction .contact_logo img {
    width: 100%;
}

.single_textus .chat_now_btn {
    display: block;
    width: 100%;
    height: 45px;
    background: #c40f22;
    position: absolute;
    border-radius: 0px 0px 10px 10px;
    left: 0px;
    bottom: 0px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 16px;
    cursor: pointer;
}
.single_messenger .chat_now_btn {
    display: block;
    width: 100%;
    height: 45px;
    background: #c40f22;
    position: absolute;
    border-radius: 0px 0px 10px 10px;
    left: 0px;
    bottom: 0px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 16px;
    cursor: pointer;
}
.both_messenger_textus .chat_now_btn {
    display: block;
    width: auto;
    min-width: 50%;
    height: 45px;
    background: #c40f22;
    position: absolute;
    border-radius: 0px 0px 0px 10px;
    left: 0px;
    bottom: 0px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 16px;
    cursor: pointer;
}
.ui-chat-container .step1_wrapper.three_messenger_textus_livechat{
  height:auto;
  overflow: hidden;
}
.three_messenger_textus_livechat .chat_now_btn {
    display: block;
    width: auto;
    min-width: 33.33%;
    height: 45px;
    background: #c40f22;
    position: relative;
    float:left;
    border-radius: 0px;
/*     left: 0px; */
    bottom: 0px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 16px;
    cursor: pointer;
    margin-top: 70px;
}
.chat_now_btn:hover,
.chat_now_btn:focus {
    background-color: #ea0019;
}
.single_messenger .chat_now_btn.textus {
	display: none;
}
.single_textus .chat_now_btn.messenger {
	display: none;
}

.single_textus .chat_now_btn.textus {
    left: unset;
    right: 0px;
    border-radius: 0px 0px 10px 10px;
    border-left: 1px solid rgba(123, 30, 30, 0.4);
}

.both_messenger_textus .chat_now_btn.textus {
    left: unset;
    right: 0px;
    border-radius: 0px 0px 10px 0px;
    border-left: 1px solid rgba(123, 30, 30, 0.4);
}


.ui-chat-container .step2_wrapper {
    width: calc(100% - 50px);
    max-width: 385px;
    min-height: 199px;
    position: fixed;
    bottom: 100px;
    right: 25px;
    background: #FFF;
    border-radius: 12px 12px 10px 10px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.06);
    transition: ease all 300ms;
    transform: translateX(20px);
    pointer-events: none;
    opacity: 0;
}

.ui-chat-container .step2_wrapper.active {
    transform: translateX(0px);
    pointer-events: all;
    opacity: 1;
}

.ui-chat-container .step2_wrapper.active.step3 {
    transform: translate(-20px, 0px);
    pointer-events: none;
    opacity: 0;
}

.ui-chat-container .step2_wrapper .header {
    background: #c40f22;
    width: 100%;
    min-height: 40px;
    border-radius: 10px 10px 0px 0px;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    padding-top: 11px;
    box-sizing: border-box;
    text-align: center;
    margin-bottom: 20px;
}

.ui-chat-container .step2_wrapper .input-group {
    min-height: 50px;
    padding-top: 10px;
    padding-left: 15px;
    padding-right: 20px;
    box-sizing: content-box;
}

.ui-chat-container .step2_wrapper .input-group label {
    display: block;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
}

.ui-chat-container .step2_wrapper .input-group input {
    display: block;
    width: 100%;
    height: 40px;
    border-radius: 3px;
    border: 1px solid #CCC;
    margin-top: 10px;
    background-color: #fbfbfb;
    padding: 10px;
    box-sizing: border-box;
    outline-color: #c40f22;
	font-family: 'Lato', sans-serif;
}

.ui-chat-container .step2_wrapper .input-group textarea {
    display: block;
    width: 100%;
    height: 150px;
    border-radius: 3px;
    border: 1px solid #CCC;
    margin-top: 10px;
    max-width: 100%;
    max-height: 150px;
    resize: none;
    background-color: #fbfbfb;
    padding: 10px;
    box-sizing: border-box;
    outline-color: #c40f22;
    font-family: 'Lato', sans-serif;
}

.ui-chat-container .step2_wrapper .input-group span.required {
    color: red;
}

.ui-chat-container .step2_wrapper .input-group span#remaining {
    display: block;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    padding-top: 5px;
}

.error{
	font-size: 12px;
    color: red;
    padding-top: 5px;
    font-family: 'Lato', sans-serif;
    display: none;
}
.error.active{
    display: block;
}

.ui-chat-container .step2_wrapper .input-group button {
    display: block;
    width: 100%;
    height: 45px;
    background: #c40f22;
    border-radius: 3px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    cursor: pointer;
    margin-bottom: 15px;
    margin-top: 10px;
}

.ui-chat-container .step2_wrapper .input-group button:hover,
.ui-chat-container .step2_wrapper .input-group button:focus {
    background-color: #ea0019;
}

.ui-chat-container .step3_wrapper {
    width: calc(100% - 50px);
    max-width: 385px;
    min-height: 199px;
    position: fixed;
    bottom: 100px;
    right: 25px;
    padding: 20px;
    box-sizing: border-box;
    background: #fbfbfb;
    border-radius: 10px 10px 12px 12px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.06);
    transition: ease all 300ms;
    transform: translate(0px, 20px);
    pointer-events: none;
    opacity: 0;
}

.ui-chat-container .step3_wrapper.active {
    transform: translate(0px, 0px);
    pointer-events: all;
    opacity: 1;
}

.ui-chat-container .step3_wrapper .instruction {}

.ui-chat-container .step3_wrapper .instruction h2 {
    font-family: 'Lato', sans-serif;
    padding: 0px;
    padding-bottom: 10px;
    font-size: 23px;
    color: rgba(18, 26, 49, 0.91);
}

.ui-chat-container .step3_wrapper .instruction p {
    font-family: 'Lato', sans-serif;
    padding-left: 100px;
    font-size: 15px;
    padding: 20px 0px;
    padding-top: 5px;
    color: rgba(18, 26, 49, 0.81);
}

.ui-chat-container .step3_wrapper .agree_btn {
    display: block;
    width: 100%;
    height: 45px;
    background: #c40f22;
    border-radius: 3px;
    border: none;
    outline: none;
    color: #FFF;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    cursor: pointer;
    margin-bottom: 0px;
    margin-top: 10px;
}
.ui-chat-container .step3_wrapper .agree_btn.disable {
  pointer-events:none;
  background:#333;
}
.ui-chat-container .step3_wrapper .agree_btn:hover,
.ui-chat-container .step3_wrapper .agree_btn:focus {
    background-color: #ea0019;
}

.ui-chat-container .step3_wrapper .disagree_btn {
    display: block;
    width: 100%;
    height: 45px;
    background-color: transparent;
    border-radius: 3px;
    border: none;
    outline: none;
    color: #6d6d6d;
    font-family: 'Lato', sans-serif;
    font-size: 14px;
    cursor: pointer;
	margin-bottom: 0px;
    margin-top: 0px;
}
.ui-chat-container .step3_wrapper .disagree_btn:hover,.ui-chat-container .step3_wrapper .disagree_btn:focus{
	color: #4a4949;
}
.ui-chat-container .step3_wrapper.active.step4 {
    transform: translate(-20px, 0px);
    pointer-events: none;
    opacity: 0;
}


.ui-chat-container .step4_wrapper {
    width: calc(100% - 50px);
    max-width: 385px;
    min-height: 199px;
    position: fixed;
    bottom: 100px;
    right: 25px;
    padding: 20px;
    box-sizing: border-box;
    background: #FFF;
    border-radius: 10px 10px 12px 12px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.06);
    transition: ease all 300ms;
    transform: translate(0px, 20px);
    pointer-events: none;
    opacity: 0;
}
.ui-chat-container .step4_wrapper .instruction img{
	width: 40px;
    margin-bottom: 20px;
    margin-top: 25px
}
.ui-chat-container .step4_wrapper .instruction {
	text-align: center;
}

.ui-chat-container .step4_wrapper .instruction h2 {
    font-family: 'Lato', sans-serif;
    padding: 0px;
    padding-bottom: 10px;
    font-size: 17px;
    color: rgba(18, 26, 49, 0.91);
}

.ui-chat-container .step4_wrapper .instruction p {
    font-family: 'Lato', sans-serif;
    padding-left: 100px;
    font-size: 17px;
    padding: 20px 0px;
    padding-top: 5px;
    padding-bottom: 0px;
    color: rgba(18, 26, 49, 0.51);
}

.ui-chat-container .step4_wrapper .send_it_btn {
    display: block;
    width: 100%;
    height: 45px;
    background-color: transparent;
    border-radius: 3px;
    border: none;
    outline: none;
    color: #2B95D6;
    font-family: 'Lato', sans-serif;
    font-size: 17px;
    cursor: pointer;
	margin-bottom: 15px;
    margin-top: 0px;
}
.ui-chat-container .step4_wrapper .send_it_btn:hover,.ui-chat-container .step4_wrapper .send_it_btn:focus{
	color: #2176ab;
}

.ui-chat-container .step4_wrapper.active {
    transform: translate(0px, 0px);
    pointer-events: all;
    opacity: 1;
}

.ui-chat-container .step5_wrapper {
    width: calc(100% - 50px);
    max-width: 385px;
    max-height: calc(100vh - 130px);
    height:100vh;
    position: fixed;
    bottom: 100px;
    right: 25px;
    background: #FFF;
    border-radius: 10px;
    box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.06);
    transition: ease all 300ms;
    transform: translateX(20px);
    pointer-events: none;
    opacity: 0;
}
.ui-chat-container .step5_wrapper iframe{
  border:none;
  width:100%;
  height:100%;
  border-radius:10px;
}
.ui-chat-container .step5_wrapper.active {
    transform: translate(0px, 0px);
    pointer-events: all;
    opacity: 1;
}
    </style>
</head>
<body>
<div class="ui-chat-container">
	<button class="btn_chat_lancher">
		<span class="open_me active"></span>
		<span class="close_me"></span>
	</button>
	<!-- Add this class "single_textus" to 'step1_wrapper' to disable messanger btn -->
	<!-- Add this class "single_messenger" to 'step1_wrapper' to disable textus btn -->
  <!-- Add this class "single_livechat" to 'step1_wrapper' to disable textus btn -->
	<!-- Add this class "both_messenger_textus" to 'step1_wrapper' to anable both textus btn & messanger btn -->
  <!-- Add this class "three_messenger_textus_livechat" to 'step1_wrapper' to anable both textus btn & messanger btn -->
	<div class="step1_wrapper three_messenger_textus_livechat">
		<button class="close"></button>
		<div class="instruction">
			<h2>Need Help ?</h2>
			<h3>Click here and start chatting with us !</h3>
			<span class="contact_logo"><img src="https://admin.v12dev.com/youssef/ui_chat/assets/img/profile.jpg"></span>
		</div>
		<!-- <div class="user_check"><img src=""><span class="name"></span><a href="#">Not you ?</a></div> -->
		<button class="chat_now_btn messanger">Chat Now</button>
		<button class="chat_now_btn textus">Text us</button>
    <button class="chat_now_btn livechat">Live Chat</button>
	</div>
	<div class="step2_wrapper">
		<div class="header">Start chatting with us !</div>
		<form class="submit_chat_form">
            <input type="hidden" name="MessageSid" id="MessageSid" value="0">
            <input type="hidden" name="To" id="To" value="+15084526008">
			<div class="input-group">
				<label>Phone number <span class="required">*</span></label>
				<input type="tel" name="From" id="From">
				<span class="error error-tel">invalid phone number</span>
			</div>
			<div class="input-group">
				<label>Question</label>
				<textarea name="Body" id="Body" maxlength="160"></textarea>
				<span id="remaining">160/160 characters remaining.<span>
				<span class="error error-qst">Please enter your question</span>
			</div>
			<div class="input-group">
				<button class="submit_textus" type="submit">Send Message</button>
			</div>
		</form>
	</div>
	<div class="step3_wrapper">
		<div class="instruction">
			<h2>Terms and Conditions</h2>
			<p>I agree to receive text messages from <strong>Santa Clara Motors</strong> representatives and understand that no consent to texting is required for purchase of products or services. </p>
		</div>
		<!-- <div class="user_check"><img src=""><span class="name"></span><a href="#">Not you ?</a></div> -->
		<button class="agree_btn">Agree</button>
		<button class="disagree_btn">Disagree</button>
	</div>
	<div class="step4_wrapper">
		<div class="instruction">
			<img src="assets/img/checked.svg">
			<h2>Text sent to <span class="tel_from"></span> <br>please reply on your phone</h2>
			<!-- <p>If you didn't receive the text</p> -->
		</div>
		<!-- <div class="user_check"><img src=""><span class="name"></span><a href="#">Not you ?</a></div> -->
		<!-- <button class="send_it_btn">Send it Again</button> -->
	</div>
	<div class="step5_wrapper">
    <iframe src="https://admin.v12dev.com/youssef/amp/"></iframe>
  </div>

</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script>
    // jQuery Mask Plugin v1.14.15
// github.com/igorescobar/jQuery-Mask-Plugin
var $jscomp={scope:{},findInternal:function(a,l,d){a instanceof String&&(a=String(a));for(var p=a.length,h=0;h<p;h++){var b=a[h];if(l.call(d,b,h,a))return{i:h,v:b}}return{i:-1,v:void 0}}};$jscomp.defineProperty="function"==typeof Object.defineProperties?Object.defineProperty:function(a,l,d){if(d.get||d.set)throw new TypeError("ES3 does not support getters and setters.");a!=Array.prototype&&a!=Object.prototype&&(a[l]=d.value)};
$jscomp.getGlobal=function(a){return"undefined"!=typeof window&&window===a?a:"undefined"!=typeof global&&null!=global?global:a};$jscomp.global=$jscomp.getGlobal(this);$jscomp.polyfill=function(a,l,d,p){if(l){d=$jscomp.global;a=a.split(".");for(p=0;p<a.length-1;p++){var h=a[p];h in d||(d[h]={});d=d[h]}a=a[a.length-1];p=d[a];l=l(p);l!=p&&null!=l&&$jscomp.defineProperty(d,a,{configurable:!0,writable:!0,value:l})}};
$jscomp.polyfill("Array.prototype.find",function(a){return a?a:function(a,d){return $jscomp.findInternal(this,a,d).v}},"es6-impl","es3");
(function(a,l,d){"function"===typeof define&&define.amd?define(["jquery"],a):"object"===typeof exports?module.exports=a(require("jquery")):a(l||d)})(function(a){var l=function(b,e,f){var c={invalid:[],getCaret:function(){try{var a,r=0,g=b.get(0),e=document.selection,f=g.selectionStart;if(e&&-1===navigator.appVersion.indexOf("MSIE 10"))a=e.createRange(),a.moveStart("character",-c.val().length),r=a.text.length;else if(f||"0"===f)r=f;return r}catch(C){}},setCaret:function(a){try{if(b.is(":focus")){var c,
g=b.get(0);g.setSelectionRange?g.setSelectionRange(a,a):(c=g.createTextRange(),c.collapse(!0),c.moveEnd("character",a),c.moveStart("character",a),c.select())}}catch(B){}},events:function(){b.on("keydown.mask",function(a){b.data("mask-keycode",a.keyCode||a.which);b.data("mask-previus-value",b.val());b.data("mask-previus-caret-pos",c.getCaret());c.maskDigitPosMapOld=c.maskDigitPosMap}).on(a.jMaskGlobals.useInput?"input.mask":"keyup.mask",c.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){b.keydown().keyup()},
100)}).on("change.mask",function(){b.data("changed",!0)}).on("blur.mask",function(){d===c.val()||b.data("changed")||b.trigger("change");b.data("changed",!1)}).on("blur.mask",function(){d=c.val()}).on("focus.mask",function(b){!0===f.selectOnFocus&&a(b.target).select()}).on("focusout.mask",function(){f.clearIfNotMatch&&!h.test(c.val())&&c.val("")})},getRegexMask:function(){for(var a=[],b,c,f,n,d=0;d<e.length;d++)(b=m.translation[e.charAt(d)])?(c=b.pattern.toString().replace(/.{1}$|^.{1}/g,""),f=b.optional,
(b=b.recursive)?(a.push(e.charAt(d)),n={digit:e.charAt(d),pattern:c}):a.push(f||b?c+"?":c)):a.push(e.charAt(d).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));a=a.join("");n&&(a=a.replace(new RegExp("("+n.digit+"(.*"+n.digit+")?)"),"($1)?").replace(new RegExp(n.digit,"g"),n.pattern));return new RegExp(a)},destroyEvents:function(){b.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(a){var c=b.is("input")?"val":"text";if(0<arguments.length){if(b[c]()!==a)b[c](a);
c=b}else c=b[c]();return c},calculateCaretPosition:function(){var a=b.data("mask-previus-value")||"",e=c.getMasked(),g=c.getCaret();if(a!==e){var f=b.data("mask-previus-caret-pos")||0,e=e.length,d=a.length,m=a=0,h=0,l=0,k;for(k=g;k<e&&c.maskDigitPosMap[k];k++)m++;for(k=g-1;0<=k&&c.maskDigitPosMap[k];k--)a++;for(k=g-1;0<=k;k--)c.maskDigitPosMap[k]&&h++;for(k=f-1;0<=k;k--)c.maskDigitPosMapOld[k]&&l++;g>d?g=10*e:f>=g&&f!==d?c.maskDigitPosMapOld[g]||(f=g,g=g-(l-h)-a,c.maskDigitPosMap[g]&&(g=f)):g>f&&
(g=g+(h-l)+m)}return g},behaviour:function(f){f=f||window.event;c.invalid=[];var e=b.data("mask-keycode");if(-1===a.inArray(e,m.byPassKeys)){var e=c.getMasked(),g=c.getCaret();setTimeout(function(){c.setCaret(c.calculateCaretPosition())},a.jMaskGlobals.keyStrokeCompensation);c.val(e);c.setCaret(g);return c.callbacks(f)}},getMasked:function(a,b){var g=[],d=void 0===b?c.val():b+"",n=0,h=e.length,q=0,l=d.length,k=1,r="push",p=-1,t=0,y=[],v,z;f.reverse?(r="unshift",k=-1,v=0,n=h-1,q=l-1,z=function(){return-1<
n&&-1<q}):(v=h-1,z=function(){return n<h&&q<l});for(var A;z();){var x=e.charAt(n),w=d.charAt(q),u=m.translation[x];if(u)w.match(u.pattern)?(g[r](w),u.recursive&&(-1===p?p=n:n===v&&n!==p&&(n=p-k),v===p&&(n-=k)),n+=k):w===A?(t--,A=void 0):u.optional?(n+=k,q-=k):u.fallback?(g[r](u.fallback),n+=k,q-=k):c.invalid.push({p:q,v:w,e:u.pattern}),q+=k;else{if(!a)g[r](x);w===x?(y.push(q),q+=k):(A=x,y.push(q+t),t++);n+=k}}d=e.charAt(v);h!==l+1||m.translation[d]||g.push(d);g=g.join("");c.mapMaskdigitPositions(g,
y,l);return g},mapMaskdigitPositions:function(a,b,e){a=f.reverse?a.length-e:0;c.maskDigitPosMap={};for(e=0;e<b.length;e++)c.maskDigitPosMap[b[e]+a]=1},callbacks:function(a){var h=c.val(),g=h!==d,m=[h,a,b,f],q=function(a,b,c){"function"===typeof f[a]&&b&&f[a].apply(this,c)};q("onChange",!0===g,m);q("onKeyPress",!0===g,m);q("onComplete",h.length===e.length,m);q("onInvalid",0<c.invalid.length,[h,a,b,c.invalid,f])}};b=a(b);var m=this,d=c.val(),h;e="function"===typeof e?e(c.val(),void 0,b,f):e;m.mask=
e;m.options=f;m.remove=function(){var a=c.getCaret();m.options.placeholder&&b.removeAttr("placeholder");b.data("mask-maxlength")&&b.removeAttr("maxlength");c.destroyEvents();c.val(m.getCleanVal());c.setCaret(a);return b};m.getCleanVal=function(){return c.getMasked(!0)};m.getMaskedVal=function(a){return c.getMasked(!1,a)};m.init=function(d){d=d||!1;f=f||{};m.clearIfNotMatch=a.jMaskGlobals.clearIfNotMatch;m.byPassKeys=a.jMaskGlobals.byPassKeys;m.translation=a.extend({},a.jMaskGlobals.translation,f.translation);
m=a.extend(!0,{},m,f);h=c.getRegexMask();if(d)c.events(),c.val(c.getMasked());else{f.placeholder&&b.attr("placeholder",f.placeholder);b.data("mask")&&b.attr("autocomplete","off");d=0;for(var l=!0;d<e.length;d++){var g=m.translation[e.charAt(d)];if(g&&g.recursive){l=!1;break}}l&&b.attr("maxlength",e.length).data("mask-maxlength",!0);c.destroyEvents();c.events();d=c.getCaret();c.val(c.getMasked());c.setCaret(d)}};m.init(!b.is("input"))};a.maskWatchers={};var d=function(){var b=a(this),e={},f=b.attr("data-mask");
b.attr("data-mask-reverse")&&(e.reverse=!0);b.attr("data-mask-clearifnotmatch")&&(e.clearIfNotMatch=!0);"true"===b.attr("data-mask-selectonfocus")&&(e.selectOnFocus=!0);if(p(b,f,e))return b.data("mask",new l(this,f,e))},p=function(b,e,f){f=f||{};var c=a(b).data("mask"),d=JSON.stringify;b=a(b).val()||a(b).text();try{return"function"===typeof e&&(e=e(b)),"object"!==typeof c||d(c.options)!==d(f)||c.mask!==e}catch(t){}},h=function(a){var b=document.createElement("div"),d;a="on"+a;d=a in b;d||(b.setAttribute(a,
"return;"),d="function"===typeof b[a]);return d};a.fn.mask=function(b,d){d=d||{};var e=this.selector,c=a.jMaskGlobals,h=c.watchInterval,c=d.watchInputs||c.watchInputs,t=function(){if(p(this,b,d))return a(this).data("mask",new l(this,b,d))};a(this).each(t);e&&""!==e&&c&&(clearInterval(a.maskWatchers[e]),a.maskWatchers[e]=setInterval(function(){a(document).find(e).each(t)},h));return this};a.fn.masked=function(a){return this.data("mask").getMaskedVal(a)};a.fn.unmask=function(){clearInterval(a.maskWatchers[this.selector]);
delete a.maskWatchers[this.selector];return this.each(function(){var b=a(this).data("mask");b&&b.remove().removeData("mask")})};a.fn.cleanVal=function(){return this.data("mask").getCleanVal()};a.applyDataMask=function(b){b=b||a.jMaskGlobals.maskElements;(b instanceof a?b:a(b)).filter(a.jMaskGlobals.dataMaskAttr).each(d)};h={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,keyStrokeCompensation:10,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&
h("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}};a.jMaskGlobals=a.jMaskGlobals||{};h=a.jMaskGlobals=a.extend(!0,{},h,a.jMaskGlobals);h.dataMask&&a.applyDataMask();setInterval(function(){a.jMaskGlobals.watchDataMask&&a.applyDataMask()},h.watchInterval)},window.jQuery,window.Zepto);


jQuery(document).ready(function($) {
    
    $(".ui-chat-container .step3_wrapper .disagree_btn").on("click", function(event) {
        event.preventDefault();
        $(".ui-chat-container .step1_wrapper").removeClass("step2 active");
        $(".ui-chat-container .step2_wrapper").removeClass("step3 active");
        $(".ui-chat-container .step3_wrapper").removeClass("active");
        $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
        $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
    });
    $(".submit_chat_form").on("submit", function(e) {
    	e.preventDefault();
        if (!validatePhone($('#From').val())) {
            $(".error-tel").addClass("active");
            return false;
        }
        $(".error-tel").removeClass("active");
        if ($('#Body').val().length == 0) {
            $(".error-qst").addClass("active");
            return false;
        }

        $(".ui-chat-container .step2_wrapper").addClass("step3");
        $(".ui-chat-container .step3_wrapper").addClass("active");
        return false;
    });
    $(".ui-chat-container .btn_chat_lancher,.ui-chat-container .step1_wrapper .close").click(function(event) {
        event.preventDefault();
        $(".ui-chat-container .step1_wrapper").toggleClass("active");
        $(".ui-chat-container .step2_wrapper").removeClass("active");
        $(".ui-chat-container .step5_wrapper").removeClass("active");
        if ($(this).hasClass("close")) {
            $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
            $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
        } else {
            $(".ui-chat-container .btn_chat_lancher .close_me").toggleClass("active");
            $(".ui-chat-container .btn_chat_lancher .open_me").toggleClass("active");
        }
        if ($(".ui-chat-container .step1_wrapper").hasClass("step2") ||
            $(".ui-chat-container .step2_wrapper").hasClass("step3") ||
            $(".ui-chat-container .step3_wrapper").hasClass("step4")) {
            $(".ui-chat-container .step1_wrapper").removeClass("active step2");
            $(".ui-chat-container .step2_wrapper").removeClass("active step3");
            $(".ui-chat-container .step3_wrapper").removeClass("active step4");
            $(".ui-chat-container .step4_wrapper").removeClass("active");
            if ($(this).hasClass("close")) {
                $(".ui-chat-container .btn_chat_lancher .close_me").addClass("active");
                $(".ui-chat-container .btn_chat_lancher .open_me").removeClass("active");
            } else {
                $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
                $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
            }
        }
    });
    $(".chat_now_btn.messanger").click(function(event) {
        event.preventDefault();
        $(".ui-chat-container .step1_wrapper").removeClass("active");
        $(".messanger_btn").trigger("click");
        $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
        $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
    });
    $(".chat_now_btn.livechat").click(function(event) {
        event.preventDefault();
        $(".ui-chat-container .step1_wrapper").addClass("step2");
        $(".ui-chat-container .step5_wrapper").addClass("active");
    });
    $(".chat_now_btn.textus").click(function(event) {
        event.preventDefault();
        $(".ui-chat-container .step1_wrapper").addClass("step2");
        $(".ui-chat-container .step2_wrapper").addClass("active");
    });
    // Submit functions
    $(".ui-chat-container .step3_wrapper .agree_btn").on("click", function(event) {
        event.preventDefault();
        var this_btn = $(this);
        $(this_btn).addClass("disable");
        $.ajax({
            url: 'https://dev2-ver2.v12dev.com/public/startSms',
            type: 'GET',
            type: 'post',
            dataType: 'json',
            data: {
                MessageSid: $('#MessageSid').val(),
                From: $('#From').val(),
                To: $('#To').val(),
                Body: $('#Body').val(),
            },
            success: function(response) {
                if (response.success == true) {
                	$(".ui-chat-container .step1_wrapper").removeClass("step2 active");
                  $(".ui-chat-container .step2_wrapper").removeClass("step3 active");
                  $(".ui-chat-container .step3_wrapper").addClass("step4");
                  $(".tel_from").text($("#From").val());
                  $(".ui-chat-container .step4_wrapper").addClass("active");
                  $('.submit_chat_form')[0].reset();
                  setTimeout(function() {
                      $(".ui-chat-container .step4_wrapper").removeClass("active");
                      $(".ui-chat-container .step3_wrapper").removeClass("step4 active");
                      $(".ui-chat-container .btn_chat_lancher .close_me").removeClass("active");
                      $(".ui-chat-container .btn_chat_lancher .open_me").addClass("active");
                  }, 4000);
                    console.log(response);
                } else {
                    console.log(response);
                }
                $(this_btn).removeClass("disable");
            },
            error: function(response){
                $(this_btn).removeClass("disable");
            }
        });
    });
    $('#Body').on('keyup', function(e) {
        var max_characters = 160;
        if ($(this).val().length > max_characters) {
            $(this).val($(this).val().substr(0, cmax));
        }
        $("#remaining").text(max_characters - $(this).val().length + '/' + max_characters + ' characters remaining.');
    });
    $('#From').mask('(000) 000-0000',{
    	placeholder: "(___) ___-____"
    });

    function validatePhone(txtPhone) {
        txtPhone = $.trim(txtPhone).replace(/\D/g, '');
        var filter = /^1?\d{10}$/;
        if (filter.test(txtPhone)) {
            return true;
        } else {
            return false;
        }
    }
});
</script>
</body>
</html>