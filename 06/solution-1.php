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
    $people_in_group = count( explode( PHP_EOL, $group ) );

    $answers_all = array_filter(
        array_count_values( str_split( $group ) ),
        function ( $count, $q ) use ( $people_in_group ) {
            return $count === $people_in_group;
        },
        ARRAY_FILTER_USE_BOTH
    );

    return count( $answers_all );
}

$solution = solve();
