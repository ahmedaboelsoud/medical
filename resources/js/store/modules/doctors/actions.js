import Doctor from "../../../models/doctor";


export const getDoctors = ({ commit,state,dispatch },query  ) => {
   // alert("Action " + query.query.page);
    dispatch('loader/startLoader', {}, { root: true })
    return new Promise(function(resolve, reject)  {
        Doctor.index(query).then(response => {
            resolve(
                commit('SET_DOCTORS', response.data.data),
                commit('SET_TOTAL', response.data.meta.total),
                dispatch('loader/stopLoader', {}, { root: true })
            );
            reject();
        })
    });
}




export const remove = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Doctor.delete(query).then(response => {
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


export const getDoctor = ({ commit,state,dispatch },query  ) => {
    dispatch('loader/startLoader', {}, { root: true })
    
    return new Promise(function(resolve, reject)  {
        Doctor.edite(query)
          .then(response => resolve(
                 commit('SET_DOCTOR', response.data.data),
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

export const addDoctor = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Doctor.create(query)
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

export const updateDoctor = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Doctor.update(query)
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

