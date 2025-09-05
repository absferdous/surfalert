import React from "react";
import ReactDOM from "react-dom";
import { addFilter } from "@wordpress/hooks";
import SurfAlert from "./surfalert/index";
import { Sidebar } from "./surfalert/admin/Settings";
import Loader from "./surfalert/components/Loader";
import Field from "./surfalert/fields/Field";
import "quickbuilder/dist/index.css";
import Modal from "./surfalert/fields/PreviewModal";

(function () {
    addFilter("wprf_tab_content", "SurfAlert", (x, props) => {
        return (
            !props.is_pro_active &&
            props.current_page === "settings" && (
                <Sidebar
                    assetsUrl={props.assets}
                    is_pro_active={props.is_pro_active}
                />
            )
        );
    });

    addFilter("nxpro_preloader", "SurfAlert", (ProContent, isLoading) => {
        return isLoading ? <Loader /> : ProContent;
    });

    addFilter("custom_field", "SurfAlert", Field);
    // addFilter('wprf_tab_content_heading', 'SurfAlert', (props) => {

    //     return <Modal {...props} ></Modal>;
    // });

    ReactDOM.render(<SurfAlert />, document.getElementById("surfalert"));
})();
