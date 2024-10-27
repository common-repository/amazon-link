<?php

/*
Plugin Name: Amazon Link Extra - Spoof Locale
Plugin URI: http://www.houseindorset.co.uk/plugins/amazon-link/
Description: Used for testing the appearance of your site when viewed from another country (needs ip2nation installed & localise Amazon Link option enabled to have any affect).  To change the locale, update the 'Spoof Locale' option in the Amazon Link settings page, or append `?spoof_locale=<country code>` to the page URL. You must Deactivate/Un-install this plugin to disable the spoofing.
Version: 1.3
Author: Paul Stuttard
Author URI: http://www.houseindorset.co.uk
*/

/*
Copyright 2011-2012 Paul Stuttard

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/*
 * Add the Spoof Locale option to the Amazon Link Settings Page
 */
function alx_spoof_locale_options ($options_list) {
   
   if (is_admin()) {
      $options_list['spoof_locale'] = array ( 'Name' => __('Spoof Locale', 'amazon-link'),
                                              'Description' => __('Force the localisation to this country code, for testing how your site will appear from another country.', 'amazon-link'),
                                              'Type' => 'selection', 
                                              'Default' => '', 
                                              'Class' => 'al_border');


      $options_list['spoof_locale']['Options'] = array_merge(array('' => array('Name' => 'Disabled')),$options_list['default_cc']['Options']);
   } else {
      $option_list['spoof_locale'] = array('Default' => '');
   }
  
   return $options_list;
}

//function alx_admin_menu_fix()
//{
   //global $awlfw;
   //remove_action( 'show_user_profile', array( $awlfw, 'show_user_options' ) );
   //remove_action( 'personal_options_update', array( $awlfw, 'update_user_options' ) ); // Update User Options
//}
//add_action ( 'admin_menu', 'alx_admin_menu_fix' ,25);
/*
 * The Spoof Locale action function that is called when the Amazon Link plugin is Initialised
 */
function alx_spoof_locale ($s, $al) {

   global $wpdb, $_SERVER, $_REQUEST;
   $settings = $al->get_default_settings();

   $locale = (isset($_REQUEST['spoof_locale']) ? $_REQUEST['spoof_locale'] : $settings['spoof_locale']);
   // Use Cloudflare localisation variable to pass the locale to the plugin
   $_SERVER['HTTP_CF_IPCOUNTRY'] = $locale;
   return;

}

/*
 * Install the Spoof Locale option and action
 */
add_filter('amazon_link_option_list', 'alx_spoof_locale_options', 10,1);
add_action('amazon_link_init', 'alx_spoof_locale',10,2);

?>
