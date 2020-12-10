<?php

function solve() {
    $input = process_input();
    sort( $input );

    return allowed_permutations( $input, 1 );
}

function process_input() {
    $input = explode( PHP_EOL, file_get_contents( 'input.txt' ) );
    array_push( $input, 0 );
    return array_values( array_unique( array_map( 'intval', $input ) ) );
}

function hash_key( $array ) {
    return crc32( serialize( $array ) );
}

// Permute the possible changes to the adapter list that are still allowed by rules.
function allowed_permutations( array $array ) : int {
    static $memo = [];

    // If there's nothing to remove, there's only one possibility.
    if ( count( $array ) < 2 ) {
        return 1;
    }

    // If we've already counted possibilities for this array, return early with
    // the memoized value.
    $hash_key = hash_key( $array );

    if ( isset( $memo[ $hash_key ] ) ) {
        return $memo[ $hash_key ];
    }

    // Else do the counting with a recursive tail call (count the current ordering as 1)..
    $counter = 1;

    for ( $i = 0; $i < count( $array ) - 2; $i++ ) {

        if ( $array[ $i + 2 ] - $array[ $i ] > 3 ) {

            // If we can't remove the next item in the array, just keep moving.
            continue;
        } else {

            // We've found an allowable permutation by removing the next item
            // in the array. Count it, and continue checking for permutations
            // with this element removed.
            $slice_to_test = array_merge(
                array_slice( $array, $i, 1 ),
                array_slice( $array, $i + 2 )
            );

            $counter += allowed_permutations( $slice_to_test );
        }
    }

    $memo[ $hash_key ] = $counter;
    return $counter;
}

$solution = solve();

var_dump( $solution );
