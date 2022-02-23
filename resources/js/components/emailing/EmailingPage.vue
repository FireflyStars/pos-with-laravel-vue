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
            <div class="ajustement py-5">
                <svg
                    width="38"
                    height="32"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="main-header-icon"
                >
                    <path
                        transform="translate(5,7)"
                        d="M2 2.5V0.993C2.00183 0.730378 2.1069 0.479017 2.29251 0.293218C2.47813 0.107418 2.72938 0.00209465 2.992 0H21.008C21.556 0 22 0.445 22 0.993V17.007C21.9982 17.2696 21.8931 17.521 21.7075 17.7068C21.5219 17.8926 21.2706 17.9979 21.008 18H2.992C2.72881 17.9997 2.4765 17.895 2.29049 17.7088C2.10448 17.5226 2 17.2702 2 17.007V16H20V4.3L12 11.5L2 2.5ZM0 7H5V9H0V7ZM0 12H8V14H0V12Z"
                        fill="black"
                    />
                </svg>
                <h3 class="color main-title">
                    <a @click="goToHome()">Emailing</a>
                </h3>
            </div>


                     <transition-group tag="div" class="row flex_wrap" name="list" appear>
                <div
                    class="card shadow-sm mb-4"
                    v-for="item in category"
                    :key="item.id"
                >
                    <router-link
                        :to="{
                            name: 'emailingprestations',
                            params: { id: item.id },
                        }"
                    >
                        <div
                            class="img_container"
                            v-on:click="getTemplates(item.id)"
                        >
                            <img
                                :src="`/storage/${item.url}`"
                                class="card-img-top body linear-gradient"
                            />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">
                                {{ item.name }}
                            </h5>
                            <div>
                                <p class="card-text">{{ item.text }}</p>
                            </div>
                        </div>
                    </router-link>
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

import useCompanies from "../../composables/companies";

export default {
    components: {

    },

    setup(props, context) {
        const showcontainer = ref(false);
        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true;
            });
        });
        const { my_ids, category, getCategory, getTemplates } = useCompanies();

        onMounted(getCategory);
        localStorage.clear();
        return {
            showcontainer,
            category,
            my_ids,
            getTemplates,
        };
    },
    methods: {
        getData() {
            axios.get("/getCampagneCategory").then((response) => {
                this.singleData = response.data.my_ids;
            });
        },
        goToHome() {
            this.$router.push("/emailing");
        },
    },
};
</script>

<style scoped>
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
    color: black;
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
    font-size: 10px;
    margin-top: 15px;
    text-align: center;
    line-height: 13.5px;
}
.card {
    width: 213px;
    padding: 0;
    margin: 7px;
    border: 1px solid rgb(0 0 0 / 34%);
    border-radius: 0;
}
.flex_wrap {
    display: flex;
    flex-wrap: wrap;
}
.card-body {
    padding: 12px 20px 15px;
    font-size: 15px;
}
.card-img-top.body {
    width: 100px;
    height: 166px;
    box-shadow: -46px 0px 23px -10px rgb(97 96 96 / 50%);
    object-fit: cover;
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
