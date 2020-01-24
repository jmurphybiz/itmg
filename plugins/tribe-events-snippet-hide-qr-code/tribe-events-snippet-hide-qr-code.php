<?php
/*
 * Plugin Name:       The Events Calendar: Remove QR Codes
 * Plugin URI:        https://theeventscalendar.com
 * Description:       Hides QR codes from the email/tickets sent to purchasers
 * Version:           0.1.1
 * Author:            Modern Tribe
 * Author URI:        http://theeventscalendar.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


function tribe_neuter_qr () {
	if ( class_exists( 'Tribe__Tickets_Plus__Main' ) ) {
		$qr_class = Tribe__Tickets_Plus__Main::instance()->qr();
		remove_action( 'tribe_tickets_ticket_email_ticket_bottom', array( $qr_class, 'inject_qr' ) );
	}
}
add_action( 'init', 'tribe_neuter_qr', 10 );