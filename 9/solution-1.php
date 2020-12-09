<?php

function solve() {
    $input = process_input();

    $preamble_length = 25;

    for ( $i = $preamble_length; $i < count( $input ); $i++ ) {
        $previous_batch = array_slice( $input, $i - $preamble_length, $preamble_length );
        $matched_pair = find_pair_that_sums( $previous_batch, $input[ $i ] );

        if ( ! $matched_pair ) {
            echo $input[ $i ] . " is not the sum of any of the previous $preamble_length numbers." . PHP_EOL;
            exit;
        }
    }
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

    return false;
}

$solution = solve();

var_dump( $solution );
