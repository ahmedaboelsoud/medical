export const SET_PATIENTS = (state, patients) => {
    state.test = patients;
}

export const SET_PATIENT = (state, patient) => {
    state.patientedite = patient;
}

export const SET_TOTAL = (state, patients) => {
    state.total = patients;
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










