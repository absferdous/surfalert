<?php
/**
 * GravityForms Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\GRVF;

use SurfAlert\Core\Rules;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * GravityForms Extension
 * @method static GravityForms get_instance($args = null)
 */
class GravityForms extends Extension {
    /**
     * Instance of GravityForms
     *
     * @var GravityForms
     */
    use GetInstance;

    public $priority        = 20;
    public $id              = 'grvf';
    public $img             = '';
    public $doc_link        = 'https://surfalert.com/docs/contact-form-submission-alert/';
    public $types           = 'form';
    public $module          = 'modules_grvf';
    public $module_priority = 11;
    public $is_pro          = true;
    public $version         = '1.4.4';
    public $class           = '\GFForms';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('Gravity Forms', 'surfalert');
        $this->module_title = __('Gravity Forms', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/gravity-forms/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>A WordPress contact forms plugin that can help you keep important leads and stay in touch with your customers.</span>
                <iframe id="email_subscription_video" type="text/html" allowfullscreen width="450" height="235"
                src="https://www.youtube.com/embed/1Gl3XRd1TxY">
                </iframe>
            ', 'surfalert')
        ];
    }

    public function source_error_message($messages) {
        if (!$this->class_exists()) {
            $url = "https://www.gravityforms.com/";
            $messages[$this->id] = [
                'message' => sprintf( '%s <a href="%s" target="_blank">%s</a> %s',
                    __( 'You have to install', 'surfalert' ),
                    $url,
                    __( 'Gravity Forms', 'surfalert' ),
                    __( 'plugin first.', 'surfalert' )
                ),
                'html' => true,
                'type' => 'error',
                'rules' => Rules::is('source', $this->id),
            ];
        }
        return $messages;
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">Gravity Forms installed & configured</a>, to use its campaign & form subscriptions data. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉SurfAlert <a target="_blank" href="%4$s">Integration with Ninja Forms</a></p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥Hacks to Increase Your <a target="_blank" href="%5$s">WordPress Contact Forms Submission Rate</a> Using SurfAlert</p>', 'surfalert'),
        'https://www.gravityforms.com/',
        'https://surfalert.com/docs/gravity-forms/',
        'https://www.youtube.com/watch?v=1Gl3XRd1TxY',
        'https://surfalert.com/integrations/gravity-forms/',
        'https://surfalert.com/blog/wordpress-contact-forms/'
        );
    }

}
