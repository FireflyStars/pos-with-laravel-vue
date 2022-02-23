<template>


        <div class="container-fluid h-100 bg-color" >
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >

                    <side-bar />

                    <div class="col main-view container">
                        <page-title icon="emailing" name="EMAILING" class="almarai_extrabold_normal_normal"/>
                          <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <form class="space-y-6" v-on:submit.prevent="saveCompany" v-if="showcontainer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
             
                        <h3 class="margin">
                            <a @click="goToHome()" class="link">Emailing</a> >
                            <a @click="goToPrestation()" class="link">{{
                                my_name
                            }}</a>
                            > Cible > Contenu
                        </h3>

                        <div class="bg-panel p-4">
                            <div class="row ">
                                <div class="col-lg-12 group_input">
                                    <label class="fix_width" for="expediteur"
                                        >EXPÉDITEUR :
                                    </label>
                                    <input
                                        type="text"
                                        id=""
                                        value="La Compagnie des Toits - Seine-et-Marne"
                                    />

                                    <label class="fix_width_tiret">-</label>
                                    <input
                                        type="text"
                                        v-model="emailFrom"
                                        @keyup.prevent="submit"
                                        name="emailFrom"
                                        id="emailFrom"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width"
                                        >RÉPONDRE À :
                                    </label>
                                    <input
                                        type="text"
                                        id=""
                                        value="La Compagnie des Toits - Seine-et-Marne"
                                    />
                                    <label class="fix_width_tiret">-</label>

                                    <input
                                        type="text"
                                        v-model="emailReplyTo"
                                        @keyup.prevent="submit"
                                        name="emailReplyTo"
                                        id="emailReplyTo"
                                    />
                                </div>

                                <div class="col-lg-12 group_input">
                                    <label class="fix_width">OBJET : </label>
                                    <input
                                        type="text"
                                        v-model="subject"
                                        @keyup.prevent="submit"
                                        name="subject"
                                        id="subject"
                                    />

                                    <span>36/50 caractères</span>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="column col-6">
                                    <div class="group_input text_data">
                                        <label class="fix_width"
                                            >AGENCE :</label
                                        >
                                        <input
                                            type="text"
                                            v-model="input_agence"
                                            @keyup.prevent="submit"
                                            name="agence"
                                        />
                                    </div>

                                    <div class="group_input"></div>
                                </div>

                                <div class="column col-6 state">
                                    <div class="group_input text_data">
                                        <label class="fix_width_column"
                                            >TEL :</label
                                        >
                                        <input
                                            type="text"
                                            id="inputPassword"
                                            v-model="input_phone"
                                            @keyup.prevent="submit"
                                            name="phone"
                                        />
                                    </div>

                                    <div class="group_input text_data pt-2">
                                        <label class="fix_width_column"
                                            >E-MAIL :</label
                                        >
                                        <input
                                            type="text"
                                            v-model="input_email"
                                            @keyup.prevent="submit"
                                            name="email"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-lg-5 apercu d-table "
                        style="margin-top: 50px"
                    >
                        <h6>APERÇU</h6>
                        <div style="position: relative; " class="bg-panel" >
                        <img
                            :src="`/storage/${vaal}`" />

                        <span
                            class="position"
                            :style="
                                'left: ' +
                                dataimage1.xfield1 +
                                'px; top: ' +
                                dataimage1.yfield1 +
                                'px; color: ' +
                                dataimage1.color1 +
                                ';'
                            "
                            id="input_agence"
                        >
                            {{ input_agence }}
                        </span>
                        <span
                            class="position"
                            :style="
                                'left: ' +
                                dataimage2.xfield2 +
                                'px; top: ' +
                                dataimage2.yfield2 +
                                'px; color: ' +
                                dataimage2.color2 +
                                ';'
                            "
                            id="input_email"
                        >
                            {{ input_email }}
                        </span>
                        <span
                            class="position"
                            :style="
                                'left: ' +
                                dataimage3.xfield3 +
                                'px; top: ' +
                                dataimage3.yfield3 +
                                'px; color: ' +
                                dataimage3.color3 +
                                ';'
                            "
                            id="input_phone"
                        >
                            {{ input_phone }}
                        </span>
                        </div>
                    </div>
                </div>
                <div class="row rigth">
                    <button
                        class="button-valider type"
                        type="submit"
                        v-on:click="validate"
                    >
                        VALIDER
                    </button>
                </div>
            </div>
        </form>
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
import { useRouter, RouterView, useRoute } from "vue-router";
import EmailingAudit from "../templates/EmailingAudit";
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
        EmailingAudit,
    },
    mounted() {
        if (localStorage.email) {
            this.email = localStorage.email;
        }
        if (localStorage.phone) {
            this.phone = localStorage.phone;
        }
    },

    // data: () => ({
    //     pdfsrc: "../../images/EmailingAudit.pdf",
    // }),
    props: {
        cible_id: {
            type: Number,
        },
        type: {
            type: String,
            default() {
                return "";
            },
        },
    },
    // props: ["email", "phone", "agence"],
    data: function () {
        return {
            company: "",
        };
    },
    setup(props) {
        const store = useStore();

        const my_name = localStorage.getItem("category");
        const input_agence = ref("Seine-et-Marne");
        const input_email = ref("contact77@lacompagniedestoits.com");
        const input_phone = ref("01 60 04 70");
        const emailFrom = ref("contact77@lacompagniedestoits.com");
        const emailReplyTo = ref("contact77@lacompagniedestoits.com");
        const subject = ref("Pourquoi réaliser des audits de toiture ?");
        const idtemplate = localStorage.getItem("imagetemplate");

        localStorage.setItem("storedName", input_agence.value);
        localStorage.setItem("storedEmail", input_email.value);
        localStorage.setItem("storedPhone", input_phone.value);
        localStorage.setItem("emailFrom", emailFrom.value);
        localStorage.setItem("emailReplyTo", emailReplyTo.value);
        localStorage.setItem("subject", subject.value);
        localStorage.setItem("emailReplyTo", emailReplyTo.value);

        const {
            errors,
            company,
            contentform,
            getImgUrl,
            vaal,
            getimagefield,
            dataimage1,
            dataimage2,
            dataimage3,
        } = useCompanies();

        const route = useRoute();
        onMounted(getImgUrl(), getimagefield());

        function saveCompany(e) {
            console.log(company.value);
            axios.put("/contentform/" + route.params.cible_id, company.value);
            console.log("read");
        }
        function submit(e) {
            if (e.target.name == "agence") {
                input_agence.value = e.target.value;
                localStorage.setItem("storedName", input_agence.value);
                console.log("input_agence.value", input_agence.value);
            } else if (e.target.name == "email") {
                input_email.value = e.target.value;
                localStorage.setItem("storedEmail", input_email.value);
                console.log("input_email.value", input_email.value);
            } else if (e.target.name == "phone") {
                input_phone.value = e.target.value;
                localStorage.setItem("storedPhone", input_phone.value);
                console.log("input_phone.value", input_phone.value);
            } else if (e.target.name == "emailFrom") {
                emailFrom.value = e.target.value;
                localStorage.setItem("emailFrom", emailFrom.value);
                console.log("emailFrom.value", emailFrom.value);
            } else if (e.target.name == "emailReplyTo") {
                emailReplyTo.value = e.target.value;
                localStorage.setItem("emailReplyTo", emailReplyTo.value);
                console.log("input_phone.value", input_phone.value);
            } else if (e.target.name == "subject") {
                subject.value = e.target.value;
                localStorage.setItem("subject", subject.value);
                console.log("subject.value", subject.value);
            }
        }

        const showcontainer = ref(false);
        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true;
            });
        });

        return {
            showcontainer,
            errors,
            company,
            saveCompany,
            submit,
            input_agence,
            input_email,
            input_phone,
            my_name,
            subject,
            emailReplyTo,
            emailFrom,
            idtemplate,
            getImgUrl,
            vaal,
            dataimage1,
            dataimage2,
            dataimage3,
        };
    },

    methods: {
        validate() {
            //
            this.$router.push({
                name: "envoi",
                params: {
                    cible_id: `${this.$route.params.cible_id}`,
                    type: this.$route.params.type,
                },
            });
        },
        goToHome() {
            this.$router.push("/emailing");
        },

        goToPrestation() {
            let id_category = localStorage.getItem("id_category");
            this.$router.push({
                name: "emailingprestations",
                params: {
                    id: `${id_category}`,
                },
            });
        },
    },
};
</script>

<style scoped>
.position {
    position: absolute;
    font-size: 14px;
    font-weight: 600;
}

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
.text_data {
    display: flex;
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
label.fix_width_column {
    width: 65px;
    text-align: end;
    font-size: 11px;
    font-weight: 700;
    padding-right: 5px;
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
.apercu {
    height: 600px;
    overflow: overlay;
    width: 465px;
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
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.rigth {
    float: right;
    padding: 40px 40px 0 0;
    margin-bottom: 20px;
}
@media only screen and (min-width: 1400px) {
    .state {
        margin-left: -55px;
    }
    .text_data {
        display: block;
    }
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
