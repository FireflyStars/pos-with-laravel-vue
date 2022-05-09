<template>
    <div class="row main-logo" >
        <div class="col-12 p-0">
            <img @click="slideinMenu"
                src="./../../images/logolcdt.png"
                alt="Lcdt logo"
                class="logo img-fluid"
            
            />
           <div>
               
                <search></search>  

                <base-button
                    prepend
                    @click="featureunavailable('Nouveau Rendez vous')"
                    class="btn btn-newrdv body_medium"
                    kind="warning"
                    title="Nouveau Rendez Vous"
                >
                    <icon name="user" color="white" />
                </base-button>

                <base-button
                    prepend
                    @click="featureunavailable('Nouveau Devis')"
                    class="btn btn-newrdv body_medium"
                    kind="warning"
                    title="Nouveau Devis"
                >
                    <icon name="clipboard" />
                </base-button>

           </div>
        </div>
    </div>
</template>

<script>

    import { useStore } from 'vuex'
    import { SIDEBAR_MODULE, SIDEBAR_SET_SLIDEIN, TOASTER_MESSAGE, TOASTER_MODULE } from "../../store/types/types";
    import Search from '../miscellaneous/Search.vue';

    import { useRouter } from 'vue-router'
    export default {
        name: "MainHeader",
        components: { Search },
        setup() {

            const store=useStore();
            const router=useRouter();
            const featureunavailable=((feature)=>{
                store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:feature+' feature not yet implemented.',ttl:5,type:'danger'});
            });

            const slideinMenu = ()=> {
                store.commit(`${SIDEBAR_MODULE}${SIDEBAR_SET_SLIDEIN}`);
            }

            const neworder=()=>{
                router.push({
                    name: 'NewOrder',
                    params: {

                    },
                })
            }
           return {
               neworder,
               slideinMenu,
               featureunavailable
           }
        }
    }
</script>

<style scoped>
    .main-logo {
        background-color:#070113;
        position: relative;
        width: 100%;
        z-index: 10;
        box-shadow: 0px 0px 4px rgba(80, 80, 80, 0.2);
    }
    .btn-newrdv {
        background: rgba(232, 88, 27, 0.7);
        margin-right:7px;
        margin-top: 9px;
        float: left;
        font-size: 12px;
        font-weight: 700;
        width: auto;
        color:#FFF;
        font-family: "Open Sans";
        height: 48px;
        border-radius: 10px;
    }
     .btn-devis{
        background: #E8581B;
        margin-right:22px;
        margin-top: 9px;
        float: left;
        font-size: 12px;
        font-weight: 700;
        width: auto;
        font-family: "Open Sans";
        color:#FFF;
        height: 48px;
        border-radius: 10px;
    }
    .col-12 {
        flex-direction: row;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .logo{
        cursor: pointer;
        height:64px;
    }
    button span{
        vertical-align: middle;
        margin-left: 8px;
    }
</style>