import "@/bootstrap";

// Components
import "@/components/base";
Vue.component(
  "global-search",
  require("@/components/globalSearch.vue").default
);
Vue.component("login-form", require("@/components/loginForm.vue").default);
Vue.component(
  "profile-picture",
  require("@/components/profilePicture.vue").default
);
Vue.component("sidebar-list", require("@/components/sidebarList.vue").default);
Vue.component(
  "sidebar-list-item",
  require("@/components/sidebarListItem.vue").default
);
Vue.component(
  "user-dropdown",
  require("@/components/userDropdown.vue").default
);
Vue.component("breadcrumb", require("@/components/breadcrumb.vue").default);
Vue.component("notification", require("@/components/notification.vue").default);
Vue.component("page-title", require("@/components/base/PageTitle.vue").default);
Vue.component("info-card", require("@/components/InfoCard.vue").default);
Vue.component("panel", require("@/components/Panel.vue").default);

import { VueRouter, router } from "./routes";
import Vuex from "vuex";
import { store } from "./store/index.js";
import Moment from 'vue-moment'
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Moment)

const app = new Vue({
  el: "#app",
  router,
  store,
  data: {
    collapseSidebar: false,
    loading: true,
    search: ""
  },
  mounted() {
    this.loading = false;
  }
});
