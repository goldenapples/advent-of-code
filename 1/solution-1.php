<?php

function solve() {
    $input = process_input();
    list( $a, $b ) = find_pair_that_sums( $input, 2020 );

    return $a * $b;
}

function process_input() {
    $input = explode( PHP_EOL, file_get_contents( 'input.txt' ) );

    return array_map( 'intval', $input );
}

function find_pair_that_sums( $input, $desired_sum ) {
    foreach ( $input as $i => $a ) {
        foreach ( $input as $j => $b ) {
            if ( $i === $j ) {
                continue;
            }

            if ( $a + $b === $desired_sum ) {
                return [ $a, $b ];
            }
        }
    }
}

$solution = solve();

var_dump( $solution );
