<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for child theme Infinite
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/*
 * Suggested plugins:
 * - Contact Form 7 ?
 * - Exopite Infinite Load
 * - Exopite Lazy Load XT
 * - Exopite Lightbox35
 * - SiteOrigin Page Builder
 * - SiteOrigin Widgets Bundle
 * - Yoast SEO
 * - All in one seucirty or WordFence
 * - WP Google Maps
 * - WooCommerce
 * - woocommerce-ajax-add-to-cart-for-variable-products.1.2.9
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once 'class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'exopite_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function exopite_register_required_plugins() {
	$is_required = true;
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

        array(
            'name'              => 'Exopite Core',
            'slug'              => 'exopite-core',
            'source'            => get_template_directory() . '/include/plugins/exopite-core.zip', // The plugin source.
            //'source'            => 'https://update.joeszalai.org/packages/exopite-core.zip', // The plugin source.
            'required'          => true,
            'force_activation'  => true,
        ),

        array(
            'name'              => 'Page Builder by SiteOrigin',
            'slug'              => 'siteorigin-panels',
            'required'          => false,
        ),

        array(
            'name'              => 'SiteOrigin Widgets Bundle',
            'slug'              => 'so-widgets-bundle',
            'required'          => false,
        ),

        array(
            'name'              => 'WP Comment Policy Checkbox',
            'slug'              => 'wp-comment-policy-checkbox',
            'required'          => false,
        ),

        array(
            'name'              => 'Exopite SEO Core',
            'slug'              => 'exopite-seo-core',
            'source'            => 'https://update.joeszalai.org/packages/exopite-seo-core.zip', // The plugin source.
            'required'          => false,
        ),

	);

    if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {
        $plugins_woocommerce = array(

            array(
                'name'              => 'Woocommerce Ajax add to cart for all products',
                'slug'              => 'woocommerce-ajax-add-to-cart-for-all-products',
                //'source'            => TEMPLATEPATH . 'include/plugins/woocommerce-ajax-add-to-cart-for-all-products.zip', // The plugin source.
                'source'            => 'https://update.joeszalai.org/packages/woocommerce-ajax-add-to-cart-for-all-products.zip', // The plugin source.
                'required'          => false,
            ),

        );

        $plugins = array_merge( $plugins, $plugins_woocommerce );
    }

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'exopite',              // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}

add_action( 'exopite-tgm-complete', 'exopite_tgm_complete' );
function exopite_tgm_complete() {
    echo esc_html( 'Redirect to theme options...', 'exopite' );
    echo '<script type="text/javascript">
            window.location.href="' . get_admin_url() . 'themes.php?page=cs-framework' . '";
            </script>';
}

add_action( 'exopite-tgm-after-user-action', 'exopite_tgm_after_user_action' );
function exopite_tgm_after_user_action() {
    echo esc_html( 'Refresh...', 'exopite' );
    echo '<script type="text/javascript">
            window.location.href="' . get_admin_url() . 'themes.php?page=tgmpa-install-plugins' . '";
            </script>';
}
