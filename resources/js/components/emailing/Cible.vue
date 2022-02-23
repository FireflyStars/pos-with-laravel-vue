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
    <form class="space-y-6" @submit.prevent="saveCible" v-if="showcontainer">


            <div class="container">
             
                <div>
                    <h3 class="margin">
                        <a @click="goToHome()" class="link">Emailing </a>>
                        <a
                            @click="goToPrestation()"
                            v-if="my_name"
                            class="link"
                        >
                            {{ my_name }} >
                        </a>
                        Cible
                    </h3>
                </div>

                <div class="row bg-panel p-4">
                    <div class="col-md-8 border-rigth">
                        <table class="table-borderless">
                            <thead>
                                <tr>
                                    <th class="px-5"></th>
                                    <template   v-if="status">
                                    <th

                                        class="vertical-name"
                                        v-for="item in status"
                                        :key="item.id"
                                    >
                                        <span class="text-left size">{{
                                            item
                                        }}</span>
                                    </th>
                                    </template>
                                    <th class="center">
                                        <span
                                            class="text-xs grey size emphasized vertical-name"
                                            >E-mails sélectionnés</span
                                        >
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    scope="row"
                                    class="matrice"
                                    v-for="item in industries"
                                    :key="item.id"
                                >
                                    <th v-if="item" class="name_vertical">
                                        {{ item }}
                                    </th>
                                    <th
                                        class="cercle"
                                        v-for="i in status.length"
                                    >
                                        <span>
                                            <input
                                                type="checkbox"
                                                @click="goToCreate()"
                                                :name="item + '_' + i"
                                                @change="onChange($event)"
                                                class="px-6 padding radio"
                                            />
                                            <span></span>
                                        </span>
                                    </th>
                                    <td
                                        class="px-4 padding butt-class"
                                        style="px-4 padding;"
                                        :class="item"
                                    >
                                        0
                                    </td>
                                </tr>
                                <tr class="total">
                                    <th>
                                        <label>
                                            <span id="total_mails">0</span>
                                            <span>
                                                <img :style="img_up"
                                                    id="img_update"
                                                    src="../../images/circle-arrow-icon-png-clipart.png"
                                                />
                                            </span>
                                        </label>
                                    </th>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex retravailler">
                            <div>
                                <label class="type data"
                                    >POUR RETRAVAILLER VOTRE LISTE :</label
                                >
                            </div>
                            <div class="type-click">
                                <button
                                    class="button type"
                                    @click="creatCompagne()"
                                >
                                    CLIQUEZ ICI
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 column">
                        <div>
                            <h2 class="size px-4 py-4 padding">
                                CHARGER UN PRÉCÉDENT CIBLAGE
                            </h2>
                            <table style="width: 100%">
                                <tr class="history_ligne" v-for="item in history_compagne" >
                                    <th class="size">
                                        <span
                                            class="close x-btn"
                                            @click="deleteOldCompagne(item.id)"
                                            >&#x2718;</span
                                        >
                                        <input
                                            type="checkbox"
                                            class="radio history"
                                            @click="goToCreateHis()"
                                            @change="onclickHis($event)"
                                            :name="item.campagne_old_id"
                                            :value="item.nb"
                                        />&nbsp; {{ item.name }}
                                    </th>
                                    <td class="px-4 padding size-date">
                                        {{
                                            moment(item.created_at).format(
                                                "DD/MM/YYYY"
                                            )
                                        }}
                                    </td>
                                    <th class="px-4 padding butt-class">
                                        {{ item.nb }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="left">
                            <div class="bloc_count">
                                <p>
                                    <strong class="font total">0</strong>

                                    <span class="emphasized size-mail">
                                        e-mails</span
                                    >
                                </p>
                                <p class="color">
                                    <strong class="font">{{formatPrice(total_price)}}</strong>
                                    <span class="emphasized size-mail">
                                        euros HT</span
                                    >
                                </p>
                            </div>

                            <button
                                class="button-valider type"
                                @click="onValide()"
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
import { Vue, watch, ref, computed, nextTick, onMounted } from "vue";
import useCompanies from "../../composables/companies";
import SideBar from "../layout/SideBar";
import Main from "../Main.vue";
import moment from "moment";
import WaveLoader from "../WaveLoader";
import { reactive } from "vue";
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
        WaveLoader,
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
    data() {
        return {
            moment: moment,
            posts: [],
            categ_id: this.$route.params.cible_id,
            ca_id: this.$route.params.categ_id,
        };
    },
    setup(props) {
        const img_up =ref({});
        const total_price = ref(0);
        const campagne_rate = ref(0);
        const distinct_email_count = ref(0);

        onMounted(() => {
            const id = route.params.categ_id;
            console.log("eeeeeeeee0", id);
            localStorage.setItem("imagetemplate", id);

            if (id) {
                localStorage.setItem("id_category", id);
                axios.get("/getTempname/" + id).then(function (response) {
                    my_name.value = response.data;

                    localStorage.setItem("category", my_name.value);
                });

                axios.post('/get-campagne-details',{id:id})
                    .then((res)=>{
                        if(res.data.campagne){
                            campagne_rate.value = res.data.campagne.price;
                        }
                    }).catch((err)=>{

                    }).finally(()=>{

                    });

            } else {
                my_name.value = localStorage.getItem("category");
            }
        });

        const form = reactive({
            data: "0",
            data2: "ENTREPRISES & INDUSTRIES",
        });
        const store = useStore();
        store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
            true,
            "Chargement en cours..",
        ]);
        const {
            string,
            indus_length,
            stat_length,
            industries,
            emails_selected,
            status,
            getCible,
            router,
            cibleSum,
            getCompgneCible,
            history_compagne,
            getTemplates,
            title,
            getTempname,
            ca_id,
            my_name,
        } = useCompanies();

        onMounted(getCible);

         const showcontainer = ref(false);
        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true;
            });
        });
        //onMounted(getCompgneCible(props.cible_id));
        const route = useRoute();

        onMounted(() => {
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            //let history_compagne;
            const route = useRoute();
            //total_cible

            if (route.params.cible_id) {

                //window.top.location.reload();

                let form_send;
                let count;
                axios
                    .get("/getCompgneCibleSelected/" + route.params.cible_id)
                    .then(function (response) {

                        response.data.cibles.forEach(function (index) {
                            //hneee
                            form_send = {
                                data: parseInt(index.type) - 1,
                                data2: index.secteur,
                            };
                            axios
                                .post("/ciblesum", form_send)
                                .then(function (response) {

                                    document
                                        .querySelector(
                                            '.matrice input[name="' +
                                                response.data.index +
                                                '"]'
                                        )
                                        .setAttribute(
                                            "count",
                                            response.data.count
                                        );
                                    document.querySelector(
                                        '.matrice input[name="' +
                                            response.data.index +
                                            '"]'
                                    ).checked = true;
                                    count = response.data.count;
                                    let elemt_total_mails =
                                        document.getElementById("total_mails");
                                    let total_mails = parseInt(
                                        elemt_total_mails.innerText
                                    );

                                    let sum;
                                    let chlidren = document.querySelector(
                                        '.matrice input[name="' +
                                            response.data.index +
                                            '"]'
                                    ).parentNode.parentNode.parentNode.children;

                                    if (
                                        chlidren[chlidren.length - 1].innerText
                                    ) {
                                        sum = parseInt(
                                            chlidren[chlidren.length - 1]
                                                .innerText
                                        );
                                        chlidren[
                                            chlidren.length - 1
                                        ].innerText = sum + count;
                                    } else {
                                        sum = 0;
                                    }

                                    sum += count;
                                    elemt_total_mails.innerHTML =
                                        total_mails + count;
                                });
                        });
                        document.querySelector(".font.total").innerText =
                            response.data.count[0].nb;
                        let element_old = JSON.parse(route.params.element_old);
                        console.log("element_old", element_old);
                        if (element_old) {
                            ///window.addEventListener("load", (event) => {
                            console.log("tloadddd");
                            setTimeout(() => {
                                element_old.forEach(function (index) {
                                    //////////////////
                                    document.querySelector(
                                        "[name='" + index + "']"
                                    ).checked = true;
                                    // var total_mails_final_el =
                                    //     document.querySelector(".font.total");
                                    var total_mails_final_el_total =
                                        document.getElementById("total_mails");

                                    // let total_mails_f = parseInt(
                                    //     total_mails_final_el.innerText
                                    // );
                                    let total_mails_f_totl = parseInt(
                                        total_mails_final_el_total.innerText
                                    );

                                    document.querySelector(
                                        "[name='" + index + "']"
                                    ).checked = true;
                                    // total_mails_final_el.innerHTML =
                                    //     total_mails_f +
                                    //     parseInt(
                                    //         document.querySelector(
                                    //             "[name='" + index + "']"
                                    //         ).value
                                    //     );
                                    total_mails_final_el_total.innerHTML =
                                        total_mails_f_totl +
                                        parseInt(
                                            document.querySelector(
                                                "[name='" + index + "']"
                                            ).value
                                        );
                                });
                            }, 2000);
                            img_up.value={display:"none"};
                            //document.getElementById(
                              //  "img_update"
                           // ).style.display = "none";
                            //});

                            document.querySelector(".font.total").innerText =
                                response.data.count[0].nb;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                    });
            } else {
                if (route.params.data) {
                    //window.top.location.reload();
                    let data_from_categ = JSON.parse(route.params.data);
                    let index_ciblage;
                    let str_ciblage, data_test, input_ciblage;

                    data_from_categ.forEach(function (index) {
                        index_ciblage = Object.keys(index);
                        setTimeout(() => {
                            for (const [key, value] of Object.entries(index)) {
                                // window.addEventListener("load", function () {
                                switch (
                                    key.split(":")[0].trim().toLowerCase()
                                ) {
                                    case "cible":
                                        data_test = 1;
                                        break;
                                    case "contact":
                                        data_test = 2;
                                        break;
                                    case "suspect":
                                        data_test = 3;
                                        break;
                                    case "prospect":
                                        data_test = 4;
                                        break;
                                    case "client":
                                        data_test = 5;
                                        break;
                                    case "fiche obsolete":
                                        data_test = 6;
                                        break;
                                    case "fiche doublons":
                                        data_test = 7;
                                        break;
                                }

                                str_ciblage =
                                    key.split(":")[1].trim() + "_" + data_test;

                                input_ciblage = document.querySelector(
                                    '.matrice input[name="' + str_ciblage + '"]'
                                );
                                document.querySelector(
                                    '.matrice input[name="' + str_ciblage + '"]'
                                ).checked = true;
                                document
                                    .querySelector(
                                        '.matrice input[name="' +
                                            str_ciblage +
                                            '"]'
                                    )
                                    .dispatchEvent(new Event("change"));
                                // });
                            }
                        }, 2000);
                    });
                    //;
                         img_up.value={display:"none"};
                   // document.getElementById("img_update").style.display =
                   //     "none";
                    store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                } else {
                    store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                }
            }
        });

        var checked_inputs = document.querySelectorAll(
            '.matrice input[type="checkbox"]:checked'
        );
        let element = [];
        var total = 0;
        for (let index = 0; index < checked_inputs.length; index++) {
            total += checked_inputs[index].count;
        }

        function formatPrice(val){
            let n = parseFloat(val).toFixed(2);
            return n.toString().replace(".",",");
        }

        return {
            img_up,
            showcontainer,
            form,
            status,
            industries,
            stat_length,
            indus_length,
            total,
            router,
            string,
            history_compagne,
            title,
            my_name,
            total_price,
            campagne_rate,
            formatPrice,
        };
    },

    methods: {
        onChange(event) {
            var index = event.target;
            var string = index.name.split("_");
            this.state = string[1] - 1;
            var form = {
                data: this.state,
                data2: string[0],
            };
            let count;
            var cible_id = this.$route.params.cible_id;
            let that=this;
            var cibleSum = axios
                .post("/ciblesum", form)
                .then(function (response) {

                    event.target.setAttribute("count", response.data.count);
                    count = response.data.count;
                    let elemt_total_mails =
                        document.getElementById("total_mails");
                    let total_mails = parseInt(elemt_total_mails.innerText);

                    let sum;
                    let chlidren =
                        event.target.parentNode.parentNode.parentNode.children;
                    if (chlidren[chlidren.length - 1].innerText) {
                        sum = parseInt(chlidren[chlidren.length - 1].innerText);
                    } else {
                        sum = 0;
                    }
                    if (event.target.checked == true) {
                        sum += count;
                        elemt_total_mails.innerHTML = total_mails + count;
                        document.querySelector(".font.total").innerText =
                            total_mails + count;
                    } else {
                        sum -= count;
                        elemt_total_mails.innerText = total_mails - count;
                        document.querySelector(".font.total").innerHTML =
                            total_mails - count;
                    }

                    //console.log(sum);
                    that.total_price = parseFloat(sum) * parseFloat(that.campagne_rate);


                    chlidren[chlidren.length - 1].innerText = sum;
                    document.querySelector(
                        "#total_mails +span"
                    ).style.marginLeft = "0px";
                         that.img_up={display:"inline-block"};
                   // document.getElementById("img_update").style.display =
                     //   "inline-block";
                });
        },

        goToCreate: function () {},
        goToCreateHis: function () {},

        onclickHis: function (event) {
            var index = event.target.value;
            var total_mails_final_el = document.querySelector(".font.total");
            var total_mails_final_el_total =
                document.getElementById("total_mails");
            //var total_mails_f = total_mails_f_e.innerText;
            let total_mails_f = parseInt(total_mails_final_el.innerText);
            let total_mails_f_totl = parseInt(
                total_mails_final_el_total.innerText
            );

            if (event.target.checked == true) {
                total_mails_final_el.innerHTML =
                    total_mails_f + parseInt(index);
                total_mails_final_el_total.innerHTML =
                    total_mails_f_totl + parseInt(index);
            } else {
                total_mails_final_el.innerHTML =
                    total_mails_f - parseInt(index);
                total_mails_final_el_total.innerHTML =
                    total_mails_f_totl - parseInt(index);
            }
        },

        creatCompagne: function () {
            var checked_inputs = document.querySelectorAll(
                '.matrice input[type="checkbox"]:checked'
            );
            var checked_inputs_old = document.querySelectorAll(
                '.history_ligne input[type="checkbox"]:checked'
            );

            let err = false;

            if(parseInt(checked_inputs.length)+parseInt(checked_inputs_old.length)==0){
                err = true;

                this.$store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,
                       {
                            message: "Pas d'emails selectionné",
                            ttl: 3,
                            type: 'danger'
                        });
            }

        if(!err){
            let element = [];
            let element_old = [];
            var string, form;
            var string_old, form_old;
            const route = useRoute();
            let categ_id = this.$route.params.categ_id;
            for (let index = 0; index < checked_inputs.length; index++) {
                string = checked_inputs[index].name.split("_");
                form = {
                    type: string[1] - 1,
                    status: string[0],
                };
                element.push(form);
            }
            for (let index = 0; index < checked_inputs_old.length; index++) {
                string_old = parseInt(checked_inputs_old[index].name);
                element_old.push(string_old);
            }
            var body = {
                data: element,
                data_old: element_old,
                for_template: categ_id,
                name:
                    "compagne-" +
                    Math.floor(Math.random() * (10000 - 1 + 1)) +
                    1,
                count: parseInt(
                    document.getElementById("total_mails").innerText
                ),
            };
            let self = this;
            var creatCompagne = axios
                .post("/creatCompagne", body)
                .then(function (response) {
                    console.log(response.data.GLOBALS);
                    self.$router.push({
                        name: "segmentation",
                        params: {
                            cible_id: `${response.data.GLOBALS}`,
                            type: self.$route.params.type,
                            element_old: JSON.stringify(element_old),
                        },
                    });

                    return self.$router;
                })
                .catch(function (error) {
                    console.log(error);
                });

            }
        },
        onValide: function () {
            const route = useRoute();
            var checked_inputs = document.querySelectorAll(
                '.matrice input[type="checkbox"]:checked'
            );
            var checked_inputs_old = document.querySelectorAll(
                '.history_ligne input[type="checkbox"]:checked'
            );

             let err = false;

            if(parseInt(checked_inputs.length)+parseInt(checked_inputs_old.length)==0){
                err = true;

                this.$store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,
                       {
                            message: "Pas d'emails selectionné",
                            ttl: 3,
                            type: 'danger'
                        });
            }

        if(!err){



            let element = [];
            let element_old = [];
            var string, form;
            var string_old, form_old;

            let categ_id = this.$route.params.categ_id;
            for (let index = 0; index < checked_inputs.length; index++) {
                string = checked_inputs[index].name.split("_");
                form = {
                    type: string[1] - 1,
                    status: string[0],
                };
                element.push(form);
            }
            for (let index = 0; index < checked_inputs_old.length; index++) {
                string_old = parseInt(checked_inputs_old[index].name);
                element_old.push(string_old);
            }
            var body = {
                data: element,
                data_old: element_old,
                for_template: categ_id,
                name:
                    "compagne-" +
                    Math.floor(Math.random() * (10000 - 1 + 1)) +
                    1,
                count: parseInt(
                    document.getElementById("total_mails").innerText
                ),
            };
            let self = this;
            if (this.$route.params.type == "COURRIER") {
                var creatCompagne = axios
                    .post("/creatCompagne", body)
                    .then(function (response) {
                        console.log(response.data.GLOBALS);
                        self.$router.push({
                            name: "mailingContenu",
                            params: {
                                cible_id: `${response.data.GLOBALS}`,
                                type: self.$route.params.type,
                            },
                        });

                        return self.$router;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                var creatCompagne = axios
                    .post("/creatCompagne", body)
                    .then(function (response) {
                        console.log(response.data.GLOBALS);
                        self.$router.push({
                            name: "content",
                            params: {
                                cible_id: `${response.data.GLOBALS}`,
                                type: self.$route.params.type,
                            },
                        });

                        return self.$router;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
        },
        deleteOldCompagne: function (id) {
            var data_cible = {
                id: id,
            };
            axios
                .put("/deleteOldCompagne/", data_cible)
                .then((res) => {
                    //posts = res.data.oldCompagne;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        goToHome() {
            this.$router.push("/emailing");
        },
        goToPrestation() {
            let id_category = localStorage.getItem("id_category");
            //    this.$router.push('/emailing/emailingprestations/'`${id_category}`);
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
    margin-bottom: 40px;
    margin-top: -34px;
    font-size: 17px;
    font-weight: bold;
}
.margin-ajustement {
    /*margin-bottom: 75px;*/
    margin-top: 39px;
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
.type-click {
    width: fit-content;
    margin-right: -20px;
}

.h1 {
    color: #ff5c00;
    margin-bottom: 3%;
}
.padding {
    padding: 15px 12px;
}
.grey {
    color: grey;
}
.size {
    font-size: 12px;
}
.size-mail {
    font-size: small;
}
.font {
    font-weight: bold;
}
.size-date {
    font-size: 12px;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.vl {
    border-left: 1px solid black;
    height: 100%;
    margin-left: 145px;
}
.emphasized {
    font-style: italic;
    font-weight: 400;
}
.radio {
    --checkbox-color: greenyellow;
    --checkmark-color: purple;
}
.radio {
    width: 15px;
    height: 15px;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input[type="checkbox"]:before {
    content: "";
    width: 25px;
    height: 25px;
    border-radius: 15px;
    top: -5px;
    left: -5px;
    position: relative;
    background-color: white;
    display: inline-block;
    visibility: visible;
    border: 1px solid #ff4500;
    cursor: pointer;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input[type="checkbox"]:checked:before {
    width: 25px;
    height: 25px;
    border-radius: 15px;
    top: -5px;
    left: -5px;
    position: relative;
    background-color: #ff4500;
    content: "";
    display: inline-block;
    visibility: visible;
    border: 1px solid white;
    border: none !important;
}

.radio input[type="checkbox"]::checked + label::after {
    border-color: #ff4500;
    border: none !important;
}
.butt-class {
    background-color: #d3d3d3;
    font-weight: normal;
    text-align: center;
}
.line {
    border-bottom: 1px;
    border-style: none solid dotted dashed;
}
.x-btn {
    color: #ff4500;
    margin-right: 8px;
}
.button-click {
    background-color: white;
    color: orangered;
    border: 2px solid #e7e7e7;
}
.button {
    background-color: white;
    border: none;
    color: orangered;
    cursor: pointer;
    width: 117px;
    height: 100%;
}
.type-click {
    border: orangered 1px solid;
}
.button-valider {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 150px;
    height: 27px;
}
.data {
    width: 120px;
    text-align: right;
    margin-right: 15px;
}
.custom-control-input::checked ~ .custom-control-label {
    color: #fff;
    border-color: orangered;
}
.center {
    text-align: center;
    line-height: 1;
}
.bord {
    width: 117px;
    padding: 10px;
    border: 1px solid orangered;
}
.column {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 328px;
    padding-left: 40px;
}
.left {
    text-align: end;
}
input.history[type="checkbox"] {
    width: 5px;
    height: 15px;
    margin-right: 9px;
    border: 2px;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input.history[type="checkbox"]:before,
input.history[type="checkbox"]:checked:before {
    width: 15px;
    height: 15px;
    top: 3px;
    left: -2px;
}
.border-rigth {
    border-right: 1px solid #000;
    padding-right: 40px;
}
.vertical-name {
    line-height: 1;
    text-align: center;
    text-transform: uppercase;
    min-width: 80px;
}
tr {
    height: 73px;
}
.history_ligne {
    border-bottom: 1px dashed;
}
.retravailler {
    margin-top: 60px;
    justify-content: end;
}
th.cercle {
    min-width: 75px;
    max-width: 75px;
    text-align: center;
}
.total {
    height: auto;
    position: relative;
}
.total th {
    position: absolute;
    right: 0;
    margin-top: 5px;
}

.total img {
    width: 35px;
}
.table-borderless tbody th.name_vertical {
    padding: 0px;
    font-size: 12px;
    text-align: right;
    padding-right: 10px;
    line-height: 1.3;
    text-transform: uppercase;
}
.table-borderless thead tr {
    height: 45px;
}
.table-borderless thead th span {
    text-transform: uppercase;
}
.table-borderless thead th.center span {
    text-transform: inherit;
}
.bloc_count {
    width: 150px;
    margin-top: 30px;
    border: 1px solid #ff4500;
    padding: 12px;
    margin-left: auto;
}
.bloc_count p {
    margin-bottom: 0;
}
#total_mails + span {
    margin-left: 25px;
}
#img_update {
    display: none;
}
.close {
    cursor: pointer;
}
@media (min-width: 1200px) .container {
    max-width: 1200px;
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
