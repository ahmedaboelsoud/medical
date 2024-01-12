
import {createStore} from 'vuex'
import loader from "./modules/loader";
import patients from "./modules/patients";
import doctors from "./modules/doctors";

const store = createStore({
    modules: {
        loader,
        patients,
        doctors,
    }
});

export default store