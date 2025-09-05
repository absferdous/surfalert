import React, { Fragment, useEffect, useState } from "react";
import nxHelper, { assetsURL } from "../../core/functions";
import { isArray } from "../../frontend/core/functions";
import { __, sprintf } from "@wordpress/i18n";
import SingleNotificationX from "../SingleNotificationX";
import { NOT_FOUND_DESC, NOT_FOUND_TITLE } from "../../core/constants";
import { Link } from "react-router-dom";

const Integration = ({ props, context }) => {
    const [surfalert, setNotificationx] = useState([]);
    const [totalItems, setTotalItems] = useState({
        all: 0,
        enabled: 0,
        disabled: 0,
    });
    const [reload, setReload] = useState();

    useEffect(() => {
        const controller =
            typeof AbortController === "undefined"
                ? undefined
                : new AbortController();
        nxHelper
            .get(`nx?&per_page=3`, { signal: controller?.signal })
            .then((res: any) => {
                if (controller?.signal?.aborted) {
                    return;
                }
                if (isArray(res?.posts)) {
                    setNotificationx(res?.posts);
                }
                if (res?.total) {
                    setTotalItems({
                        all: res?.total || 0,
                        enabled: res?.enabled || 0,
                        disabled: res?.disabled || 0,
                    });
                }
            })
            .catch((err) => {
                console.error(__("SurfAlert Fetch Error: ", "surfalert"), err);
            });
    }, [reload]);

    return (
        <div className="sa-admin-content-wrapper sa-notifications-wrapper surfalert-items">
            <div className="sa-integrations-details sa-content-details header">
                <h4>{__("Notifications", "surfalert")}</h4>
                <Link
                    className="sa-secondary-btn"
                    to={{ pathname: "/admin.php", search: `?page=sa-admin` }}
                >
                    {__("View All Notifications", "surfalert")}
                </Link>
            </div>
            <div className="sa-admin-items">
                <div className="sa-list-table-wrapper">
                    <table className="wp-list-table widefat fixed striped surfalert-list">
                        {surfalert?.length > 0 && (
                            <Fragment>
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>
                                            {__("SurfAlert Title", "surfalert")}
                                        </td>
                                        <td>{__("Preview", "surfalert")}</td>
                                        <td>{__("Status", "surfalert")}</td>
                                        <td>{__("Type", "surfalert")}</td>
                                        <td>{__("Stats", "surfalert")}</td>
                                        <td>{__("Date", "surfalert")}</td>
                                        <td>{__("Action", "surfalert")}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    {surfalert.map((item, i) => {
                                        return (
                                            <SingleNotificationX
                                                updateNotice={setNotificationx}
                                                totalItems={totalItems}
                                                setTotalItems={setTotalItems}
                                                i={i}
                                                key={`sa-${item.nx_id}`}
                                                setReload={setReload}
                                                {...item}
                                            />
                                        );
                                    })}
                                </tbody>
                            </Fragment>
                        )}
                        {surfalert?.length <= 0 && (
                            <div className="notifications-not-found sa-content-details">
                                <img
                                    src={assetsURL(
                                        "/images/new-img/not-found.svg"
                                    )}
                                    alt="icon"
                                />
                                <h5>{sprintf("%s", NOT_FOUND_TITLE)}</h5>
                                <p>{sprintf("%s", NOT_FOUND_DESC)}</p>
                                <Link
                                    className="sa-primary-btn"
                                    to={{
                                        pathname: "/admin.php",
                                        search: `?page=sa-edit`,
                                    }}
                                >
                                    {__("Add New", "surfalert")}
                                </Link>
                            </div>
                        )}
                    </table>
                </div>
            </div>
        </div>
    );
};

export default Integration;
