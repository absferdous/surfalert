import React from "react";
import { __ } from "@wordpress/i18n";
import Docs from "../Dashboard/Docs";

const Documentation = ({ assetsUrl }) => {
    return (
        <div className="sa-settings-documentation">
            <div className="sa-settings-row">
                <Docs props={null} context={null} />
            </div>
        </div>
    );
};

export default Documentation;
