import { createRouter, createWebHistory } from "vue-router";


import Home from '../views/home.vue'
import Auth from '../views/auth.vue'
import Reg from '../views/regist.vue'
import Profile from '../views/profile.vue'
import Tasks from '../views/user.vue'
import store from "../store.js";
import adminLayout from "../layouts/adminLayout";
import userLayout from "../layouts/userLayout";
let routes;
// let getterRule = store.getters.getUserRule;
console.log(store.state.userRule);
routes = [
    {
        path: '/',
        name: 'auth',
        component: Auth,
        
    },
    {
        path: '/regist',
        name: 'regist',
        component: Reg,
    },
    {
        path: '/home',
        name: 'Home',
        component: adminLayout,
        children: [
            {
                path: '',
                name: 'admHome',
                component: Home,
                beforeEnter: (to, from, next) => {
                    if (store.state.userRule == '900') {
                        next()
                    }else{
                        next(from)
                    }
                }  
            },
            {
                path: '/profile',
                name: 'profileAdm',
                component: Profile,
                beforeEnter: (to, from, next) => {
                    if (store.state.userRule == '900') {
                        next()
                    }else{
                        next(from)
                    }
                }  
            },
            {
                path: '/tasks',
                name: 'AdminTasks',
                component: Tasks,
                beforeEnter: (to, from, next) => {
                    if (store.state.userRule == '900') {
                        next()
                    }else{
                        next(from)
                    }
                }       
            },
        ],
        beforeEnter: (to, from, next) => {
            if (store.state.userRule == '900') {
                next()
            } else {
                next({ name: 'user' })
                
            }
        }
    },
    {
        path: '/user',
        name: 'user',
        component: userLayout,
        children: [
            {
                path: '',
                name: 'userTasks',
                component: Tasks,
                beforeEnter: (to, from, next) => {
                    if (store.state.userRule == '100') {
                        next()
                    }else{
                        next(from)
                    }
                }
               
            },
            {
                path: '/userProfile',
                name: 'userProfile',
                component: Profile,
                beforeEnter: (to, from, next) => {
                    if (store.state.userRule == '100') {
                        next()
                    }else{
                        next(from)
                    }
                }
                
            },
        ],
    }
]


const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})
export default router