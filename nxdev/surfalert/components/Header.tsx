import React, { useState } from "react";
import { __ } from "@wordpress/i18n";
import { Link } from "react-router-dom";
import { applyFilters } from "@wordpress/hooks";
import Logo from "./Logo";
import { useNotificationXContext } from "../hooks";
import nxHelper from "../core/functions";

const Version = ({ version }) => {
    return (
        <span>
            {__("SurfAlert:", "surfalert")} <strong>{version}</strong>
        </span>
    );
};

const Header = ({ addNew = false, context = {} }) => {
    const builderContext = useNotificationXContext();
    const pro_version = builderContext.pro_version;
    const version = builderContext.version;
    return (
        <div className="sa-settings-header">
            <div className="sa-header-left">
                <div className="sa-admin-header">
                    <Logo />
                    {!builderContext?.createRedirect && !addNew && (
                        <Link
                            className="sa-add-new-btn"
                            to={nxHelper.getRedirect({ page: `sa-edit` })}
                        >
                            {__("Add New", "surfalert")}
                        </Link>
                    )}
                </div>
            </div>
            <div className="sa-header-right">
                {applyFilters(
                    "notificationx_header",
                    <Version version={version} />
                )}
                {typeof pro_version === "string" && (
                    <span>
                        {__("SurfAlert Pro:", "surfalert")}{" "}
                        <strong>{pro_version}</strong>
                    </span>
                )}
            </div>
        </div>
    );
};
export default Header;
