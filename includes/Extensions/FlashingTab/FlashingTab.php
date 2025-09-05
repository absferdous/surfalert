<?php

/**
 * flashing Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\FlashingTab;

use SurfAlert\Core\Helper;
use SurfAlert\Core\Locations;
use SurfAlert\Core\PostType;
use SurfAlert\Core\Rules;
use SurfAlert\Extensions\Extension;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\FrontEnd\FrontEnd;
use SurfAlert\GetInstance;

/**
 * flashing Extension
 * @method static FlashingTab get_instance($args = null)
 */
class FlashingTab extends Extension {
    /**
     * Instance of flashing
     *
     * @var FlashingTab
     */
    use GetInstance;

    public $priority        = 5;
    public $id              = 'flashing_tab';
    public $img             = '';
    public $doc_link        = 'https://surfalert.com/docs/contact-form-submission-alert/';
    public $types           = 'flashing_tab';
    // used in Settings > General tab
    public $module          = 'modules_flashing';
    public $module_priority = 30;
    public $default_theme   = 'flashing_tab_theme-1';
    public $is_pro          = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct() {
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Flashing Tab', 'surfalert');
        $this->module_title = __('Flashing Tab', 'surfalert');
        $this->themes = [
            'theme-1' => array(
                'is_pro'          => true,
                'source'          => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/flashing-tab/theme-1.gif',
                'defaults'        => [
                    'ft_theme_one_icons' => [
                        'icon-one' => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-1-icon-1.png',
                        'icon-two' => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-1-icon-2.png',
                    ],
                    'ft_theme_one_message' => __('Comeback!', 'surfalert'),
                ],
            ),
            'theme-2' => array(
                'is_pro'          => true,
                'source'          => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/flashing-tab/theme-2.gif',
                'defaults'        => [
                    'ft_theme_one_icons' => [
                        'icon-one' => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-2-icon-1.png',
                        'icon-two' => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-2-icon-2.png',
                    ],
                    'ft_theme_one_message' => __('Comeback! We miss you.', 'surfalert'),
                ],
            ),
            'theme-3' => array(
                'is_pro'          => true,
                'source'          => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/flashing-tab/theme-3.gif',
                'defaults'        => [
                    'ft_theme_three_line_one' => [
                        'icon'    => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-3-icon-1.png',
                        'message' => __('Comeback!', 'surfalert'),
                    ],
                    'ft_theme_three_line_two' => [
                        'icon'    => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-3-icon-2.png',
                        'message' => __('You forgot to purchase!', 'surfalert'),
                    ],
                ],
            ),
            'theme-4' => array(
                'is_pro'          => true,
                'source'          => SURFALERT_ADMIN_URL . 'images/extensions/themes/pro/flashing-tab/theme-4.gif',
                'defaults'        => [
                    // 'ft_theme_three_line_one' => 'dddddd',
                    'ft_theme_three_line_one' => [
                        'icon'    => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-4-icon-1.png',
                        'message' => __('Comeback!', 'surfalert'),
                    ],
                    'ft_theme_four_line_two' => [
                        'is-show-empty' => false,
                        'default'       => [
                            'icon'    => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-4-icon-2.png',
                            'message' => __('{quantity} items in your cart!', 'surfalert'),
                        ],
                        'alternative' => [
                            'icon'    => SURFALERT_PUBLIC_URL . 'image/flashing-tab/theme-4-icon-2.png',
                            'message' => '',
                        ],
                    ],
                ],
            ),
        ];
    }

    public function init_fields(){
        parent::init_fields();

        add_filter( 'sa_metabox_tabs', [ $this, 'sa_tabs' ], 15 );
    }

    /**
     * Undocumented function
     *
     * @param [type] $tabs
     * @return void
     */
    public function sa_tabs( $tabs ) {
        $tabs['display_tab']   = Rules::is( 'source', $this->id, true, $tabs['display_tab'] );
        $tabs['customize_tab'] = Rules::is( 'source', $this->id, true, $tabs['customize_tab'] );
        return $tabs;
    }

    public function doc(){
        // translators: links
        return sprintf(__('
        <p>Make sure that you have SurfAlert PRO installed and activated on your website to use Flashing Tab. For further assistance, follow the step-by-step <a target="_blank" href="%1$s">documentation</a>.</p>
		<p>🎥 Get a quick demo from the <a target="_blank" href="%2$s">video tutorial</a></p>
		<p>📖 Recommended Blog:</p>
		<p>🔥How To <a target="_blank" href="%3$s">Attract Customers With Flashing Browser Tab Notification Using SurfAlert?</a></p>
		', 'surfalert'),
        'https://surfalert.com/docs/flashing-tab-alerts/',
        'https://www.youtube.com/watch?v=RCyB06nI-Xc',
        'https://surfalert.com/blog/flashing-browser-tab-notifications/'
        );
    }
}
