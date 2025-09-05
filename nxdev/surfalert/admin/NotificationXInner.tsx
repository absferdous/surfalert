import { __ } from "@wordpress/i18n";
import React from "react";
import SingleNotificationX from "./SingleNotificationX";

const NotificationXInner = ({
    filteredNotice,
    setFilteredNotice,
    getNotice,
    updateNotice,
    totalItems,
    setTotalItems,
    checkAll,
    setCheckAll,
    setReload,
}) => {
    const selectAll = () => {
        const notices = filteredNotice.map((item, i) => {
            return { ...item, checked: !checkAll };
        });
        setFilteredNotice(notices);
        setCheckAll(!checkAll);
    };

    const checkItem = (index) => {
        const notices = filteredNotice.map((item, i) => {
            if (index == i) {
                return { ...item, checked: !item?.checked };
            }
            return { ...item };
        });
        setFilteredNotice(notices);
    };

    // useEffect(() => {
    //     setNotices(filteredNotice);
    // }, [filteredNotice])

    return (
        <div className="sa-admin-items">
            <div className="sa-list-table-wrapper">
                <table className="wp-list-table widefat fixed striped surfalert-list">
                    <thead>
                        <tr>
                            <td>
                                <div className="sa-all-selector">
                                    <input
                                        type="checkbox"
                                        checked={checkAll}
                                        onChange={selectAll}
                                        name="nx_all"
                                        id=""
                                    />
                                </div>
                            </td>
                            <td>{__("SurfAlert Title", "surfalert")}</td>
                            <td>{__("Preview", "surfalert")}</td>
                            <td>{__("Status", "surfalert")}</td>
                            <td>{__("Type", "surfalert")}</td>
                            <td>{__("Stats", "surfalert")}</td>
                            <td>{__("Date", "surfalert")}</td>
                            <td>{__("Action", "surfalert")}</td>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredNotice.map((item, i) => {
                            return (
                                <SingleNotificationX
                                    i={i}
                                    key={`sa-${item.nx_id}`}
                                    {...item}
                                    updateNotice={updateNotice}
                                    getNotice={getNotice}
                                    totalItems={totalItems}
                                    setTotalItems={setTotalItems}
                                    checkItem={checkItem}
                                    setReload={setReload}
                                />
                            );
                        })}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default NotificationXInner;
