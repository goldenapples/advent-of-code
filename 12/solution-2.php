<?php

function solve() {
    $input = process_input();

    $position = [ 0, 0 ];
    $waypoint = [ 1, 10 ];

    foreach ( $input as $instruction ) {
        list( $position, $waypoint ) = move( $position, $waypoint, $instruction );

        printf(
            'Instruction: %s. Waypoint: [ %d, %d ]. Coordinates: [ %d, %d ].' . PHP_EOL,
            $instruction[0],
            $waypoint[0],
            $waypoint[1],
            $position[0],
            $position[1]
        );
    }

    return abs( $position[0] ) + abs( $position[1] );
}

function process_input() {
    $input = preg_match_all(
        '#(?<action>\w)(?<value>\d*)#',
        file_get_contents( 'input.txt' ),
        $matches,
        PREG_SET_ORDER
    );

    return $matches;
}

function move( $position, $waypoint, $instruction ) {

    $value = intval( $instruction['value'] );

    switch ( $instruction['action'] ) {

    case 'N':
        $waypoint[0] += $value;
        break;
    case 'S':
        $waypoint[0] -= $value;
        break;
    case 'W':
        $waypoint[1] -= $value;
        break;
    case 'E':
        $waypoint[1] += $value;
        break;
    case 'R':
        $value = -1 * $value;
    case 'L':
        $angle = deg2rad( $value );

        $new_y = ( $waypoint[0] * cos( $angle ) ) + ( $waypoint[1] * sin( $angle ) );
        $new_x = ( $waypoint[1] * cos( $angle ) ) - ( $waypoint[0] * sin( $angle ) );
        $waypoint = [ $new_y, $new_x ];
        break;
    case 'F':

        $position[0] += ( $value * $waypoint[0] );
        $position[1] += ( $value * $waypoint[1] );
        break;
    }

    return [ $position, $waypoint ];
}

$solution = solve();

var_dump( $solution );
