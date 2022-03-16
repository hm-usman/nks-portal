import Dashboard from './components/dashboard';
import NotFound from './components/notfound';


export default {
    mode: 'history',
    linkActiveClass: 'active',

    routes: [{
            path: '*',
            component: Dashboard
        },
        {
            path: '/dashboard',
            component: Dashboard
        }

    ]
};