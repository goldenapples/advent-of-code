<?php

function solve() {
    $input = process_input();
    sort( $input );


    $counts = [
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 1, // Always the last step is a difference of 3
    ];

    for ( $i = 0; $i < ( count( $input ) - 1 ); $i++ ) {
        $difference = abs( $input[ $i + 1 ] - $input[ $i ] );

        $counts[ $difference ] ++;
    }

    var_dump( $counts );

    return $counts[1] * $counts[3];
}

function process_input() {
    $input = explode( PHP_EOL, file_get_contents( 'input.txt' ) );
    array_push( $input, 0 );
    return array_values( array_unique( array_map( 'intval', $input ) ) );
}

$solution = solve();

var_dump( $solution );
