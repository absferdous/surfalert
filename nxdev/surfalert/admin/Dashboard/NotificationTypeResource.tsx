import { __, sprintf } from "@wordpress/i18n";
import React, { useEffect, useState } from "react";
import { assetsURL, getAlert, proAlert } from "../../core/functions";
import { Link } from "react-router-dom";
import {
    DOCS,
    NotificationType,
    proFeaturePopupConfigCrossDomain,
} from "../../core/constants";
const NotificationTypeResource = ({ props, context }) => {
    const handleSalesRedirection = (type, source) => {
        if (
            ["inline", "flashing_tab", "cross-domain"].includes(type) &&
            !context?.is_pro_active
        ) {
            const popup = getAlert(type, context);
            proAlert(popup).fire();
        } else {
            context.setRedirect({
                page: `sa-edit`,
                state: {
                    type: type,
                    source: source,
                    timestamp: new Date().getTime(),
                },
            });
        }
    };

    const handleCrossDomain = () => {
        if (!context?.is_pro_active) {
            proAlert(proFeaturePopupConfigCrossDomain).fire();
        } else {
            context.setRedirect({
                page: `sa-settings`,
                tab: "tab-miscellaneous-settings",
                keepHash: true,
            });
        }
    };

    return (
        <div className="sa-other-details-wrapper">
            <div className="sa-notification-type-wrapper sa-admin-content-wrapper">
                <div className="sa-notification-type-header sa-content-details header">
                    <div className="header-content-ex">
                        <h4>
                            {__(
                                "Exclusive Features & Notification Types",
                                "surfalert"
                            )}
                        </h4>
                        <p>
                            {__(
                                "Get various types of notification support including",
                                "surfalert"
                            )}
                        </p>
                    </div>
                    <Link
                        className="sa-secondary-btn"
                        to={{ pathname: "/admin.php", search: `?page=sa-edit` }}
                    >
                        {__("Add New", "surfalert")}
                    </Link>
                </div>
                <div className="sa-notification-type-body">
                    {NotificationType.map((item, index) => (
                        <div className="sa-body-content-wrapper" key={index}>
                            <div className="type-image">
                                <img src={item?.img} alt="icon" />
                            </div>
                            <div className="sa-body-content sa-content-details">
                                <h5>{item?.title}</h5>
                                <p>{item?.desc}</p>
                                {item?.type == "cross-domain" ? (
                                    <button
                                        className={`sa-secondary-btn ${
                                            !context?.is_pro_active &&
                                            [
                                                "inline",
                                                "flashing_tab",
                                                "cross-domain",
                                            ].includes(item?.type)
                                                ? "upgrade-pro"
                                                : ""
                                        }`}
                                        onClick={() => handleCrossDomain()}
                                    >
                                        {!context?.is_pro_active
                                            ? __("Upgrade To Pro")
                                            : item?.button_text}
                                    </button>
                                ) : (
                                    <button
                                        className={`sa-secondary-btn ${
                                            !context?.is_pro_active &&
                                            [
                                                "inline",
                                                "flashing_tab",
                                                "cross-domain",
                                            ].includes(item?.type)
                                                ? "upgrade-pro"
                                                : ""
                                        }`}
                                        onClick={() =>
                                            handleSalesRedirection(
                                                item?.type,
                                                item?.source
                                            )
                                        }
                                    >
                                        {[
                                            "inline",
                                            "flashing_tab",
                                            "cross-domain",
                                        ].includes(item?.type) &&
                                        !context?.is_pro_active
                                            ? __("Upgrade To Pro")
                                            : item?.button_text}
                                    </button>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            <div className="sa-resource-stories-wrapper">
                <div className="sa-resource-wrapper sa-admin-content-wrapper">
                    <div className="sa-resource-header sa-content-details header">
                        <h4>{__("Helpful Resources", "surfalert")}</h4>
                        <a
                            className="sa-secondary-btn"
                            href={sprintf("%s", "https://surfalert.com/docs/")}
                            target="_blank"
                        >
                            {__("Explore More", "surfalert")}
                        </a>
                    </div>

                    <div className="sa-resource-body">
                        {DOCS.map((item) => (
                            <div className="sa-resource-content sa-content-details">
                                <span>
                                    <div
                                        dangerouslySetInnerHTML={{
                                            __html: item?.svg,
                                        }}
                                    ></div>
                                </span>
                                <a href={item?.url} target="_blank">
                                    {item?.desc}
                                </a>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="sa-stories-wrapper sa-admin-content-wrapper">
                    <div className="sa-stories-header sa-content-details header">
                        <h4>{__("Customer Success Stories", "surfalert")}</h4>
                        <a
                            target="_blank"
                            className="sa-secondary-btn"
                            href={`https://surfalert.com/case-study/`}
                        >
                            {__("Learn More", "surfalert")}
                        </a>
                    </div>

                    <div className="sa-stories-body">
                        <div className="sa-stories-content">
                            <img
                                className="stories-bg"
                                src={`https://surfalert.com/wp-content/uploads/2024/09/stories-2.png`}
                                alt="stories img"
                            />
                            <div className="sa-content-details">
                                <h5
                                    dangerouslySetInnerHTML={{
                                        __html: __(
                                            "How Emilio Johann <br> Got 1.4M+ Views with Surfalert Sales Alert"
                                        ),
                                    }}
                                ></h5>
                                <p>
                                    {__(
                                        "eCom Founder Web & Ops AI Consultant",
                                        "surfalert"
                                    )}
                                </p>
                                <div className="sa-author-details">
                                    <img
                                        src={assetsURL(
                                            "/images/new-img/author-1.png"
                                        )}
                                        alt={__("author img", "surfalert")}
                                    />
                                    <div>
                                        <h6>
                                            {__("Emilio Johann", "surfalert")}
                                        </h6>
                                        <p>
                                            {__("San Diego, CA", "surfalert")}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="sa-stories-content">
                            <img
                                className="stories-bg"
                                src={`https://surfalert.com/wp-content/uploads/2024/09/stories-2.png`}
                                alt="stories img"
                            />
                            <div className="sa-content-details">
                                <h5>
                                    {__(
                                        "Converting Prospects to Customers: Barn2's Success Story with Surfalert",
                                        "surfalert"
                                    )}
                                </h5>
                                <p>
                                    {__(
                                        "WordPress Plugin Developer Company",
                                        "surfalert"
                                    )}
                                </p>
                                <div className="sa-author-details">
                                    <img
                                        src="/wp-content/plugins/surfalert/assets/admin/images/new-img/author-2.png"
                                        alt="author img"
                                    />
                                    <div>
                                        <h6>
                                            {__("Katie Keith", "surfalert")}
                                        </h6>
                                        <p>
                                            {__(
                                                "Co-Founder & CEO at Barn2",
                                                "surfalert"
                                            )}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default NotificationTypeResource;
