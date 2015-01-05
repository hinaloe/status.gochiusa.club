<!--<div class="marquee blink"><h1>なんか動かんスマン</h1></div>
<p>直してください おねがいします<a href="https://github.com/eai04191/status.gochiusa.net">https://github.com/eai04191/status.gochiusa.net</a></p>-->
<?php
date_default_timezone_set('Asia/Tokyo');
header("Content-Type: text/html; charset=UTF-8");
$time_start = microtime(true);

$names = array();$icon_urls = array();$matches = array();$score = '';

include 'getMultiCotents.php';

$url_list = array(
    'https://mobile.twitter.com/yaplus',
    'https://mobile.twitter.com/otack',
    'https://mobile.twitter.com/karno',
    'https://mobile.twitter.com/3qgt',
    'https://mobile.twitter.com/eai04191',
    'https://mobile.twitter.com/snovxn',
    'https://mobile.twitter.com/yonex',
    );

$results = getMultiContents($url_list);

$res[] = $results['https://mobile.twitter.com/yaplus']['content'];
$res[] = $results['https://mobile.twitter.com/otack']['content'];
$res[] = $results['https://mobile.twitter.com/karno']['content'];
$res[] = $results['https://mobile.twitter.com/3qgt']['content'];
$res[] = $results['https://mobile.twitter.com/eai04191']['content'];
$res[] = $results['https://mobile.twitter.com/snovxn']['content'];
$res[] = $results['https://mobile.twitter.com/yonex']['content'];

$pattern1 = '#<title>(.*?) \(@[a-z0-9_]{1,15}\)さんはTwitterを利用しています</title>#i';
$pattern2 = '@<img alt="[^"]*+" src="(https://pbs.twimg.com/profile_images/\d++/\w++.*)" />@';

foreach ($res as $tmp) {
  preg_match ($pattern2,$tmp,$matches);
  array_push ($icon_urls,$matches[1]);
}

preg_match($pattern1,$res[0],$matches);
$yaplus_name =  ($matches[1]);
preg_match($pattern1,$res[1],$matches);
$otack_name =  ($matches[1]);
preg_match($pattern1,$res[2],$matches);
$karno_name =  ($matches[1]);
preg_match($pattern1,$res[3],$matches);
$_3qgt_name =  ($matches[1]);
preg_match($pattern1,$res[4],$matches);
$eai04191_name =  ($matches[1]);
preg_match($pattern1,$res[5],$matches);
$snovxn_name =  ($matches[1]);
preg_match($pattern1,$res[6],$matches);
$yonex_name =  ($matches[1]);

$score = "";
if (stristr($yaplus_name, '香風智乃') !== false || stristr($yaplus_name, 'チノ') !== false) {
    $yaplus_result = '<a href="http://twitter.com/yaplus">'."@yaplus"."</a>"."は香風智乃です。";
    $yaplus_menber = '1';
    $score += 14.28;
} else {
    $yaplus_result = '<a href="http://twitter.com/yaplus">'."@yaplus"."</a>"."は香風智乃ではありません。($yaplus_name)";
    $yaplus_menber = '0';
}
if (stristr($otack_name, '保登心愛') !== false || stristr($otack_name, 'ココア') !== false) {
    $otack_result = '<a href="http://twitter.com/otack">'."@otack"."</a>"."は保登心愛です。";
    $otack_menber = '1';
    $score += 14.28;
} else {
    $otack_result = '<a href="http://twitter.com/otack">'."@otack"."</a>"."は保登心愛ではありません。($otack_name)";
    $otack_menber = '0';
}
if (stristr($karno_name, '天々座理世') !== false || stristr($karno_name, 'リゼ') !== false) {
    $karno_result = '<a href="http://twitter.com/karno">'."@karno"."</a>"."は天々座理世です。";
    $karno_menber = '1';
    $score += 14.28;
} else {
    $karno_result = '<a href="http://twitter.com/karno">'."@karno"."</a>"."は天々座理世ではありません。($karno_name)";
    $karno_menber = '0';
}
if (stristr($_3qgt_name, '桐間紗路') !== false || stristr($_3qgt_name, 'シャロ') !== false) {
    $_3qgt_result = '<a href="http://twitter.com/3qgt">'."@3qgt"."</a>"."は桐間紗路です。";
    $_3qgt_menber = '1';
    $score += 14.28;
} else {
    $_3qgt_result = '<a href="http://twitter.com/3qgt">'."@3qgt"."</a>"."は桐間紗路ではありません。($_3qgt_name)";
    $_3qgt_menber = '0';
}
if (stristr($eai04191_name, '宇治松千夜') !== false || stristr($eai04191_name, 'chiya') !== false) {
    $eai04191_result = '<a href="http://twitter.com/eai04191">'."@eai04191"."</a>"."は宇治松千夜です。";
    $eai04191_menber = '1';
    $score += 14.28;
} else {
    $eai04191_result = '<a href="http://twitter.com/eai04191">'."@eai04191"."</a>"."は宇治松千夜ではありません。($eai04191_name)";
    $eai04191_menber = '0';
}
if (stristr($snovxn_name, '条河麻耶') !== false || stristr($snovxn_name, 'マヤ') !== false) {
    $snovxn_result = '<a href="http://twitter.com/snovxn">'."@snovxn"."</a>"."は条河麻耶です。";
    $snovxn_menber = '1';
    $score += 14.28;
} else {
    $snovxn_result = '<a href="http://twitter.com/snovxn">'."@snovxn"."</a>"."は条河麻耶ではありません。($snovxn_name)";
    $snovxn_menber = '0';
}
if (stristr($yonex_name, 'ティッピー') !== false || stristr($yonex_name, 'tippy') !== false) {
    $yonex_result = '<a href="http://twitter.com/yonex">'."@yonex"."</a>"."はティッピーです。";
    $yonex_menber = '1';
    $score += 14.28;
} else {
    $yonex_result = '<a href="http://twitter.com/yonex">'."@yonex"."</a>"."はティッピーではありません。($yonex_name)";
    $yonex_menber = '0';
}

