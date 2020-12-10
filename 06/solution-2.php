<?php

function solve() {
    $input = process_input();

    $count_by_group = array_map( 'count_by_group', $input );

    $total = array_reduce(
        $count_by_group,
        function ( $carry, $count ) {
            return $carry + $count;
        },
        0
    );

    var_dump( $total );
}

function process_input() {
    $input = explode(
        PHP_EOL . PHP_EOL,
        trim( file_get_contents( 'input.txt' ) )
    );

    return $input;
}

function count_by_group( $group ) {
    $group = str_replace( PHP_EOL, '', $group );

    $all = array_filter(
        array_unique( str_split( $group ) )
    );

    return count( $all );
}

$solution = solve();
