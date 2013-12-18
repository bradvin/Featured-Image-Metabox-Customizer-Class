<?php
/*
Plugin Name: Featured Image Metabox Customizer Demo
Description: A demo plugin showcasing how to customize the featured image metabox for a specific post type
Version: 1.0.0
Author: Brad Vincent
Author URI: http://themergency.com
License: GPL2
*/

require_once 'class-featured-image-metabox-cusomizer.php';

new Featured_Image_Metabox_Customizer(array(
	'post_type'     => 'page',
	'metabox_title' => __( 'Company Logo', 'feat-img-custom' ),
	'set_text'      => __( 'Set Company logo', 'feat-img-custom' ),
	'remove_text'   => __( 'Remove Company logo', 'feat-img-custom' )
));