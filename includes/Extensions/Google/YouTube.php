<?php
/**
 * YouTube Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Google;

use SurfAlert\Core\Helper;
use SurfAlert\GetInstance;
use SurfAlert\Extensions\Extension;

/**
 * YouTube Extension
 * @method static YouTube get_instance($args = null)
 */
class YouTube extends Extension {
    /**
     * Instance of YouTube
     *
     * @var YouTube
     */
    use GetInstance;

    public $priority        = 5;
    public $id              = 'youtube';
    // public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/google-rating.png';
    public $doc_link        = 'https://surfalert.com/docs/google-reviews-with-surfalert/';
    public $types           = 'video';
    public $module          = 'modules_google_youtube';
    public $module_priority = 25;
    public $default_theme   = 'youtube_channel-1';
    public $is_pro          = true;
    public $link_type       = 'yt_channel_link';
    public $api_base        = 'https://youtube.googleapis.com/youtube/v3/';
    public $img             = SURFALERT_ADMIN_URL . 'images/extensions/sources/youtube.png';
    public $cron_schedule   = 'sa_youtube_interval';
    public $channel_themes  = ['youtube_channel-1', 'youtube_channel-2'];
    public $video_themes    = ['youtube_video-1', 'youtube_video-2', 'youtube_video-3', 'youtube_video-4'];

    /**
     * Initially Invoked when initialized.
     */
    public function __construct(){
        // add_action('admin_init', array($this, 'init_google_client'));
        parent::__construct();
    }

