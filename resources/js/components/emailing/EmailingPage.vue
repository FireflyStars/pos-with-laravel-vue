<template>

    <div class="container-fluid h-100 bg-color" >
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >

                    <side-bar />


                    <div class="col main-view container">
                            
                            <page-title icon="emailing" name="PLATEFORME MARKETING" class="almarai_extrabold_normal_normal"/>
                            
                            <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <div class="container" v-if="showcontainer">
         
                     <transition-group tag="div" class="row flex_wrap bg-panel p-4" name="list" appear>
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

                            <div class="voir-plus" v-on:click="getTemplates(item.id)">
                                    voir
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
    color: white !important;
    font-weight: bold;
}
.card-title:hover {
    color: orangered;
}
.card-text {
    font-size: 13px;
    margin-top: 29px;
    text-align: center;
    line-height: 13.5px;
    color: white;
}
.card {
    width: 236px;
    padding: 0;
    margin: 7px;
    border: none;
    border-radius: 0;
}
.flex_wrap {
    display: flex;
    flex-wrap: wrap;
}
.card-body {
    padding: 12px 20px 15px;
    font-size: 15px;
    background-color: #f26e26;
    min-height: 201px;
    width: 100%;
}
.card-img-top.body {
    width: 100%;
    height: 326px;
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
.voir-plus{

    text-align: center;
    background-color: black;
    color: white;
    width: 50%;
    align-self: center;
    margin-top: auto;
    margin-bottom: 10px;

}
.voir-plus:hover{
    background-color: #d22c2c;
    color: black;
}
</style>
