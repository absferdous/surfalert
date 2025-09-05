import { __ } from "@wordpress/i18n";
import React from "react";

const ProWidget = () => {
    // @ts-ignore
    const isProActive = notificationxTabs?.is_pro_active;
    if (isProActive) {
        return;
    }
    return (
        <div className="surfalert-pro-widget sidebar-widget sa-widget">
            <div className="sa-widget-content">
                <h4>{__("Want to explore more?", "surfalert")}</h4>
                <p>
                    {__(
                        "Dive in and discover all the premium features",
                        "surfalert"
                    )}{" "}
                </p>
                <a target="_blank" href="https://surfalert.com/#pricing">
                    {__("Upgrade To PRO", "surfalert")}
                </a>
            </div>
        </div>
    );
};

export default ProWidget;
