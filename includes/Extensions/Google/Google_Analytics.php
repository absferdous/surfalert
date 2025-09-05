<?php

/**
 * Google_Analytics Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Google;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * Google_Analytics Extension
 * @method static Google_Analytics get_instance($args = null)
 */
class Google_Analytics extends Extension
{
    /**
     * Instance of Google_Analytics
     *
     * @var Google_Analytics
     */
    use GetInstance;

    public $priority        = 5;
    public $id              = 'google';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/google-analytics.png';
    public $doc_link        = 'https://surfalert.com/docs/google-analytics/';
    public $types           = 'page_analytics';
    public $module          = 'modules_google_analytics';
    public $module_priority = 19;
    public $is_pro          = true;
    public $version         = '1.4.0';

    /**
     * option key for saving google analytics data as option
     * @var string
     */
    public $option_key = 'sa_pa_settings';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Google Analytics', 'surfalert');
        $this->module_title = __('Google Analytics', 'surfalert');
    }

    /**
     * Get data for Google_Analytics Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data($args = array())
    {
        return 'Hello From Google Analytics';
    }

    public function doc()
    {
        return sprintf(
            __('<p>Make sure that you have <a target="_blank" href="%1$s">signed in to Google Analytics site</a>, to use its campaign & page analytics data. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉SurfAlert <a target="_blank" href="%4$s">Integration with Google Analytics</a></p>', 'surfalert'),
            'https://analytics.google.com/analytics/web/',
            'https://surfalert.com/docs/google-analytics/',
            'https://www.youtube.com/watch?v=zZPF5nJD4mo',
            'https://surfalert.com/docs/google-analytics/'
        );
    }
}