if ($score == 99.96) {
    $score =  $score + 0.04;
} else {
}

if ($score == 100) {
  $progress_bar_status = "progress-bar-success";
  $favicon = 'success';
} elseif ($score > 80) {
  $progress_bar_status = "progress-bar-info";
  $favicon = 'info';
} elseif ($score > 60) {
  $progress_bar_status = "progress-bar-info";
  $favicon = 'info';
} elseif ($score > 40) {
  $progress_bar_status = "progress-bar-warning";
  $favicon = 'warn';
} elseif ($score > 30) {
  $progress_bar_status = "progress-bar-warning";
  $favicon = 'warn';
} elseif ($score > 10) {
  $progress_bar_status = "progress-bar-danger";
  $favicon = 'danger';
} elseif ($score == 0) {
  $progress_bar_status = "progress-bar-danger";
  $favicon = 'danger';
} else {
}
$time_end = microtime(true);
$time = $time_end - $time_start;
$strtime = substr($time, 0, -10);

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ごちうさ部メンバーの安否を確認できます。">
    <meta name="author" content="eai04191">
    <meta name="date" content="<?php echo(date('c')); ?>" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <meta property="og:title" content="ごちうさ部ステータス">
    <meta property="og:type" content="website">
    <meta property="og:description" content="ごちうさ部メンバーの状況を確認できます。">
    <meta property="og:url" content="http://status.gochiusa.net/">
    <meta property="og:image" content="http://status.gochiusa.net/tippy.png">
    <meta property="og:site_name" content="ごちうさ部ステータス">
    <meta property="og:email" content="eai04191@gmail.com">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@eai04191">
    <meta name="twitter:creator" content="@eai04191">

    <link rel="shortcut icon" href="/favicon/<?=$favicon?>/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/iphone/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/iphone/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/iphone/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/iphone/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/iphone/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/iphone/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/iphone/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/iphone/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/iphone/apple-touch-icon-180x180.png">
    <meta name="apple-mobile-web-app-title" content="ごちうさ部ステータス">
    <link rel="icon" type="image/png" href="/favicon/<?=$favicon?>/favicon-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon/<?=$favicon?>/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/favicon/<?=$favicon?>/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon/<?=$favicon?>/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/favicon/<?=$favicon?>/favicon-32x32.png" sizes="32x32">
    <meta name="msapplication-TileImage" content="/favicon/iphone/mstile-144x144.png">
    <meta name="msapplication-config" content="/favicon/iphone/browserconfig.xml">
    <meta name="application-name" content="ごちうさ部ステータス">
    <title>ごちうさ部ステータス</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="jumbotron-narrow.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">

@keyframes blink {
  75% { opacity: 0.0; }
}
@-webkit-keyframes blink {
  75% { opacity: 0.0; }
}
.blink {
  animation: blink 1s step-end infinite;
  -webkit-animation: blink 1s step-end infinite;
}

.marquee {
width:100%;
padding:0.5em 0;
overflow:hidden;
position:relative;
}

.marquee h1:after {
content:"";
white-space:nowrap;
padding-right:50px;
}

