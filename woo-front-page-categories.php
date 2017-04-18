<?php
/**
 * Plugin Name: WooCommerce Front Page Categories
 * Plugin URI: http://www.netpad.gr
 * Description: Displays an in-line list of your WooCommerce categories
 * Version: 1.0
 * Author: George Tsiokos
 * Author URI: http://www.netpad.gr
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright (c) 2015-2016 "gtsiokos" George Tsiokos www.netpad.gr
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'woo_front_page_categories', 'woo_front_page_categories' );
function woo_front_page_categories() {
	$taxonomy     = 'product_cat';
	$orderby      = 'name';
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no
	$title        = '';
	$empty        = 0;
	
	$output = '';
	
	$args = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'show_count'   => 0,
			'pad_counts'   => 0,
			'hierarchical' => 1,
			'title_li'     => $title,
			'hide_empty'   => $empty
	);
	$all_categories = get_categories( $args );
	write_log( 'categories' );
	write_log( $all_categories);
	foreach ($all_categories as $cat) {
		if($cat->category_parent == 0) {
			//$category_id = $cat->term_id;
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			$thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
			$output .= '<ul class="product-cats" style="display:inline;">';
			$output .= '<li>';
			//$output .= woocommerce_subcategory_thumbnail( $cat );
			// @todo add alt text attr, img width, img height.
			
			$output .= '<a href="'. esc_url( get_term_link( $cat->slug, 'product_cat' ) ) .'">';
			$output .= '<img src="' . $thumbnail_src[0] .'">';
			$output .= '</a>';
			$output .= '</li>';
			$output .= '</ul>';
			
	
			/*$args2 = array(
					'taxonomy'     => $taxonomy,
					'child_of'     => 0,
					'parent'       => $category_id,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty
			);
			$sub_cats = get_categories( $args2 );
			if($sub_cats) {
				foreach($sub_cats as $sub_category) {
					$output .=  $sub_category->name ;
				}
			}*/
		}
	}
	//get_woocommerce_term_meta();
	//$parentid = get_queried_object_id();
	/*
	$terms = get_terms( 
			array( 
				'taxonomy' => 'product_cat',
				'childless' => true,
				'parent' => 0 
			)
	);
	write_log( 'terms' );
	write_log( get_queried_object_id() );
	if ( $terms ) {
		 
		echo '<ul class="product-cats">';
		 
		foreach ( $terms as $term ) {
			 
			$output .= '<li class="category">';
			 
			//woocommerce_subcategory_thumbnail( $term );
			 
			$output .= '<h2>';
			$output .= '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
			$output .= $term->name;
			$output .= '</a>';
			$output .= '</h2>';
			 
			$output .= '</li>';
			 
	
		}
		 
		$output .= '</ul>';
	}*/
	
	return $output;
}