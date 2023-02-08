import {
  mdiAccountCircle,
  mdiMonitor,
  mdiTable,
  mdiGoogleMaps,
  mdiUpload,
  mdiAccountMultiple,
  mdiDevices,
} from "@mdi/js";

export default [
  {
    route: "dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
  },
  {
    label: "Device",
    icon: mdiDevices,
    menu: [
      {
        route: "device.index",
        label: "Device List",
        icon: mdiTable,
      },
      {
        route: "location.index",
        label: "Device Location",
        icon: mdiGoogleMaps,
      },
      {
        route: "uplink.index",
        label: "Device Uplink",
        icon: mdiUpload,
      },
    ],
  },
  {
    route: "user.index",
    label: "Users",
    icon: mdiAccountMultiple,
  },
  {
    route: "profile",
    label: "Profile",
    icon: mdiAccountCircle,
  },
];
