import {createWebHistory, createRouter} from "vue-router";
import Patients from "./patients";
import Doctors from "./doctors";  
import Dashboard from "./dashboard";
import Management from "./management";

  
const routes = [
  {
    children: [
        ...Patients,
        ...Doctors,
        ...Dashboard,
        ...Management
    ]
  }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;

