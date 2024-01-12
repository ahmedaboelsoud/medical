export const STOP_LOADER = (state,loader) => {
    state.loader = loader;
}
export const START_LOADER = (state,loader) => {
    state.loader = loader;
}

export const STOP_SUCCESSALERT = (state,successAlert) => {
    state.successAlert = successAlert;
}

export const SET_MESSAGE = (state,message) => {
    state.message = message;
}


// export const SET_MESSAGE = (state,"HHHHHHHHHHHH") => {
//     state.message = "NNNNNNNNNNNNNNNNN";
// }


