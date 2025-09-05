import React from "react";

const ThemePreview = ({ name, preview }) => {
    return (
        <>
            {preview && (
                <div className="sa-admin-preview">
                    <img src={preview} alt={name} />
                </div>
            )}
        </>
    );
};

export default React.memo(ThemePreview);
