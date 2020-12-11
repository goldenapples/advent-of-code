<?php

function solve() {
    $input = process_input();

    $layout = shuffle_seats( $input );
    var_dump( $layout );

    return array_count_values( array_merge( ...$layout ) );
}

function process_input() {
    $input = explode( PHP_EOL, file_get_contents( 'input.txt' ) );
    return array_map( 'str_split', array_filter( $input ) );
}

function shuffle_seats( $layout ) {
    $new_layout = $layout;
    $has_changed = false;

    foreach ( $layout as $y => $row ) {
        foreach ( $row as $x => $seat ) {
            // Nobody sits on the floor
            if ( $seat === '.' ) {
                continue;
            }

            $surrounding_occupied_seats = count_surrounding_occupied_seats( $layout, $y, $x );

            if ( $seat === 'L' && $surrounding_occupied_seats === 0 ) {
                $new_layout[ $y ][ $x ] = '#';
                $has_changed = true;
            }

            if ( $seat === '#' && $surrounding_occupied_seats >= 4 ) {
                $new_layout[ $y ][ $x ] = 'L';
                $has_changed = true;
            }
        }
    }

    if ( $has_changed ) {
        return shuffle_seats( $new_layout );
    }

    return $new_layout;
}

function count_surrounding_occupied_seats( $layout, $y, $x ) {
    $rows = count( $layout );
    $seats = count( $layout[0] );

    $surroundings = array_merge(
        $y == 0 ?
            []
            : array_slice( $layout[ $y - 1 ], max( 0, $x - 1 ), ( $x === 0 || $x === ( $seats - 1 ) ) ? 2 : 3 ),
        $x == 0 ?
            [ $layout[ $y ][1] ]
            : ( $x === $seats - 1 ) ?
                [ $layout[ $y ][ $x - 1 ] ]
                : [ $layout[ $y ][ $x - 1 ], $layout[ $y ][ $x + 1 ] ],
        $y == $rows - 1 ?
            []
            : array_slice( $layout[ $y + 1 ], max( 0, $x - 1 ), ( $x === 0 || $x === ( $seats - 1 ) ) ? 2 : 3 )
    );

    $counts = array_count_values( $surroundings );
    return $counts['#'] ?? 0;
}

$solution = solve();

var_dump( $solution );
