import { pushScopeId } from "vue"

<template>
    <!--<side-bar></side-bar>
    <Main></Main>-->
    <transition
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
    >
        <div class="container">
            <h3 class="color margin">CIBLES</h3>

            <div>
                <div class="filtter d-flex">
                    <div class="d-flex colum">
                        <label>Filtrer par Société:</label>
                        <input class="search" v-model="search" />
                    </div>
                </div>
                <div class="bloc-table">
                    <v-table>
                        <thead slot="head">
                            <tr>
                                <th class="square border-none">
                                    <input
                                        type="checkbox"
                                        class="radio"
                                        v-model="isCheckAll"
                                        @click="checkAll()"
                                    />
                                </th>
                                <th
                                    v-for="(col, index) in TableRow"
                                    :key="index"
                                    @click="sort(index, col.sortable)"
                                >
                                    {{ col.name }}

                                    <span class="sort-arrows">
                                        <svg
                                            v-if="
                                                sortColumn == index && ascending
                                            "
                                            width="8"
                                            height="6"
                                            viewBox="0 0 8 6"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="asc"
                                        >
                                            <path
                                                d="M3.59091 0.75C3.78336 0.416666 4.26449 0.416667 4.45694 0.75L7.05502 5.25C7.24747 5.58333 7.0069 6 6.622 6H1.42585C1.04095 6 0.800387 5.58333 0.992837 5.25L3.59091 0.75Z"
                                                fill="#ffffff"
                                            />
                                        </svg>
                                        <svg
                                            v-if="
                                                sortColumn == index &&
                                                !ascending
                                            "
                                            width="8"
                                            height="6"
                                            viewBox="0 0 8 6"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="desc"
                                        >
                                            <path
                                                d="M4.45694 5.25C4.26449 5.58333 3.78336 5.58333 3.59091 5.25L0.992837 0.749999C0.800387 0.416666 1.04095 -6.10471e-07 1.42585 -5.76822e-07L6.622 -1.2256e-07C7.0069 -8.8911e-08 7.24747 0.416666 7.05502 0.75L4.45694 5.25Z"
                                                fill="#ffffff"
                                            />
                                        </svg>

                                        <svg
                                            v-if="
                                                col.sortable &&
                                                sortColumn != index
                                            "
                                            width="8"
                                            height="6"
                                            viewBox="0 0 8 6"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="desc"
                                        >
                                            <path
                                                d="M4.45694 5.25C4.26449 5.58333 3.78336 5.58333 3.59091 5.25L0.992837 0.749999C0.800387 0.416666 1.04095 -6.10471e-07 1.42585 -5.76822e-07L6.622 -1.2256e-07C7.0069 -8.8911e-08 7.24747 0.416666 7.05502 0.75L4.45694 5.25Z"
                                                fill="#ffffff"
                                            />
                                        </svg>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in datacible"
                                :key="item.id"
                            >
                                <td class="border-none">
                                    <input
                                        @click="
                                            onToggleCible(
                                                item.id,
                                                $event,
                                                index
                                            )
                                        "
                                        type="checkbox"
                                        class="radio"
                                        :name="item.id"
                                        v-model="isCheck"
                                        :value="item.id"
                                        v-bind:value="item.id"
                                    />
                                </td>
                                <td>{{ item.id }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.gender }}</td>
                                <td>{{ item.firstname }}</td>
                                <td>-</td>
                                <td>{{ item.industrie }}</td>
                                <td>{{ item.company }}</td>
                                <td>{{ item.phone }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>{{ item.address1 }}</td>
                                <td>{{ item.address2 }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </v-table>
                </div>
                <div class="marg-count d-flex">
                    <div>
                        <span class="emphasized">E-mails Sélectionnés : </span>
                        <strong>{{ datacibleCount }} </strong>
                    </div>
                    <div>
                        <button class="button-valider" @click="onReturn()">
                            VALIDER
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import { Vue, ref, onMounted, nextTick, computed } from "vue";
import SideBar from "../layout/SideBar";
import Main from "../Main.vue";
import useCompanies from "../../composables/companies";
import { reactive } from "vue";
import { useRouter, RouterView, useRoute } from "vue-router";
import WaveLoader from "../WaveLoader";
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

    data() {
        return {
            search: "",
            item: [],
            datacible: [],
            isCheckAll: true,
            isCheck: [],
            languages: [],
            array_ids: [],
        };
    },

    props: {
        cible_id: {
            type: Number,
        },
    },

    setup(props) {
        const { datacible, getCible_data, router, datacibleCount } =
            useCompanies();
        const route = useRoute();
        const store = useStore();
        const isCheck = [];
        const sortColumn = "";
        const ascending = false;
        const SORTCOL = "asc";

        const TableRow = ref({
            id: {
                name: "#",
                sortable: false,
            },
            email: {
                name: "email",
                sortable: true,
            },
            gender: {
                name: "Civilité",
                sortable: true,
            },
            firstname: {
                name: "Prénom",
                sortable: true,
            },
            name: {
                name: "Nom",
                sortable: true,
            },
            Fonction: {
                sortable: true,
            },
            Société: {
                name: "Société",
                sortable: true,
            },
            phone: {
                name: "Téléphone",
                sortable: true,
            },
            Internet: {
                name: "Site Internet",
                sortable: true,
            },
            Address: {
                name: "Address",
                sortable: true,
            },
            Address0: {
                name: "Address",
                sortable: true,
            },
            address1: {
                name: "Address",
                sortable: true,
            },
            address2: {
                name: "Address",
                sortable: true,
            },
            Address3: {
                name: "Address",
                sortable: true,
            },
            Address4: {
                name: "Address",
                sortable: true,
            },
            Address5: {
                name: "Address",
                sortable: true,
            },
            Address6: {
                name: "Address",
                sortable: true,
            },
        });

        function sort(colname) {
            if (this.sortColumn === colname) {
                this.ascending = !this.ascending;
            } else {
                this.ascending = true;
                this.sortColumn = colname;
            }

            var ascending = this.ascending;
            datacible.value.sort(function (a, b) {
                if (a[colname] > b[colname]) {
                    return ascending ? 1 : -1;
                } else if (a[colname] < b[colname]) {
                    return ascending ? -1 : 1;
                }
                return 0;
            });
        }

        onMounted(() => {
            const id = route.params.cible_id;
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            axios
                .get("/getCibleByCampagne/" + id)
                .then(function (response) {
                    datacible.value = response.data.cibles;
                    datacibleCount.value = response.data.count;
                    if (datacibleCount.value < 0) {
                        datacibleCount.value = 0;
                    }
                    for (let i in response.data.cibles) {
                        isCheck.push(response.data.cibles[i].id);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(() => {
                    store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
                });
        });
        return {
            getCible_data,
            datacibleCount,
            datacible,
            router,
            store,
            isCheck,
            sort,
            TableRow,
            sortColumn,
            ascending,
            SORTCOL,
        };
    },

    computed: {
        filtredPosts() {
            return this.item.filter((datacible) =>
                datacible.email.includes(this.search)
            );
        },
    },

    methods: {
        checkAll: function () {
            const store = useStore();
            this.store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [
                true,
                "Chargement en cours..",
            ]);
            this.isCheckAll = !this.isCheckAll;

            var data_cible;
            const campagne_id = this.$route.params.cible_id;

            if (this.isCheckAll) {
                // code for select
                for (let i in this.datacible) {
                    this.isCheck.push(this.datacible[i].id);
                }

                var self = this;
                this.datacible.forEach(function (index) {
                    // self.datacibleCount = self.datacibleCount + 1;

                    data_cible = {
                        id: index.id,
                        campagne_id: campagne_id,
                    };
                    axios
                        .put("/insertCompagneCible/", data_cible)
                        .then((res) => {
                            console.log("checked", res.data.cibles);
                            self.datacibleCount = res.data.cibles;
                        });
                });
                //this.isCheck = this.isCheckAll;
                this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
            } else if (!this.isCheckAll) {
                this.isCheck = [];

                var self = this;
                this.datacible.forEach(function (index) {
                    //self.datacibleCount = self.datacibleCount - 1;

                    data_cible = {
                        id: index.id,
                        campagne_id: campagne_id,
                    };
                    axios
                        .put("/deleteCompagneCible/", data_cible)
                        .then((res) => {
                            self.datacibleCount = res.data.cibles;
                            console.log("not checked", res.data.cibles);
                        });
                });

                this.store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
            }
        },

        onToggleCible: function (id, event, index) {
            const route = useRoute();
            const campagne_id = this.$route.params.cible_id;

            if (event.target.checked == true) {
                var data_cible = {
                    id: id,
                    campagne_id: campagne_id,
                };

                this.isCheck.push(id);

                if (this.isCheck.length == this.datacible.length) {
                    this.isCheckAll = true;
                } else {
                    this.isCheckAll = false;
                }

                axios.put("/insertCompagneCible/", data_cible).then((res) => {
                    this.datacibleCount = res.data.cibles;
                    console.log("checked", res.data.cibles);
                });
            } else {
                var data_cible = {
                    id: id,
                    campagne_id: campagne_id,
                };
                this.isCheck.splice(this.isCheck.indexOf(id), 1);

                if (this.isCheck.length == 0) {
                    this.isCheckAll = false;
                }
                axios.put("/deleteCompagneCible/", data_cible).then((res) => {
                    this.datacibleCount = res.data.cibles;
                    console.log("not checked", res.data.cibles);
                });
            }
        },

        onReturn: function () {
            const route = useRoute();
            this.$router.push({
                name: "cibleSeg",
                params: {
                    cible_id: `${this.$route.params.cible_id}`,
                    type: this.$route.params.type,
                    element_old: `${this.$route.params.element_old}`,
                },
            });
            return this.$router;
        },
    },
};
</script>

<style scoped>
.container {
    padding-bottom: 100px;
}
.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 15px;
}
.bloc-table {
    width: 100%;
    height: 350px;
    overflow: scroll;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
input[type="checkbox"] {
    width: 7px;
    height: 8px;
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
    border: none !important;
}
.square {
    background-color: #fff;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
.square input[type="checkbox"]:before {
    border-radius: 0;
}
input[type="checkbox"] {
    -moz-appearance: initial;
}
.square input[type="checkbox"]:checked:before {
    border-radius: 0;
}
.emphasized {
    border-top: 1px solid #2196f3;
    font-size: 15px;
    font-style: italic;
    margin-left: 40px;
    font-weight: 500;
}
strong {
    font-size: 15px;
    border-top: 1px solid #2196f3;
}
th {
    padding: 0px 10px;
    color: #fff;
    background-color: orangered;
    border: 1px solid #000;
    font-weight: 400;
    min-width: 100px;
}
td {
    padding: 0px 10px;
}
th,
td {
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 12px;
}
.marg-count {
    margin-top: 20px;
    justify-content: space-between;
}
.button-valider {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 170px;
    height: 35px;
    font-size: 15px;
    font-weight: 500;
}
.border-none {
    border: none;
}
.filtter {
    margin-bottom: 20px;
    flex-wrap: wrap;
    margin-left: 40px;
}
.filtter label {
    font-size: 12px;
}
.filtter input {
    height: 22px;
    font-size: 12px;
}
.colum {
    flex-direction: column;
}
.sort-arrows {
    background-color: white;
    position: relative;
    display: block;
    margin: 6px 3px;
    float: right;
}
.sort-arrows .asc {
    position: absolute;
    top: 0;
    left: 0;
}
.sort-arrows .desc {
    position: absolute;
    top: 0;
    left: 0;
}
</style>
