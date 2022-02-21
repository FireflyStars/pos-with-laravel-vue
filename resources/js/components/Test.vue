<template>
<side-bar></side-bar>
    <Main></Main>
    <transition   enter-active-class="animate__animated animate__fadeIn"
                                      leave-active-class="animate__animated animate__fadeOut">
        <div class="container">
            <h3 class="color margin">E-MAILING</h3>
        
 
                           
                        

            <div class="row flex_wrap">
                    <div class="card shadow-sm mb-4" v-for="item in category" :key="item.id">
                   <router-link :to="{ name: 'category', params: { id: item.id } }">    
                        <div>  <img src="../images/login.jpg" class="card-img-top body linear-gradient" alt=""></div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">{{item.name}}</h5>
                            <p class="text-muted card-text">{{item.text}}</p>
                            
                        </div>
            </router-link>

                    </div> 
            </div>
        </div>
    </transition>
</template>

<script>
    import {ref,onMounted,nextTick} from 'vue';
    import  SideBar from './layout/SideBar'
    import Main from './Main.vue';
    import useCompanies from "../composables/companies";

    export default {
        components: {
            Main,
            SideBar,
        },

        setup(props,context){
            const showimg=ref(false);
            onMounted(()=>{
                 nextTick(()=>{
                    console.log('mounted');
                    showimg.value=true;
                });

            })
            const {category, getCategory } = useCompanies()
          onMounted(getCategory)
          console.log('data', category);
            
            
            ;

            return {
                showimg,
                category
            }
        }
    }

</script>

<style scoped>
.color {
    color: orangered;
}
.margin {
    margin-bottom: 100px;
    margin-top: 35px;
}
.card-title {
    text-align: center;
    font-size: unset;
    font-family: revert;

}
.card-text{
    font-size: x-small;
    margin-top: 18%;
    text-align: center;
}
.card 
{
    width: 192px;
    padding: 0;
    margin: 1.5%;
    border : 1px dashed rgb(0 0 0 / 34%);
}
.flex_wrap{
    display:flex;
    flex-wrap:wrap;
}
.body 
{
    width: 100%;
    height: 10vw;
    border-right: 13mm inset;
    border-left: 13mm inset;
}

</style>
