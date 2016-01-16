<?php
/**
 * http://techblog.yahoo.co.jp/architecture/api1_curl_multi/
 * 複数URLのコンテンツ、及び通信ステータスを一括取得する。
 * サンプル:
 *   $urls = array( "http://〜", "http://〜", "http://〜" );
 *   $results = getMultiContents($urls);
 *   print_r($results);
 */
function getMultiContents( $url_list ) {
    // マルチハンドルの用意
    $mh = curl_multi_init();

    // URLをキーとして、複数のCurlハンドルを入れて保持する配列
    $ch_list = array();

    // Curlハンドルの用意と、マルチハンドルへの登録
    foreach( $url_list as $url ) {
        $ch_list[$url] = curl_init($url);
        curl_setopt($ch_list[$url], CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch_list[$url], CURLOPT_TIMEOUT, 5);  // タイムアウト秒数を指定
        curl_setopt($ch_list[$url], CURLOPT_SSL_VERIFYPEER,false);
        curl_multi_add_handle($mh, $ch_list[$url]);
    }

    // 一括で通信実行、全て終わるのを待つ
    $running = null;
    do { curl_multi_exec($mh, $running); } while ( $running );

    // 実行結果の取得
    foreach( $url_list as $url ) {
        // ステータスとコンテンツ内容の取得
        $results[$url] = curl_getinfo($ch_list[$url]);
        $results[$url]["content"] = curl_multi_getcontent($ch_list[$url]);

        // Curlハンドルの後始末
        curl_multi_remove_handle($mh, $ch_list[$url]);
        curl_close($ch_list[$url]);
    }

    // マルチハンドルの後始末
    curl_multi_close($mh);

    // 結果返却
    return $results;
}