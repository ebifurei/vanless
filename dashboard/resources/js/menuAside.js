import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiGoogleMaps,
  mdiUpload,
} from "@mdi/js";

export default [
  {
    route: "dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
  },
  {
    route: "device.index",
    label: "Devices Table",
    icon: mdiTable,
  },
  {
    route: "location.index",
    label: "Location",
    icon: mdiGoogleMaps,
  },
  {
    route: "uplink.index",
    label: "Uplinks Table",
    icon: mdiUpload,
  },
  {
    route: "style",
    label: "Styles",
    icon: mdiPalette,
  },
  {
    route: "profile",
    label: "Profile",
    icon: mdiAccountCircle,
  },
  {
    route: "login",
    label: "Login",
    icon: mdiLock,
  },
  {
    route: "dashboard",
    label: "Error",
    icon: mdiAlertCircle,
  },
  {
    label: "Dropdown",
    icon: mdiViewList,
    menu: [
      {
        label: "Item One",
      },
      {
        label: "Item Two",
      },
    ],
  },
  {
    href: "#",
    label: "GitHub",
    icon: mdiGithub,
    target: "_blank",
  },
];
