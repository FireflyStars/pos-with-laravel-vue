<template>
   <!-- <SideBar />
    <Main />-->

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
            <h3 class="margin link"><a @click="goToHome()">Emailing</a></h3>
        </div>
        <div class="col-lg-12">
            <h3 class="margin-align">
                <a @click="goToHome()" class="link">Emailing</a> >
                <a @click="goToPrestation()" class="link">{{ my_name }}</a> >
                Cible > <a @click="goToContent()" class="link"> Contenu</a> >
                Envoi
            </h3>
        </div>

        <div class="row">
            <div class="col-lg-4" v-if="type != 'COURRIER'">
                <h5 class="color bold">TEST</h5>
                <p class="">Testez votre campagne avant envoi.</p>
                <div class="bloc-input">
                    <input
                        placeholder="E-mail de test"
                        type="email"
                        class="input-text"
                        id="listItem"
                        pattern=".+@globex\.com"
                        size="30"
                        v-model="todoText"
                    />
                    <i class="bi bi-plus plus-but" v-on:click="addTodo()"></i>
                </div>
                <div>
                    <p class="l-size">CARNET D’ADRESSES :</p>
                </div>
                <div class="">
                    <form>
                        <div class="test_mail mrg_btm" v-for="todo in todos">
                            <span class="close x-btn" v-on:click="remove(todo)"
                                >&#x2718;</span
                            >
                            <input
                                type="checkbox"
                                class="radio"
                                :name="todo.text"
                                @change="selectValue($event)"
                            />
                            <span>{{ todo.text }}</span>
                        </div>

                        <button
                            type="button"
                            class="button-tester type"
                            @click="send()"
                        >
                            TESTER
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-1" v-if="type == 'COURRIER'"></div>
            <div
                class="col-lg-4"
                v-if="type == 'COURRIER'"
                style="padding-right: 30px"
            >
                <h5 class="color bold">ENVOI IMMÉDIAT</h5>
                <p class="">Envoyez votre campagne immédiatement.</p>
                <div class="time_envoi_courrier">
                    <p style="">Réception du mailing estimé au</p>
                    <p style="">{{ currentDate() }}</p>
                </div>
                <div class="bloc_count" style="margin-top: 78px">
                    <p>
                        <strong class="font">{{ count_cible }}</strong>
                        <span class="emphasized size-mail"> courriers</span>
                    </p>
                    <p class="color">
                        <strong class="font">210</strong>
                        <span class="emphasized size-mail"> euros HT</span>
                    </p>
                </div>
                <button class="button-envoyer type" @click="sendLettre()">
                    ENVOYER
                </button>
            </div>
            <div
                class="col-lg-1 border_hr_empty"
                v-if="type == 'COURRIER'"
            ></div>
            <div class="col-lg-4 border_hr" v-if="type != 'COURRIER'">
                <h5 class="color bold">ENVOI IMMÉDIAT</h5>
                <p class="">Envoyez votre campagne immédiatement.</p>
                <div class="time_envoi">
                    <span style="">{{ currentDate() }}</span>
                    <span style="">{{ currentTime() }}</span>
                </div>
                <div class="bloc_count">
                    <p>
                        <strong class="font">{{ count_cible }}</strong>
                        <span class="emphasized size-mail"> e-mails</span>
                    </p>
                    <p class="color">
                        <strong class="font">7,50</strong>
                        <span class="emphasized size-mail"> euros HT</span>
                    </p>
                </div>
                <button class="button-envoyer type" @click="requestsend()">
                    ENVOYER
                </button>
            </div>

            <div class="col-lg-4" v-if="type == 'COURRIER'">
                <h5 class="color bold">ENVOI DIFFÉRÉ</h5>
                <p class="">Programmez l’envoi de votre campagne.</p>
                <div class="time_envoi">
                    <span style=""
                        ><input
                            type="date"
                            name="dateofbirth"
                            id="dateofbirth"
                            v-model="date"
                            @change="concatFunction"
                    /></span>
                    <span style=""
                        ><input
                            type="time"
                            class="uk-input"
                            @change="concatFunction"
                            v-model="time"
                    /></span>
                </div>
                <div class="time_envoi_courrier" style="border-top: none">
                    <p style="">Réception du mailing estimé au</p>
                    <p style="">{{ currentDate() }}</p>
                </div>
                <div class="bloc_count">
                    <p>
                        <strong class="font">{{ count_cible }}</strong>
                        <span class="emphasized size-mail"> courriers</span>
                    </p>
                    <p class="color">
                        <strong class="font">210</strong>
                        <span class="emphasized size-mail"> euros HT</span>
                    </p>
                </div>

                <button class="button-programmer type" disabled>
                    PROGRAMMER
                </button>
            </div>
            <div class="col-lg-4 border_hr" v-else>
                <h5 class="color bold">ENVOI DIFFÉRÉ</h5>
                <p class="">Programmez l’envoi de votre campagne.</p>
                <div class="time_envoi">
                    <span style=""
                        ><input
                            type="date"
                            name="dateofbirth"
                            id="dateofbirth"
                            v-model="date"
                            @change="concatFunction"
                    /></span>
                    <span style=""
                        ><input
                            type="time"
                            class="uk-input"
                            @change="concatFunction"
                            v-model="time"
                    /></span>
                </div>
                <div class="bloc_count">
                    <p>
                        <strong class="font">{{ count_cible }}</strong>
                        <span class="emphasized size-mail"> e-mails</span>
                    </p>
                    <p class="color">
                        <strong class="font">7,50</strong>
                        <span class="emphasized size-mail"> euros HT</span>
                    </p>
                </div>

                <button class="button-programmer type" @click="sendImme()">
                    PROGRAMMER
                </button>
            </div>
            <div class="col-lg-1" v-if="type == 'COURRIER'"></div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, nextTick } from "vue";
