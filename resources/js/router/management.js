import Management from '../pages/management/management.vue';
import Edite from '../pages/management/subviews/editeform.vue';
import Add from '../pages/management/subviews/create.vue';

export default [{
        name: 'management',
        path: '/management',
        component: Management,
        meta: {
            title: "Management",
        },
    },
    {
        name: 'editeManagement',
        path: '/editeManagement/:id',
        component: Edite,
        meta: {
            title: "Edite-Management",
        },
    },
    {
        name: 'management-creat',
        path: '/management/creat',
        component: Add,
        meta: {
            title: 'create-management',
        },
    },
];
