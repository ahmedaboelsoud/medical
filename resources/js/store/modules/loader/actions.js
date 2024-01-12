export const stopLoader = ({ commit}) => {commit('STOP_LOADER',false);}
export const startLoader = ({ commit}) => {commit('START_LOADER',true);}  
export const successAlert = ({ commit}) => {commit('STOP_SUCCESSALERT',true);}
export const successMessage = ({ commit},message) => {commit('SET_MESSAGE',message);}


   
