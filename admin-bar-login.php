<?


function strip_admin_bar_of_all_but_user_actions( $wp_admin_bar ) {
	
	if ( is_admin() || current_user_can('manage_options') ) return;
	
	$keep = array(// menu nodes to keep
	'top-secondary',
	'my-account',
	'user-actions',
	'user-info',
	'edit-profile',
	'logout',
	'search',
	);
	$nodes = $wp_admin_bar->get_nodes();
		
	$nodes = array_diff_key( $nodes, array_flip( $keep ) );
	
	foreach ( $nodes as $id => $node ) {
		$wp_admin_bar->remove_node( $id );
	}
}
add_action( 'admin_bar_menu', 'strip_admin_bar_of_all_but_user_actions', 9999 );


add_filter('show_admin_bar', '__return_true');


function wp_admin_bar_login_add( $wp_admin_bar ) {

	if ( is_user_logged_in() ) return;

	$wp_admin_bar->add_menu( array(
		'id'		=> 'login-trigger',
		'parent'	=> 'top-secondary',
		'title'		=> 'Login',
		'href'		=> wp_login_url() . '#fpmlogin',
		'meta'		=> array(
			'class'	=> 'monger-login-trigger',
			'html' => '<style>div#wpadminbar li#wp-admin-bar-login-trigger {display: block;} div#wpadminbar li#wp-admin-bar-login-trigger > a {padding: 0 1em;}</style>',
		),
	) );
}
add_action( 'admin_bar_menu', 'wp_admin_bar_login_add', 9999 );


add_action( 'wp_footer', function(){
	if ( ! is_user_logged_in() )
		echo do_shortcode('[modalmonger login=1 suffix=login text=""]');
} );

add_filter('login_form_bottom', function(){
	$html = wp_register('', ' | ', false);
	$html .= '<a href="'. esc_url( wp_lostpassword_url() ) .'" title="'. esc_attr( 'Password Lost and Found' ) .'">'. __( 'Lost your password?' ) .'</a>';
	return $html;
});

add_shortcode( 'show_login_modal', function($a, $c = ''){ return (is_user_logged_in()) ? $c: '<style>#modalmonger-login{display:block}</style>'; });
