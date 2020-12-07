<?php

function solve() {
    $input = process_input();
    sort( $input );

    var_dump( $input );

    var_dump( max( $input ) );
}

function process_input() {
    $input = explode(
        PHP_EOL,
        trim( file_get_contents( 'input.txt' ) )
    );


    return array_map( 'get_seat_number', $input );
}

function get_seat_number( $pass ) {
    $pass = str_replace(
        [ 'F', 'B', 'L', 'R' ],
        [ '0', '1', '0', '1' ],
        $pass
    );

    return bindec( $pass );
}

$solution = solve();
