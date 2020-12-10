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

    extract( $passport );

    switch ( false ) {

    // Lots of cases where passports can be invalid. Any of these cases evaluating as false will invalidate the passport.
    case ( empty( $missing_keys ) ) :
    case ( 1920 <= intval( $byr ) && 2020 >= intval( $byr ) ):
    case ( 2010 <= intval( $iyr ) && 2020 >= intval( $iyr ) ):
    case ( 2020 <= intval( $eyr ) && 2030 >= intval( $eyr ) ):
    case ( preg_match( '#^(?<measure>\d{2,3})(?<unit>in|cm)$#', $hgt, $height ) ) :
    case (
        ( $height['unit'] == 'cm' && 150 <= intval( $height['measure'] ) && 193 >= intval( $height['measure'] ) ) ||
        ( $height['unit'] == 'in' && 59 <= intval( $height['measure'] ) && 76 >= intval( $height['measure'] ) )
    ) :
    case ( preg_match( '~^#[0-9a-f]{6}$~', $hcl ) ) :
    case ( in_array( $ecl, [ 'amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth' ] ) ) :
    case ( preg_match( '~^[0-9]{9}$~', $pid ) ):
        return false;
    default:
        return true;
    }
}

$solution = solve();
