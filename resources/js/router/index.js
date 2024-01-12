import {createWebHistory, createRouter} from "vue-router";
import Patients from "./patients";
import Doctors from "./doctors";  



const routes = [
  {
    children: [
        ...Patients,
        ...Doctors,
    ]
  }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

