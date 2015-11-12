<?php
date_default_timezone_set('Asia/Tokyo');
header("Content-Type: text/html; charset=UTF-8");
$time_start = microtime(true);

$names = array();$icon_urls = array();$matches = array();$score = '';$get_error = '0';

$error_alert = <<< EOM
<meta http-equiv="refresh" content="3">
<div class="alert alert-danger" role="alert">データが取得できませんでした3秒後に再読み込みします。</div>
EOM;

//if (@file_get_contents("http://gochiusa.club/")){
//    $gochiusanetstatus = "gochiusa.clubはオンラインです。";
//} else {
//    $gochiusanetstatus = "gochiusa.clubはオフラインです。";
//}

include 'getMultiCotents.php';

$url_list = array(
    'https://twitter.com/intent/user?user_id=538308036',
    'https://twitter.com/intent/user?user_id=64319102',
    'https://twitter.com/intent/user?user_id=14157941',
    'https://twitter.com/intent/user?user_id=2439755767',
    'https://twitter.com/intent/user?user_id=873775722',
    'https://twitter.com/intent/user?user_id=2239375134',
    'https://twitter.com/intent/user?user_id=547406123',
    'https://twitter.com/intent/user?user_id=241113884',
    );

$results = getMultiContents($url_list);

$res[] = $results['https://twitter.com/intent/user?user_id=538308036']['content']; //yaplus
$res[] = $results['https://twitter.com/intent/user?user_id=64319102']['content']; //otack
$res[] = $results['https://twitter.com/intent/user?user_id=14157941']['content']; //karno
$res[] = $results['https://twitter.com/intent/user?user_id=2439755767']['content']; //akouryy1
$res[] = $results['https://twitter.com/intent/user?user_id=873775722']['content']; //eai04191
$res[] = $results['https://twitter.com/intent/user?user_id=2239375134']['content']; //aayh
$res[] = $results['https://twitter.com/intent/user?user_id=547406123']['content']; //su2ca
$res[] = $results['https://twitter.com/intent/user?user_id=241113884']['content']; //yonex

