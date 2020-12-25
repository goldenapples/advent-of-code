<?php

function solve() {
    list( $start_time, $buses ) = process_input();

    $bus_times = array_combine(
        $buses,
        array_map(
            function ( $interval ) use ( $start_time ) {
                return $interval * ceil( $start_time / $interval );
            },
            $buses
        )
    );

    asort( $bus_times );

    return array_key_first( $bus_times ) * ( current( $bus_times ) - $start_time );
}

function process_input() {
    list ( $start_time, $buses ) = explode(
        PHP_EOL,
        file_get_contents( 'input.txt' ),
    );

    $buses = array_filter(
        array_map( 'intval', explode( ',', $buses ) )
    );

    return [ (int) $start_time, $buses ];
}

$solution = solve();

var_dump( $solution );
