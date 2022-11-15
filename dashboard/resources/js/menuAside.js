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
} from "@mdi/js";

export default [
  {
    route: "dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
  },
  {
    route: "devices.index",
    label: "Tables",
    icon: mdiTable,
  },
  {
    route: "dashboard",
    label: "Forms",
    icon: mdiSquareEditOutline,
  },
  {
    route: "dashboard",
    label: "UI",
    icon: mdiTelevisionGuide,
  },
  {
    route: "dashboard",
    label: "Responsive",
    icon: mdiResponsive,
  },
  {
    route: "dashboard",
    label: "Styles",
    icon: mdiPalette,
  },
  {
    route: "dashboard",
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
