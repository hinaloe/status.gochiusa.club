<?php
////////// configuration //////////
$url_list = array(
  'https://mobile.twitter.com/yaplus',   //チノ
  'https://mobile.twitter.com/otack',    //ココア
  'https://mobile.twitter.com/karno',    //リゼ
  'https://mobile.twitter.com/eai04191', //千夜
  'https://mobile.twitter.com/3qgt',     //シャロ
  //'https://mobile.twitter.com/',         //メグ
  'https://mobile.twitter.com/snovxn',   //マヤ
  //'https://mobile.twitter.com/',         //青山ブルーマウンテン
  //'https://mobile.twitter.com/',         //ティッピー
  );
///////////////////////////////////
date_default_timezone_set('Asia/Tokyo');
header("Content-Type: text/html; charset=UTF-8");
$time_start = microtime(true);
include 'fetch_multi_url.php';
$names = array();$icon_urls = array();$matches = array() ;//なぜか外すと動かなくなる😠

$htmls = fetch_multi_url($url_list);

$pattern1 = '#<title>(.*?) \(@[a-z0-9_]{1,15}\) on Twitter</title>#i';
$pattern2 = '@<img alt="[^"]*+" src="(https://pbs.twimg.com/profile_images/\d++/\w++.*)" />@';

foreach ($htmls as $tmp) {
  preg_match ($pattern1,$tmp,$matches);
  array_push ($names,$matches[1]);
}

foreach ($htmls as $tmp) {
  preg_match ($pattern2,$tmp,$matches);
  array_push ($icon_urls,$matches[1]);
}

$time_end = microtime(true);
$time = $time_end - $time_start;
$strtime = substr($time, 0, -10);

echo $strtime;
?>