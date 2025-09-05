import { __ } from "@wordpress/i18n";
(function (surfalert) {
    if (surfalert) {
        // @ts-ignore
        window.notificationXArr = window.notificationXArr || [];
        // @ts-ignore
        window.notificationXArr.push(surfalert);
    }
    console.warn(
        __(
            "You are using old version of cross-domain scripts for SurfAlert Pro. Please update this from your SurfAlert Settings page.",
            "surfalert"
        )
    );
    // @ts-ignore
})(window.nxCrossSite);

import "./index";
