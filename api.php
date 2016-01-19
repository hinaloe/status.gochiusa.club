<?php
/**
 * ごちうさ部ステータス API
 */

header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=utf-8" );

date_default_timezone_set( "Asia/Tokyo" );
$time_start = microtime( true );

require_once "functions.php";

// メンバーのリスト 並び順は http://www.gochiusa.com/contents/chara/index.html に準拠。
$member_list = array(
	"64319102"   => array(
		"chara" => "cocoa",
		"names" => array( "心愛", "ココア" ), // @otack
	),
	"538308036"  => array(
		"chara" => "chino",
		"names" => array( "智乃", "チノ" ),   // @yaplus
	),
	"14157941"   => array(
		"chara" => "rize",
		"names" => array( "理世", "リゼ" ),   // @karno
	),
	"873775722"  => array(
		"chara" => "chiya",
		"names" => array( "千夜" ),          // @eai04191
	),
	"2439755767" => array(
		"chara" => "syaro",
		"names" => array( "紗路", "シャロ" ), // @akouryy1
	),
	"2239375134" => array(
		"chara" => "maya",
		"names" => array( "麻耶", "マヤ" ),   // @aayh
	),
	"547406123"  => array(
		"chara" => "megumi",
		"names" => array( "恵", "メグ" ),     // @su2ca
	),
	"463401611"  => array(
		"chara" => "mocha",
		"names" => array( "モカ" ),          // @kazukiti_28
	),
);

// 何名居るかをキャッシュする
$member_count = count( $member_list );

$user_info_list = get_users_info( array_keys( $member_list ) );

if ( $user_info_list instanceof Exception ) {
	error_die( "ユーザー情報が取得できませんでした。({$user_info_list->getMessage()})" );
}

// 配列の頭を数字にして扱いやすく
//$user_info_list = array_values( $user_info_list );

// ジャッジ
$hopping_count = 0;

// 最終的なメンバー情報を入れるリスト
$member_info_list = array();

foreach ( $user_info_list as $id => $user_info ) {

	// 名前の一部分がごちうさキャラの名前かどうかを確認する
	$member                    = $member_list[ $id ];
	$member_info               = $user_info;
	$member_info["is_hopping"] = false;
	foreach ( $member["names"] as $name ) {
		if ( strpos( $user_info["name"], $name ) !== false ) {
			$member_info["is_hopping"] = true;
			$hopping_count ++;
			break;
		}
	}

	// メンバー情報を入れるリストに追加する
	$member_info_list[ $member["chara"] ] = $member_info;
}

// 1人当たりの数
$percentage_per_member = floor( 100 / $member_count );

// ☝の余り これいる？
$percentage_per_member_remainder = 100 - $percentage_per_member * $member_count;

$total_percent = $percentage_per_member * $hopping_count;

// 全員ごちうさキャラになっているかどうかを確認する
if ( $hopping_count === $member_count ) {
	$is_all_hopping = true;
	$total_percent  = 100;
} else {
	$is_all_hopping = false;
}

$result = array(
	"status"  => "success",
	"data"    => array(
		"total_percent"                   => $total_percent,
		"percentage_per_member"           => $percentage_per_member,
		"percentage_per_member_remainder" => $percentage_per_member_remainder,
		"members"                         => $member_info_list,
	),
	"message" => null,
);

echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

/**
 * @param $message
 * @param string $status
 * @param null|array|string|object $data
 * @param int $http_code
 *
 * @return void
 */
function error_die( $message, $status = 'error', $data = null, $http_code = 500 ) {
	http_response_code( $http_code );
	$result = array(
		"status"  => $status,
		'data'    => $data,
		'message' => $message,
	);
	die( json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
}