<?php

/**
 * Class TGDF_Sponsor_I18n
 * @author Aotokitsuruya
 */
class TGDF_Sponsor_I18n
{
    /**
     * Return current plugin using textdomain
     *
     * @since    1.0.0
     */
    static public function textdomain() {
        return 'tgdf-sponsors';
    }

    /**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
    public function load_textdomain() {
        load_plugin_textdomain(
            self::textdomain(),
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );
    }
}
