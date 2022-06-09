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
 
        <div class="col-lg-12">
            <h3 class="margin">
                <a @click="goToHome()" class="link">PLATEFORME MARKETING</a> >
                <a @click="goToPrestation()" class="link">{{ my_name }}</a> >
                Cible > <a @click="goToContent()" class="link"> Contenu</a> >
                Envoi
            </h3>
        </div>

        <div class="row position-relative p-4 bg-panel">
            <div class="col-lg-4" v-if="type != 'COURRIER'">
                <h5 class="color bold">TEST</h5>
                <p class="">Testez votre campagne avant envoi.</p>
                <div class="bloc-input row">
                    <div class="col-lg-10">
                    <input
                        placeholder="E-mail de test"
                        type="email"
                        class="input-text"
                        id="listItem"
                        pattern=".+@globex\.com"
                        size="30"
                        v-model="todoText"
                    />
                    </div>
                    <div class="col-lg-2">
                    <i class="bi bi-plus plus-but" v-on:click="addTodo()"></i>
                    </div>
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
                        <strong class="font">{{formatPrice(campagne_price*count_cible)}}</strong>
                        <span class="emphasized size-mail">&nbsp;HT</span>
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
                        <strong class="font">{{formatPrice(campagne_price*count_cible)}}</strong>
                        <span class="emphasized size-mail">&nbsp;HT</span>
                    </p>
                </div>
                <button class="button-envoyer type" @click="requestsend()">
                    ENVOYER
                </button>
            </div>

            <div class="col-lg-4" :class={collg6} v-if="type == 'COURRIER'">
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
                        <strong class="font">{{formatPrice(campagne_price*count_cible)}}</strong>
                        <span class="emphasized size-mail">&nbsp;HT</span>
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
                             :min="today" 
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
                        <strong class="font">{{formatPrice(campagne_price*count_cible)}}</strong>
                        <span class="emphasized size-mail">&nbsp;HT</span>
                    </p>
                </div>

                <button class="button-programmer type" @click="sendDifferer()">
                    PROGRAMMER
                </button>
            </div>
            <div class="col-lg-1" v-if="type == 'COURRIER'"></div>
        </div>
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
import moment from "moment";
import useCompanies from "../../composables/companies";
import { useRouter, RouterView, useRoute } from "vue-router";
import { useStore } from "vuex";
import { reactive } from "vue";
import {formatDate,formatPrice} from "../helpers/helpers"
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
            //todos: [{ text: "test@test.fr" }, { text: "test@test.com" }],
            users: [],
            date: "",
            time: "",
            time_full: "",
            fulldata: "",
            type: "",
            store: useStore(),
            todoText:"",
        };
    },

    setup(data) {
        const my_name = localStorage.getItem("category");
        const todos = ref([]);
        const today="2022-03-10"
        const {
            datacible,
            getCible_data,
            router,
            datacibleCount,
            getCampagneCampagneCategory,
            count_cible,
        } = useCompanies();
        const route = useRoute();
        const store = useStore();
        const type = route.params.type;
           const showcontainer = ref(false);
        const campagne_price=ref(0);

        onMounted(() => {
        
            const id = route.params.cible_id;

            
            localStorage.setItem("id_campagne", id)
            getCampagneCampagneCategory(id).then((response)=>{
                campagne_price.value=response.data.campagnesCategory.price
                showcontainer.value = true
            })
            
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ])

            axios.post('/get-affiliate-detail',{})
                .then((res)=>{
                    if(res.data.affiliate){
                        let obj = {};
                        obj.text = res.data.affiliate.email;
                        todos.value.push(obj)

                    }
                }).catch((err)=>{
                    console.log(err)
                }).finally(()=>{

                })

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

        function collg6(){
            if(type==COURRIER)
            return 'col-lg-6';
        }
        return {
            data,
            count_cible,
            getCible_data,
            type,
            my_name,
            showcontainer,
            todos,
            campagne_price,
            formatPrice,
            formatDate,
            collg6,
            today
        };
    },
    methods: {
        currentDate() {
            const current = new Date();
            const date = `${current.getMonth() + 1}/${current.getDate()}/${current.getFullYear()}`;
            return formatDate(date);
        },
        currentTime() {
            const current = new Date();
            const time =(current.getHours()<10?`0${current.getHours()}`:`${current.getHours()}:`) + (current.getMinutes()<10?`0${current.getMinutes()}`:`${current.getMinutes()}`);

            return time;
        },

        addTodo: function (e) {
            var newTodo = this.todoText.trim();
            let mail_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,63})+$/;

            if (!newTodo) {
                return;
            }else if(!mail_regex.test(newTodo.toLowerCase())){
                this.store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,
                       {
                            message: 'Erreur format email',
                            ttl: 3,
                            type: 'danger'
                        });
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

            var checked_inputs = document.querySelectorAll(
                'input[type="checkbox"]:checked'
            );

            if(checked_inputs.length == 0){
                this.store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,
                       {
                            message: 'Pas email selectionné',
                            ttl: 3,
                            type: 'danger'
                        });
            }else{

                this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                    true,
                    "Chargement en cours..",
                ]);

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
                .post(
                    "/insertdestinataire/" +
                        localStorage.getItem("id_campagne"),
                    form2
                )
                .then((response) => {
                    this.singleData = response.data;
                    this.store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:response.data,ttl:8,type:'success'});
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
            }
        },
        // sendImmediat() {
        //     this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
        //         true,
        //         "Chargement en cours..",
        //     ]);
        //     axios
        //         .get("/envoi/" + localStorage.getItem("id_category"))
        //         .then((response) => {
        //             this.singleData = response.data;
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         })
        //         .finally(() => {
        //             this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
        //         });
        // },

        concatFunction: function () {
            var v = this;
            v.fulldata = v.date.concat("T" + v.time + ":43.280Z");
            this.time_full = v.fulldata;
        },
        sendDifferer() {
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Envoi différé en cours..",
            ]);
            var form = {
                date: this.date,
                time: this.time,
                id: this.$route.params.cible_id,
                input_agence: localStorage.getItem("storedName"),
                input_email: localStorage.getItem("storedEmail"),
                input_phone: localStorage.getItem("storedPhone"),
                emailReplyTo: localStorage.getItem("emailReplyTo"),
                emailFrom: localStorage.getItem("emailFrom"),
                subject: localStorage.getItem("subject"),
                id_category: localStorage.getItem("id_category"),
            };
            axios
                .post("/envoiprogramme/" + this.$route.params.cible_id, form)
                .then((response) => {
                    this.singleData = response.data;
                    this.store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:response.data,ttl:8,type:'success'});
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

            var formrequest = {
                input_agence: localStorage.getItem("storedName"),
                input_email: localStorage.getItem("storedEmail"),
                input_phone: localStorage.getItem("storedPhone"),
                emailReplyTo: localStorage.getItem("emailReplyTo"),
                emailFrom: localStorage.getItem("emailFrom"),
                subject: localStorage.getItem("subject"),
                id_category: localStorage.getItem("id_category"),
            };
            axios
                .post("/createdata/" + this.$route.params.cible_id, formrequest)
                .then((response) => {
                    this.store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:response.data,ttl:8,type:'success'});
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

<style scoped>
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
      font-size: 17px;
    font-weight: bold;
}

input[type="checkbox"] {
    width: 7px;
    height: 15px;
    margin-right: 7px;
    margin-left: 5px;
}
input[type="checkbox"] {
    -moz-appearance: initial;
    position:relative;
}
input[type="checkbox"]:before {
    width: 13px;
    height: 13px;
    border-radius: 15px;
    top: 4px;
    left: -1px;
    position: absolute;
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
    height: calc(100% - 20px);
    position: absolute;
    border-radius: 15px;
    background-color: #000000;
    margin-left: -25px;
    top: 10px;
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
    top: 0;
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
    color:orange;
}
.link:hover {
    color: orangered;
}
.bg-panel{
    min-height: 440px;
}
</style>
