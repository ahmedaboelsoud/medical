import Patient from '../pages/patient/Patient.vue';
import Edite from '../pages/patient/subviews/editeform.vue';
import Add from '../pages/patient/subviews/create.vue';


export default [{
        name: 'patients',
        path: '/patients',
        component: Patient,
        meta: {
            title: "Patients",
        },
    },
    {
        name: 'editePatient',
        path: '/editePatient/:id',
        component: Edite,
        meta: {
            title: "Edite-Patient",
        },
    },
    {
        name: 'patient-creat',
        path: '/patient/create',
        component: Add,
        meta: {
            title: 'create-patient',
        },
    },


];
