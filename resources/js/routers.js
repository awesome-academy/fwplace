import VueRouter from 'vue-router'
import RegisterAccount from './components/RegisterAccountComponent'
import Home from './components/HomeComponent'
import Report from './components/layouts/reports/ReportComponent'
import Reports from './components/Reports.vue'
import Multiguard from 'vue-router-multiguard'
import axios from 'axios';

const getUser = () => {
    axios.defaults.headers.common['Authorization'] =
        'Bearer ' + localStorage.getItem('access_token');

    return axios.get('current-user');
}

let user = null;

const isAdmin = async (to, form, next) => {
    if (user === null) await getUser().then(res => {
        user = res.data.data;
    });
    if (user) {
        if (user.role !== 'trainee') {
            next();
        } else {
            next({
                name: 'index'
            });
        }
    };
}

let routes = [
    {
        path: '/manager-report',
        name: 'manager_report',
        component: Report,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/reports',
        name: 'reports',
        component: Reports,
        meta: {
            requiresAuth: true
        },
        beforeEnter: Multiguard([isAdmin])
    }
];

export default new VueRouter({
    routes
});
