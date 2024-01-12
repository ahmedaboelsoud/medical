import * as Sentry from "@sentry/vue";
import axios from "axios";
// import app from "../app.js";
// import { showSwal, showToastr } from "./helpers";

const api = axios.create({
  headers: {
    "X-Requested-With": "XMLHttpRequest"
  }
});

api.interceptors.response.use(
  res => {
    if (res.data.action === "SHOW_TOASTR") {
      showToastr("success", res.data.message);
    } else if (res.data.action === "SHOW_CONFIRMATION") {
      showSwal("success", res.data.message, res.data.title || "");
    } else if (res.data.action === "SHOW_ERROR") {
      showToastr("danger", res.data.message, res.data.title || "");
    }

    return res;
  },
  err => {
    Sentry.captureException(err.response, scope => {
      scope.setUser(window.Laravel.user);
      // scope.setTransactionName(app.$route.name);
      return scope;
    });
    // TODO: Show 500 error messages
    if (err.response.status === 422) {
      // showFieldErrors(err.response.data.errors)
    } else if (err.response.status === 404) {
      // app.$router.push("/404");
    } else if (err.response.status === 403) {
      // app.$router.push("/403");
    }

    return Promise.reject(err);
  }
);

export default api;
