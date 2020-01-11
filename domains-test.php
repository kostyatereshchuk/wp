<?php

function generate_all_domains( $name, $zones ) {
    $postfixes = array( 's', 'es' );
    $prefixes = array( 'the', 'a' );

    $domains = array();

    $max_domains_count = 10000;

    foreach ( $zones as $zone ) {
        $domains[] = $name . '.' . $zone;
    }

    foreach ( $zones as $zone ) {
        foreach ( $postfixes as $postfix ) {
            $domains[] = $name . $postfix . '.' . $zone;

            if ( count( $domains ) >= $max_domains_count ) {
                break;
            }
        }
    }

    foreach ( $zones as $zone ) {
        foreach ( $prefixes as $prefix ) {
            $domains[] = $prefix . $name . '.' . $zone;

            if ( count( $domains ) >= $max_domains_count ) {
                break;
            }
        }
    }

    foreach ( $zones as $zone ) {
        foreach ( $prefixes as $prefix ) {
            foreach ( $postfixes as $postfix ) {
                $domains[] = $prefix . $name . $postfix . '.' . $zone;

                if ( count( $domains ) >= $max_domains_count ) {
                    break;
                }
            }

            if ( count( $domains ) >= $max_domains_count ) {
                break;
            }
        }

        if ( count( $domains ) >= $max_domains_count ) {
            break;
        }
    }

    return $domains;
}


$name = 'test';

$zones = array( 'com', 'org', 'in', 'news', 'top', 'mobile', 'es', 'eu' );

$domains = generate_all_domains( $name, $zones );



$available_domains = array();

$max_available_domains_count = 20;

$iteration = 0;

$stop_iteration = false;

while ( count( $available_domains ) < $max_available_domains_count ) {
    $iteration++;

    $domains_to_check = array();

    for ( $i = ($iteration -1) * 50; $i < $iteration * 50; $i++ ) {
        if ( ! isset( $domains[$i] ) ) {
            $stop_iteration = true;

            break;
        }

        $domains_to_check[] = $domains[$i];
    }

    echo 'Iteration ' . $iteration . '<br>';
    echo '<pre>';
    print_r( $domains_to_check );
    echo '</pre>';

    // TODO: extend $available_domains array; ($available_domains[] = $domain)

    if ( count( $available_domains ) >= $max_available_domains_count ) {
        $stop_iteration = true;
    }

    if ( $stop_iteration ) {
        break;
    }

}

