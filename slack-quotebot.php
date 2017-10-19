<?php

/*
Plugin Name: Slack Quotebot
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: Admin
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

function sqb_register_quote_post_type() {

	/**
	 * Post Type: Quotes.
	 */

	$labels = array(
		"name" => __( "Quotes", "twentyseventeen" ),
		"singular_name" => __( "Quote", "twentyseventeen" ),
	);

	$args = array(
		"label" => __( "Quotes", "twentyseventeen" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "quote", "with_front" => true ),
		"query_var" => true,
		"supports" => false,
	);

	register_post_type( "quote", $args );

	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => 'sqb_quote',
			'title' => 'Quote',
			'fields' => array (
				array (
					'key' => 'field_59e7a0de60e13',
					'label' => 'Quote',
					'name' => 'quote',
					'type' => 'text',
					'required' => 1,
					'default_value' => '',
					'placeholder' => 'Write down the quote here',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_59e7a12460e14',
					'label' => 'Quotemaster',
					'name' => 'quotemaster',
					'type' => 'text',
					'required' => 1,
					'default_value' => '',
					'placeholder' => 'The person that quoted',
					'prepend' => '',
					'append' => '',
					'formatting' => 'html',
					'maxlength' => '',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'quote',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'no_box',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));
	}
}

add_action( 'init', 'sqb_register_quote_post_type' );

function sqb_filter_quote_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'quote' => __( 'Quote' ),
		'quotemaster' => __( 'Quotemaster' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_filter( 'manage_edit-quote_columns', 'sqb_filter_quote_columns' );

function sqb_manage_quote_column( $column, $post_id ) {
	switch( $column ) {
		case 'quote':
			$quote = get_post_meta( $post_id, 'quote', true );
			echo $quote;
			break;
		case 'quotemaster':
			$quotemaster = get_post_meta( $post_id, 'quotemaster', true );
			echo $quotemaster;
			break;
		default:
			break;
	}
}

add_action( 'manage_quote_posts_custom_column', 'sqb_manage_quote_column', 10, 2 );

