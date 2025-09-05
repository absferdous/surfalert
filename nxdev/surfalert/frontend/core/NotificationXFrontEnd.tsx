import React from "react";
import {
    NotificationProvider,
    NotificationContainer,
    useNotificationX,
} from "./index";

import "../scss/theme.scss";

const NotificationXFrontEnd = (props) => {
    const surfalert = useNotificationX(props);
    return (
        <NotificationProvider value={surfalert}>
            <NotificationContainer />
        </NotificationProvider>
    );
};

export default NotificationXFrontEnd;
