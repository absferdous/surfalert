import { __ } from "@wordpress/i18n";
import React from "react";
import { assetsURL } from "../../core/functions";
import { NavLink } from "react-router-dom";

const AnalyticsOverview = ({ props, context }) => {
    return (
        <div className="sa-analytics-wrapper">
            <NavLink
                className={"sa-analytics-content-wrapper"}
                to={{
                    pathname: "/admin.php",
                    search: "?page=sa-analytics&comparison=views",
                }}
            >
                <img
                    src={assetsURL("/images/analytics/views-icon.png")}
                    alt={__("Total Views", "surfalert")}
                />
                <div className="analytics-counter">
                    <span className="sa-counter-label">
                        {__("Total Views", "surfalert")}
                    </span>
                    <h3 className="sa-counter-number">
                        {context?.analytics?.totalViews}
                    </h3>
                </div>
            </NavLink>
            <NavLink
                className={"sa-analytics-content-wrapper"}
                to={{
                    pathname: "/admin.php",
                    search: "?page=sa-analytics&comparison=clicks",
                }}
            >
                <img
                    src={assetsURL("/images/analytics/clicks-icon.png")}
                    alt={__("Total Clicks", "surfalert")}
                />
                <div className="analytics-counter">
                    <span className="sa-counter-label">
                        {__("Total Clicks", "surfalert")}
                    </span>
                    <h3 className="sa-counter-number">
                        {context?.analytics?.totalClicks}
                    </h3>
                </div>
            </NavLink>
            <NavLink
                className={"sa-analytics-content-wrapper"}
                to={{
                    pathname: "/admin.php",
                    search: "?page=sa-analytics&comparison=ctr",
                }}
            >
                <div>
                    <img
                        src={assetsURL("/images/analytics/clicks-icon.png")}
                        alt={__("Click-Through-Rate", "surfalert")}
                    />
                </div>
                <div className="analytics-counter">
                    <span className="sa-counter-label">
                        {__("Click-Through-Rate", "surfalert")}
                    </span>
                    <h3 className="sa-counter-number">
                        {context?.analytics?.totalCtr}
                    </h3>
                </div>
            </NavLink>
        </div>
    );
};

export default AnalyticsOverview;
