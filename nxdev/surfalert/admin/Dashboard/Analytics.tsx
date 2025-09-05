import React from "react";
import { __ } from "@wordpress/i18n";
import Analytics from "../Analytics/Analytics";
import { assetsURL } from "../../core/functions";
import { Link } from "react-router-dom";
import AnalyticsForDashboard from "../Analytics/AnalyticsForDashboard";

const AnalyticsDashboard = ({ props, context }) => {
    return (
        <div className="sa-analytics-integration-wrapper">
            <div className="sa-analytics-graph-main-wrapper sa-admin-content-wrapper">
                <AnalyticsForDashboard isDashboard={true} />
            </div>
            <div className="sa-integration-wrapper sa-admin-content-wrapper">
                <div className="sa-integrations-header sa-content-details header">
                    <h4>{__("Integrations", "surfalert")}</h4>
                    <Link
                        className="sa-secondary-btn"
                        to={{
                            pathname: "/admin.php",
                            search: `?page=sa-settings`,
                        }}
                    >
                        {__("View All Integrations", "surfalert")}
                    </Link>
                </div>
                <div className="sa-integrations-body">
                    <img
                        src={`https://surfalert.com/wp-content/uploads/2024/09/integration.png`}
                        alt="icon"
                    />
                </div>
            </div>
        </div>
    );
};
export default AnalyticsDashboard;
