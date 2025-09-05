import React from "react";
import { FOOTER_DOCS } from "../../core/constants";
import { assetsURL } from "../../core/functions";

const Docs = ({ props, context }) => {
    return (
        <div className="sa-more-docs-wrapper">
            {FOOTER_DOCS.map((item) => (
                <div className="sa-docs-content-wrapper sa-content-details">
                    <div className="img-wrap">
                        <img
                            src={assetsURL(`/images/new-img/${item?.image}`)}
                            alt="icon"
                        />
                    </div>
                    <h3>{item?.title}</h3>
                    <p>{item?.desc}</p>
                    <a
                        className="sa-resource-link"
                        target="_blank"
                        href={item?.button_url}
                    >
                        {item?.button_text}
                        <img
                            src={assetsURL(`/images/new-img/link.svg`)}
                            alt="icon"
                        />
                    </a>
                </div>
            ))}
        </div>
    );
};

export default Docs;
