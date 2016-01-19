<?php
/**
 * functions.php
 *
 * 共通関数など
 */

/**
 * http://techblog.yahoo.co.jp/architecture/api1_curl_multi/
 * 複数URLのコンテンツ、及び通信ステータスを一括取得する。
 * サンプル:
 *   $urls = array( "http://〜", "http://〜", "http://〜" );
 *   $results = getMultiContents($urls);
 *   print_r($results);
 *
 * @param string[] $url_list
 *
 * @return array $results
 */
function getMultiContents( $url_list ) {
	// マルチハンドルの用意
	$mh = curl_multi_init();

	// URLをキーとして、複数のCurlハンドルを入れて保持する配列
	$ch_list = array();

	// Curlハンドルの用意と、マルチハンドルへの登録
	foreach ( $url_list as $url ) {
		$ch_list[ $url ] = curl_init( $url );
		curl_setopt( $ch_list[ $url ], CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch_list[ $url ], CURLOPT_TIMEOUT, 5 );  // タイムアウト秒数を指定
		curl_setopt( $ch_list[ $url ], CURLOPT_SSL_VERIFYPEER, false );
		curl_multi_add_handle( $mh, $ch_list[ $url ] );
	}

	// 一括で通信実行、全て終わるのを待つ
	$running = null;
	do {
		curl_multi_exec( $mh, $running );
	} while ( $running );

	$results = [ ];

	// 実行結果の取得
	foreach ( $url_list as $url ) {
		// ステータスとコンテンツ内容の取得
		$results[ $url ]            = curl_getinfo( $ch_list[ $url ] );
		$results[ $url ]["content"] = curl_multi_getcontent( $ch_list[ $url ] );

		// Curlハンドルの後始末
		curl_multi_remove_handle( $mh, $ch_list[ $url ] );
		curl_close( $ch_list[ $url ] );
	}

	// マルチハンドルの後始末
	curl_multi_close( $mh );

	// 結果返却
	return $results;
}

/**
 * @param $str
 *
 * @return string
 */
function h( $str ) {
	return htmlspecialchars( $str, ENT_QUOTES, "UTF-8" );
}

/**
 * @param array $ids
 *
 * @return array|RuntimeException
 */
function get_users_info( $ids ) {
	$mh  = curl_multi_init();
	$chs = array();
	foreach ( $ids as $id ) {
		$ch         = curl_init();
		$chs[ $id ] = $ch;
		curl_setopt( $ch, CURLOPT_URL, 'https://twitter.com/intent/user?user_id=' . $id );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );  // タイムアウト秒数を指定
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Accept-Language: ja' ) );
		curl_multi_add_handle( $mh, $ch );
	}

	$running = null;
	do {
		curl_multi_exec( $mh, $running );
	} while ( $running );

	$results = array();
	foreach ( $chs as $id => $ch ) {
		$httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		$html     = curl_multi_getcontent( $ch );
		curl_close( $ch );

		if ( $httpCode === 200 ) {
			$pattern_name                    = '#<title>(.*?)\s?\(@[a-z0-9_]{1,15}\)\s?[^<]+</title>#i';
			$pattern_profile_image_url_https = '<img class="photo" src="(.+?)".+?>';
			$pattern_screen_name             = '#<span class="nickname">@([a-z0-9_]{1,15})</span>#';
			// name
			preg_match( $pattern_name, $html, $name );

			// screen_name
			preg_match( $pattern_screen_name, $html, $screen_name );

			// profile_image_url, profile_image_url_https
			preg_match( $pattern_profile_image_url_https, $html, $profile_image_url_https );
			$profile_image_url_https = str_replace( "200x200", "normal", $profile_image_url_https );
			$profile_image_url       = str_replace( "https", "http", $profile_image_url_https );

			if ( count( $name ) !== 2 || count( $screen_name ) !== 2 || count( $profile_image_url_https ) !== 2 ) {
				return new RuntimeException( "必要な情報が取得できませんでした。(user:{$id})" );
			} else {
				$result         = array(
					"is_exist"                => true,
					"id"                      => $id,
					"screen_name"             => $screen_name[1],
					"name"                    => $name[1],
					"profile_image_url"       => $profile_image_url[1],
					"profile_image_url_https" => $profile_image_url_https[1],

				);
				$results[ $id ] = $result;
			}

		} else {
			return new RuntimeException( "HTMLの取得に失敗しました。(ステータスコード:" . $httpCode . ")" );
		}

	}

	return $results;
}

