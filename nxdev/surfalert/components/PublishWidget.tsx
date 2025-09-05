import React, { useCallback, useState } from "react";
import { Button, ButtonGroup } from "@wordpress/components";
import { Date } from "quickbuilder";
import { isInTheFuture } from "@wordpress/date";
import nxHelper, { proAlert } from "../core/functions";
import Swal from "sweetalert2";
import { useNotificationXContext } from "../hooks";
import classNames from "classnames";
import nxToast from "../core/ToasterMsg";
import { __, sprintf } from "@wordpress/i18n";

const PublishWidget = (props) => {
    const { title, context, isEdit, setIsLoading, setIsCreated, id, ...rest } =
        props;
    const builderContext = useNotificationXContext();
    const [isEnabled, setIsEnabled] = useState(props?.context?.values?.enabled);
    const handleSubmit = useCallback(
        (event) => {
            context.setSubmitting(true);
            setIsLoading(true);
            let route = "nx" + (isEdit && id ? `/${id}` : "");
            nxHelper
                .post(route, {
                    ...context.values,
                    title,
                    currentTab: context.config.active,
                })
                .then((res: any) => {
                    if (res?.nx_id) {
                        if (setIsCreated) {
                            builderContext.setRedirect({
                                page: `sa-edit`,
                                id: res?.nx_id,
                                state: { published: true },
                            });
                        } else {
                            setIsLoading(false);
                            context.setValues(res);
                            context.setSavedValues(res);
                            rest?.setIsUpdated("saved");
                        }
                    } else {
                        setIsLoading(false);
                        console.error(__("NX Not Created", "surfalert"));
                    }
                })
                .catch((err) => console.error(__("Error: ", "surfalert"), err));
        },
        [title, context]
    );

    const handleDelete = useCallback(() => {
        Swal.fire({
            title: __("Are you sure?", "surfalert"),
            text: __("You won't be able to revert this!", "surfalert"),
            icon: "error",
            showCancelButton: true,
            confirmButtonText: __("Yes, Delete It", "surfalert"),
            cancelButtonText: __("No, Cancel", "surfalert"),
            customClass: { actions: "sa-delete-actions" },
            reverseButtons: true,
            // target: "#surfalert",
        }).then((result) => {
            if (result.isConfirmed) {
                nxHelper
                    .delete(`nx/${id}`, { nx_id: id })
                    .then((res) => {
                        if (res) {
                            nxToast.deleted(
                                __(
                                    `Notification Alert has been Deleted.`,
                                    "surfalert"
                                )
                            );
                            builderContext.setRedirect({
                                page: `sa-admin`,
                            });
                        } else {
                            nxToast.error(
                                __(
                                    `Oops, Something went wrong. Please try again.`,
                                    "surfalert"
                                )
                            );
                        }
                    })
                    .catch((err) =>
                        console.error(__("Delete Error: ", "surfalert"), err)
                    );
            }
        });
    }, [isEdit]);

    const toggleStatus = (event) => {
        let target = event.target ? event.target : event.currentTarget;
        const source = context?.values?.source;
        const enabled = target.checked;

        nxHelper
            .post("nx/" + id, {
                source: source,
                enabled: enabled,
                nx_id: id,
                update_status: true,
            })
            .then((res) => {
                if (res) {
                    setIsEnabled(enabled);
                    if (enabled) {
                        nxToast.enabled(
                            __(
                                `Notification Alert has been Enabled.`,
                                "surfalert"
                            )
                        );
                    } else {
                        nxToast.disabled(
                            __(
                                `Notification Alert has been Disabled.`,
                                "surfalert"
                            )
                        );
                    }
                    context.setFieldValue("enabled", enabled);
                } else if (res === 0) {
                    proAlert(
                        enabled
                            ? sprintf(
                                  __(
                                      "You need to upgrade to the <strong><a target='_blank' href='%s' style='color:red'>Premium Version</a></strong> to use this feature.",
                                      "surfalert"
                                  ),
                                  "https://surfalert.com/#pricing"
                              )
                            : __("Disabled", "surfalert")
                    ).fire();
                } else {
                    proAlert(
                        enabled
                            ? sprintf(
                                  __(
                                      "You need to upgrade to the <strong><a target='_blank' href='%s' style='color:red'>Premium Version</a></strong> to use multiple notification.",
                                      "surfalert"
                                  ),
                                  "https://surfalert.com/#pricing"
                              )
                            : __("Disabled", "surfalert")
                    ).fire();
                }
                return res;
            })
            .catch((err) => {
                nxToast.error(
                    __(
                        `Oops, Something went wrong. Please try again.`,
                        "surfalert"
                    )
                );
            });
    };

    const meta_id = `_sa_meta_active_check_${id}`;
    return (
        <div className="sidebar-widget sa-widget">
            <div className="sa-widget-title">
                <h4>{__("Publish", "surfalert")}</h4>
                {id && (
                    <div className="sa-admin-status">
                        <input
                            type="checkbox"
                            name={"_sa_meta_active_check"}
                            id={meta_id}
                            onChange={(event) => toggleStatus(event)}
                            checked={isEnabled}
                        />
                        <label htmlFor={meta_id}></label>
                        <span>
                            {isEnabled
                                ? __("Active", "surfalert")
                                : __("Inactive", "surfalert")}{" "}
                        </span>
                    </div>
                )}
            </div>
            <div className="sa-widget-content">
                <div className="sa-publish-date-widget">
                    <label htmlFor="updated_at">
                        {isInTheFuture(context.values?.updated_at)
                            ? __("Scheduled For", "surfalert")
                            : isEdit
                            ? __("Published On", "surfalert")
                            : __("Publish On", "surfalert")}{" "}
                        :{" "}
                    </label>
                    <Date
                        name="updated_at"
                        value={context.values?.updated_at}
                        position="bottom left"
                        onChange={(data) => {
                            context.setFieldValue(
                                "updated_at",
                                data.target.value
                            );
                        }}
                    />
                </div>
                <ButtonGroup>
                    {isEdit && (
                        <Button
                            className={classNames("sa-trash sa-btn is-danger", {
                                disabled: builderContext?.createRedirect,
                            })}
                            onClick={handleDelete}
                            disabled={builderContext?.createRedirect}
                        >
                            Delete
                        </Button>
                    )}
                    <Button
                        isPrimary
                        className={classNames("sa-save sa-btn", {
                            disabled: builderContext?.createRedirect,
                        })}
                        onClick={handleSubmit}
                        disabled={builderContext?.createRedirect}
                    >
                        {isInTheFuture(context.values?.updated_at)
                            ? __("Schedule", "surfalert")
                            : isEdit
                            ? __("Update", "surfalert")
                            : __("Publish", "surfalert")}
                    </Button>
                </ButtonGroup>
            </div>
        </div>
    );
};

export default PublishWidget;
