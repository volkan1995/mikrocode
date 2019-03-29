<?php
    header("Content-type: text/css; charset: UTF-8");
    include 'css' . DIRECTORY_SEPARATOR . 'colors.1.php';
?>
body{background:<?=$tema_ayar['renkler']['body']?>;color:<?=$tema_ayar['renkler']['color']?>;font-family:'Open Sans',sans-serif;font-weight:300;position:relative;width:100%;height:100%;overflow-x:hidden}
.tm-white, .tm-white a{color:<?=$tema_ayar['renkler']['banner_color']?>}
a{color:<?=$tema_ayar['renkler']['color_alt']?>}
h1{margin-top:0;margin-bottom:25px}
h1,h2,h3,h4{font-weight:700}
p{line-height:1.6em}
img{max-width:100%;height:auto}
.overlay{width:100%;height:90%;background:rgba(0,0,0,0.4);padding-top:90px;padding-bottom:90px}
@media (min-width: 768px) {
.container{width:700px}
}
@media (min-width: 992px) {
.container{width:900px}
}
@media (min-width: 1200px) {
.container{width:1000px}
}
.preloader{position:fixed;top:0;left:0;width:100%;height:100%;z-index:99999;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row nowrap;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-align-items:center;-ms-flex-align:center;align-items:center;background:none repeat scroll 0 0 #fff}
.sk-spinner-rotating-plane.sk-spinner{width:30px;height:30px;background-color:<?=$tema_ayar['renkler']['color']?>;margin:0 auto;-webkit-animation:sk-rotatePlane 1.2s infinite ease-in-out;animation:sk-rotatePlane 1.2s infinite ease-in-out}
@-webkit-keyframes sk-rotatePlane {
0%{-webkit-transform:perspective(120px) rotateX(0deg) rotateY(0deg);transform:perspective(120px) rotateX(0deg) rotateY(0deg)}
50%{-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg);transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg)}
100%{-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}
}
@keyframes sk-rotatePlane {
0%{-webkit-transform:perspective(120px) rotateX(0deg) rotateY(0deg);transform:perspective(120px) rotateX(0deg) rotateY(0deg)}
50%{-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg);transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg)}
100%{-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}
}
.navbar-default{background:<?=$tema_ayar['renkler']['navbar']?>;border:none;box-shadow:0 2px 8px 0 rgba(50,50,50,0.08);margin:0!important}
.navbar-default .navbar-brand{color:<?=$tema_ayar['renkler']['navbar_color_alt']?>;font-size:30px;font-weight:700;height:70px;line-height:35px}
.navbar-default .nav li a{color:<?=$tema_ayar['renkler']['navbar_color']?>;font-size:13px;font-weight:700;height:70px;line-height:40px}
.navbar-default .nav li a:hover,.navbar-default .nav li a:focus,.navbar-default .nav li a.current{color:<?=$tema_ayar['renkler']['navbar_color_alt']?>}
.navbar-default .navbar-toggle{border:none;padding-top:20px}
.navbar-default .navbar-toggle .icon-bar{background:<?=$tema_ayar['renkler']['navbar_color']?>;border-color:transparent}
.navbar-default .navbar-toggle:hover,.navbar-default .navbar-toggle:focus{background-color:transparent}
#home{background-size:cover;color:#fff;margin-top:70px;text-align:center;width:100%}
#home p{font-weight:400;font-style:italic;line-height:2em}
#home img{display:inline-block;margin-top:30px}
#home .overlay{height:70%;}
#divider{text-align:center;padding-top:80px;padding-bottom:80px}
#divider .fa{color:<?=$tema_ayar['renkler']['color']?>;font-size:60px}
#divider h3{font-size:20px}
#feature{background:#f8f8f8;padding-top:80px;padding-bottom:80px}
#feature p{padding-top:10px}
#feature span{float:left}
#feature .fa{background:<?=$tema_ayar['renkler']['backcolor']?>;border-radius:50%;color:#fff;display:inline-block;width:40px;height:40px;line-height:40px;text-align:center;margin-right:20px}
#feature1{padding-top:60px;padding-bottom:60px}
#feature1 p{padding-top:10px}
#feature1 span{float:left}
#feature1 .fa{background:<?=$tema_ayar['renkler']['backcolor']?>;border-radius:50%;color:#fff;display:inline-block;width:40px;height:40px;line-height:40px;text-align:center;margin-right:20px}
#pricing{background:#f8f8f8;text-align:center;padding-top:80px;padding-bottom:80px}
#pricing h2{padding-bottom:60px}
#pricing .pricing{background:#fff}
#pricing .active{position:relative;bottom:20px}
#pricing .pricing .pricing-title{background:<?=$tema_ayar['renkler']['backcolor']?>;color:#fff;font-weight:700;padding:30px}
#pricing .pricing .pricing-title p{font-size:20px}
#pricing .pricing ul{padding:0;margin:0}
#pricing .pricing ul li{display:block;list-style:none;padding:16px}
#pricing .pricing .btn{background:transparent;border:1px solid <?=$tema_ayar['renkler']['color']?>;border-radius:0;color:<?=$tema_ayar['renkler']['color']?>;font-weight:700;padding-right:40px;padding-left:40px;margin-top:20px;margin-bottom:30px;transition:all .3s ease}
#pricing .pricing .btn:hover{background:<?=$tema_ayar['renkler']['backcolor']?>;color:#fff}
#download{padding-top:80px;padding-bottom:80px}
#download h2{padding-bottom:20px}
#download .btn{border-radius:0;font-weight:700;margin-top:20px;padding:10px 40px}
#contact{background:url(../images/contact-bg.jpg) no-repeat;background-size:cover;color:#fff}
#contact h2{padding-bottom:10px}
#contact address{padding-top:20px}
#contact address .fa{background:<?=$tema_ayar['renkler']['backcolor']?>;border-radius:50%;width:40px;height:40px;line-height:40px;text-align:center;margin-top:6px;margin-right:10px}
#contact .contact-form{padding-top:40px}
#contact .form-control{border:none;border-radius:0;box-shadow:none;margin-bottom:20px}
#contact input{height:50px}
#contact input[type="submit"]{background:<?=$tema_ayar['renkler']['backcolor']?>;color:#fff;font-weight:700;transition:all .3s ease}
#contact input[type="submit"]:hover{background:<?=$tema_ayar['renkler']['backcolor_alt']?>}
footer{background:#fff;font-weight:400;text-align:center;padding:20px}
@media screen and ( max-width: 991px ) {
.templatemo-box{margin-bottom:30px}
#pricing .active{bottom:0}
.pricing{margin-bottom:20px}
#feature img,#download img{margin-top:30px}
#feature1 img{margin-bottom:30px}
}
@media screen and ( max-width: 767px ) {
.navbar-default .nav li a{height:auto;line-height:2em}
#feature,#pricing,#download{padding-top:20px;padding-bottom:40px}
#contact .overlay{padding-top:40px}
}
@media screen and ( max-width: 360px ) {
.pricing{padding-bottom:40px}
}
.ml-fiyat{margin-left:20px;}