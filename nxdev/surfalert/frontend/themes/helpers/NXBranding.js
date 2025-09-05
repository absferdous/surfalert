import React from "react";
import { __ } from "@wordpress/i18n";
import { Logo, NotificationText } from ".";

export const NXBranding = (props) => {
    return (
        <small className="sa-branding">
            <Logo />
            <span className="sa-byline">{__("by", "surfalert")}</span>
            <a
                href={props?.config?.affiliate_link}
                rel="nofollow"
                target="_blank"
                className="sa-powered-by"
            >
                <NotificationText {...props} />
            </a>
        </small>
    );
};

export default NXBranding;
