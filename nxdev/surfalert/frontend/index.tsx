import React from "react";
import ReactDOM from "react-dom";
import domReady from "@wordpress/dom-ready";
import { setLocaleData } from "@wordpress/i18n";
import { NotificationXFrontEnd } from "./core";

function notificationXWrapper(surfalert, id) {
    if (!surfalert?.rest) return;

    if (surfalert.localeData) {
        const localeData = JSON.parse(surfalert.localeData)?.locale_data;
        if (localeData?.messages) {
            localeData.messages[""].domain = "surfalert";
            setLocaleData(localeData.messages, "surfalert");
        } else if (localeData?.["surfalert"]) {
            localeData["surfalert"][""].domain = "surfalert";
            setLocaleData(localeData["surfalert"], "surfalert");
        }
    }
    let lang = surfalert.lang?.replace("_", "-")?.toLowerCase();
    if (lang && lang !== "en" && lang !== "en-us") {
        import("moment/locale/" + lang).catch((err) => {
            lang = lang.split("-")[0];
            import("moment/locale/" + lang).catch((err) => {
                console.log("Couldn't locate moment/locale/" + lang);
            });
        });
    }

    let xDiv = document.createElement("div");
    xDiv.id = "surfalert-frontend" + id;
    xDiv.classList.add("surfalert-frontend");

    document.body.appendChild(xDiv);

    ReactDOM.render(
        <NotificationXFrontEnd config={surfalert} />,
        document.getElementById("surfalert-frontend" + id)
    );
    // @ts-ignore
}

function inIframe() {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

domReady(function () {
    // @ts-ignore
    if (inIframe() && !window.notificationXArr?.[0]?.nxPreview) {
        console.error("SurfAlert: SurfAlert doesn't work in iframe.");
        return;
    }

    (function (surfalert) {
        surfalert?.map((nx, index) => notificationXWrapper(nx, index));

        // @ts-ignore
    })(window.notificationXArr);

    if (!("Proxy" in window)) {
        return;
    }

    // @ts-ignore
    window.notificationXArr = new Proxy(window.notificationXArr || [], {
        set: function (target, property, value, receiver) {
            target[property] = value;

            if ("length" !== property) {
                notificationXWrapper(value, property);
            }
            return true;
        },
    });
});
