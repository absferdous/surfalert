import React, {
    Fragment,
    useCallback,
    useEffect,
    useRef,
    useState,
} from "react";
import { sprintf, __ } from "@wordpress/i18n";
import { Link, Redirect } from "react-router-dom";
import nxHelper, {
    getAlert,
    permissionAlert,
    proAlert,
} from "../core/functions";
import { CopyToClipboard } from "react-copy-to-clipboard";
import { useNotificationXContext } from "../hooks";
import classNames from "classnames";
import nxToast from "../core/ToasterMsg";
import Swal from "sweetalert2";
import copy from "copy-to-clipboard";
import editIcon from "../icons/edit.png";
import translateIcon from "../icons/translate.png";
import duplicateIcon from "../icons/duplicate.png";
import shortcodeIcon from "../icons/shortcode.png";
import regenerateIcon from "../icons/regenerate.png";
import refreshIcon from "../icons/refresh.svg";
import deleteIcon from "../icons/trash.png";
import xssIcon from "../icons/xss.png";
import threeDots from "../icons/three-dots.svg";

// import copyToClipboard from '../icons/cross.png';

const SingleNotificationAction = ({
    id,
    getNotice,
    updateNotice,
    regenerate,
    setTotalItems,
    enabled,
    setReload,
    ...item
}) => {
    const nxContext = useNotificationXContext();
    const [action, setAction] = useState(false);
    const buttonRef = useRef(null);
    let xssText = null;
    if (nxContext?.is_pro_active) {
        let xss_id = {};
        if (item.source == "press_bar") {
            if (!item?.elementor_id) {
                xss_id = { pressbar: [id] };
            }
        } else if (item?.global_queue) {
            xss_id = { global: [id] };
        } else {
            xss_id = { active: [id] };
        }
        const xss_data = { ...nxContext.xss_data, ...xss_id, cross: true };
        xssText = sprintf(
            `<script>\n window.notificationXArr = window.notificationXArr || []; \nwindow.notificationXArr.push(%s);\n</script>%s`,
            JSON.stringify(xss_data),
            nxContext.xss_scripts
        );
    }

    // @ts-ignore
    const ajaxurl = window.ajaxurl;
    const handleDelete = useCallback(
        (event) => {
            if (id) {
                nxHelper.swal({
                    title: __("Are you sure?", "surfalert"),
                    text: __("You won't be able to revert this!", "surfalert"),
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: __("Yes, Delete It", "surfalert"),
                    cancelButtonText: __("No, Cancel", "surfalert"),
                    reverseButtons: true,
                    customClass: { actions: "sa-delete-actions" },
                    confirmedCallback: () => {
                        return nxHelper.delete(`nx/${id}`, { nx_id: id });
                    },
                    completeAction: (response) => {
                        setReload((r) => !r);
                    },
                    completeArgs: () => {
                        return [
                            "deleted",
                            __(
                                `Notification Alert has been Deleted.`,
                                "surfalert"
                            ),
                        ];
                    },
                    afterComplete: () => {},
                });
            }
        },
        [id, getNotice]
    );

    const handleRegenerate = (event) => {
        nxHelper.swal({
            title: __("Are you sure you want to Regenerate?", "surfalert"),
            text: __(
                "Regenerating will fetch new data based on settings",
                "surfalert"
            ),
            iconHtml: `<img alt="SurfAlert" src="${nxContext.assets.admin}images/regenerate.svg" style="height: 85px; width:85px" />`,
            showCancelButton: true,
            iconColor: "transparent",
            confirmButtonText: __("Regenerate", "surfalert"),
            cancelButtonText: __("Cancel", "surfalert"),
            reverseButtons: true,
            customClass: { actions: "sa-delete-actions" },
            confirmedCallback: () => {
                return nxHelper.get(`regenerate/${id}`, { nx_id: id });
            },
            completeAction: (response) => {},
            completeArgs: () => {
                return [
                    "regenerated",
                    __("Notification Alert has been Regenerated.", "surfalert"),
                ];
            },
            afterComplete: () => {
                // setRedirect('/');
            },
        });
    };

    // @ts-ignore
    const handleCopy = useCallback(
        (event) => {
            if (id) {
                if (item?.type == "inline") {
                    copy(`[notificationx_inline id=${id}]`, {
                        format: "text/plain",
                        onCopy: () => {
                            nxToast.info(
                                __(
                                    `Inline Notification Alert has been copied to Clipboard.`,
                                    "surfalert"
                                )
                            );
                        },
                    });
                    return;
                }
                Swal.fire({
                    iconHtml: `<img alt="SurfAlert" src="${nxContext.assets.admin}images/shortcode.svg" style="height: 45px; width:55px" class="shortcodeIcon" />`,
                    iconColor: "#6a4bff",
                    title: "Copy to Clipboard",
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: __("Cancel", "surfalert"),
                    cancelButtonColor: "#d14529",
                    html: `<div class="swal-shortcode-wrapper">
                        <label><img src="${nxContext.assets.admin}images/copy icon.svg"/>Copy Regular Shortcode: <code id="regulat-shortcode" title="click to copy">[surfalert id=${id}]</code>
                            <span>Note: Regular Shortcode will copy the notification content & its styles.</span>
                        </label>
                        <label><img src="${nxContext.assets.admin}images/copy icon.svg"/>Copy Inline Shortcode: <code id="inline-shortcode" title="click to copy">[notificationx_inline id=${id}]</code>
                            <span>Note: Inline Shortcode will only copy the notification content which you can insert anywhere on your page.</span>
                        </label>
                    </div>`,
                    didOpen: () => {
                        document
                            .getElementById("regulat-shortcode")
                            .addEventListener("click", () => {
                                copy(`[surfalert id=${id}]`, {
                                    format: "text/plain",
                                    onCopy: () => {
                                        nxToast.info(
                                            __(
                                                `Regular Notification Alert has been copied to Clipboard.`,
                                                "surfalert"
                                            )
                                        );
                                    },
                                });
                            });
                        document
                            .getElementById("inline-shortcode")
                            .addEventListener("click", () => {
                                copy(`[notificationx_inline id=${id}]`, {
                                    format: "text/plain",
                                    onCopy: () => {
                                        nxToast.info(
                                            __(
                                                `Inline Notification Alert has been copied to Clipboard.`,
                                                "surfalert"
                                            )
                                        );
                                    },
                                });
                            });
                    },
                });
            }
        },
        [id, getNotice]
    );

    const onCopyXSS = (text, result) => {
        if (nxContext?.is_pro_active) {
            nxToast.info(
                __(
                    `Cross Domain Notice code has been copied to Clipboard.`,
                    "surfalert"
                )
            );
        } else {
            proAlert(
                sprintf(
                    __(
                        "You need to upgrade to the <strong><a target='_blank' href='%s' style='color:red'>Premium Version</a></strong> to use <a target='_blank' href='%s' style='color:red'>Cross Domain Notice</a> feature.",
                        "surfalert"
                    ),
                    "https://surfalert.com/#pricing",
                    "https://surfalert.com/docs/surfalert-cross-domain-notice/"
                )
            ).fire();
        }
    };

    // handle reset
    const handleReset = () => {
        nxHelper.swal({
            title: __("Are you sure you want to Reset?", "surfalert"),
            text: __(
                "Reset will delete All analytics report for this notification",
                "surfalert"
            ),
            iconHtml: `<img alt="SurfAlert" src="${refreshIcon}" style="height: 85px; width:85px" />`,
            showCancelButton: true,
            iconColor: "transparent",
            confirmButtonText: __("Reset", "surfalert"),
            cancelButtonText: __("Cancel", "surfalert"),
            reverseButtons: true,
            customClass: {
                container: "sa-reset-analytics-container",
                popup: "sa-reset-analytics-popup",
                actions: "sa-delete-actions sa-reset-analytics-action",
            },
            confirmedCallback: () => {
                return nxHelper.get(`reset/${id}`, { nx_id: id });
            },
            completeAction: (response) => {
                nxContext.setReset({
                    analytics: response.data,
                });
                setReload((r) => !r);
            },
            completeArgs: () => {
                return [
                    "regenerated",
                    __("Notification Alert has been Reset.", "surfalert"),
                ];
            },
            afterComplete: () => {
                // setRedirect('/');
            },
        });
    };

    useEffect(() => {
        function handleClickOutside(event) {
            if (
                buttonRef.current &&
                !buttonRef.current.contains(event.target)
            ) {
                setAction(false);
            }
        }

        window.addEventListener("click", handleClickOutside);
        return () => {
            window.removeEventListener("click", handleClickOutside);
        };
    }, []);

    const handleWPMLRedirection = (event) => {
        if (!nxContext.settings.is_wpml_active) {
            nxToast.warning(
                __(
                    `You need to Install, Activate & Setup WPML Multilingual CMS & WPML String Translation plugins to use this feature.`,
                    "surfalert"
                )
            );
        } else {
            window.open(`${ajaxurl}?action=sa-translate&id=${id}`);
        }
    };

    return (
        <div className="sa-admin-actions-wrapper">
            <div
                className="sa-admin-actions sa-admin-action-button"
                ref={buttonRef}
            >
                <a
                    className="sa-admin-three-dots"
                    title={__("Three Dots", "surfalert")}
                    onClick={() => setAction(!action)}
                >
                    <img src={threeDots} alt={"three-dots"} />
                </a>
            </div>
            {action && (
                <div className="sa-admin-actions sa-admin-actions-lists">
                    {/*  || item?.elementor_id */}
                    <ul id="sa-admin-actions-ul">
                        <li>
                            <Link
                                className="sa-admin-title-edit"
                                title={__("Edit", "surfalert")}
                                to={{
                                    pathname: "/admin.php",
                                    search: `?page=sa-edit&id=${id}`,
                                }}
                            >
                                <img src={editIcon} alt={"edit-icon"} />
                                <span>{__("Edit", "surfalert")}</span>
                            </Link>
                        </li>
                        <li>
                            <a
                                className={classNames(
                                    "sa-admin-title-translate",
                                    {
                                        hidden: !nxContext?.can_translate,
                                    }
                                )}
                                title={__("Translate", "surfalert")}
                                onClick={handleWPMLRedirection}
                            >
                                <img
                                    src={translateIcon}
                                    alt={"translate-icon"}
                                />
                                <span>{__("Translate", "surfalert")}</span>
                            </a>
                        </li>
                        <li>
                            <Link
                                className={classNames(
                                    "sa-admin-title-duplicate",
                                    {
                                        hidden: nxContext?.createRedirect,
                                    }
                                )}
                                title={__("Duplicate", "surfalert")}
                                to={{
                                    pathname: "/admin.php",
                                    search: `?page=sa-edit`, //&clone=${id}
                                    state: { duplicate: true, _id: id },
                                }}
                            >
                                <img
                                    src={duplicateIcon}
                                    alt={"duplicate-icon"}
                                />
                                <span>{__("Duplicate", "surfalert")}</span>
                            </Link>
                        </li>
                        {nxContext?.is_pro_active &&
                            item.source != "press_bar" &&
                            item.source != "gdpr_notification" &&
                            item.source != "flashing_tab" &&
                            item.themes !== "woo_inline_stock-theme-one" &&
                            item.themes !==
                                "woocommerce_sales_inline_stock-theme-one" &&
                            item.themes !== "woo_inline_stock-theme-two" &&
                            item.themes !==
                                "woocommerce_sales_inline_stock-theme-two" && (
                                <li>
                                    <a
                                        className="sa-admin-title-shortcode sa-shortcode-btn"
                                        title={__("Shortcode", "surfalert")}
                                        onClick={handleCopy}
                                    >
                                        <img
                                            src={shortcodeIcon}
                                            alt={"shortcode-icon"}
                                        />
                                        <span>
                                            {__("ShortCode", "surfalert")}
                                        </span>
                                    </a>
                                </li>
                            )}
                        {!nxContext?.is_pro_active &&
                            item.source != "press_bar" &&
                            item.source != "flashing_tab" &&
                            item.source != "gdpr_notification" &&
                            item.themes !== "woo_inline_stock-theme-one" &&
                            item.themes !==
                                "woocommerce_sales_inline_stock-theme-one" &&
                            item.themes !== "woo_inline_stock-theme-two" &&
                            item.themes !==
                                "woocommerce_sales_inline_stock-theme-two" && (
                                <li>
                                    <CopyToClipboard
                                        className="sa-admin-title-shortcode sa-shortcode-btn"
                                        title={__("Shortcode", "surfalert")}
                                        text={`[notificationx_inline id=${id}]`}
                                        options={{ format: "text/plain" }}
                                        onCopy={() => {
                                            nxToast.info(
                                                __(
                                                    `Inline Notification Alert has been copied to Clipboard.`,
                                                    "surfalert"
                                                )
                                            );
                                        }}
                                    >
                                        <a>
                                            <img
                                                src={shortcodeIcon}
                                                alt={"shortcode-icon"}
                                            />
                                            {__("Shortcode", "surfalert")}
                                        </a>
                                    </CopyToClipboard>
                                </li>
                            )}
                        <li>
                            {!item?.elementor_id &&
                                item.source != "flashing_tab" &&
                                item.source != "gdpr_notification" && (
                                    <CopyToClipboard
                                        className="sa-admin-title-xss"
                                        title={__(
                                            "Cross Domain Notice",
                                            "surfalert"
                                        )}
                                        text={xssText}
                                        options={{ format: "text/plain" }}
                                        onCopy={onCopyXSS}
                                    >
                                        <a>
                                            {" "}
                                            <img
                                                src={xssIcon}
                                                alt={"cross-domain-notice"}
                                            />{" "}
                                            {__(
                                                "Cross Domain Notice",
                                                "surfalert"
                                            )}
                                        </a>
                                    </CopyToClipboard>
                                )}
                        </li>
                        <li>
                            {/* <Link className="sa-admin-title-duplicate" title="Entries" to={`/entries/${id}`}><span>{__('Entries', 'surfalert')}</span></Link> */}
                            {regenerate && (
                                <Fragment>
                                    <a
                                        className="sa-admin-title-regenerate"
                                        onClick={handleRegenerate}
                                        title={__("Regenerate", "surfalert")}
                                    >
                                        <img
                                            src={regenerateIcon}
                                            alt={"regenerate-icon"}
                                        />
                                        <span>
                                            {__("Regenerate", "surfalert")}
                                        </span>
                                    </a>
                                </Fragment>
                            )}
                        </li>
                        <li>
                            <a
                                className={classNames("sa-admin-title-reset", {
                                    hidden: nxContext?.createRedirect,
                                })}
                                title={__("Reset", "surfalert")}
                                onClick={handleReset}
                            >
                                <img src={refreshIcon} alt={"reset-icon"} />
                                <span>{__("Reset", "surfalert")}</span>
                            </a>
                        </li>
                        <li>
                            <a
                                className={classNames("sa-admin-title-trash", {
                                    hidden: nxContext?.createRedirect,
                                })}
                                title={__("Delete", "surfalert")}
                                onClick={handleDelete}
                            >
                                <img src={deleteIcon} alt={"delete-icon"} />
                                <span>{__("Delete", "surfalert")}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            )}
        </div>
    );
};

export default SingleNotificationAction;
