<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
vc_include_template( 'pages/partials/vc-roles-parts/_part.tpl.php', array(
	'part' => $part,
	'role' => $role,
	'params_prefix' => 'vc_roles[' . $role . '][' . $part . ']',
	'controller' => vc_role_access()->who( $role )->part( $part ),
	'options' => array(
		array( true, __( 'Enabled', 'page_builder' ) ),
		array( false, __( 'Disabled', 'page_builder' ) ),
	),
	'main_label' => __( 'Grid Builder', 'page_builder' ),
	'custom_label' => __( 'Grid Builder', 'page_builder' ),
	'description' => __( 'Control user access to Grid Builder and Grid Builder Elements.', 'page_builder' ),
) );
