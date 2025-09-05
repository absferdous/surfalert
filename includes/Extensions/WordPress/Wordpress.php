<?php

namespace SurfAlert\Extensions\WordPress;

/**
 * Common functionality for WordPres.
 */
trait WordPress
{

    public function doc(){
        return sprintf(__('<p>Make sure that you have a <a target="_blank" href="%1$s">wordpress.org</a> account to use its campaign on blog comments, reviews and download stats data. For further assistance, check out our step by step documentation on <a target="_blank" href="%2$s">comments popup</a>, <a target="_blank" href="%3$s">plugin reviews</a> & <a target="_blank" href="%4$s">downloads stats</a>.</p>
		<p>🎦 Watch video tutorial on <a target="_blank" href="%5$s">blog comments</a>, <a target="_blank" href="%6$s">reviews</a> & <a target="_blank" href="%6$s">downloads stats</a> to learn quickly</p>
		<p><strong>Recommended Blogs:</strong></p>
		<p>🔥 Proven Hacks To <a target="_blank" href="%7$s">Get More Comments on Your WordPress Blog</a> Posts</p>
		<p>🚀 How To Increase <a target="_blank" href="%8$s">WordPress Plugin Download Rates & Increase Sales</a> in 2023</p>', 'surfalert'),
		'https://wordpress.org/',
		'https://surfalert.com/docs/wordpress-comment-popup-alert/',
		'https://surfalert.com/docs/wordpress-plugin-review-surfalert/',
		'https://surfalert.com/docs/wordpress-plugin-download-stats/',
		'https://www.youtube.com/watch?v=wZKAUKH9XQY',
		'https://www.youtube.com/watch?v=wZKAUKH9XQY',
		'https://surfalert.com/blog/hacks-to-get-more-comments-wordpress/',
		'https://wpdeveloper.com/wordpress-plugin-download/'
		);
    }
}
