<?php

/**
 * Plugin main file.
 *
 * @wordpress-plugin
 * Plugin Name:       Kntnt's Any Term for Beaver Builder Page Builder
 * Plugin URI:        https://github.com/TBarregren/kntnt-bb-any-term
 * Description:       Adds special purpose term to every taxonomy (including categories and tags) that makes taxonomy filters in post modules of Beaver Builder Page Builder (e.g. Post Grid, Post Slider, Post Carousel) to match posts that has at least on term in that taxonomy in common with the post that the module appeares on. It can for instance be used to create reading recommendations at the end of a blog post.
 * Version:           1.0.4
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.se/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       kntnt-bb-any-term
 * Domain Path:       /languages
 */

namespace Kntnt\BB_Any_Term;

defined( 'WPINC' ) || die;

new Plugin();

final class Plugin {

	// For each public taxonomy, there is an key/value pair, where key is the
	// taxonomy's slug and key is the term id of the taxonomy's "any term".
	private $tids = [];

	// Post id of the main loop post.
	private $pid = false;

	// Whether "any term" should be removed from the array returned by
	// get_terms().
	private $hide_any_term = true;

	// Start here. :-)
	public function __construct() {

		// Setup localization.
		load_plugin_textdomain( 'kntnt-bb-any-term', false, 'languages' );

		// Make sure there is an "any term" in each public taxonomi.
		add_action( 'init', [ $this, 'control_term_id' ] );

		// Unhide "any term" when module settings are rendered.
		if ( '1' === FL_BUILDER_VERSION[0] ) {
			add_action( 'fl_ajax_before_render_module_settings', [ $this, 'unhide_any_tag' ] );
			add_action( 'fl_ajax_after_render_module_settings', [ $this, 'hide_any_tag' ] );
		} else {
			add_action( 'fl_ajax_before_get_autosuggest_values', [ $this, 'unhide_any_tag' ] );
			add_action( 'fl_ajax_after_get_autosuggest_values', [ $this, 'hide_any_tag' ] );
		}

		// Unhide "any term" for autosuggest.
		add_action( 'fl_ajax_before_fl_builder_autosuggest', [ $this, 'unhide_any_tag' ] );
		add_action( 'fl_ajax_after_fl_builder_autosuggest', [ $this, 'hide_any_tag' ] );

		// Remove "any term" in all listings, except for Beaver Builder.
		add_filter( 'get_terms', [ $this, 'remove_any_term' ], 10, 4 );

		// Replace the "any term" with the actual tags of the post.
		add_filter( 'fl_builder_loop_before_query_settings', [ $this, 'filter_query_settings' ] );

		// Exclude current post from the query.
		add_action( 'pre_get_posts', [ $this, 'exclude_current_page' ] );

	}

	// Unhides "any term" before get_terms() is called to get terms that
	// are suggested in Beaver Builder administrative interface.
	public function unhide_any_tag( $args ) {
		$this->hide_any_term = false;
	}

	// Hides "any term" after get_terms() has been called to get terms that
	// are suggested in Beaver Builder administrative interface.
	public function hide_any_tag( $args ) {
		$this->hide_any_term = true;
	}

	// Makes sure there is an "any term" in each public taxonomy.
	public function control_term_id() {
		foreach ( get_taxonomies( [ 'public' => true ] ) as $tax ) {
			$res = term_exists( 'kntnt-bb-any-term', $tax );
			if ( is_null( $res ) ) {
				$res = wp_insert_term( __( 'Any term of the post', 'kntnt-bb-any-term' ), $tax, [ 'slug' => 'kntnt-bb-any-term' ] );
				if ( is_wp_error( $res ) ) {
					error_log( $res->get_error_message() );
					$res['term_id'] = null;
				}
			}
			$this->tids[ $tax ] = $res['term_id'];
		}
	}

	// Hides "any term" in all listings, except for Beaver Builder.
	public function remove_any_term( $terms, $taxonomies, $args, $term_query ) {
	  $fields = $term_query->query_vars['fields'];
		if ( $this->hide_any_term && ( 'all' == $fields || 'ids' == $fields ) ) {
			foreach ( $terms as $i => $term ) {
				if ( 'all' == $fields ) {
					$tid = $term->term_id;
					$tax = $term->taxonomy;
				}
        else {
          $tid = $term;
					$tax = $taxonomies[0];
				}
				if ( isset( $this->tids[ $tax ] ) && $this->tids[ $tax ] == $tid ) {
					unset( $terms[ $i ] );
				}
			}
		}

		return $terms;
	}

	// Replaces the "any term" with the tags of the main loop post.
	public function filter_query_settings( $settings ) {
		foreach ( $this->tids as $tax => $tid ) {
			if ( isset( $settings->{"tax_post_$tax"} ) ) {
				$tags = explode( ',', $settings->{"tax_post_$tax"} );
				if ( false !== ( $i = array_search( $tid, $tags ) ) ) {
					unset( $tags[ $i ] );
					if ( $this->pid = get_the_ID() ) {
						$tags = array_merge( $tags, wp_get_post_terms( $this->pid, $tax, [ 'fields' => 'ids' ] ) );
					}
					$settings->{"tax_post_$tax"} = implode( ',', $tags );
				}
			}
		}

		return $settings;
	}

	public function exclude_current_page( $query ) {
		if ( $this->pid ) {
			$query->set( 'post__not_in', [ $this->pid ] );
			$this->pid = false; // Prevents additional queries to be modified.
		}
	}

}
