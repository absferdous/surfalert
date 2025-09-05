import React from "react";

const Notice = ({ message }) => {
    return (
        <div className="sa-admin-notice success-notice">
            <p>{message}</p>
        </div>
    );
};

export default Notice;
