import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiTable,
  mdiViewList,
  mdiPalette,
  mdiGoogleMaps,
  mdiUpload,
  mdiAccountMultiple,
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
    route: "user.index",
    label: "Users",
    icon: mdiAccountMultiple,
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
