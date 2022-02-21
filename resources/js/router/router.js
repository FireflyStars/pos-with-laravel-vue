import {
    createRouter,
    createWebHistory,
} from  'vue-router';
import NotFound from '../components/NotFound';
import Table from "../components/Table";
import Test from "../components/Test";
import Envoi from "../components/Envoi";
import Category from "../components/Category";
import AuthenticationMiddleware from './middleware/authentication';

const router = createRouter({
    history:createWebHistory(),
    routes:[
        {
            path: "/category/:id",
            name: "category",
            component: Category,
            props: true,
        },
        {
            path: "/affichage",
            name: "test",
            component: Test,
            props: true,
        },

        {
            path: "/cibletable",
            name: "cibletable",
            component: Table,
            props: true,
        },
        {
            path: "/envoi",
            name: "envoi",
            component: Envoi,
            props: true,
        },

        {
            path:'',
            name:'LandingPage',
            component:()=> import('../components/emailing/EmailingPage.vue'),//import('../Pages/Index'),
            meta:{
                authenticated:true
            },

        },
        {
            path:'/ComponentsTest',
            name:'ComponentsTest',
            component:()=> import('../pages/ComponentsTest'),
            meta:{
                authenticated:true
            },

        },



        {
            path:'/auth/',
            name:'AuthPage',
            component:()=> import('../components/auth/AuthPage'),
            meta:{
                authenticated:false
            },
            children:[
                {
                    path:'/auth/login/',
                    name:'Login',
                    component:()=> import('../components/auth/Login'),
                    meta:{
                        authenticated:false
                    }
                },
                {
                    path:'/auth/forgot-password/',
                    name:'ForgotPassword',
                    component:()=> import('../components/auth/ForgotPassword'),
                    meta:{
                        authenticated:false
                    }
                },
                {
                    path:'/auth/new-password/:recovery_token',
                    name:'NewPassword',
                    component:()=> import('../components/auth/NewPassword'),
                    meta:{
                        authenticated:false
                    }
                }
            ]
        },
     /*   {
            path: "/emailing/",
            name: "emailing",
            props: true,
            component: () => import("../components/emailing/EmailingPage.vue"),
            meta: {
                authenticated: true,
            },
        },*/

        {
            path: "/emailing/emailingprestations/:id",
            name: "emailingprestations",
            props: true,
            component: () =>
                import("../components/emailing/EmailingPrestations.vue"),
            meta: {
                authenticated: true,
            },
        },

        {
            path: "/emailing/cible/:type/:categ_id/:data",
            name: "cible",
            props: true,
            component: () => import("../components/emailing/Cible.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/cible/:type/:cible_id/:element_old",
            name: "cibleSeg",
            props: true,
            component: () => import("../components/emailing/Cible.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/segmentation/:type/:cible_id/:element_old",
            name: "segmentation",
            props: true,
            component: () =>
                import("../components/emailing/EmailingSegmentations.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/content/:type/:cible_id",
            name: "content",
            props: true,
            component: () =>
                import("../components/emailing/EmailingContent.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/mailing/:type/:cible_id",
            name: "mailingContenu",
            props: true,
            component: () =>
                import("../components/emailing/MailingContenu.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/display/:type/:cible_id/:show",
            name: "mailingInterface",
            props: true,
            component: () =>
                import("../components/emailing/MailingInterface.vue"),
            meta: {
                authenticated: true,
            },
        },
        {
            path: "/emailing/envoi/:type/:cible_id",
            name: "envoi",
            props: true,
            component: () => import("../components/emailing/EmailingEnvoi.vue"),
            meta: {
                authenticated: true,
            },
        },

        {
            path: "/emailing/content/:type",
            name: "mailing",
            props: true,
            component: () =>
                import("../components/emailing/MailingContenu.vue"),
            meta: {
                authenticated: false,
            },
        },
        {
            path: "/emailing/display",
            name: "mailingcontent",
            props: true,
            component: () =>
                import("../components/emailing/MailingInterface.vue"),
            meta: {
                authenticated: false,
            },
        },
        {
            path: "/template",
            name: "LettreAccompagnement",
            component: () =>
                import("../components/templates/LettreAccompagnement.vue"),
            props: true,
            meta: {
                authenticated: false,
            },
        },
        {
            path: '/:pathMatch(.*)',
            name: 'not-found',
            component:NotFound
        },

    ]
});

router.beforeEach(AuthenticationMiddleware);

export default router;
