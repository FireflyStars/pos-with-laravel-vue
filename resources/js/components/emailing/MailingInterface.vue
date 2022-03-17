<template>

    <div class="container-fluid h-100 bg-color">
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >

                    <side-bar />

                    <div class="col main-view container">
                        <page-title icon="emailing" name="EMAILING" class="almarai_extrabold_normal_normal"/>
                            <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <form class="space-y-6" v-if="show === 'lettre'" >
            <div class="container">
             
                <div class="row">
                    <div class="col-lg-7">
                        <h3 class="margin-align">
                            <a @click="goToHome()" class="link">Emailing</a> >
                            {{ my_name }} > Cible > Contenu > Lettre
                            Accompagnement
                        </h3>
                        <div class="bg-panel p-4">
                            <div class="row">
                                <div class="col-lg-12 group_input">
                                    <label class="fix_width" for="expediteur"
                                        >EXPÉDITEUR :
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="La Compagnie des Toits"
                                        v-model="input_expediteur"
                                        @keyup.prevent="submit"
                                        name="expediteur"
                                    />

                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        id="inputPassword"
                                        v-model="input_expediteur2"
                                        @keyup.prevent="submit"
                                        name="expediteur2"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width">ADRESSE : </label>
                                    <input
                                        type="text"
                                        placeholder="1 Rue Jean-Baptiste Colbert"
                                        v-model="input_adresse"
                                        @keyup.prevent="submit"
                                        name="adresse"
                                    />

                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        id="inputPassword"
                                        v-model="input_adresse2"
                                        @keyup.prevent="submit"
                                        name="adresse2"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width">COORD : </label>
                                    <input
                                        type="text"
                                        placeholder="01 60 65 04 70"
                                        v-model="input_coord"
                                        @keyup.prevent="submit"
                                        name="coord"
                                    />
                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        id="inputPassword"
                                        v-model="input_email"
                                        @keyup.prevent="submit"
                                        name="email"
                                    />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <label class="fix_width">MESSAGE : </label>

                                <quill-editor
                                    class="form-control rounded-0"
                                    id="exampleFormControlTextarea1"
                                    rows="10"
                                    v-if="state.showEditor"
                                    v-model:value="state.content"
                                    @keyup.prevent="submit"
                                    name="lettre"
                                    :options="state.editorOption"
                                    :disabled="state.disabled"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 apercu" style="margin-top: 26px">
                        <div class="bg-panel p-4" >
                        <h6>APERÇU</h6>
                        <div ref="document">
                            <LettreAccompagnement
                                :expediteur="input_expediteur"
                                :adresse="input_adresse"
                                :coord="input_coord"
                                :expediteur2="input_expediteur2"
                                :adresse2="input_adresse2"
                                :email="input_email"
                                :content="input_content"
                            ></LettreAccompagnement>
                        </div>
                        </div>
                        <button
                            class="button-valider type"
                            @click="exportToPDF()"
                        >
                            VALIDER
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form v-else>
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
                    <h3 class="margin">Emailing</h3>
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <h3 class="margin-align">
                            <a @click="goToHome()" class="link">Emailing</a> >
                            Cible > Contenu > Flyer
                        </h3>
                        <div class="bg-panel p-4">
                            <div class="row">
                                <div class="col-lg-12 group_input">
                                    <label class="fix_width" for="expediteur"
                                        >CONTACT :
                                    </label>
                                    <input
                                        type="text"
                                        v-model="input_flyer_contact"
                                        @keyup.prevent="submitFlyer"
                                        name="contact"
                                    />

                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        id="inputPassword"
                                        v-model="input_flyer_contact2"
                                        @keyup.prevent="submitFlyer"
                                        name="contact2"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width">AGENCE : </label>
                                    <input
                                        type="text"
                                        v-model="input_flyer_agence"
                                        @keyup.prevent="submitFlyer"
                                        name="agence"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width">COORD : </label>
                                    <input
                                        type="text"
                                        v-model="input_flyer_coord"
                                        @keyup.prevent="submitFlyer"
                                        name="coord"
                                    />
                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        id="inputPassword"
                                        value="Pierre-Xavier BASSI"
                                    />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <p class="p-title">APERÇU RECTO</p>
                                <p class="p-subtitle">(Non personnalisable)</p>
                                <div class="col text-center">
                                    <button class="button type type-click">
                                        VOIR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 apercu" style="margin-top: 26px">
                        <div class="bg-panel p-4">
                        <h6>APERÇU</h6>
                        <div>
                            <TemplateFlyer
                                :contact="input_flyer_contact"
                                :contact2="input_flyer_contact2"
                                :agence="input_flyer_agence"
                                :coord="input_flyer_coord"
                                :email="input_flyer_email"
                            >
                            </TemplateFlyer>
                        </div>
                        <button
                            class="button-valider type"
                            type="submit"
                            v-on:click="validate"
                        >
                            VALIDER
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
         </transition>
                    </div>
                </div>
                </div>

