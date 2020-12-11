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

            if ( $seat === '#' && $surrounding_occupied_seats >= 5 ) {
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
    $directions = [
        [ -1, -1 ],
        [ -1, 0 ],
        [ -1, 1 ],
        [ 0, -1 ],
        [ 0, 1 ],
        [ 1, -1 ],
        [ 1, 0 ],
        [ 1, 1 ]
    ];

    $rows = count( $layout );
    $seats = count( $layout[0] );

    $visible_seats = array_map(
        function ( $direction ) use ( $layout, $y, $x, $rows, $seats ) {
            $visible_y = $y;
            $visible_x = $x;

            do {
                $visible_y += $direction[ 0 ];
                $visible_x += $direction[ 1 ];

                if ( $visible_y < 0 || $visible_y >= $rows || $visible_x < 0 || $visible_x >= $seats ) {
                    return '.';
                }

                $seen = $layout[ $visible_y ][ $visible_x ];

                if ( in_array( $seen, [ 'L', '#' ] ) ) {
                    return $seen;
                }
            } while ( true );
        },
        $directions
    );

    $counts = array_count_values( $visible_seats );
    return $counts['#'] ?? 0;
}

$solution = solve();

var_dump( $solution );
