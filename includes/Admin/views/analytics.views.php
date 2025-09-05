<div class="sa-analytics-header-counter-wrapper <?php echo esc_attr( $class ); ?>">
    <div class="sa-header-analytics-counter-wrapper">
        <div>
            <div class="sa-header-analytics-counter">
                <a href="<?php echo esc_url( $views_link );?> ">
                    <span class="sa-counter-icon">
                        <img src="<?php echo esc_url( self::ASSET_URL . 'images/analytics/views-icon.png' ); ?>" alt="<?php esc_html_e( 'Total Views', 'surfalert' ); ?>">
                    </span>
                    <div>
                        <span class="sa-counter-number"><?php echo esc_html( $views ); ?></span>
                        <span class="sa-counter-label"><?php esc_html_e( 'Total Views', 'surfalert' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="sa-header-analytics-counter">
                <a href="<?php echo esc_url( $clicks_link );?> ">
                    <span class="sa-counter-icon">
                        <img src="<?php echo esc_url( self::ASSET_URL . 'images/analytics/clicks-icon.png' ); ?>" alt="<?php esc_html_e( 'Total Clicks', 'surfalert' ); ?>">
                    </span>
                    <div>
                        <span class="sa-counter-number"><?php echo esc_html( $clicks ); ?></span>
                        <span class="sa-counter-label"><?php esc_html_e( 'Total Clicks', 'surfalert' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="sa-header-analytics-counter">
                <a href="<?php echo esc_url( $ctr_link );?> ">
                    <span class="sa-counter-icon">
                        <img src="<?php echo esc_url( self::ASSET_URL . 'images/analytics/ctr-icon.png' ); ?>" alt="<?php esc_html_e( 'Click-Through-Rate', 'surfalert' ); ?>">
                    </span>
                    <div>
                        <span class="sa-counter-number"><?php echo esc_html( round( $ctr, 2 ) ); ?>%</span>
                        <span class="sa-counter-label"><?php esc_html_e( 'Click-Through-Rate', 'surfalert' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
