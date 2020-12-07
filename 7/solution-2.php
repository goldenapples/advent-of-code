<?php

function solve() {
    $input = process_input();

    // Subtract one because the question asks "how many OTHER bags"...
    var_dump( bags_inside( 'shiny gold', $input ) - 1 );
}

function process_input() {
    $input = preg_match_all(
        '#(?<parent>[\w ]*) bags? contain (?<allowed>.*)\.#',
        file_get_contents( 'input.txt' ),
        $matches,
        PREG_SET_ORDER
    );

    $rules = [];

    foreach ( $matches as $rule ) {
        $rules[ $rule['parent'] ] = allowed_children( $rule['allowed'] );
    }

    return $rules;
}

// Parse the text into a standard format for the required children of each bag type.
function allowed_children( $allowed_string ) {
    preg_match_all(
        '#(?<qty>\d+) (?<color>\w+ \w+) bags?#',
        $allowed_string,
        $matches,
        PREG_SET_ORDER
    );

    return array_map(
        function( $a ) {
            return array_intersect_key(
                $a,
                [
                    'qty' => true,
                    'color' => true,
                ]
            );
        },
        $matches
    );
}

function bags_inside( $color, $input ) {

    // The bag itself is 1.
    $bag_count = 1;

    foreach ( ( $input[ $color ] ?? [] ) as $requirement ) {
        $bags_inside = $requirement['qty'] * bags_inside( $requirement['color'], $input );
        $bag_count += $bags_inside;
    }

    return $bag_count;
}

$solution = solve();
