<?php
/**
 * MailChimp Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\MailChimp;

use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * MailChimp Extension
 * @method static MailChimp get_instance($args = null)
 */
class MailChimp extends Extension {
    /**
     * Instance of MailChimp
     *
     * @var MailChimp
     */
    use GetInstance;

    public $priority        = 5;
    public $id              = 'mailchimp';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/mailchimp.png';
    public $doc_link        = 'https://surfalert.com/docs/mailchimp-email-subscription-alert/';
    public $types           = 'email_subscription';
    public $module          = 'modules_mailchimp';
    public $module_priority = 14;
    public $is_pro          = true;

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('MailChimp', 'surfalert');
        $this->module_title = __('MailChimp', 'surfalert');
    }

    /**
     * Get data for MailChimp Extension.
     *
     * @param array $args Settings arguments.
     * @return array
     */
    public function get_data( $args = array() ){
        return 'Hello From MailChimp';
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">signed in & retrieved API key from MailChimp account</a> to use its campaign & email subscriptions data. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉 SurfAlert <a target="_blank" href="%4$s">Integration with MailChimp</a></p>
		<p><strong>Recommended Blogs:</strong></p>
		<p>🔥 How To Improve Your <a target="_blank" href="%5$s">Email Marketing Strategy</a> With Social Proof</p>
		<p>🚀 Hacks To Grow Your <a target="_blank" href="%6$s">Email Subscription List</a> On WordPress Website</p>', 'surfalert'),
        'https://mailchimp.com/help/about-api-keys/',
        'https://surfalert.com/docs/mailchimp-email-subscription-alert/',
        'https://youtu.be/WvX8feM5DBw',
        'https://surfalert.com/integrations/mailchimp/',
        'https://wpdeveloper.com/email-marketing-social-proof/',
        'https://wpdeveloper.com/email-subscription-list-wordpress/'
        );
    }
}
