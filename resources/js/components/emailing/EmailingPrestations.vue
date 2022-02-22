<template>

  
    <div class="container-fluid h-100 bg-color" >
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
                    
                    <side-bar />

                    <div class="col main-view container">
                          <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <div class="container" v-if="showcontainer">
            <div class="ajustement">
                <svg
                    width="38"
                    height="32"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="margin-ajustement"
                >
                    <path
                        transform="translate(5,7)"
                        d="M2 2.5V0.993C2.00183 0.730378 2.1069 0.479017 2.29251 0.293218C2.47813 0.107418 2.72938 0.00209465 2.992 0H21.008C21.556 0 22 0.445 22 0.993V17.007C21.9982 17.2696 21.8931 17.521 21.7075 17.7068C21.5219 17.8926 21.2706 17.9979 21.008 18H2.992C2.72881 17.9997 2.4765 17.895 2.29049 17.7088C2.10448 17.5226 2 17.2702 2 17.007V16H20V4.3L12 11.5L2 2.5ZM0 7H5V9H0V7ZM0 12H8V14H0V12Z"
                        fill="black"
                    />
                </svg>
                <h3 class="margin-email">Emailing</h3>
        
            </div>

            <div v-if="myvar == true">
                <h3 class="margin" v-for="data in campagnedata" :key="data.id">
                    <a @click="goToHome()" class="link">Emailing </a> >
                    {{ data.name }}
                </h3>
            </div>
            <div v-if="myvar2 == true && myvar == false">
                <h3 class="color margin" v-for="item in title" :key="item.id">
                    <a @click="goToHome()" class="link">Emailing</a> >
                    {{ item.name }}
                </h3>
            </div>

                    <transition-group tag="div" class="row flex_wrap" name="list" appear>
                <div
                    class="card shadow-sm mb-4"
                    v-for="item in template"
                    :key="item.id"
                >
                    <div class="img_container" @click="SubCategory(item.id)">
                        <img
                            :src="`/storage/${item.url}`"
                            class="card-img-top body linear-gradient"
                        />
                    </div>
                    <div
                        class="card-body d-flex flex-column"
                        @click="SubCategory(item.id)"
                    >
                        <h5 class="card-title text-uppercase card-title">
                            {{ item.name }}
                        </h5>
                    </div>
                </div>
                </transition-group>
        </div>
            </transition>
                    </div>
                </div>
    </div>

</template>

<script>
import { ref, onMounted, nextTick } from "vue";
import SideBar from "../layout/SideBar";
import Main from "../Main.vue";
import useCompanies from "../../composables/companies";

export default {
    components: {
        Main,
        SideBar,
    },
    props: {
        id: {
            // This is the param that we are putting in our url
            type: Number,
            default() {
                return 0;
            },
        },
        idc: {
            type: Number,
            default() {
                return 0;
            },
        },
    },
    setup(props, context) {
        const showcontainer = ref(false);
        onMounted(() => {
            nextTick(() => {
            
                showcontainer.value = true;
            });
        });
        const {
            myvar,
            myvar2,
            mytitle,
            template,
            campagnedata,
            title,
            subdata,
            mylist,
            getTemplates,
            SubCategory,
        } = useCompanies();

        onMounted(getTemplates(props.id));
        // onMounted(SubCategory(props.id));

        return {
            showcontainer,
            template,
            campagnedata,
            SubCategory,
            subdata,
            mylist,
            myvar,
            title,
            mytitle,
            myvar2,
        };
    },
    methods: {
        goToHome() {
            this.$router.push("/emailing");
        },
    },
};
</script>

<style scoped>
.margin-email {
    margin-top: 50px;
}
.margin-ajustement {
    margin-top: 53px;
}
.ajustement {
    display: flex;
}

.container {
    padding-bottom: 100px;
}
.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 35px;
    font-size: 17px;
    font-weight: bold;
}
.card-title {
    text-align: center;
    font-size: unset;
    font-family: revert;
    cursor: pointer;
}
.card-title:hover {
    color: orangered;
}
.card-text {
    font-size: x-small;
    margin-top: 18%;
    text-align: center;
}
.card {
    width: 210px;
    padding: 0;
    margin: 9px;
    border: 1px solid rgb(0 0 0 / 34%);
    border-radius: 0;
}
.flex_wrap {
    display: flex;
    flex-wrap: wrap;
}
.card-body {
    padding: 12px 20px 0px;
    font-size: 15px;
}
.card-img-top.body {
    width: 100px;
    height: 166px;
    box-shadow: -46px 0px 23px -10px rgb(97 96 96 / 50%);
}
.img_container {
    text-align: center;
    background: #e6e6e6;
}
.card a {
    color: inherit;
    text-decoration: none;
}
.link {
    cursor: pointer;
    text-decoration: none;
}
.link:hover {
    color: orangered;
}
</style>
