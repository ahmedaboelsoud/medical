import Appointments from '../pages/appointments/Appointment.vue';
import Edite from '../pages/appointments/subviews/editeform.vue';
import Add from '../pages/appointments/subviews/create.vue';


export default [{
        name: 'appointments',
        path: '/appointments',
        component: Appointments,
        meta: {
            title: "Appointments",
        },
    },
    {
        name: 'editeAppointment',
        path: '/editeAppointment/:id',
        component: Edite,
        meta: {
            title: "Edite-Appointment",
        },
    },
    {
        name: 'appointment-creat',
        path: '/appointments/create',
        component: Add,
        meta: {
            title: 'create-appointment',
        },
    },


];
