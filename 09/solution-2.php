<?php

function solve() {
    $input = process_input();

    $invalid_number = 15353384;

    for ( $i = 0; $i < count( $input ); $i++ ) {
        $matched_series = find_series_that_sums( $invalid_number, array_slice( $input, $i ) );

        if ( ! $matched_series ) {
            continue;
        }

        sort( $matched_series );

        return ( $matched_series[0] + $matched_series[ count( $matched_series ) - 1 ] );
    }

}

function process_input() {
    $input = explode( PHP_EOL, file_get_contents( 'input.txt' ) );
    return array_map( 'intval', $input );
}

function find_series_that_sums( $target, $array ) {
    $sum = 0;
    $series = [];

    while ( $sum < $target ) {
        $next = array_shift( $array );
        array_push( $series, $next );
        $sum += $next;
    }

    if ( $sum > $target ) {
        return false;
    }

    return $series;
}

$solution = solve();

var_dump( $solution );
