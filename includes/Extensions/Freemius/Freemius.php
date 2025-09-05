<?php

/**
 * Freemius Extension
 *
 * @package SurfAlert\Extensions
 */

namespace SurfAlert\Extensions\Freemius;

/**
 * Common functionality for Freemius.
 */
trait Freemius
{


    public function doc(){
        return sprintf(__('<p>Make sure that you have <a target="_blank" href="%1$s">created & signed in to Freemius account</a> to use its campaign & product sales data. For further assistance, check out our step by step <a target="_blank" href="%2$s">documentation</a>.</p>
		<p>🎦 <a target="_blank" href="%3$s">Watch video tutorial</a> to learn quickly</p>
		<p>👉 SurfAlert <a target="_blank" href="%4$s">Integration with Freemius</a></p>', 'surfalert'),
        'https://dashboard.freemius.com/login/',
        'https://surfalert.com/docs/freemius-sales-notification/',
        'https://youtu.be/0uANsOSFmtw',
        'https://surfalert.com/integrations/freemius/'
        );
    }
}
