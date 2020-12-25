<?php

function solve() {
    $input = process_input();

    $position = [ 0, 0 ];
    $direction = 0;

    foreach ( $input as $instruction ) {
        list( $position, $direction ) = move( $position, $direction, $instruction );

        printf(
            'Instruction: %s. Facing %d. Coordinates: [ %d, %d ].' . PHP_EOL,
            $instruction[0],
            $direction,
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

function move( $position, $direction, $instruction ) {

    $value = intval( $instruction['value'] );

    switch ( $instruction['action'] ) {

    case 'N':
        $position[0] += $value;
        break;
    case 'S':
        $position[0] -= $value;
        break;
    case 'W':
        $position[1] -= $value;
        break;
    case 'E':
        $position[1] += $value;
        break;
    case 'L':
        $direction += $value;
        var_dump( 'turning left by '.$value);
        break;
    case 'R':
        $direction -= $value;

        var_dump( 'turning right by '.$value);
        break;
    case 'F':
        $position[0] += ( $value * sin( deg2rad( $direction ) ) );
        $position[1] += ( $value * cos( deg2rad( $direction ) ) );
        break;

    }

    return [ $position, (int) $direction ];
}

$solution = solve();

var_dump( $solution );
