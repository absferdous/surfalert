<style>
.surfalert-disabled-javascript-notice {
    font-size: 20px;
    width: 700px;
    border: 1px solid #ffcece;
    padding: 30px;
    background: #fff;
}
</style>
<hr class="wp-header-end"/>
<div class="wrap">
    <div class="surfalert-admin">
        <noscript>
            <p class="surfalert-disabled-javascript-notice">
                <?php
                    echo
                        // translators: html tags
                        __( 'To work <strong><em>SurfAlert</em></strong> properly you need to <strong>Enable JavaScript</strong> in your browser or make sure you have installed updated browser in your device.', 'surfalert' );
                ?>
            </p>
        </noscript>
        <div id="surfalert">
            <div style="display: flex;align-items: center;justify-content: center;height: 60vh;">
                <img src="<?php echo esc_url( self::ASSET_URL . 'images/logos/logo-preloader.gif' ); ?>" alt="">
            </div>
        </div>
    </div>
</div>