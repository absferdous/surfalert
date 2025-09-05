import React from "react";
import { NavLink } from "react-router-dom";

const AnalyticsCard = ({ type, url, icon, title, count, is_pro }) => {
    return (
        <div>
            <div
                className={`sa-analytics-counter ${!is_pro ? "disabled" : ""}`}
            >
                <NavLink
                    to={
                        is_pro
                            ? {
                                  pathname: "/admin.php",
                                  search:
                                      "?page=sa-analytics&comparison=" + type,
                              }
                            : {
                                  pathname: "/#",
                              }
                    }
                    onClick={(e) => {
                        if (!is_pro) {
                            e.preventDefault();
                        }
                    }}
                >
                    <>
                        <span className="sa-counter-icon">
                            <img src={icon} alt={title} />
                        </span>
                        <div>
                            <span className="sa-counter-number">
                                {count || 0}
                            </span>
                            <span className="sa-counter-label">{title}</span>
                        </div>
                    </>
                </NavLink>
            </div>
        </div>
    );
};

export default React.memo(AnalyticsCard);
