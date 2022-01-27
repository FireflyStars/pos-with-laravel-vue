<template>
    <div class="col-lg-6 col-sm-3 side-bar-wrap d-flex flex-column align-items-center" :class="{slidein:slidesidebar}">
<div class="d-flex flex-column side-bar align-items-center position-fixed">

                    <Icon imageurl="../../images/star-icon.png"/>
                    <Icon imageurl="../../images/user-icon.png"/>
                    <Icon imageurl="../../images/user-profile.png"/>


                    <Icon imageurl="../../images/panier-icon.png"/>
                    <Icon imageurl="../../images/folder-icon.png"/>
                    <Icon imageurl="../../images/edit-icon.png"/>
                    <Icon imageurl="../../images/message-icon.png"/>
</div>
            <div class="user_initials body_bold" @click="showmenu">
                {{initials}}
            </div>
        <transition name="usermenu" >
            <div class="usermenu" v-if="dispmenu" >

                <button class="btn btn-outline-dark body_medium"  data-bs-toggle="tooltip" data-bs-placement="right" title="Logout user" @click="logout">Sign out</button>


            </div>
        </transition>
    </div>

</template>

<script>

    import {ref,computed,watch} from 'vue';
    import { useRouter, useRoute } from 'vue-router'
    import Icon from './../Icon.vue';
    import axios from 'axios';
    import {useStore} from 'vuex';
    import {
        DISPLAY_LOADER,
        HIDE_LOADER,
        LOADER_MODULE,
        SIDEBAR_GET_SLIDEIN,
        SIDEBAR_MODULE
    } from "../../store/types/types";

    export default {
        name: "SideBar",
        components:{Icon},
        setup(){
            const store=useStore();
            let colorIconDefault=ref("#FFFFFF");
             let colorIconClicked=ref("#FFA500");
             let colorIcon=ref("#FFA500");
             const isClicked=ref('false');
            const uname=ref(window.sessionStorage.getItem('name'));
            const initials= ref((uname.value!=null?uname.value.substr(0,2):''));
            const router = useRouter();
            const route = useRoute();
            const dispmenu=ref(false);
            const route_name=ref(route.name);
            watch(() =>route.name, (current_val, previous_val) => {
                route_name.value=current_val;
                // emit('checkbox-clicked', current_val,props.id,props.name)
            });
            function logout(){
                showmenu();
                store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`,[true,'Logging out, please wait...']);

                axios.get('/logout', {

                })
                    .then(function (response) {
                        if(response.data.ok==1) {
                            sessionStorage.clear();
                           // router.push({
                            //    name:'Login',

                            //})
                            window.location="/";
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    }).finally(()=>{
                    store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
            }
            function selectedIcon(){
                console.log('item selected');
                console.log(isClicked.value);
                isClicked.value!=isClicked.value;
                console.log(isClicked.value);

            }
            function showmenu() {
                dispmenu.value=!dispmenu.value;
            }
            const slidesidebar=computed(()=>{
                return store.getters[`${SIDEBAR_MODULE}${SIDEBAR_GET_SLIDEIN}`];
            });

            function gotoPermissions(){
                router.push({
                    name:'Permissions',
                    params: {

                    },});
            }
            return {
                uname,
                initials,
                logout,
                showmenu,
                dispmenu,
                slidesidebar,

                gotoPermissions,
                route_name,
                router,

                selectedIcon,colorIcon,colorIconClicked,isClicked,colorIconDefault




            }
        }
    }
</script>

<style lang="scss" scoped>

.user_initials{
  z-index: 2;
  text-transform: uppercase;
  background-color:#868686;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  text-align: center;
  line-height: 40px;
  vertical-align: middle;
  font-size: 16px;
  margin: auto 0 16px 0;
  position: fixed;
  bottom:16px;
  color:#FFF;
  &:hover{
    background-color: #333;
    cursor:pointer;
  }
}
    .side-bar-wrap{
        width: 72px;
        transition: left ease-in-out 0.5s;
    }

.side-bar{
    background:#FBFBFB;
    box-shadow: inset 0px 0px 6px rgba(0, 0, 0, 0.25);
    width: 72px;
    height: 100%;
    z-index: 1;
}
.side-icons:first-child{
    margin-top:114px;

}
.side-icons{
    margin-bottom: 32px;
    cursor: pointer !important

}
    .usermenu{
        background: #FFFFFF;

        /* Drop shadow */
        box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.12);
        border-radius: 4px;
        min-width: 184px;
        position: fixed;
        left: 16px;
        bottom: 79px;
        z-index: 2;
       padding:45px 1rem 37px 1rem;
        transform-origin: left bottom;
    }
    .usermenu .btn{
        min-width: 154px;
        margin: 0 auto;
        display: block;

    }
    .usermenu-enter-from{
        opacity: 0;
        transform: scale(0.6);
    }
    .usermenu-enter-to{
        opacity: 1;
        transform: scale(1);
    }
    .usermenu-enter-active{
        transition: all ease 0.2s;
    }
    .usermenu-leave-from{
        opacity: 1;
        transform: scale(1);
    }
    .usermenu-leave-to{
        opacity: 0;
        transform: scale(0.6);
    }
    .usermenu-leave-active{
        transition: all ease 0.2s;
    }
</style>
