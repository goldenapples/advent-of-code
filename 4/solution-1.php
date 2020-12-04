<?php

function solve() {
    $input = process_input();

    echo "There are " . count( $input ) . " total passports." . PHP_EOL;

    $valid_passports = array_filter(
        $input,
        'is_valid'
    );

    echo count( $valid_passports ) . " of them are valid." . PHP_EOL;
}

function process_input() {
    $input = explode(
        PHP_EOL . PHP_EOL,
        trim( file_get_contents( 'input.txt' ) )
    );

    return array_map( 'parse_passport', $input );
}

function parse_passport( $passport ){
    $parts = preg_match_all(
        '#(\w{3}):([^\s]*)#',
        $passport,
        $matches
    );

    return array_filter( array_combine( $matches[1], $matches[2] ) );
}

const REQUIRED_KEYS = [ 'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid' ]; // ignoring 'cid'

function is_valid( $passport ) {

    $missing_keys = array_diff(
        REQUIRED_KEYS,
        array_keys( $passport )
    );

    return empty( $missing_keys );
}

$solution = solve();
