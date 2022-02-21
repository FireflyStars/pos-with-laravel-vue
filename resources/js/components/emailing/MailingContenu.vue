<template>
    <!--<side-bar></side-bar>
    <Main></Main>-->
    <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <div class="container">
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
                <div>
                    <h3 class="margin link">
                        <a @click="goToHome()">Emailing</a>
                    </h3>
                </div>
            </div>
            <div>
                <h3 class="margin-align">
                    Emailing > {{ my_name }} > Cible > Contenu
                </h3>
            </div>

            <div class="row flex_wrap">
                <div class="row flex_wrap col-lg-10">
                    <div class="card shadow-sm mb-4">
                        <div class="img_container">
                            <img
                                src="../../images/prestation.png"
                                class="card-img-top body linear-gradient"
                                alt=""
                            />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">
                                LETTRE D’ACCOMPAGNEMENT
                            </h5>
                            <div>
                                <p class="card-text" style="color: orangered">
                                    Personnalisable
                                </p>

                                <p class="card-text">
                                    Format A4 - Impression recto - 80g/m²
                                </p>
                                <p>
                                    <button
                                        class="button type"
                                        v-on:click="personnaliser('lettre')"
                                    >
                                        PERSONNALISER
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-4">
                        <div class="img_container">
                            <img
                                src="../../images/prestation.png"
                                class="card-img-top body linear-gradient"
                                alt=""
                            />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">
                                FLYER
                            </h5>
                            <div>
                                <p class="card-text" style="color: orangered">
                                    Personnalisable
                                </p>

                                <p class="card-text">
                                    Format A4 - Impression recto/verso - 180g/m²
                                </p>
                                <p>
                                    <button
                                        class="button type"
                                        v-on:click="personnaliser('flayer')"
                                    >
                                        PERSONNALISER
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-4">
                        <div class="img_container">
                            <img
                                src="../../images/prestation.png"
                                class="card-img-top body linear-gradient"
                                alt=""
                            />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">
                                DÉPLIANT
                            </h5>
                            <div>
                                <p class="card-text" style="color: orangered">
                                    Non Personnalisable
                                </p>

                                <p class="card-text">
                                    Format fermé A5 - Impression recto/verso - 3
                                    volets - 120g/m²
                                </p>
                                <p>
                                    <button
                                        class="button type"
                                        v-on:click="voir"
                                    >
                                        VOIR
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-4">
                        <div class="img_container">
                            <img
                                src="../../images/prestation.png"
                                class="card-img-top body linear-gradient"
                                alt=""
                            />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-uppercase card-title">
                                NVELOPPE PORTEUSE
                            </h5>
                            <div>
                                <p class="card-text" style="color: orangered">
                                    Non Personnalisable
                                </p>

                                <p class="card-text">
                                    Format 162x229 - Impression recto - 3 volets
                                    - 80g/m²
                                </p>
                                <p>
                                    <button
                                        class="button type"
                                        v-on:click="voir"
                                    >
                                        VOIR
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h5 class="paragraph">
                        OUTRE CES ÉLÉMENTS, VOTRE CAMPAGNE MAILING POSTAL
                        COMPREND :
                    </h5>
                    <p class="p-text">
                        L’impression et le façonnage La mise sous pli
                        L’affranchissement Le dépôt Poste
                    </p>
                </div>
            </div>
        </div>
    </transition>
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
        cible_id: {
            type: Number,
        },
        type: {
            type: String,
        },
        show: {
            type: String,
        },
    },
    setup() {
        const my_name = localStorage.getItem("category");

        const {
            courrier,
            courrier_lettre,
            courrier_autre,
            check_name,
            getCourrier,
        } = useCompanies();

        // onMounted(getCourrier);
        onMounted(() => {
            //     let response = axios.get("/getCourrier").then(function (response) {
            //         console.log(response);
            //         courrier.value = response.data.data;
            //         courrier_autre.value = response.data.data2;
            //         courrier_lettre.value = response.data.data1;
            //         console.log("courrier", courrier);
            //         console.log("courrier_autre", courrier_autre);
            //         console.log("courrier_lettre", courrier_lettre);
            //         for (let i = 0; i < courrier.value.length; i++) {
            //             check_name.value.push(response.data.data[i].name);
            //             // console.log(check_name.value.push(response.data.data[i].name));
            //         }
            //     });
        });

        return {
            check_name,
            courrier,
            courrier_lettre,
            courrier_autre,
            my_name,
        };
    },
    methods: {
        // getData() {
        //     axios.get("/getCourrier").then((response) => {
        //         this.singleData = response.data.data;
        //         console.log(this.singleData);
        //     });
        // },
        voir() {
            this.$router.push({
                name: "envoi",
                params: {
                    cible_id: `${this.$route.params.cible_id}`,
                    type: this.$route.params.type,
                },
            });
        },
        personnaliser(e) {
            console.log(e);
            this.$router.push({
                name: "mailingInterface",
                params: {
                    cible_id: `${this.$route.params.cible_id}`,
                    type: this.$route.params.type,
                    show: e,
                },
            });
        },
        goToHome() {
            this.$router.push("/emailing");
        },
    },
};
</script>

<style scoped>
.margin-align {
    margin-bottom: 40px;
    margin-top: -34px;
    font-size: 17px;
    font-weight: bold;
}
.margin-ajustement {
    margin-top: 39px;
}
.ajustement {
    display: flex;
}

.paragraph {
    padding: 0px;
    font-size: 12px;
    text-align: center;
    padding-right: 8px;
    line-height: 1.3;
    text-transform: uppercase;
    margin-top: 101px;
}
.p-text {
    padding: 0px;
    font-size: 11.6px;
    text-align: center;
    padding-right: 8px;
    line-height: 1.3;
    text-transform: uppercase;
    margin-top: 45px;
    color: orangered;
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
    font-size: 13px;
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
}
.img_container {
    text-align: center;
    background: #e6e6e6;
}
.card a {
    color: inherit;
    text-decoration: none;
}
.button {
    background-color: white;
    border: 1px solid #ff4500;
    color: orangered;
    cursor: pointer;
    width: 117px;
    height: 100%;
    margin-left: 28px;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.link {
    cursor: pointer;
    text-decoration: none;
}
.link:hover {
    color: orangered;
}
</style>
