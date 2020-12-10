<?php

function solve() {
    $program = [
        'pointer' => 0,
        'accumulator' => 0,
        'steps' => process_input(),
        'visited' => [],
    ];

    for ( $i = 0; $i < count( $program['steps'] ); $i++ ) {
        test( $program, $i );
    }
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

function test( $program, $instruction_to_change ) {
    $op = $program['steps'][ $instruction_to_change ]['op'];

    if ( $op === 'nop' ) {
        echo "Testing changing instruction $instruction_to_change to 'jmp'." . PHP_EOL;
        $program['steps'][ $instruction_to_change ]['op'] = 'jmp';
    } elseif ( $op === 'jmp' ) {
        echo "Testing changing instruction $instruction_to_change to 'nop'." . PHP_EOL;
        $program['steps'][ $instruction_to_change ]['op'] = 'nop';
    } else {
        return;
    }

    do {
        $program = run_instruction( $program );
    }
    while ( ! in_array( $program['pointer'], $program['visited'] ) );
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

    // If the program has terminated, output the value and exit;
    if ( $pointer >= count( $steps ) ) {
        echo "Program terminated! Acc value $accumulator." . PHP_EOL;
        exit;
    }

    return compact( 'pointer', 'accumulator', 'steps', 'visited' );
}

solve();