    public function init_extension()
    {
        $this->title = __('YouTube', 'surfalert');
        $this->module_title = __('YouTube', 'surfalert');
        $this->themes = [
            'channel-1'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/channel-theme-1.png',
                'template'                => [
                    // 'first_param'         => 'tag_rated',
                    // 'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('Follow ', 'surfalert'),
                    'third_param'         => 'tag_yt_channel_title',
                    'custom_third_param'  => __('Anonymous Title', 'surfalert'),
                    'yt_third_label'      => __('YouTube Channel', 'surfalert'),
                    'fourth_param'        => 'tag_yt_views',
                    'custom_fourth_param' => '3.4M+',
                    'yt_fourth_label'     => __('Views', 'surfalert'),
                    'fifth_param'         => 'tag_yt_videos',
                    'custom_fifth_param'  => '564',
                    'yt_fifth_label'      => __('Videos', 'surfalert'),
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'channel',
                    'image_shape'             => 'rounded',
                    'link_type'               => 'yt_channel_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Subscribe Now','surfalert'),
                    'link_button'             => true,
                ],
            ],
            'channel-2'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/channel-theme-2.png',
                'template'                => [
                    // 'first_param'         => 'tag_rated',
                    // 'custom_first_param'  => __('Someone', 'surfalert'),
                    'second_param'        => __('Follow ', 'surfalert'),
                    'third_param'         => 'tag_yt_channel_title',
                    'custom_third_param'  => __('Anonymous Title', 'surfalert'),
                    'yt_third_label'      => __('YouTube Channel', 'surfalert'),
                    'fourth_param'        => 'tag_yt_views',
                    'custom_fourth_param' => '3.4M+',
                    'fifth_param'         => 'tag_yt_videos',
                    'custom_fifth_param'  => '564',
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'channel',
                    'image_shape'             => 'circle',
                    'link_type'               => 'yt_channel_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Subscribe Now','surfalert'),
                    'link_button'             => true,
                ],
            ],
            'video-1'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/video-theme-1.png',
                'template'                => [
                    'second_param'        => __('Check our latest video ', 'surfalert'),
                    'third_param'         => 'tag_yt_views',
                    'custom_third_param'  => '3.4M+',
                    'fourth_param'        => 'tag_yt_likes',
                    'custom_fourth_param' => '2.5K',
                    'fifth_param'         => 'tag_yt_comments',
                    'custom_fifth_param'  => '1K',
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'video',
                    'image_shape'             => 'circle',
                    'link_type'               => 'yt_video_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Watch Now','surfalert'),
                ],
            ],
            'video-2'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/video-theme-2.png',
                'template'                => [
                    'second_param'       => __('Check our latest video ', 'surfalert'),
                    'third_param'        => 'tag_yt_views',
                    'custom_third_param'  => '3.4M+',
                    'yt_third_label'     => __('Views', 'surfalert'),
                    'fourth_param'       => 'tag_yt_likes',
                    'custom_fourth_param' => '2.5K',
                    'yt_fourth_label'    => __('Likes', 'surfalert'),
                    'fifth_param'        => 'tag_yt_comments',
                    'yt_fifth_label'     => __('Comments', 'surfalert'),
                    'custom_fifth_param'  => '1K',
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'video',
                    'image_shape'             => 'rounded',
                    'link_type'               => 'yt_video_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Watch Now','surfalert'),
                ],
            ],
            'video-3'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/video-theme-3.png',
                'template'                => [
                    'second_param'       => __('Check our latest video ', 'surfalert'),
                    'third_param'        => 'tag_yt_views',
                    'custom_third_param'  => '3.4M+',
                    'fourth_param'       => 'tag_yt_likes',
                    'custom_fourth_param' => '2.5K',
                    'fifth_param'        => 'tag_yt_comments',
                    'custom_fifth_param'  => '1K',
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'video',
                    'image_shape'             => 'circle',
                    'link_type'               => 'yt_video_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Watch Now','surfalert'),
                    'link_button'             => true,
                ],
            ],
            'video-4'     => [
                'source'                  => SURFALERT_ADMIN_URL . 'images/extensions/themes/youtube/video-theme-4.png',
                'template'                => [
                    'second_param'       => __('Check our latest video ', 'surfalert'),
                    'third_param'        => 'tag_yt_views',
                    'custom_third_param'  => '3.4M+',
                    'yt_third_label'     => __('Views', 'surfalert'),
                    'fourth_param'       => 'tag_yt_likes',
                    'custom_fourth_param' => '2.5K',
                    'yt_fourth_label'    => __('Links', 'surfalert'),
                    'fifth_param'        => 'tag_yt_comments',
                    'yt_fifth_label'     => __('Comments', 'surfalert'),
                    'custom_fifth_param'  => '1K',
                ],
                'defaults'                => [
                    // 'youtube_type'            => 'video',
                    'image_shape'             => 'rounded',
                    'link_type'               => 'yt_video_link',
                    'show_notification_image' => 'yt_thumbnail',
                    'link_button_text'        => __('Watch Now','surfalert'),
                    'link_button'             => true,
                ],
            ],
        ];
        $this->res_themes = [
            'res-channel-1'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-1.png',
                'is_pro' => true,
            ],
            'res-channel-2'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-2.png',
                'is_pro' => true,
            ],
            'res-video-1'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-3.png',
                'is_pro' => true,
            ],
            'res-video-2'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-4.png',
                'is_pro' => true,
            ],
            'res-video-3'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-5.png',
                'is_pro' => true,
            ],
            'res-video-4'     => [
                'source' => SURFALERT_ADMIN_URL . 'images/extensions/themes/res_youtube/channel-res-theme-6.png',
                'is_pro' => true,
            ],
        ];
        $this->templates = [
            "{$this->id}_channel"  => [
                'third_param' => [
                    'tag_yt_channel_title' => __('Channel Title', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_yt_views' => __('Total Views', 'surfalert'),
                    'tag_none'     => __('None', 'surfalert'),
                ],
                'fifth_param' => [
                    'tag_yt_videos' => __('Total Videos', 'surfalert'),
                    'tag_none'      => __('None', 'surfalert'),
                ],
                '_themes' => [
                    "{$this->id}_channel-1",
                    "{$this->id}_channel-2",
                ],
            ],
            "{$this->id}_video"  => [
                'third_param' => [
                    'tag_yt_views' => __('Total Views', 'surfalert'),
                    'tag_none'     => __('None', 'surfalert'),
                ],
                'fourth_param' => [
                    'tag_yt_likes' => __('Total Likes', 'surfalert'),
                    'tag_none'     => __('None', 'surfalert'),
                ],
                'fifth_param' => [
                    'tag_yt_comments' => __('Total Comments', 'surfalert'),
                    'tag_none'        => __('None', 'surfalert'),
                ],
                '_themes' => [
                    "{$this->id}_video-1",
                    "{$this->id}_video-2",
                    "{$this->id}_video-3",
                    "{$this->id}_video-4",
                ],
            ],
        ];
        $this->popup = [
            "denyButtonText" => __("<a href='https://surfalert.com/docs/google-reviews-with-surfalert/
            ' target='_blank'>More Info</a>", "surfalert"),
            "confirmButtonText" => __("<a href='https://surfalert.com/#pricing' target='_blank'>Upgrade to PRO</a>", "surfalert"),
            "html"=> __('
                <span>Google reviews provide helpful information and make your business stand out.</span>
            ', 'surfalert')
        ];
    }

     /**
     * @param array $data
     * @param array $saved_data
     * @param stdClass $settings
     * @return array
     */
    public function fallback_data($data, $saved_data, $settings) {
        $data['title']          = $saved_data['yt_channel_title'];
        // channel
        $data['yt_views']       = Helper::nice_number($saved_data['_yt_views']);
        $data['yt_subscribers'] = Helper::nice_number($saved_data['_yt_subscribers']);
        $data['yt_videos']      = Helper::nice_number($saved_data['_yt_videos']);
        // single video
        $data['yt_likes']      = Helper::nice_number($saved_data['_yt_likes']);
        $data['yt_comments']   = Helper::nice_number($saved_data['_yt_comments']);
        $data['yt_favorites']  = Helper::nice_number($saved_data['_yt_favorites']);
        return $data;
    }
    
    public function doc(){
        $url = admin_url('admin.php?page=sa-settings&tab=tab-api-integrations#google_youtube_settings_section');
        return sprintf(__('<p>To create YouTube notification popups, make sure that you have configured your <a target="_blank" href="%1$s">YouTube API</a> key, Check out our step-by-step documentation for further assistance. <a target="_blank" href="%2$s">documentation</a>.</p>

		<p>👉SurfAlert <a target="_blank" href="%3$s">Integration with Youtube</a>.</p>', 'surfalert'),
        $url,
        'https://surfalert.com/docs/collect-youtube-api-key/',
        'https://surfalert.com/docs/youtube-video-activities-popups/'
        );
    }
}
