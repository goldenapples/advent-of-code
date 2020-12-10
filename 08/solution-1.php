<?php

function solve() {
    $program = [
        'pointer' => 0,
        'accumulator' => 0,
        'steps' => process_input(),
        'visited' => [],
    ];

    do {
        $program = run_instruction( $program );
    }
    while ( ! in_array( $program['pointer'], $program['visited'] ) );

    var_dump( $program['accumulator'] );
}

function process_input() {
    preg_match_all(
        '#(?<op>\w{3}) (?<val>[+\-]\d+)#',
        file_get_contents( 'input.txt' ),
        $matches,
        PREG_SET_ORDER
    );

    return array_map(
        function ( $line ) {
            return [
                'op' => $line['op'],
                'val' => intval( $line['val'] ),
            ];
        },
        $matches
    );
}

function run_instruction( $program ) {

    extract( $program );

    $current = $steps[ $pointer ];
    array_push( $visited, $pointer );

    switch ( $current['op'] ) {
    case 'acc':
        $accumulator += $current['val'];
        $pointer ++;
        break;
    case 'jmp':
        $pointer += $current['val'];
        break;
    case 'nop':
        $pointer ++;
        break;
    }

    return compact( 'pointer', 'accumulator', 'steps', 'visited' );
}

solve();
