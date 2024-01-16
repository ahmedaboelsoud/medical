
import {createStore} from 'vuex'
import loader from "./modules/loader";
import patients from "./modules/patients";
import doctors from "./modules/doctors";
import managements from "./modules/managements";
import appointments from "./modules/appointments";




const store = createStore({
    modules: {
        loader,
        patients,
        doctors,
        managements,
        appointments,
    }
});

export default store