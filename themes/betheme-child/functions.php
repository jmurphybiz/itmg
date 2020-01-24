<?php

/* ---------------------------------------------------------------------------
 * Child Theme URI | DO NOT CHANGE
 * --------------------------------------------------------------------------- */
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );


/* ---------------------------------------------------------------------------
 * Define | YOU CAN CHANGE THESE
 * --------------------------------------------------------------------------- */

// White Label --------------------------------------------
define( 'WHITE_LABEL', false );

// Static CSS is placed in Child Theme directory ----------
define( 'STATIC_IN_CHILD', false );


/* ---------------------------------------------------------------------------
 * Enqueue Style
 * --------------------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', 'mfnch_enqueue_styles', 101 );
function mfnch_enqueue_styles() {
	
	// Enqueue the parent stylesheet
// 	wp_enqueue_style( 'parent-style', get_template_directory_uri() .'/style.css' );		//we don't need this if it's empty
	
	// Enqueue the parent rtl stylesheet
	if ( is_rtl() ) {
		wp_enqueue_style( 'mfn-rtl', get_template_directory_uri() . '/rtl.css' );
	}
	
	// Enqueue the child stylesheet
	wp_dequeue_style( 'style' );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() .'/style.css' );
	
}


/* ---------------------------------------------------------------------------
 * Load Textdomain
 * --------------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'mfnch_textdomain' );
function mfnch_textdomain() {
    load_child_theme_textdomain( 'betheme',  get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'mfn-opts', get_stylesheet_directory() . '/languages' );
}
/*
 * Alters event's archive titles
 */
function tribe_alter_event_archive_titles ( $original_recipe_title, $depth ) {
	// Modify the titles here
	// Some of these include %1$s and %2$s, these will be replaced with relevant dates
	$title_upcoming =   'Upcoming Events & Outreach'; // List View: Upcoming events
	$title_past =       'Past Events'; // List view: Past events
	$title_range =      'Events for %1$s - %2$s'; // List view: range of dates being viewed
	$title_month =      'Events for %1$s'; // Month View, %1$s = the name of the month
	$title_day =        'Events for %1$s'; // Day View, %1$s = the day
	$title_all =        'All events for %s'; // showing all recurrences of an event, %s = event title
	$title_week =       'Events for week of %s'; // Week view
	// Don't modify anything below this unless you know what it does
	global $wp_query;
	$tribe_ecp = Tribe__Events__Main::instance();
	$date_format = apply_filters( 'tribe_events_pro_page_title_date_format', tribe_get_date_format( true ) );
	// Default Title
	$title = $title_upcoming;
	// If there's a date selected in the tribe bar, show the date range of the currently showing events
	if ( isset( $_REQUEST['tribe-bar-date'] ) && $wp_query->have_posts() ) {
		if ( $wp_query->get( 'paged' ) > 1 ) {
			// if we're on page 1, show the selected tribe-bar-date as the first date in the range
			$first_event_date = tribe_get_start_date( $wp_query->posts[0], false );
		} else {
			//otherwise show the start date of the first event in the results
			$first_event_date = tribe_event_format_date( $_REQUEST['tribe-bar-date'], false );
		}
		$last_event_date = tribe_get_end_date( $wp_query->posts[ count( $wp_query->posts ) - 1 ], false );
		$title = sprintf( $title_range, $first_event_date, $last_event_date );
	} elseif ( tribe_is_past() ) {
		$title = $title_past;
	}
	// Month view title
	if ( tribe_is_month() ) {
		$title = sprintf(
			$title_month,
			date_i18n( tribe_get_option( 'monthAndYearFormat', 'F Y' ), strtotime( tribe_get_month_view_date() ) )
		);
	}
	// Day view title
	if ( tribe_is_day() ) {
		$title = sprintf(
			$title_day,
			date_i18n( tribe_get_date_format( true ), strtotime( $wp_query->get( 'start_date' ) ) )
		);
	}
	// All recurrences of an event
	if ( function_exists('tribe_is_showing_all') && tribe_is_showing_all() ) {
		$title = sprintf( $title_all, get_the_title() );
	}
	// Week view title
	if ( function_exists('tribe_is_week') && tribe_is_week() ) {
		$title = sprintf(
			$title_week,
			date_i18n( $date_format, strtotime( tribe_get_first_week_day( $wp_query->get( 'start_date' ) ) ) )
		);
	}
	if ( is_tax( $tribe_ecp->get_event_taxonomy() ) && $depth ) {
		$cat = get_queried_object();
		$title = '<a href="' . esc_url( tribe_get_events_link() ) . '">' . $title . '</a>';
		$title .= ' &#8250; ' . $cat->name;
	}
	return $title;
}
add_filter( 'tribe_get_events_title', 'tribe_alter_event_archive_titles', 11, 2 );

