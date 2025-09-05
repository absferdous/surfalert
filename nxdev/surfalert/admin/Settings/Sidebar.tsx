import React from "react";
import { __ } from "@wordpress/i18n";
import { applyFilters } from "@wordpress/hooks";

const Sidebar = ({ assetsUrl, is_pro_active = false }) => {
    return (
        <div className="sa-settings-right">
            <div className="sa-sidebar">
                <div className="sa-sidebar-block">
                    <div className="sa-admin-sidebar-logo">
                        <img
                            alt="SurfAlert"
                            src={`${assetsUrl.admin}images/logo.svg`}
                        />
                    </div>
                    <div className="sa-admin-sidebar-cta">
                        {is_pro_active ? (
                            <a
                                href="https://store.wpdeveloper.com"
                                rel="nofollow"
                                target="_blank"
                            >
                                {__("Manage License", "surfalert")}
                            </a>
                        ) : (
                            <a
                                href="https://surfalert.com/#pricing"
                                rel="nofollow"
                                target="_blank"
                            >
                                {__("Upgrade to Pro", "surfalert")}
                            </a>
                        )}
                    </div>
                </div>
                <div className="sa-sidebar-block sa-license-block">
                    {applyFilters("nx_licensing")}
                </div>
            </div>
        </div>
    );
};

export default Sidebar;
