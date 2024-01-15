import Management from "../../../models/management";


export const getManagements = ({ commit,state,dispatch },query  ) => {
    dispatch('loader/startLoader', {}, { root: true })
    return new Promise(function(resolve, reject)  {
        Management.index(query).then(response => {
            resolve(
                commit('SET_USERS', response.data.data),
                commit('SET_TOTAL', response.data.meta.total),
                dispatch('loader/stopLoader', {}, { root: true })
            );
            reject();
        })
    });
}




export const remove = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Management.delete(query).then(response => {
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


export const getManagement = ({ commit,state,dispatch },query  ) => {
    dispatch('loader/startLoader', {}, { root: true })
    return new Promise(function(resolve, reject)  {
        Management.edite(query)
          .then(response => resolve(
                 commit('SET_USER', response.data.data),
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

export const addManagement = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Management.create(query)
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

export const updateManagement = ({ commit,state,dispatch },query  ) => {
    return new Promise(function(resolve, reject)  {
        Management.update(query)
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

