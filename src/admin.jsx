import React from "react";
import { createRoot } from "react-dom/client";

function AdminApp() {
    return (
        <div
            style={{
                padding: "2em",
                margin: "20px 0",
                backgroundColor: "#fff",
                border: "1px solid #c3c4c7",
            }}
        >
            <h1>Welcome to the SurfAlert Rebuild!</h1>
            <p>The new React frontend has successfully replaced the old UI.</p>
        </div>
    );
}

const container = document.getElementById("surfalert-admin-app");
if (container) {
    const root = createRoot(container);
    root.render(<AdminApp />);
} else {
    console.error(
        "SurfAlert admin root element #surfalert-admin-app not found."
    );
}
