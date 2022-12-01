import { defineStore } from "pinia";
import * as styles from "@/styles";
import { darkModeKey, styleKey } from "@/config";

export const useStyleStore = defineStore("style", {
  state: () => ({
    /* Styles */
    asideStyle: "",
    asideScrollbarsStyle: "",
    asideBrandStyle: "",
    asideMenuItemStyle: "",
    asideMenuItemActiveStyle: "",
    asideMenuDropdownStyle: "",
    navBarItemLabelStyle: "",
    navBarItemLabelHoverStyle: "",
    navBarItemLabelActiveColorStyle: "",
    overlayStyle: "",

    /* Dark mode */
    darkMode: true,

    /* MapStyle */
    mapStyleDefault: [
      {
        featureType: "poi.business",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }],
      },
    ],
    mapStyleDark: [
      { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
      { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
      { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
      {
        featureType: "administrative.locality",
        elementType: "labels.text.fill",
        stylers: [{ color: "#d59563" }],
      },
      {
        featureType: "poi",
        elementType: "labels.text.fill",
        stylers: [{ color: "#d59563" }],
      },
      {
        featureType: "poi.business",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "poi.park",
        elementType: "geometry",
        stylers: [{ color: "#263c3f" }],
      },
      {
        featureType: "poi.park",
        elementType: "labels.text.fill",
        stylers: [{ color: "#6b9a76" }],
      },
      {
        featureType: "road",
        elementType: "geometry",
        stylers: [{ color: "#38414e" }],
      },
      {
        featureType: "road",
        elementType: "geometry.stroke",
        stylers: [{ color: "#212a37" }],
      },
      {
        featureType: "road",
        elementType: "labels.text.fill",
        stylers: [{ color: "#9ca5b3" }],
      },
      {
        featureType: "road.highway",
        elementType: "geometry",
        stylers: [{ color: "#746855" }],
      },
      {
        featureType: "road.highway",
        elementType: "geometry.stroke",
        stylers: [{ color: "#1f2835" }],
      },
      {
        featureType: "road.highway",
        elementType: "labels.text.fill",
        stylers: [{ color: "#f3d19c" }],
      },
      {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "transit.station",
        elementType: "labels.text.fill",
        stylers: [{ color: "#d59563" }],
      },
      {
        featureType: "water",
        elementType: "geometry",
        stylers: [{ color: "#17263c" }],
      },
      {
        featureType: "water",
        elementType: "labels.text.fill",
        stylers: [{ color: "#515c6d" }],
      },
      {
        featureType: "water",
        elementType: "labels.text.stroke",
        stylers: [{ color: "#17263c" }],
      },
    ],
    mapStyle: [],
  }),
  actions: {
    setMapStyle() {
      if (this.darkMode) {
        this.mapStyle = this.mapStyleDark;
      } else {
        this.mapStyle = this.mapStyleDefault;
      }
    },
    setStyle(payload) {
      if (!styles[payload]) {
        return;
      }

      if (typeof localStorage !== "undefined") {
        localStorage.setItem(styleKey, payload);
      }

      const style = styles[payload];

      for (const key in style) {
        this[`${key}Style`] = style[key];
      }
    },

    setDarkMode(payload = null) {
      this.darkMode = payload !== null ? payload : !this.darkMode;

      if (typeof localStorage !== "undefined") {
        localStorage.setItem(darkModeKey, this.darkMode ? "1" : "0");
      }

      if (typeof document !== "undefined") {
        document.body.classList[this.darkMode ? "add" : "remove"](
          "dark-scrollbars"
        );

        document.documentElement.classList[this.darkMode ? "add" : "remove"](
          "dark-scrollbars-compat"
        );
      }
      this.mapStyle = this.darkMode ? this.mapStyleDark : this.mapStyleDefault;
    },
  },
});
