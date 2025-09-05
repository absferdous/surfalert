import { __ } from "@wordpress/i18n";
import React from "react";
import { assetsURL } from "../../core/functions";

const HelpReviewSection = ({ props, context }) => {
    return (
        <div className="sa-admin-help-review-wrapper">
            <div className="sa-admin-help-content-wrapper">
                <div className="sa-admin-help-content">
                    <h4>{__("Need Help?", "surfalert")}</h4>
                    <p>
                        {__(
                            "Our dedicated support team is here to assist you with all your inquiries, anytime you need.",
                            "surfalert"
                        )}
                    </p>
                    <a
                        href="https://surfalert.com/support/?support=chat"
                        target="_blank"
                    >
                        <div className="sa-btn-content">
                            <img
                                src={assetsURL(
                                    "/images/new-img/contact-us.svg"
                                )}
                                alt=""
                            />
                            {__("Contact Us", "surfalert")}
                        </div>
                    </a>
                </div>
                <div className="sa-admin-help-content-banner">
                    <img
                        src={assetsURL("/images/new-img/need-help-banner.png")}
                        alt="icon"
                    />
                </div>
            </div>
            <div className="sa-admin-review-content-wrapper">
                <div className="sa-admin-help-content-wrapper">
                    <div className="sa-admin-help-content">
                        <h4>{__("Love Surfalert?", "surfalert")}</h4>
                        <p>
                            {__(
                                "Your quick feedback helps us grow and build more awesome features for you!",
                                "surfalert"
                            )}{" "}
                        </p>
                        <a
                            href="https://wpdeveloper.com/review-surfalert"
                            target="_blank"
                        >
                            <div className="sa-btn-content">
                                <img
                                    src={assetsURL(
                                        "/images/new-img/message.svg"
                                    )}
                                    alt=""
                                />
                                {__("Leave a Review", "surfalert")}
                            </div>
                        </a>
                    </div>
                    <div className="sa-admin-help-content-banner">
                        <img
                            src={assetsURL("/images/new-img/review-banner.png")}
                            alt="icon"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default HelpReviewSection;
