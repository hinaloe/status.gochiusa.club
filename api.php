<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

date_default_timezone_set( "Asia/Tokyo" );
$time_start = microtime(true);

include "getMultiCotents.php";

// メンバーのリスト　並び順は http://www.gochiusa.com/contents/chara/index.html に準拠。
$member_list = array(
    "64319102",   // ココア @otack
    "538308036",  // チノ　 @yaplus
    "14157941",   // リゼ　 @karno
    "873775722",  // 千夜　 @eai04191
    "2439755767", // シャロ @akouryy1
    "2239375134", // マヤ　 @aayh
    "547406123",  // メグ　 @su2ca
    "463401611",  // モカ　 @kazukiti_28
);

$member_count = count($member_list);

// URL作成
foreach( $member_list as $member_id ){
  $member_url_list[] = "http://lab.mizle.net/status.gochiusa/user_information.php?id=".$member_id;
}

// 一気に取得（すごい早い）
$results = getMultiContents( $member_url_list );

// 配列の頭を数字にして扱いやすく
$results = array_values( $results );

// 正しく読み込まれているか
for ($count = 0; $count < $member_count; $count++){
  if( $results[$count]["http_code"] == "0" ){
    $result = array(
        "status" => "error",
        "data" => null,
        "message" => "ユーザー情報の読み込みに失敗しました。"
    );
    die( json_encode( $result , JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ) );
  }
}

// JSON配列型でデコード
$member_cocoa = json_decode( $results[0]["content"], true );
$member_chino = json_decode( $results[1]["content"], true );
$member_rize = json_decode( $results[2]["content"], true );
$member_chiya = json_decode( $results[3]["content"], true );
$member_syaro = json_decode( $results[4]["content"], true );
$member_maya = json_decode( $results[5]["content"], true );
$member_megu = json_decode( $results[6]["content"], true );
$member_mocha = json_decode( $results[7]["content"], true );


// ジャッジ
$hopping_count = 0;

if( strpos( $member_cocoa["name"], "心愛") !== false or strpos( $member_cocoa["name"], "ココア" !== false) ){
    $member_cocoa["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_cocoa["is_hopping"] = false;
}

if( strpos( $member_chino["name"], "智乃") !== false or strpos( $member_chino["name"], "チノ" !== false) ){
    $member_chino["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_chino["is_hopping"] = false;
}

if( strpos( $member_rize["name"], "理世") !== false or strpos( $member_rize["name"], "リゼ" !== false) ){
    $member_rize["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_rize["is_hopping"] = false;
}

if( strpos( $member_chiya["name"], "千夜") !== false ){
    $member_chiya["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_chiya["is_hopping"] = false;
}

if( strpos( $member_syaro["name"], "紗路") !== false or strpos( $member_syaro["name"], "シャロ" !== false) ){
    $member_syaro["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_syaro["is_hopping"] = false;
}

if( strpos( $member_maya["name"], "麻耶") !== false or strpos( $member_maya["name"], "マヤ" !== false) ){
    $member_maya["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_maya["is_hopping"] = false;
}

if( strpos( $member_megu["name"], "恵") !== false or strpos( $member_megu["name"], "メグ" !== false) ){
    $member_megu["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_megu["is_hopping"] = false;
}

if( strpos( $member_mocha["name"], "モカ") !== false ){
    $member_mocha["is_hopping"] = true;
    $hopping_count++;
}else{
    $member_mocha["is_hopping"] = false;
}


// 1人当たりの数
$percentage_per_member = floor( 100 / $member_count );

// ?の余り これいる？
$percentage_per_member_remainder = 100 - $percentage_per_member * $member_count;

$total_percent = $percentage_per_member * $hopping_count;

if( $hopping_count == $member_count ){
    $is_all_hopping = true;
    $total_percent = 100;
}else{
    $is_all_hopping = false;
}


$result = array(
    "status" => "success",
    "data" => array(
        "total_percent" => $total_percent, 
        "percentage_per_member" => $percentage_per_member,
        "percentage_per_member_remainder" => $percentage_per_member_remainder,
        "members" => array(
            "count" => $member_count,
            "cocoa" => $member_cocoa,
            "chino" => $member_chino,
            "rize" => $member_rize,
            "chiya" => $member_chiya,
            "syaro" => $member_syaro,
            "maya" => $member_maya,
            "megu" => $member_megu,
            "mocha" => $member_mocha,
            "hopping_count" => $hopping_count,
            "is_all_hopping" => $is_all_hopping
        )
    ),
    "message" => null
);

echo json_encode( $result , JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ) ;

?>
