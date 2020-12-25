<?php

function solve() {
    $buses = process_input();

    list( $test, $lcm ) = get_lcm( $buses );
    var_dump( $test, $lcm );

    // Remove the items with modulus 13 from the list to test.
    $buses = array_filter(
        $buses,
        function ( $interval ) use ( $test ) {
            return $interval !== $test;
        }
    );

    var_dump( $buses );

    while ( ! check_time( $test, $buses ) ) {
        print( 'testing: ' . $test . "\r" );
        $test += $lcm;
    }

    echo PHP_EOL. PHP_EOL;
    var_dump( $test );
}

function process_input() {
    $buses = explode( ',', file_get_contents( 'input.txt' ) );

    $buses = array_flip(
        array_filter(
            array_map( 'intval', $buses )
        )
    );

    ksort( $buses );

    var_dump( $buses );


    foreach ( $buses as $interval => $offset ) {
        $buses[ $interval ] = $offset % $interval;
    }

    return $buses;
}

function get_lcm( $list ) {
    $counts = array_count_values( $list );
    arsort( $counts );

    $offset = key( $counts );
    $intervals = array_filter( $list, function ( $elt ) use ( $offset ) { return $elt === $offset; } );

    return [
        - $offset,
        array_reduce(
            array_keys( $intervals ),
            function ( $carry, $value ) {
                return $value * $carry;
            },
            1
        )
    ];
}

function check_time( $time, $schedule ) {
    foreach ( $schedule as $interval => $offset ) {
        if ( ( $time + $offset ) % $interval !== 0 ) {
            return false;
        }
    }

    return true;
}

$solution = solve();