import SideBar from "../layout/SideBar";
import Main from "../Main.vue";
import moment from "moment";
import useCompanies from "../../composables/companies";
import { useRouter, RouterView, useRoute } from "vue-router";
import { useStore } from "vuex";
import { reactive } from "vue";
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
    },
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

    data: function () {
        return {
            todos: [{ text: "test@test.fr" }, { text: "test@test.com" }],
            users: [],
            date: "",
            time: "",
            time_full: "",
            fulldata: "",
            type: "",
            store: useStore(),
        };
    },

    setup(data) {
        const my_name = localStorage.getItem("category");

        const {
            datacible,
            getCible_data,
            router,
            datacibleCount,
            count_cible,
        } = useCompanies();
        const route = useRoute();
        const store = useStore();
        const type = route.params.type;
        onMounted(() => {
            const id = route.params.cible_id;
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            axios
                .get("/getCount_cible/" + id)
                .then(function (response) {
                    count_cible.value = response.data.count_cible;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        });
        return {
            data,
            count_cible,
            getCible_data,
            type,
            my_name,
        };
    },
    methods: {
        currentDate() {
            const current = new Date();
            const date = `${current.getDate()}/${
                current.getMonth() + 1
            }/${current.getFullYear()}`;
            return date;
        },
        currentTime() {
            const current = new Date();
            const time =
                `${current.getHours()}` + ":" + `${current.getMinutes()}`;

            return time;
        },

        addTodo: function (e) {
            var newTodo = this.todoText.trim();
            if (!newTodo) {
                return;
            }
            this.todos.push({ text: newTodo });
            this.todoText = "";
        },
        remove: function (list) {
            var index = _.findIndex(this.todos, list);

            this.todos.splice(index, 1);
        },

        selectValue(event) {
            console.log(event.target.name);
            //virtuel list
            let form = {
                email: event.target.name,
                phone: "12121212",
                input_agence: localStorage.getItem("storedName"),
                input_email: localStorage.getItem("storedEmail"),
                input_phone: localStorage.getItem("storedPhone"),
                emailReplyTo: localStorage.getItem("emailReplyTo"),
                emailFrom: localStorage.getItem("emailFrom"),
                subject: localStorage.getItem("subject"),
            };
        },
        send() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            var checked_inputs = document.querySelectorAll(
                'input[type="checkbox"]:checked'
            );
            let element = [];
            var string, form;
            for (let index = 0; index < checked_inputs.length; index++) {
                string = checked_inputs[index].name;
                form = {
                    email: string,
                    phone: "1212",
                    input_agence: localStorage.getItem("storedName"),
                    input_email: localStorage.getItem("storedEmail"),
                    input_phone: localStorage.getItem("storedPhone"),
                    emailReplyTo: localStorage.getItem("emailReplyTo"),
                    emailFrom: localStorage.getItem("emailFrom"),
                    subject: localStorage.getItem("subject"),
                };
                element.push(form);
            }
            let form2 = {
                data: element,
            };
            axios
                .post("/insertdestinataire", form)
                .then((response) => {
                    this.singleData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        },
        sendImmediat() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            axios
                .get("/envoi/" + this.$route.params.cible_id)
                .then((response) => {
                    this.singleData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        },

        concatFunction: function () {
            var v = this;
            v.fulldata = v.date.concat("T" + v.time + ":43.280Z");
            this.time_full = v.fulldata;
            console.log(v.fulldata);
        },
        sendImme() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            var form = {
                formatedDate: this.time_full,
                id: this.$route.params.cible_id,
                input_agence: localStorage.getItem("storedName"),
                input_email: localStorage.getItem("storedEmail"),
                input_phone: localStorage.getItem("storedPhone"),
                emailReplyTo: localStorage.getItem("emailReplyTo"),
                emailFrom: localStorage.getItem("emailFrom"),
                subject: localStorage.getItem("subject"),
            };
            axios
                .post("/envoiprogramme/" + this.$route.params.cible_id, form)
                .then((response) => {
                    this.singleData = response.data;
                    this.$router.push("/emailing");
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        },
        requestsend() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            console.log(localStorage.getItem("storedName"));
            console.log(localStorage.getItem("storedEmail"));
            console.log(localStorage.getItem("storedPhone"));
            var formrequest = {
                input_agence: localStorage.getItem("storedName"),
                input_email: localStorage.getItem("storedEmail"),
                input_phone: localStorage.getItem("storedPhone"),
                emailReplyTo: localStorage.getItem("emailReplyTo"),
                emailFrom: localStorage.getItem("emailFrom"),
                subject: localStorage.getItem("subject"),
            };
            axios
                .post("/createdata/" + this.$route.params.cible_id, formrequest)
                .then((response) => {
                    console.log(response);
                    this.$router.push("/emailing");
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        },
        sendLettre() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            let filename = localStorage.getItem("url_pdf");
            let file = localStorage.getItem("url_csv");

            setTimeout(() => {
                axios
                    .get("/envoi_lettre/" + filename + "/" + file)
                    .then(() => {
                        console.log("email sent");
                        this.$router.push("/emailing");
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                    });
            }, 2000);
        },
        goToHome() {
            this.$router.push("/emailing");
        },
        goToContent() {
            this.$router.push({
                name: "content",
                params: {
                    type: `${this.$route.params.type}`,
                    id: `${this.$route.params.cible_id}`,
                },
            });
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

<style>
.margin-align {
    margin-bottom: 60px;
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
.font {
    font-weight: bold;
}
.emphasized {
    font-style: italic;
}
.line {
    border-bottom: 5px;
    border-style: none solid dotted dashed;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.bold {
    font-weight: bold;
}
.button-programmer {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 117px;
}
.button-envoyer {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 117px;
}
.button-tester {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 117px;
}
.button-envoyer,
.button-tester,
.button-programmer {
    margin-top: 50px !important;
    margin: auto;
    display: block;
}
.button-envoyer,
.button-programmer {
    margin-top: 36px !important;
}
.x-btn {
    color: #ff4500;
}
.size {
    font-size: small;
}
.l-size {
    font-size: x-small;
    font-weight: 700;
}
.plus-but {
    background-color: orangered;
    color: white;
    padding: 1px 2px;
    cursor: pointer;
}
.close {
    cursor: pointer;
}

.input-text {
    width: 310px;
    border: none;
    background-color: #e3e2e2;
    height: 23px;
    padding-left: 15px;
}

.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 35px;
}

input[type="checkbox"] {
    width: 7px;
    height: 15px;
    margin-right: 7px;
    margin-left: 5px;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input[type="checkbox"]:before {
    width: 13px;
    height: 13px;
    border-radius: 15px;
    top: -3px;
    left: -1px;
    position: relative;
    background-color: white;
    content: "";
    display: inline-block;
    visibility: visible;
    border: 1px solid #ff4500;
    cursor: pointer;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input[type="checkbox"]:checked:before {
    width: 13px;
    height: 13px;
    border-radius: 15px;
    top: -3px;
    left: -1px;
    position: relative;
    background-color: #ff4500;
    content: "";
    display: inline-block;
    visibility: visible;
    border: 1px solid #ff4500;
    border: none !important;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
.border_hr:before {
    content: "";
    width: 1px;
    height: 440px;
    position: absolute;
    border-radius: 15px;
    background-color: #000000;
    margin-left: -25px;
    top: 200px;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
.border_hr_empty:before {
    content: "";
    width: 1px;
    height: 440px;
    position: absolute;
    border-radius: 15px;
    background-color: #000000;
    margin-left: 25px;
    top: 150px;
}
.border_hr {
    padding-right: 35px;
}
.mrg_top {
    margin-top: 25px;
}
.mrg_btm {
    margin-bottom: 15px;
}
.color.bold {
    text-align: center;
}
.col-lg-4 > p {
    text-align: center;
    margin-bottom: 40px;
    font-size: 12px;
}
.bloc-input {
    margin-bottom: 25px;
    text-align: center;
    padding-right: 7%;
}
.test_mail span {
    font-size: 12px;
    margin-left: 5px;
}
.time_envoi {
    padding: 13px 0;
    border-bottom: 1px dashed;
    border-top: 1px dashed;
    display: flex;
    justify-content: space-around;
    font-size: 12px;
}
.time_envoi_courrier {
    padding: 13px 0;
    border-bottom: 1px dashed;
    border-top: 1px dashed;
    text-align: center;
    font-size: 12px;
}
.time_envoi_courrier p {
    margin-bottom: 0px;
}
.bloc_count {
    width: fit-content;
    margin: 30px auto 0;
    border: 1px solid #ff4500;
    padding: 12px;
}
.bloc_count p {
    margin-bottom: 0;
}
#dateofbirth,
.uk-input {
    border: none;
    border-bottom: 1px solid #fff;
}
.link {
    cursor: pointer;
    text-decoration: none;
}
.link:hover {
    color: orangered;
}
</style>
