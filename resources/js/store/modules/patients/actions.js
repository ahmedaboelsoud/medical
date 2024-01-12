import Patient from "../../../models/patient";


export const getPatients = ({ commit,state,dispatch },query  ) => {
   // alert("Action " + query.query.page);
    dispatch('loader/startLoader', {}, { root: true })
    return new Promise(function(resolve, reject)  {
        Patient.index(query).then(response => {
            resolve(
                commit('SET_PATIENTS', response.data.data),
                commit('SET_TOTAL', response.data.meta.total),
                dispatch('loader/stopLoader', {}, { root: true })
            );
            reject();
        })
    });
}




export const remove = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Patient.delete(query).then(response => {
            resolve(
                dispatch('loader/stopLoader', {}, { root: true })
            );
            reject();
        })
    });
   
}

export const emptyErrors = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        commit('REMOVE_ERRORS')
    });
}


export const getPatient = ({ commit,state,dispatch },query  ) => {
    dispatch('loader/startLoader', {}, { root: true })
    
    return new Promise(function(resolve, reject)  {
        Patient.edite(query)
          .then(response => resolve(
                 commit('SET_PATIENT', response.data.data),
                 dispatch('loader/stopLoader', {}, { root: true })
                 
                 ))
                 .catch(err => {
                     if (err.response.status === 404) {
                         commit('SET_CODE', err.response.status);
                     }
                     reject(err);
                 })
         });
}

export const addPatient = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Patient.create(query)
            .then(res => resolve(
                commit('REMOVE_ERRORS'),
                dispatch('loader/successAlert', {}, { root: true }),
                
            ))
            .catch(err => {
                if (err.response.status === 422) {
                    let { errors } = err.response.data;
                    commit('SET_ERRORS', errors);
                }
                reject();
            })
    });
}

export const updatePatient = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Patient.update(query)
          .then(res => resolve(
              commit('REMOVE_ERRORS'),
              dispatch('loader/successAlert', {}, { root: true }),
            ))
            .catch(err => {
                if (err.response.status === 422) {
                    let { errors } = err.response.data;
                    commit('SET_ERRORS', errors);
                }
                reject();
            })
    });
}

