import React from "react";

const Sidebar = ({ children }) => {
    return (
        <div className="sa-admin-sidebar">
            <div className="sa-admin-sidebar-wrapper">{children}</div>
        </div>
    );
};

export default Sidebar;
