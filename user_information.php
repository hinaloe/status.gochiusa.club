<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

function h( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, "UTF-8" );
}

if( isset( $_GET["id"] ) && is_numeric( $_GET["id"] ) ) {
    $id = h( $_GET["id"] );
    $html = file_get_contents('https://twitter.com/intent/user?user_id='.$id);

    $pattern_name = '#<title>(.*?) \(@[a-z0-9_]{1,15}\) さんはTwitterを使ってます</title>#i';
    $pattern_profile_image_url_https = '<img class="photo" src="(.+?)".+?>';
    $pattern_screen_name = '#<span class="nickname">@([a-z0-9_]{1,15})</span>#';
    // name
    preg_match( $pattern_name, $html , $name );
    
    // screen_name
    preg_match( $pattern_screen_name, $html , $screen_name );
    
    // profile_image_url, profile_image_url_https
    preg_match( $pattern_profile_image_url_https, $html , $profile_image_url_https );
    $profile_image_url_https = str_replace( "200x200", "normal", $profile_image_url_https );
    $profile_image_url = str_replace( "https", "http", $profile_image_url_https );

    $result = array(
        "is_exist" => true,
        "id" => $id,
        "screen_name" => $screen_name[1] ,
        "name" => $name[1],
        "profile_image_url" => $profile_image_url[1],
        "profile_image_url_https" => $profile_image_url_https[1],
    );
} else {
    $result = array(
        "message" => "不正なidです。",
    );
}

echo json_encode( $result , JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );