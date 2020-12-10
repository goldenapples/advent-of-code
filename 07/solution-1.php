<?php

function solve() {
    $input = process_input();

    var_dump( bags_that_can_hold( 'shiny gold', $input ) );
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

function bags_that_can_hold( $color, $input ) {
    static $checked = [];

    $parents = [];

    if ( in_array( $color, $checked ) ) {
        return $parents;
    }

    array_push( $checked, $color );

    foreach ( $input as $parent => $allowed_children ) {
        if ( in_array( $color, array_column( $allowed_children, 'color' ) ) ) {
            array_push( $parents, $parent );

            $parents = array_merge( $parents, bags_that_can_hold( $parent, $input ) );
        }
    }

    return array_unique( $parents );
}

$solution = solve();