</template>

<script>
import { ref, onMounted, nextTick, reactive, watch } from "vue";
import LettreAccompagnement from "../templates/LettreAccompagnement";
import SideBar from "../layout/SideBar";
import Main from "../Main.vue";
import TemplateFlyer from "../templates/TemplateFlyer";

import useCompanies from "../../composables/companies";
import quillEditor from "../miscellaneous/editor.vue";
import html2pdf from "html2pdf.js";
import axios from "axios";

import { useRouter, RouterView, useRoute } from "vue-router";
import { useStore } from "vuex";
import {
    DISPLAY_LOADER,
    HIDE_LOADER,
    LOADER_MODULE,
    TOASTER_GET_ALL,
    TOASTER_MESSAGE,
    TOASTER_MODULE,
    TOASTER_REMOVE_TOAST,
} from "../../store/types/types";

export default {
    components: {
        Main,
        SideBar,
        LettreAccompagnement,
        quillEditor,
        TemplateFlyer,
    },
    props: {
        id: {
            required: true,
            type: String,
        },
        show: {
            type: Boolean,
            default: false,
        },
    },
    data: () => ({
        pdfsrc: "../../images/EmailingAudit.pdf",
    }),

    setup(props) {
        const my_name = localStorage.getItem("category");

        const input_expediteur = ref("La Compagnie des Toits");
        const input_adresse = ref("1 Rue Jean-Baptiste Colbert");
        const input_coord = ref("01 60 65 04 70");
        const input_expediteur2 = ref("Agence Seine-et-Marne");
        const input_adresse2 = ref("77350 Le Mée-sur-Seine");
        const input_email = ref("contact77@lacompagniedestoits.com");
        const input_content = ref("");
        const input_flyer_contact = ref("Pierre-Xavier BASSI");
        const input_flyer_contact2 = ref("Dirigeant");
        const input_flyer_agence = ref("Seine-et-Marne");
        const input_flyer_coord = ref("06 37 44 27 81");
        const input_flyer_email = ref("pxbassi@lacompagniedestoits.com");
        const store = useStore();

        const { type, router, errors, company, contentform } = useCompanies();
        const route = useRoute();

        let show = route.params.show;
        const showcontainer = ref(false);
        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true;
            });
        });
        onMounted(() => {
            const id = localStorage.getItem("id_category");

            axios
                .get("/lettredata/" + localStorage.getItem("id_category"))
                .then((res) => {
                    input_content.value = res.data.content;
                         console.log(input_content.value);
                         state.content=input_content.value;
                });
        });
   
        const state = reactive({
            curTheme: "snow",
            showEditor: true,
            content: input_content.value,
            editorOption: {
                placeholder: "Insérer le contenu ici...",
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline"],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [
                            { align: "" },
                            { align: "center" },
                            { align: "right" },
                        ],
                    ],
                },
            },
            disabled: false,
        });

        watch(
            () => state.content,
            (current_val, previous_val) => {
                input_content.value = current_val;
            }
        );
        function submitFlyer(e) {
            if (e.target.name == "contact") {
                input_flyer_contact.value = e.target.value;
            } else if (e.target.name == "contact2") {
                input_flyer_contact2.value = e.target.value;
            } else if (e.target.name == "agence") {
                input_flyer_agence.value = e.target.value;
            } else if (e.target.name == "coord") {
                input_flyer_coord.value = e.target.value;
            } else if (e.target.name == "email") {
                input_flyer_email.value = e.target.value;
            }
        }

        function submit(e) {
            if (e.target.name == "expediteur") {
                input_expediteur.value = e.target.value;
            } else if (e.target.name == "adresse") {
                input_adresse.value = e.target.value;
            } else if (e.target.name == "coord") {
                input_coord.value = e.target.value;
            } else if (e.target.name == "adresse2") {
                input_adresse2.value = e.target.value;
            } else if (e.target.name == "expediteur2") {
                input_expediteur2.value = e.target.value;
            } else if (e.target.name == "email") {
                input_email.value = e.target.value;
            }
        }
        function exportToPDF() {
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            const timestamp = Date.now();
            const filename = "Lcdt-" + timestamp + ".pdf";

            setTimeout(() => {
                var opt = {
                    margin: 1,
                    filename: filename,
                    image: { type: "jpeg", quality: 1 },
                    html2canvas: { dpi: 79, scale: 2 },
                    jsPDF: {
                        unit: "in",
                        format: "a4",
                        orientation: "portrait",
                    },
                };
                let company_Id = route.params.cible_id;
                let test = this;
                let self = this;
                axios
                    .post("/downloadPdf", {
                        expediteur: input_expediteur.value,

                        address: input_adresse.value,
                        coord: input_coord.value,
                        expediteur2: input_expediteur2.value,
                        address2: input_adresse2.value,
                        email: input_email.value,
                        html: input_content.value,

                        fileName: filename,
                    })
                    .then((response) => {
                        axios
                            .get("/exportCsv/" + company_Id)
                            .then((response) => {
                                let url_csv =
                                    "http://127.0.0.1:8000/uploads/" +
                                    response.headers.file;
                                localStorage.setItem(
                                    "url_csv",
                                    response.headers.file
                                );
                                localStorage.setItem("url_pdf", filename);
                                router.push({
                                    name: "envoi",
                                    params: {
                                        cible_id: `${route.params.cible_id}`,
                                        type: route.params.type,
                                    },
                                });
                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .finally(() => {
                                store.dispatch(
                                    `${LOADER_MODULE}${HIDE_LOADER}`
                                );
                            });
                    });
            }, 3000);
        }

        function validate() {
            router.push({
                name: "envoi",
                params: {
                    cible_id: `${route.params.cible_id}`,
                    type: route.params.type,
                },
            });
            return router;
        }
        return {
            errors,
            company,

            type,
            show,
            submit,
            router,
            input_expediteur,
            input_adresse,
            input_coord,
            input_expediteur2,
            input_adresse2,
            input_email,
            input_content,
            state,

            exportToPDF,
            input_flyer_contact,
            input_flyer_contact2,
            input_flyer_agence,
            input_flyer_coord,
            input_flyer_email,
            my_name,
            validate
        };
    },
    methods: {
        getPDFPath() {
            return axios
                .get(
                    "../../images/EmailingAudit.pdf#toolbar=0&navpanes=0&scrollbar=0",
                    {
                        responseType: "blob",
                    }
                )
                .then((response) => {
                    const blob = new Blob([response.data]);
                    const objectUrl = URL.createObjectURL(blob);
                    this.pdfsrc = objectUrl;
                })
                .catch(console.error); //
        },
        created() {
            this.getPDFPath();
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

.p-subtitle {
    text-align: center;
    font-size: 11px;
    font-weight: 700;
    color: orangered;
}
.p-title {
    text-align: center;
    font-size: 11px;
    font-weight: 700;
}
.button {
    background-color: white;
    border: none;
    color: orangered;
    cursor: pointer;
    width: 117px;
    height: 100%;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.type-click {
    border: orangered 1px solid;
}
.container {
    padding-bottom: 100px;
}
img.card-img-top {
    height: 100%;
}

div.group_input {
    justify-content: space-between;
}
div.group_input input {
    width: 246px;
    background-color: #d3d3d3;
    border: none;
    height: 27px;
    font-size: small;
}
div.group_input {
    margin: 7px 0;
    align-items: center;
}
label.fix_width {
    width: 100px;
    font-size: 11px;
    font-weight: 700;
}
div.group_input span {
    margin-left: 15px;
    font-size: 10px;
}
label.fix_width_tiret {
    width: 45px;
    text-align: center;
    font-size: 11px;
    font-weight: 700;
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
}
.card-text {
    font-size: x-small;
    margin-top: 18%;
    text-align: center;
}
.card {
    width: 12rem;
}
.body {
    width: 100%;
    height: 100%;
}
hr {
    margin: 40px 0px;
}
.col-lg-7 {
 
}
.apercu h6 {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
}
.last label {
    margin-right: 10px;
    margin-left: 15px;
}
.button-valider {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 125px;
    height: 27px;
    float: right;
    margin: 40px 40px 0px 0;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.link {
    cursor: pointer;
    text-decoration: none;
    color:orange;
}
.link:hover {
    color: orangered;
}
</style>
