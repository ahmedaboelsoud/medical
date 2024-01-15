export const SET_USERS = (state, managements) => {
    state.test = managements;
}

export const SET_USER = (state, management) => {
    state.managementedite = management;
}

export const SET_TOTAL = (state, managements) => {
    state.total = managements;
}

export const SET_ERRORS = (state, errors) => {
    state.errors = errors;
}
export const REMOVE_ERRORS = (state) => {
    state.errors = "";
}
export const SET_CAT = (state, cats) => {
    state.cats = cats;
}
export const SET_CODE = (state, code) => {
    state.code = code;
}