.marquee h1 {
margin:0;
padding-left:100%;
display:inline-block;
white-space:nowrap;
    -webkit-animation-name:marquee;
    -webkit-animation-timing-function:linear;
    -webkit-animation-duration:5s;
    -webkit-animation-iteration-count:infinite;
    -moz-animation-name:marquee;
    -moz-animation-timing-function:linear;
    -moz-animation-duration:5s;
    -moz-animation-iteration-count:infinite;
    -ms-animation-name:marquee;
    -ms-animation-timing-function:linear;
    -ms-animation-duration:5s;
    -ms-animation-iteration-count:infinite;
    -o-animation-name:marquee;
    -o-animation-timing-function:linear;
    -o-animation-duration:5s;
    -o-animation-iteration-count:infinite;
    animation-name:marquee;
    animation-timing-function:linear;
    animation-duration:5s;
    animation-iteration-count:infinite;
}
@-webkit-keyframes marquee {
  from   { -webkit-transform: translate(0%);}
  99%,to { -webkit-transform: translate(-100%);}
}
@-moz-keyframes marquee {
  from   { -moz-transform: translate(0%);}
  99%,to { -moz-transform: translate(-100%);}
}
@-ms-keyframes marquee {
  from   { -ms-transform: translate(0%);}
  99%,to { -ms-transform: translate(-100%);}
}
@-o-keyframes marquee {
  from   { -o-transform: translate(0%);}
  99%,to { -o-transform: translate(-100%);}
}
@keyframes marquee {
  from   { transform: translate(0%);}
  99%,to { transform: translate(-100%);}
}


#loading {
display:none;
}
@media screen and (min-width: 500px) {
  .br-sp { display:none; }
}
.alert {
  border-color: red;
  color: #FFF;
}
.alert a {
  color: #FFF;
}
.alert img {
  margin-right: 5px;
}
.alert-chino {
background-color: #4F96FF;
<?php
if ($yaplus_menber == '1') {
  echo "border-color: #4F96FF;\n";
} else {
}
?>
}
.alert-cocoa {
background-color: #F5A5BE;
<?php
if ($otack_menber == '1') {
  echo "border-color: #F5A5BE;\n";
} else {
}
?>
}
.alert-rize {
background-color: #8E71E7;
<?php
if ($karno_menber == '1') {
  echo "border-color: #9468ED;\n";
} else {
}
?>
}
.alert-syaro {
background-color: #F4D7A1;
<?php
if ($_3qgt_menber == '1') {
  echo "border-color: #F4D7A1;\n";
} else {
}
?>
}
.alert-chiya {
background-color: #8DB46F;
<?php
if ($eai04191_menber == '1') {
  echo "border-color: #8DB46F;\n";
} else {
}
?>
}
.alert-maya {
background-color: #5F74AF;
<?php
if ($snovxn_menber == '1') {
  echo "border-color: #5F74AF;\n";
} else {
}
?>
}
.alert-megu {
background-color: #CA354F;
border-color: #CA354F;
}
.alert-aoyama {
background-color: #497487;
border-color: #497487;
}
.alert-tippy {
background-color: #8b99cd;
<?php
if ($yonex_menber == '1') {
  echo "border-color: #8b99cd;\n";
} else {
}
?>
}
</style>

  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <!--<li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>-->
          <li><?php echo(date('c')); ?></li>
        </ul>
        <h3 class="text-muted">ごちうさ部<br class="br-sp">ステータス</h3>
      </div>
        <h1><?php echo $score;?>%</h1>
        <div class="progress">
          <div class="progress-bar <?php echo $progress_bar_status;?>" role="progressbar" aria-valuenow="<?php echo $score;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $score;?>%;">
            <span class="sr-only"><?php echo $score;?>% Complete</span>
          </div>
        </div>
        <div class="alert alert-chino" role="alert"><img src="<?=$icon_urls[0]?>" width=32px height=32px><?=$yaplus_result?></div>
        <div class="alert alert-cocoa" role="alert"><img src="<?=$icon_urls[1]?>" width=32px height=32px><?=$otack_result?></div>
        <div class="alert alert-rize" role="alert"><img src="<?=$icon_urls[2]?>" width=32px height=32px><?=$karno_result?></div>
        <div class="alert alert-syaro" role="alert"><img src="<?=$icon_urls[3]?>" width=32px height=32px><?=$_3qgt_result?></div>
        <div class="alert alert-chiya" role="alert"><img src="<?=$icon_urls[4]?>" width=32px height=32px><?=$eai04191_result?></div>
        <div class="alert alert-maya" role="alert"><img src="<?=$icon_urls[5]?>" width=32px height=32px><?=$snovxn_result?></div>
        <div class="alert alert-megu" role="alert"><img src="megu.png" width=32px height=32px>いません</div>
        <div class="alert alert-aoyama" role="alert"><img src="aoyama.png" width=32px height=32px>いません</div>
        <div class="alert alert-tippy" role="alert"><img src="<?=$icon_urls[6]?>" width=32px height=32px><?=$yonex_result?></div>

      <div class="footer">
        <p>time:<?=$strtime?>sec. &copy; <a href="http://chiya.tk">chiya.tk</a> 2014 <a href="https://twitter.com/share" class="twitter-share-button" data-text="ごちうさ部ステータス <?php echo $score;?>%" data-via="eai04191">Tweet</a></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script type="text/JavaScript">
<!--
flg=true;
function Blink(){
if(flg){
document.getElementById("blink").style.visibility="visible";
}else{
document.getElementById("blink").style.visibility="hidden";
}
flg=!flg;
setTimeout("Blink()",500);
}
Blink();
//-->
</script>
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
