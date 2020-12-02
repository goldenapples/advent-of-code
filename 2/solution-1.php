<?php

function solve() {
    $input = process_input();

    $valid_pws = array_filter(
        $input,
        'is_valid'
    );

    var_dump( count( $valid_pws ) );
}

function process_input() {
    $input = preg_match_all(
        '#(?<min>\d+)-(?<max>\d+) (?<char>\w): (?<password>\w+)#',
        file_get_contents( 'input.txt' ),
        $matches,
        PREG_SET_ORDER
    );

    return $matches;
}

function is_valid( $input ) {
    $used_chars = array_filter(
        str_split( $input['password'] ),
        function ( $char ) use ( $input ) {
            return $char === $input['char'];
        }
    );

    return count( $used_chars ) >= (int) $input['min']
        && count( $used_chars ) <= (int) $input['max'];
}

$solution = solve();