$pattern1 = '#<title>(.*?) \(@[a-z0-9_]{1,15}\) さんはTwitterを使ってます</title>#i';
$pattern2 = '<img class="photo" src="(.+?)".+?>';
foreach ($res as $tmp) {
  preg_match ($pattern2,$tmp,$matches);
  if (array_key_exists('1', $matches)) {
    $matches[1] = str_replace("200x200", "normal", $matches[1]);
    array_push ($icon_urls,$matches[1]);
  } else {
    array_push ($icon_urls,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAQAAADZc7J/AAAAmklEQVR4Ae2UsQrDMAxEX0rx7sG/mw/xX+S7OmQ0hoILpYPpEUE4SpecN4t7SLakBVO3XwAuQKZwpEKGWCuNTiVJJFHpNFYCZRrjfTbSl337RFqURaEzFDHZB51CoMoQxGwfVESa6ozQG84hztkVEdhjhGNXhNr9VvZL8B/R/0a/kfxW9ofJH2d/oSyaBXcehyU+2RXw7618AV5eRLbw9+qXiAAAAABJRU5ErkJgggc1f8e3757d62544003611df9b7dfc691');
    $get_error = '1';
  }
}

preg_match($pattern1,$res[0],$matches);
  if (array_key_exists('1', $matches)) {
    $yaplus_name =  ($matches[1]);
  } else {
    $yaplus_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[1],$matches);
  if (array_key_exists('1', $matches)) {
    $otack_name =  ($matches[1]);
  } else {
    $otack_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[2],$matches);
  if (array_key_exists('1', $matches)) {
    $karno_name =  ($matches[1]);
  } else {
    $karno_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[3],$matches);
  if (array_key_exists('1', $matches)) {
    $akouryy1_name =  ($matches[1]);
  } else {
    $akouryy1_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[4],$matches);
  if (array_key_exists('1', $matches)) {
    $eai04191_name =  ($matches[1]);
  } else {
    $eai04191_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[5],$matches);
  if (array_key_exists('1', $matches)) {
    $aayh_name =  ($matches[1]);
  } else {
    $aayh_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[6],$matches);
  if (array_key_exists('1', $matches)) {
    $su2ca_name =  ($matches[1]);
  } else {
    $su2ca_name = ('取得できませんでした');
  }
preg_match($pattern1,$res[7],$matches);
  if (array_key_exists('1', $matches)) {
    $yonex_name =  ($matches[1]);
  } else {
    $yonex_name = ('取得できませんでした');
  }
$score = 0;
if (stristr($yaplus_name, '香風智乃') !== false || stristr($yaplus_name, 'チノ') !== false) {
    $yaplus_result = '<a href="http://twitter.com/yaplus">'."@yaplus"."</a>"."は香風智乃です。";
    $yaplus_menber = '1';
    $score += 12.5;
} else {
    $yaplus_result = '<a href="http://twitter.com/yaplus">'."@yaplus"."</a>"."は香風智乃ではありません。($yaplus_name)";
    $yaplus_menber = '0';
}
if (stristr($otack_name, '保登心愛') !== false || stristr($otack_name, 'ココア') !== false) {
    $otack_result = '<a href="http://twitter.com/otack">'."@otack"."</a>"."は保登心愛です。";
    $otack_menber = '1';
    $score += 12.5;
} else {
    $otack_result = '<a href="http://twitter.com/otack">'."@otack"."</a>"."は保登心愛ではありません。($otack_name)";
    $otack_menber = '0';
}
if (stristr($karno_name, '天々座理世') !== false || stristr($karno_name, 'リゼ') !== false) {
    $karno_result = '<a href="http://twitter.com/karno">'."@karno"."</a>"."は天々座理世です。";
    $karno_menber = '1';
    $score += 12.5;
} else {
    $karno_result = '<a href="http://twitter.com/karno">'."@karno"."</a>"."は天々座理世ではありません。($karno_name)";
    $karno_menber = '0';
}
if (stristr($akouryy1_name, '桐間紗路') !== false || stristr($akouryy1_name, 'シャロ') !== false) {
    $akouryy1_result = '<a href="http://twitter.com/akouryy1">'."@akouryy1"."</a>"."は桐間紗路です。";
    $akouryy1_menber = '1';
    $score += 12.5;
} else {
    $akouryy1_result = '<a href="http://twitter.com/akouryy1">'."@akouryy1"."</a>"."は桐間紗路ではありません。($akouryy1_name)";
    $akouryy1_menber = '0';
}
if (stristr($eai04191_name, '宇治松千夜') !== false || stristr($eai04191_name, 'chiya') !== false) {
    $eai04191_result = '<a href="http://twitter.com/eai04191">'."@eai04191"."</a>"."は宇治松千夜です。";
    $eai04191_menber = '1';
    $score += 12.5;
} else {
    $eai04191_result = '<a href="http://twitter.com/eai04191">'."@eai04191"."</a>"."は宇治松千夜ではありません。($eai04191_name)";
    $eai04191_menber = '0';
}
if (stristr($aayh_name, '条河麻耶') !== false || stristr($aayh_name, 'マヤ') !== false) {
    $aayh_result = '<a href="http://twitter.com/aayh">'."@aayh"."</a>"."は条河麻耶です。";
    $aayh_menber = '1';
    $score += 12.5;
} else {
    $aayh_result = '<a href="http://twitter.com/aayh">'."@aayh"."</a>"."は条河麻耶ではありません。($aayh_name)";
    $aayh_menber = '0';
}
if (stristr($su2ca_name, '奈津恵') !== false || stristr($su2ca_name, 'メグ') !== false) {
    $su2ca_result = '<a href="http://twitter.com/su2ca">'."@su2ca"."</a>"."は奈津恵です。";
    $su2ca_menber = '1';
    $score += 12.5;
} else {
    $su2ca_result = '<a href="http://twitter.com/su2ca">'."@su2ca"."</a>"."は奈津恵ではありません。($su2ca_name)";
    $su2ca_menber = '0';
}
if (stristr($yonex_name, 'ティッピー') !== false || stristr($yonex_name, 'tippy') !== false) {
    $yonex_result = '<a href="http://twitter.com/yonex">'."@yonex"."</a>"."はティッピーです。";
    $yonex_menber = '1';
    $score += 12.5;
} else {
    $yonex_result = '<a href="http://twitter.com/yonex">'."@yonex"."</a>"."はティッピーではありません。($yonex_name)";
    $yonex_menber = '0';
}

if ($score > 99) {
    $score =  100;
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
    <meta property="og:url" content="http://status.gochiusa.club/">
    <meta property="og:image" content="http://status.gochiusa.club/tippy.png">
    <meta property="og:site_name" content="ごちうさ部ステータス">
    <meta property="og:email" content="eai04191@gmail.com">

    <meta name="twitter:card" content="summary">
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
.alert-gochiusa.alert {
  border-color: red;
  color: #FFF;
}
.alert-gochiusa.alert a {
  color: #FFF;
}
.alert img {
  margin-right: 5px;
}
#alert-chino {
background-color: #4F96FF;
<?php
if ($yaplus_menber == '1') {
  echo "border-color: #4F96FF;\n";
} else {
}
?>
}
#alert-cocoa {
background-color: #F5A5BE;
<?php
if ($otack_menber == '1') {
  echo "border-color: #F5A5BE;\n";
} else {
}
?>
}
#alert-rize {
background-color: #9468ED;
<?php
if ($karno_menber == '1') {
  echo "border-color: #9468ED;\n";
} else {
}
?>
}
#alert-syaro {
background-color: #F4D7A1;
<?php
if ($akouryy1_menber == '1') {
  echo "border-color: #F4D7A1;\n";
} else {
}
?>
}
#alert-chiya {
background-color: #8DB46F;
<?php
if ($eai04191_menber == '1') {
  echo "border-color: #8DB46F;\n";
} else {
}
?>
}
#alert-maya {
background-color: #5F74AF;
border-color: #5F74AF;
}
#alert-megu {
background-color: #CA354F;
<?php
if ($su2ca_menber == '1') {
  echo "border-color: #CA354F;\n";
} else {
}
?>
}
#alert-aoyama {
background-color: #497487;
border-color: #497487;
}
#alert-tippy {
background-color: #8D96D0;
<?php
if ($yonex_menber == '1') {
  echo "border-color: #8D96D0;\n";
} else {
}
?>
}
.nav-pills>li {
  float: none;
}
</style>

  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <!--<li role="presentation"><a href="http://gochiusa.club/"><?//=$gochiusanetstatus?></a></li>-->
          <li role="presentation"><a href="#"><?php echo(date('c')); ?></a></li>
        </ul>
        <h3 class="text-muted">ごちうさ部<br class="br-sp">ステータス</h3>
      </div>
      <?php
      if ($get_error == '1') {
        echo $error_alert;
      } else {
      }
      ?>
        <h1><?php echo $score;?>%</h1>
        <div class="progress">
          <div class="progress-bar <?php echo $progress_bar_status;?>" role="progressbar" aria-valuenow="<?php echo $score;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $score;?>%;">
            <span class="sr-only"><?php echo $score;?>% Complete</span>
          </div>
        </div>
        <div class="alert alert-gochiusa" id="alert-chino" role="alert"><img src="<?=$icon_urls[0]?>" width=32px height=32px><?=$yaplus_result?></div>
        <div class="alert alert-gochiusa" id="alert-cocoa" role="alert"><img src="<?=$icon_urls[1]?>" width=32px height=32px><?=$otack_result?></div>
        <div class="alert alert-gochiusa" id="alert-rize" role="alert"><img src="<?=$icon_urls[2]?>" width=32px height=32px><?=$karno_result?></div>
        <div class="alert alert-gochiusa" id="alert-syaro" role="alert"><img src="<?=$icon_urls[3]?>" width=32px height=32px><?=$akouryy1_result?></div>
        <div class="alert alert-gochiusa" id="alert-chiya" role="alert"><img src="<?=$icon_urls[4]?>" width=32px height=32px><?=$eai04191_result?></div>
        <div class="alert alert-gochiusa" id="alert-maya" role="alert"><img src="<?=$icon_urls[5]?>" width=32px height=32px><?=$aayh_result?></div>
        <div class="alert alert-gochiusa" id="alert-megu" role="alert"><img src="<?=$icon_urls[6]?>" width=32px height=32px><?=$su2ca_result?></div>
        <div class="alert alert-gochiusa" id="alert-aoyama" role="alert"><img src="aoyama.png" width=32px height=32px>いません</div>
        <div class="alert alert-gochiusa" id="alert-tippy" role="alert"><img src="<?=$icon_urls[7]?>" width=32px height=32px><?=$yonex_result?></div>

      <div class="footer">
        <p>time:<?=$strtime?>sec. <a href="http://mizle.net">mizle.net</a> 2015 <a href="https://twitter.com/share" class="twitter-share-button" data-text="ごちうさ部ステータス <?php echo $score;?>%" data-via="eai04191">Tweet</a></p>
      </div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
  </body>
</html>
