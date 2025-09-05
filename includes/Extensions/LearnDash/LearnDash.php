<?php
/**
 * LearnDash Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\LearnDash;

use SurfAlert\Core\Rules;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * LearnDash Extension
 * @method static LearnDash get_instance($args = null)
 */
class LearnDash extends Extension {
    /**
     * Instance of LearnDash
     *
     * @var LearnDash
     */
    use GetInstance;

    public $priority        = 10;
    public $id              = 'learndash';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/learndash.png';
    public $doc_link        = 'https://surfalert.com/docs/how-to-display-learndash-course-enrollment-alert-using-surfalert/';
    public $types           = 'elearning';
    public $module          = 'modules_learndash';
    public $module_priority = 18;
    public $is_pro          = true;
    public $version         = '1.2.0';
    public $class           = '\LDLMS_Post_Types';

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('LearnDash', 'surfalert');
        $this->module_title = __('LearnDash', 'surfalert');
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/how-to-display-learndash-course-enrollment-alert-using-surfalert/' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>A widely used WordPress learning management system.</span>
            ', 'surfalert')
        ];
    }

    public function source_error_message($messages) {
        if (!$this->class_exists()) {
            $messages[$this->id] = [
                'message' => __('You have to install <a target="_blank" rel="nofollow" href="https://www.learndash.com">LearnDash</a> plugin first.' , 'surfalert'),
                'html' => true,
                'type' => 'error',
                'rules' => Rules::is('source', $this->id),
            ];
        }
        return $messages;
    }

    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">LearnDash installed & configured</a> to use its campaign & course selling data.  For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉 SurfAlert <a target="_blank" href="%4$s">Integration with LearnDash</a> </p>
		<p><strong>Recommended Blog:</strong></p>
		<p>🔥 How to Increase Your <a target="_blank" href="%5$s">LearnDash Course Enrollment Rates</a> With SurfAlert</p>', 'surfalert'),
        'https://www.learndash.com/',
        'https://surfalert.com/docs/how-to-display-learndash-course-enrollment-alert-using-surfalert',
        'https://www.youtube.com/watch?v=sTbBt2DVsIA',
        'https://surfalert.com/integrations/learndash/',
        'https://wpdeveloper.com/learndash-course-enrollment-rate-surfalert/'
        );
    }
}
