<?php
/**
 * Wistia Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\GDPR;

use SurfAlert\GetInstance;
use SurfAlert\Core\Rules;
use SurfAlert\Extensions\GlobalFields;
use SurfAlert\Extensions\Extension;

/**
 * GDPR Extension
 * @method static GDPR get_instance($args = null)
 */
class GDPR_Notification extends Extension {
    /**
     * Instance of GDPR
     *
     * @var GDPR
     */
    use GetInstance;

    public $priority        = 15;
    public $id              = 'gdpr_notification';
    public $doc_link        = 'https://surfalert.com/docs/google-reviews-with-surfalert/';
    public $types           = 'gdpr';
    public $module          = 'modules_gdpr';
    // public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/GDPR.png';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
        add_filter('sa_design_tab_fields', [$this, 'design_fields'], 99);
        add_filter('sa_content_fields', array($this, 'content_fields'), 999);
        add_filter('sa_customize_fields', array($this, 'customize_fields'), 999);
    }

    public function init_extension()
    {
        $this->title = __('GDPR', 'surfalert');
        $this->module_title = __('Cookie Notice', 'surfalert');
    }

    public function design_fields( $fields ) {
        if (isset($fields['advance_design_section']['fields']['design'])) {
			$fields['advance_design_section']['fields']['design'] = Rules::is('source', $this->id, true, $fields['advance_design_section']['fields']['design']);
		}
        if (isset($fields['advance_design_section']['fields']['typography'])) {
			$fields['advance_design_section']['fields']['typography'] = Rules::is('source', $this->id, true, $fields['advance_design_section']['fields']['typography']);
		}
        if (isset($fields['advance_design_section']['fields']['image-appearance'])) {
			$fields['advance_design_section']['fields']['image-appearance'] = Rules::is('source', $this->id, true, $fields['advance_design_section']['fields']['image-appearance']);
		}
        if (isset($fields['advance_design_section']['fields']['link_button_design'])) {
			$fields['advance_design_section']['fields']['link_button_design'] = Rules::is('source', $this->id, true, $fields['advance_design_section']['fields']['link_button_design']);
		}

        $fields['advance_design_section']['fields']['gdpr_design'] = [
            'label'    => __("Design", 'surfalert'),
            'name'     => "gdpr_design",
            'type'     => "section",
            'priority' => 5,
            'rules'    => Rules::logicalRule([
                Rules::is('source', $this->id, false),
                Rules::is('advance_edit', true),
            ]),
            'fields' => [
                [
                    'label' => __("Background Color", 'surfalert'),
                    'name'  => "gdpr_design_bg_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Footer Background Color", 'surfalert'),
                    'name'  => "gdpr_design_ft_bg_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Title Color", 'surfalert'),
                    'name'  => "title_text_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label'       => __('Title Font Size', 'surfalert'),
                    'name'        => "title_font_size",
                    'type'        => "number",
                    'default'     => '20',
                    'description' => 'px',
                    'help'        => __('This font size will be applied for <mark>Title</mark> only', 'surfalert'),
                ],
                [
                    'label' => __("Description Color", 'surfalert'),
                    'name'  => "description_text_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label'       => __('Description Font Size', 'surfalert'),
                    'name'        => "description_font_size",
                    'type'        => "number",
                    'default'     => '14',
                    'description' => 'px',
                    'help'        => __('This font size will be applied for <mark>Description</mark> only', 'surfalert'),
                ],
                [
                    'label' => __("Close Button Color", 'surfalert'),
                    'name'  => "close_btn_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                    'rules' => Rules::logicalRule([
                        Rules::is('themes', 'gdpr_theme-banner-light-one', true),
                        Rules::is('themes', 'gdpr_theme-light-two', true),
                        Rules::is('themes', 'gdpr_theme-light-four', true),
                        Rules::is('themes', 'gdpr_theme-banner-dark-one', true),
                        Rules::is('themes', 'gdpr_theme-dark-two', true),
                        Rules::is('themes', 'gdpr_theme-dark-four', true),
                    ]),
                ],
                [
                    'label'       => __('Close Button Size', 'surfalert'),
                    'name'        => "close_btn_size",
                    'type'        => "number",
                    'default'     => '18',
                    'description' => 'px',
                    'rules' => Rules::logicalRule([
                        Rules::is('themes', 'gdpr_theme-banner-light-one', true),
                        Rules::is('themes', 'gdpr_theme-light-two', true),
                        Rules::is('themes', 'gdpr_theme-light-four', true),
                        Rules::is('themes', 'gdpr_theme-banner-dark-one', true),
                        Rules::is('themes', 'gdpr_theme-dark-two', true),
                        Rules::is('themes', 'gdpr_theme-dark-four', true),
                    ]),
                ],
            ]
        ];

        $fields['advance_design_section']['fields']['gdpr_accept_btn'] = [
            'label'    => __("Accept Button", 'surfalert'),
            'name'     => "gdpr_accept_btn",
            'type'     => "section",
            'priority' => 6,
            'rules'    => Rules::logicalRule([
                Rules::is('source', $this->id, false),
                Rules::is('advance_edit', true),
            ]),
            'fields' => [
                [
                    'label' => __("Background Color", 'surfalert'),
                    'name'  => "gdpr_accept_btn_bg_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Border Color", 'surfalert'),
                    'name'  => "gdpr_accept_btn_border_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Text Color", 'surfalert'),
                    'name'  => "gdpr_accept_btn_text_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label'       => __('Font Size', 'surfalert'),
                    'name'        => "gdpr_accept_btn_font_size",
                    'type'        => "number",
                    'default'     => '14',
                    'description' => 'px',
                ],
            ]
        ];

        $fields['advance_design_section']['fields']['gdpr_reject_btn'] = [
            'label'    => __("Reject Button", 'surfalert'),
            'name'     => "gdpr_reject_btn",
            'type'     => "section",
            'priority' => 7,
            'rules'    => Rules::logicalRule([
                Rules::is('source', $this->id, false),
                Rules::is('advance_edit', true),
                Rules::is('themes', 'gdpr_theme-banner-light-two', true),
                Rules::is('themes', 'gdpr_theme-light-one', true),
                Rules::is('themes', 'gdpr_theme-light-three', true),
                Rules::is('themes', 'gdpr_theme-banner-dark-two', true),
                Rules::is('themes', 'gdpr_theme-dark-one', true),
                Rules::is('themes', 'gdpr_theme-dark-three', true),
            ]),
            'fields' => [
                [
                    'label' => __("Background Color", 'surfalert'),
                    'name'  => "gdpr_reject_btn_bg_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Border Color", 'surfalert'),
                    'name'  => "gdpr_reject_btn_border_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Text Color", 'surfalert'),
                    'name'  => "gdpr_reject_btn_text_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label'       => __('Font Size', 'surfalert'),
                    'name'        => "gdpr_reject_btn_font_size",
                    'type'        => "number",
                    'default'     => '14',
                    'description' => 'px',
                ],
            ]
        ];

        $fields['advance_design_section']['fields']['gdpr_customize_btn'] = [
            'label'    => __("Customize Button", 'surfalert'),
            'name'     => "gdpr_customize_btn",
            'type'     => "section",
            'priority' => 8,
            'rules'    => Rules::logicalRule([
                Rules::is('source', $this->id, false),
                Rules::is('advance_edit', true),
            ]),
            'fields' => [
                [
                    'label' => __("Background Color", 'surfalert'),
                    'name'  => "gdpr_customize_btn_bg_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Border Color", 'surfalert'),
                    'name'  => "gdpr_customize_btn_border_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label' => __("Text Color", 'surfalert'),
                    'name'  => "gdpr_customize_btn_text_color",
                    'type'  => "colorpicker",
                    'default'  => "",
                ],
                [
                    'label'       => __('Font Size', 'surfalert'),
                    'name'        => "gdpr_customize_btn_font_size",
                    'type'        => "number",
                    'default'     => '14',
                    'description' => 'px',
                ],
            ]
        ];

        return $fields;
    }

    public function customize_fields( $fields ) {
        if (isset($fields['appearance'])) {
			$fields['appearance'] = Rules::is('source', $this->id, true, $fields['appearance']);
		}
        if (isset($fields['queue_management'])) {
			$fields['queue_management'] = Rules::is('source', $this->id, true, $fields['queue_management']);
		}
        if (isset($fields['queue_management'])) {
			$fields['queue_management'] = Rules::is('source', $this->id, true, $fields['queue_management']);
		}
        if (isset($fields['timing'])) {
			$fields['timing'] = Rules::is('source', $this->id, true, $fields['timing']);
		}
        if (isset($fields['behaviour'])) {
			$fields['behaviour'] = Rules::is('source', $this->id, true, $fields['behaviour']);
		}
        if (isset($fields['sound_section'])) {
			$fields['sound_section'] = Rules::is('source', $this->id, true, $fields['sound_section']);
		}
        return $fields;
    }

    public function content_fields( $fields ) {
        if (isset($fields['utm_options'])) {
			$fields['utm_options'] = Rules::is('source', $this->id, true, $fields['utm_options']);
		}
        if (isset($fields['content'])) {
			$fields['content'] = Rules::is('source', $this->id, true, $fields['content']);
		}
        return $fields;
    }

    public function doc(){
        return sprintf(__('<p>You can showcase Cookie Notice effortlessly on your WordPress site to ensure compliance with visitors. Need help? Follow our <a href="%1$s" target="_blank">step-by-step guides</a> for creating a Cookie Notice on the WordPress website.</p>
        <p>🎦 Watch the video <a target="_blank" href="%2$s">tutorial</a> for a quick guide.</p>
        <p><strong>Recommended Blogs:</strong></p>
        <p>🔥 <a target="_blank" href="%3$s">How to Display WordPress Cookie Notice Using SurfAlert?</a></p>
        <p><strong>Recommended Plugins:</strong></p>
        <p>🔌 <a target="_blank" href="%4$s">WP Consent API</a> - Centralize cookie handling with a unified consent solution.</p>', 'surfalert'),
        'https://surfalert.com/docs/how-to-configure-cookies-policy-for-website/',
        'https://youtu.be/xMiRgH436SE',
        'https://surfalert.com/blog/display-wordpress-cookie-notice/',
        'https://wordpress.org/plugins/wp-consent-api/'
    );
    }

}
