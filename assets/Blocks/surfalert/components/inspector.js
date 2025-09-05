/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useState, useEffect } from "@wordpress/element";
import { InspectorControls, PanelColorSettings } from "@wordpress/block-editor";
import apiFetch from "@wordpress/api-fetch";
import { applyFilters } from '@wordpress/hooks';
import Select from 'react-select/async';

import {
  PanelBody,
  SelectControl,
  // ToggleControl,
  // TextControl,
  // TextareaControl,
  Button,
  ButtonGroup,
  BaseControl,
  TabPanel,
} from "@wordpress/components";
import { select } from "@wordpress/data";

/**
 * Internal depencencies
 */
import {
  NX_MARGIN,
  NX_PADDING,
  NX_BORDER,
  UNIT_TYPES,
  TEXT_ALIGN,
  WRAPPER_ALIGN,
} from "./constants";
import { NX_TYPOGRAPHY } from "./typographyConstants";
const {
  // faIcons,
  ResponsiveDimensionsControl,
  TypographyDropdown,
  BorderShadowControl,
  // ResponsiveRangeController,
  // BackgroundControl,
} = window.EBControls;

import objAttributes from "./attributes";

export default function Inspector(props) {
  const { attributes, setAttributes } = props;
  const {
    resOption,
    blockId,
    blockRoot,
    blockMeta,
    sa_id,
    nxColor,
    nxBgColor,
    nxLinkColor,
    nxTextAlign,
    nxWrapperAlign,
    product_id,
    selected_product,
    post_type,
  } = attributes;
  const [sa_ids, set_sa_ids] = useState(null);

  const editorStoreForGettingPreivew =
    sa_style_handler.editor_type === "edit-site"
      ? "core/edit-site"
      : "core/edit-post";

  // this useEffect is for setting the resOption attribute to desktop/tab/mobile depending on the added 'eb-res-option-' class only the first time once
  useEffect(() => {
    setAttributes({
      resOption: select(
        editorStoreForGettingPreivew
      ).__experimentalGetPreviewDeviceType(),
    });
  }, []);

  // Get current post type for Site Editor Template from URL
  const urlParams = new URLSearchParams(window.location.search);
  const postType = urlParams.get('postType');
  attributes.post_type = postType;

  // All woocommerce product
  const [sa_products,set_sa_products] = useState(null);

  // Notification type state handler
  const [sa_type,set_sa_type] = useState(null);
  const [sa_source,set_sa_source] = useState(null);

  const resRequiredProps = {
    setAttributes,
    resOption,
    attributes,
    objAttributes,
  };

  useEffect(() => {
    // set current notification type
    set_sa_type( sa_ids ? sa_ids.filter( (item) => item.value == sa_id )[0]?.type : null );
    set_sa_source( sa_ids ? sa_ids.filter( (item) => item.value == sa_id )[0]?.source : null );
    if ( sa_source !== null ) {
      const data = {
        "search_empty" : true,
        "type": "inline",
        "source": sa_source,
        "field": "product_list"
      };
      apiFetch({ path: "surfalert/v1/get-data", method: "POST", data: data }).then((res) => {
        set_sa_products([
          { label: __("Select", "surfalert"), value: "" },
          ...res,
        ]);
      });
    }
  },[sa_ids,sa_id,sa_source]);

  useEffect(() => {
    apiFetch({ path: "surfalert/v1/nx?per_page=999", method: "GET", }).then((res) => {
      let ids = [];
      if (res?.posts?.length > 0) {
        ids = res.posts
          .filter((item) => item.enabled && item.source != "press_bar" && item.type !== 'flashing_tab')
          .map((item) => ({
            label: item?.title || item?.sa_id,
            value: item?.sa_id,
            type: item.type,
            source: item.source,
          }));
      }
      set_sa_ids([
        { label: __("Select", "surfalert"), value: "" },
        ...ids,
      ]);

    });

  }, []);

  const loadOptions = (inputValue, callback) => {
    setTimeout(() => {
      if (inputValue.length >= 3) {
        const data = {
          "search_empty": true,
          "inputValue"  : inputValue,
          "type"        : "inline",
          "source"      : sa_source,
          "field"       : "product_list"
        };
        apiFetch({ path: "surfalert/v1/get-data", method: "POST", data: data }).then((res) => {
          callback(res);
        });
      }
    }, 1000);
  };

  return (
    <InspectorControls key="controls">
      <div className="eb-panel-control">
        <TabPanel
          className="eb-parent-tab-panel"
          activeClass="active-tab"
          tabs={[
            {
              name: "general",
              title: "General",
              className: "eb-tab general",
            },
            {
              name: "styles",
              title: "Style",
              className: "eb-tab styles",
            },
          ]}
        >
          {(tab) => (
            <div className={"eb-tab-controls" + tab.name}>
              {tab.name === "general" && (
                <div className="eb-panel-control">
                  <div className="sa-panel-body-default">
                    <SelectControl
                      label={__("Choose Notification", "surfalert")}
                      value={sa_id}
                      options={sa_ids}
                      onChange={(selected) =>
                        setAttributes({ sa_id: selected })
                      }
                    />
                    {sa_type === 'inline' && postType !== 'wp_template' &&
                      <>
                        {
                          sa_source == 'tutor_inline' || sa_source == 'learndash_inline' ? (
                            <label htmlFor="chooseOption">{ __( 'Choose Course','surfalert' ) }</label>
                          ) : (
                            <label htmlFor="chooseOption">{ __( 'Choose Product','surfalert' ) }</label>
                          )}
                        <Select
                          value={selected_product || null}
                          id="chooseOption"
                          loadOptions={loadOptions}
                          defaultOptions={sa_products || []}
                          noOptionsMessage={() => __("Please type 3 or more characters", "surfalert")}
                          onChange={(selected) => {
                            const safeSelected = selected || {};
                            setAttributes({ product_id: String(safeSelected.value || "") });
                            setAttributes({ selected_product: safeSelected });
                          }}
                        />
                      </>
                    }
                    {sa_ids && sa_ids.length <= 1 ? (
                      <>
                        <p className="sa-block-no-sa-notice">
                          <b>{__("Note: ", "surfalert")}</b>
                          {__(
                            "You have no notification enabled. Please Enable notifications to get here.",
                            "surfalert"
                          )}
                        </p>
                      </>
                    ) : (
                      <></>
                    )}
                    <div style={{ marginBottom: 20 }}>
                      <BaseControl label={__("Alignment", "surfalert")}>
                        <ButtonGroup id="eb-advance-heading-alignment">
                          {WRAPPER_ALIGN.map((item) => (
                            <Button
                              key={item.value}
                              isPrimary={nxWrapperAlign === item.value}
                              isSecondary={nxWrapperAlign !== item.value}
                              onClick={() =>
                                setAttributes({
                                  nxWrapperAlign: item.value,
                                })
                              }
                            >
                              {item.label}
                            </Button>
                          ))}
                        </ButtonGroup>
                      </BaseControl>
                      <a href="https://surfalert.com/docs/surfalert-inline-notification-in-gutenberg/" target="_blank">Need Help?</a>
                    </div>
                  </div>
                </div>
              )}
              {tab.name === "styles" && (
                <div className="eb-panel-control">
                  <div className="sa-panel-body-default">
                    <div style={{ marginBottom: 15 }}>
                      <TypographyDropdown
                        baseLabel={__("Typography", "surfalert")}
                        typographyPrefixConstant={NX_TYPOGRAPHY}
                        resRequiredProps={resRequiredProps}
                      />
                    </div>
                    <div style={{ marginBottom: 20 }}>
                      <BaseControl label={__("Alignment", "surfalert")}>
                        <ButtonGroup id="eb-advance-heading-alignment">
                          {TEXT_ALIGN.map((item) => (
                            <Button
                              isPrimary={nxTextAlign === item.value}
                              isSecondary={nxTextAlign !== item.value}
                              onClick={() =>
                                setAttributes({
                                  nxTextAlign: item.value,
                                })
                              }
                            >
                              {item.label}
                            </Button>
                          ))}
                        </ButtonGroup>
                      </BaseControl>
                    </div>
                    <div style={{ marginBottom: 20 }}>
                      <ResponsiveDimensionsControl
                        resRequiredProps={resRequiredProps}
                        controlName={NX_PADDING}
                        baseLabel="Padding"
                      />
                    </div>
                    <div style={{ marginBottom: 20 }}>
                      <ResponsiveDimensionsControl
                        resRequiredProps={resRequiredProps}
                        controlName={NX_MARGIN}
                        baseLabel="Margin"
                      />
                    </div>
                    <PanelColorSettings
                      initialOpen={false}
                      className={"sa-color-control"}
                      title={__("Color", "surfalert")}
                      colorSettings={[
                        {
                          value: nxLinkColor,
                          onChange: (newColor) =>
                            setAttributes({ nxLinkColor: newColor }),
                          label: __("Link Color", "surfalert"),
                        },
                        {
                          value: nxColor,
                          onChange: (newColor) =>
                            setAttributes({ nxColor: newColor }),
                          label: __("Text Color", "surfalert"),
                        },
                        {
                          value: nxBgColor,
                          onChange: (newColor) =>
                            setAttributes({ nxBgColor: newColor }),
                          label: __("Background Color", "surfalert"),
                        },
                      ]}
                    />
                    <PanelBody
                      title={__("Border")}
                      initialOpen={false}
                      className={"sa-color-control"}
                    >
                      <BorderShadowControl
                        controlName={NX_BORDER}
                        resRequiredProps={resRequiredProps}
                        noBdrHover
                        noShdowHover
                      />
                    </PanelBody>
                  </div>
                </div>
              )}
            </div>
          )}
        </TabPanel>
      </div>
    </InspectorControls>
  );
}