function add_custom_script(){
?>
<script>
jQuery(window).load(function(){
	jQuery('img').removeAttr('title');
jQuery('a').removeAttr('title');	
});
</script>
<?php
}
add_action('wp_footer', 'add_custom_script');

if ( class_exists( 'Tribe__Tickets__RSVP' ) ) {

	// Remove the form from its default location (after the meta).
	remove_action( 'tribe_events_single_event_after_the_meta', array( Tribe__Tickets__RSVP::get_instance(), 'front_end_tickets_form' ), 5 );
}
if ( class_exists( 'Tribe__Tickets__RSVP' ) ) {

	// Add the form to its new location (before the content).
	add_action( 'tribe_events_single_event_after_the_content', array( Tribe__Tickets__RSVP::get_instance(), 'front_end_tickets_form' ), 5 );
}
if ( class_exists( 'Tribe__Tickets_Plus__Commerce__WooCommerce__Main' ) ) {
	
	// Remove the form from its default location (after the meta).
	remove_action( 'tribe_events_single_event_after_the_meta', array( Tribe__Tickets_Plus__Commerce__WooCommerce__Main::get_instance(), 'front_end_tickets_form' ), 5 );
}
if ( class_exists( 'Tribe__Tickets_Plus__Commerce__WooCommerce__Main' ) ) {

	// Place the form in the new location (before the content).
	add_action( 'tribe_events_single_event_after_the_content', array( Tribe__Tickets_Plus__Commerce__WooCommerce__Main::get_instance(), 'front_end_tickets_form' ), 5 );
}

// Simple products
add_filter( 'woocommerce_quantity_input_args', 'jk_woocommerce_quantity_input_args', 10, 2 );

function jk_woocommerce_quantity_input_args( $args, $product ) {
	if ( is_singular( 'product' ) ) {
		$args['input_value'] 	= 1;	// Starting value (we only want to affect product pages, not cart)
	}
	$args['max_value'] 	= 100; 	// Maximum value
	$args['min_value'] 	= 1;   	// Minimum value
	$args['step'] 		= 1;    // Quantity steps
	return $args;
}

// Variations
add_filter( 'woocommerce_available_variation', 'jk_woocommerce_available_variation' );

function jk_woocommerce_available_variation( $args ) {
	$args['max_qty'] = 100; 		// Maximum value (variations)
	$args['min_qty'] = 1;   	// Minimum value (variations)
	return $args;
}

// remove Order Notes from checkout field in Woocommerce
add_filter( 'woocommerce_checkout_fields' , 'alter_woocommerce_checkout_fields' );
function alter_woocommerce_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

function patricks_billing_fields( $fields ) {
	global $woocommerce;
	// if the total is more than 0 then we still need the fields
	if ( 0 != $woocommerce->cart->total ) {
		return $fields;
	}
	// return the regular billing fields if we need shipping fields
	if ( $woocommerce->cart->needs_shipping() ) {
		return $fields;
	}
  // we don't need the billing fields so empty all of them except the email
  unset( $fields['billing_country'] );
  unset( $fields['billing_company'] );
  unset( $fields['billing_address_1'] );
  unset( $fields['billing_address_2'] );
  unset( $fields['billing_city'] );
  unset( $fields['billing_state'] );
  unset( $fields['billing_postcode'] );
	return $fields;
}
add_filter( 'woocommerce_billing_fields', 'patricks_billing_fields', 20 );
//Change the Billing Address checkout label
function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Billing Address' :
            $translated_text = __( 'Info', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );
 
//Change the Shipping Address checkout label
function wc_shipping_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Shipping Address' :
            $translated_text = __( 'Info', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_shipping_field_strings', 20, 3 );

add_filter ('add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}
?>
