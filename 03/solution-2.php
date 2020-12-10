<?php

function solve() {
    list ( $modulus, $input ) = process_input();

    $slopes_to_check = [
        [ 1, 1 ],
        [ 3, 1 ],
        [ 5, 1 ],
        [ 7, 1 ],
        [ 1, 2 ],
    ];

    $hit_trees = array_map(
        function ( $slope ) use ( $modulus, $input ) {
            return traverse( $input, $modulus, $slope );
        },
        $slopes_to_check
    );

    var_dump( $hit_trees );

    $product = array_reduce(
        $hit_trees,
        function ( $carry, $num ) { return $carry * $num; },
        1
    );

    var_dump( $product );
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

function traverse( $input, $modulus, $slope ) {
    list ( $x, $y ) = $slope;

    // Skip lines if the downward slope would miss them.
    $input = array_values(
        array_filter(
            $input,
            function ( $line, $i ) use ( $y ) {
                return ! ( $i % $y );
            },
            ARRAY_FILTER_USE_BOTH
        )
    );

    $first_position = 1 << ( $modulus - 1 );
    $hit_trees = 0;


    foreach ( $input as $i => $line ) {

        if ( $line & ( $first_position >> ( $i * $x % $modulus ) ) ) {
            $hit_trees++;
        }
    }

    return $hit_trees;
}

$solution = solve();
