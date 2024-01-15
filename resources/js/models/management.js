import qs from "qs";
import api from "../utils/api";

export default {

  index(query = {}) {
    return api.get(`/api/users?page=${query.page}`);
  },

  cats() {
    return api.get(`/api/getCats`);
  },
  edite(query) {
    return api.get(`/api/edite-user/${query}`);
  },
  create(payload) {
    payload.lang = localStorage.getItem('lang');
    return api.post("/api/add-user", payload);
  },
  update(payload) {
    payload.lang = localStorage.getItem('lang');
    return api.patch(`/api/update-user/${payload.id}`, payload)
  },
  resetPassword(id) {
    return api.get(`/api/users/password/reset/${id}`);
  },

  fetch(id, flags = {}) {
    return api.get(`/api/users/${id}`, {
      params: flags,
      paramsSerializer: params => {
        return qs.stringify(params);
      }
    });
  },
  delete(id) {
    return api.delete(`/api/delete-user/${id}`);
  },
  restore(id) {
    return api.get(`/api/users/return/${id}`);
  },
  auditors(query = {}) {
    return api.get("/api/users/auditors", {
      params: query,
      paramsSerializer: params => {
        return qs.stringify(params);
      }
    });
  },
  admins(query = {}) {
    return api.get("/api/users/admins", {
      params: query,
      paramsSerializer: params => {
        return qs.stringify(params);
      }
    });
  }
};
