<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || die;

foreach ( get_taxonomies( [ 'public' => true ] ) as $tax ) {
	if ( $res = term_exists( 'kntnt-bb-any-term', $tax ) ) {
		wp_delete_term( $res['term_id'], $tax );
	}
}