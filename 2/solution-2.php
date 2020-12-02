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
        '#(?<one>\d+)-(?<two>\d+) (?<char>\w): (?<password>\w+)#',
        file_get_contents( 'input.txt' ),
        $matches,
        PREG_SET_ORDER
    );

    return $matches;
}

function is_valid( $input ) {
    $password_chars = str_split( $input['password'] );

    $idx_1 = intval( $input['one'] ) -1;
    $idx_2 = intval( $input['two'] ) -1;

    return $password_chars[ $idx_1 ] === $input['char']
        xor $password_chars[ $idx_2 ] === $input['char'];
}

$solution = solve();
