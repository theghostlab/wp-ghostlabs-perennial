<?php


if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$ghostlabs_dynamic_copyright_option = 'ghostlabs_dynamic-copyright_year';

delete_option( $ghostlabs_dynamic_copyright_option );

if ( is_multisite() ) {
	$ghostlabs_dynamic_copyright_sites = get_sites(
		[
			'fields' => 'ids',
			'number' => 0,
		]
	);

	foreach ( $ghostlabs_dynamic_copyright_sites as $ghostlabs_dynamic_copyright_site_id ) {
		switch_to_blog( (int) $ghostlabs_dynamic_copyright_site_id );
		delete_option( $ghostlabs_dynamic_copyright_option );
		restore_current_blog();
	}
}
