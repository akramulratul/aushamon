<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
* Third party
*/
class WooLentorProductQuery{

    /**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Base]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){

        if( class_exists('WooCommerce') ){
            add_action( 'woocommerce_product_query', [ $this, 'parse_query' ] );

            //compatibility with woo shortcode
            add_filter('woocommerce_shortcode_products_query', [ $this, 'woocommerce_shortcode_products_query' ], 99, 3 );

        }

    }

    /**
     * [parse_query]
     * @param  [object] $wp_query WooCommerce Default Widget
     * @return [void]
     */
    public function parse_query( $wp_query ){

        if ( isset( $_GET['wlfilter'] ) ) {

            $queries =[];
            $new_queries = [];
            parse_str( $_SERVER['QUERY_STRING' ], $queries );
            foreach ( $queries as $key => $querie ) {
                $new_queries[] = $key;
            }

            if( isset( $_GET['wlorder_by'] ) ){
                if( in_array( $_GET['wlorder_by'], [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {

                    $wp_query->set( 'meta_key', $_GET['wlorder_by'] );
                    $wp_query->set( 'orderby', 'meta_value_num' );

                }else{
                    $wp_query->set( 'orderby', $_GET['wlorder_by'] );
                }
            }

            if( isset( $_GET['wlsort'] ) ){
                $wp_query->set( 'order', $_GET['wlsort'] );
            }

            $wp_query->set( 'meta_query', $this->get_meta_query() );

            $wp_query->set( 'tax_query', $this->get_tax_query() );

            
        }

    }

    public function woocommerce_shortcode_products_query( $query_args, $attr, $type = "" ) {
        if ( isset( $_GET['wlfilter'] ) ) {

            $query_args['tax_query'] = array_merge( $query_args['tax_query'], $this->get_tax_query() );
            $query_args['meta_query'] = array_merge( $query_args['meta_query'], $this->get_meta_query() );
            $query_args = apply_filters('woolentor_products_query', $query_args);

            if ( isset( $_GET['paged'] ) ) {
                $query_args['paged'] = intval( $_GET['paged'] );
            }

            if ( isset( $_GET['orderby'] ) ) {
                $ordering_args = WC()->query->get_catalog_ordering_args();
            } else {
                $ordering_args = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
            }
            $query_args['orderby'] = $ordering_args['orderby'];
            $query_args['order'] = $ordering_args['order'];
            if ( $ordering_args['meta_key'] ) {
                $query_args['meta_key'] = $ordering_args['meta_key'];
            }

            if( isset( $_GET['wlorder_by'] ) ){
                if( in_array( $_GET['wlorder_by'], [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
                    
                    $query_args['meta_key'] = $_GET['wlorder_by'];
                    $query_args['orderby'] = 'meta_value_num';

                }else{
                    $query_args['orderby'] = $_GET['wlorder_by'];
                }
            }

            if( isset( $_GET['wlsort'] ) ){
                $query_args['order'] = $_GET['wlsort'];
            }


        }

        // Search Result
        if ( isset( $_GET['q'] ) || isset( $_GET['s'] ) ) {
            $s = !empty( $_GET['s'] ) ? $_GET['s'] : '';
            $q = !empty( $_GET['q'] ) ? $_GET['q'] : '';
            $query_args['s'] = !empty( $q ) ? $q : $s;
        }

        // Taxonomy Taxquery
        $termobj = get_queried_object();
        if( isset( $termobj->taxonomy ) ){
            $term_id = $termobj->term_id;
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => $termobj->taxonomy,
                    'terms' => $term_id,
                    'field' => 'term_id',
                    'include_children' => true
                )
            );
        }

        return $query_args;
    }

    /**
     * [get_tax_query]
     * @return [array]
     */
    public function get_tax_query(){
        if ( isset( $_GET['wlfilter'] ) ) {

            $queries =[];
            $new_queries = [];
            parse_str( $_SERVER['QUERY_STRING' ], $queries );
            foreach ( $queries as $key => $querie ) {
                $new_queries[] = $key;
            }

            $woo_taxonomies = get_object_taxonomies( 'product' );

            $tax_query = array();
            if( isset( $new_queries[1] ) && !in_array( $new_queries[1], [ 'wlsort', 'wlorder_by' ] ) ){
                $attr_pre_str = substr( $new_queries[1], 0, 6 );

                $taxonomy = ( 'filter' === $attr_pre_str ) ? str_replace('filter', 'pa', $new_queries[1] ) : $new_queries[1];
                if( isset( $_GET[$new_queries[1] ] ) && in_array( $taxonomy, $woo_taxonomies ) ){
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field' => 'name',
                        'terms' => explode( ',', $_GET[$new_queries[1]] ),
                    );
                }

            }

            if( isset( $_GET['wlorder_by'] ) && $_GET['wlorder_by'] === 'featured' ){
                $tax_query[] = [
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => explode( ',', $_GET['wlorder_by'] ),
                    'operator' => ( $_GET['wlorder_by'] === 'exclude-from-catalog' ? 'NOT IN' : 'IN' ),
                ];
            }

            return $tax_query;            
        }

    }

    /**
     * [get_meta_query]
     * @return [array] meta Query
     */
    public function get_meta_query(){

        $meta_query = WC()->query->get_meta_query();
        $meta_query = array_merge( array('relation' => 'AND'), $meta_query );

        if( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ){
            $meta_query[] = array(
                [
                    'key' => '_price',
                    'value' => array( $_GET['min_price'], $_GET['max_price'] ),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC'
                ],
            );
        }
        return $meta_query;

    }

    
}

WooLentorProductQuery::instance();