<?php

header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=utf-8" );

require_once( "functions.php" );


if ( isset( $_GET["id"] ) && is_numeric( $_GET["id"] ) ) {
	$id = h( $_GET["id"] );

	$results = get_users_info( [ $id ] );

	if ( ! $results instanceof Exception ) {
		echo json_encode( $results[ $id ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	} else {
		http_response_code( 500 );
		echo json_encode( array( "message" => $results->getMessage() ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	}
} else {
	http_response_code( 500 );
	json_encode( array( "message" => "不正なidです。" ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}