<template>
    <div class="row main-logo">
        <div class="col-12 p-0">
    <img  @click="slideinMenu"
            src="./../../images/lcdt-logo.png"
            alt="Lcdt logo"
            class="logo img-fluid"
        />
           <div>

             <search></search>  

             <button class="btn btn-newrdv body_medium" @click="featureunavailable('Nouveau Rendez vous')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="21" viewBox="0 0 16 21" fill="none">
<path d="M7 13.062V19H9V13.062C12.946 13.554 16 16.92 16 21H0C3.30739e-05 19.0514 0.711187 17.1698 2 15.7083C3.28882 14.2467 5.0667 13.3058 7 13.062ZM8 12C4.685 12 2 9.315 2 6C2 2.685 4.685 0 8 0C11.315 0 14 2.685 14 6C14 9.315 11.315 12 8 12Z" fill="white"/>
</svg>
                <span>Nouveau Rendez Vous</span>
            </button>

            <button class="btn btn-devis body_medium" @click="featureunavailable('Nouveau Devis')"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4 7.80985C4 7.05613 4 6.67926 4.10029 6.37461C4.29878 5.77169 4.77169 5.29878 5.37461 5.10029C5.67926 5 6.05613 5 6.80985 5C7.13404 5 7.29614 5 7.43364 5.04022C7.70521 5.11967 7.93042 5.31045 8.05343 5.56527C8.11571 5.69429 8.14236 5.85418 8.19566 6.17396L8.25 6.5C8.35527 7.13161 8.4079 7.44741 8.59795 7.66237C8.66164 7.73441 8.7354 7.79689 8.81694 7.84788C9.06021 8 9.38037 8 10.0207 8H13.9793C14.6196 8 14.9398 8 15.1831 7.84788C15.2646 7.79689 15.3384 7.73441 15.4021 7.66237C15.5921 7.44741 15.6447 7.13161 15.75 6.5L15.8043 6.17396C15.8576 5.85418 15.8843 5.69429 15.9466 5.56527C16.0696 5.31045 16.2948 5.11967 16.5664 5.04022C16.7039 5 16.866 5 17.1902 5C17.9439 5 18.3207 5 18.6254 5.10029C19.2283 5.29878 19.7012 5.77169 19.8997 6.37461C20 6.67926 20 7.05613 20 7.80985V17C20 18.8856 20 19.8284 19.4142 20.4142C18.8284 21 17.8856 21 16 21H8C6.11438 21 5.17157 21 4.58579 20.4142C4 19.8284 4 18.8856 4 17V7.80985Z" fill="#7E869E" fill-opacity="0.25"/>
<rect x="4" y="5" width="16" height="16" rx="2" stroke="white" stroke-width="1.2"/>
<path d="M16 2L16 6C16 6.94281 16 7.41421 15.7071 7.7071C15.4142 8 14.9428 8 14 8L10 8C9.05719 8 8.58579 8 8.29289 7.70711C8 7.41421 8 6.94281 8 6L8 2" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
<path d="M9 14L15 14" stroke="white" stroke-width="1.2" stroke-linecap="round"/>
</svg>

 <span>Nouveau Devis</span></button>
           </div>
        </div>
    </div>
</template>

<script>
    import {ref} from 'vue';
    import {useStore} from 'vuex'
    import {SIDEBAR_MODULE, SIDEBAR_SET_SLIDEIN, TOASTER_MESSAGE, TOASTER_MODULE} from "../../store/types/types";
    import Search from '../miscellaneous/Search.vue';

    import {useRouter} from 'vue-router'
    export default {
        name: "MainHeader",
        components: {Search}, 
        setup(props,context){
            const store=useStore();
            const router=useRouter();
           const featureunavailable=((feature)=>{
               store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:feature+' feature not yet implemented.',ttl:5,type:'danger'});
            });
            const slideinMenu=()=>{
                store.commit(`${SIDEBAR_MODULE}${SIDEBAR_SET_SLIDEIN}`);
            }

          
            const neworder=()=>{
                router.push({
                    name:'NewOrder',
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
.main-logo{
    background-color:#070113;
    position: fixed;
    width: 100%;
    z-index: 10;
    box-shadow: 0px 0px 4px rgba(80, 80, 80, 0.2);
}
    .btn-newrdv{
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
    .col-12{
    flex-direction: row;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    }


    .logo{
        cursor: pointer;
    }
    button span{
        vertical-align: middle;
        margin-left: 8px;
    }
</style>