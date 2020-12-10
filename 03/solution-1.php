<?php

function solve() {
    list ( $modulus, $input ) = process_input();

    $hit_trees = traverse( $input, $modulus );

    var_dump( $hit_trees );
}

// Treat the "map" as a binary string and convert it to integers
function process_input() {
    $input = explode(
        PHP_EOL,
        str_replace(
            [ '.', '#' ],
            [ '0', '1' ],
            file_get_contents( 'input.txt' ),
        )
    );

    $modulus = strlen( $input[0] );
    $input = array_map( 'bindec', $input );

    return [ $modulus, $input ];
}

function traverse( $input, $modulus ) {
    $first_position = 1 << ( $modulus - 1 );

    $hit_trees = 0;

    foreach ( $input as $i => $line ) {
        if ( $line & ( $first_position >> ( $i * 3 % $modulus ) ) ) {
            $hit_trees++;
        }
    }

    return $hit_trees;
}

$solution = solve();
