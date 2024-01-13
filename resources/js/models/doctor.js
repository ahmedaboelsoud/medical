import qs from "qs";
import api from "../utils/api";

export default {

  index(query = {}) {
   // alert("Models " + query.query.page);
    return api.post(`/api/doctors?page=${query.page}`, query.query);
  },

  cats() {
    return api.get(`/api/getCats`);
  },
  edite(query) {
    return api.get(`/api/edite-doctor/${query}`);
  },
  create(payload) {
    payload.lang = localStorage.getItem('lang');
    return api.post("/api/add-doctor", payload);
  },
  update(payload) {
    payload.lang = localStorage.getItem('lang');
    return api.patch(`/api/update-doctor/${payload.id}`, payload)
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
  edit(id, payload) {
    return api.patch(`/api/users/${id}`, payload);
  },
  delete(id) {
    return api.delete(`/api/delete-doctor/${id}`);
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
