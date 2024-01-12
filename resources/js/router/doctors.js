import Doctor from '../pages/doctor/Doctor.vue';
import Edite from '../pages/doctor/subviews/editeform.vue';
import Add from '../pages/doctor/subviews/create.vue';


export default [{
        name: 'doctors',
        path: '/doctors',
        component: Doctor,
        meta: {
            title: "Doctors",
        },
    },
    {
        name: 'editeDoctor',
        path: '/editeDoctor/:id',
        component: Edite,
        meta: {
            title: "Edite-Doctor",
        },
    },
    {
        name: 'doctors-creat',
        path: '/doctor/create',
        component: Add,
        meta: {
            title: 'create-doctor',
        },
    },


];
