<template>
    <transition name="search">    
        <div class="card search--results" v-if="!lodash.isEmpty(results)">

            <div class="card-body">
                <section class="societe" v-if="results?.customers?.length">
                    <div class="header">
                        <h4>Sociéte</h4>
                        <a href="#">Voir plus</a>
                    </div>

                    <div 
                        class="info-box" 
                        v-for="(customer, index) in results?.customers"
                        :key="index"
                    >
                        <div class="item">
                            <h5>{{ customer.company }}</h5>
                            <label for="">{{ customer.customer_name }}</label>
                        </div>
                        <div class="label-info">
                            <label>{{ customer.raisonsociale }}</label>
                        </div>
                        <div class="label-info">
                            <label>{{ customer.raisonsociale2 }}</label>
                            <label>{{ customer.email }}</label>
                        </div>
                        <div 
                            class="tag tag-contact-type"
                            :style="{'background': customer.statut_color}"
                        >
                            {{ customer.statut_name }}
                        </div>
                    </div>

                </section>

                <section class="contact">
                    
                    <div class="header">
                        <h4>Contact</h4>
                        <a href="#">Voir plus</a>
                    </div>

                    <div class="info-box">
                        <div class="item">
                            <h5>Brad pitt</h5>
                            <label for="">+444 0979 7900</label>
                        </div>
                        <div class="label-info">
                            <label>carli@gmail.com</label>
                        </div>
                        <div class="label-info">
                        </div>
                        <div class="tag tag-contact-type">
                            client
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="item">
                            <h5>Coulomier Bart</h5>
                            <label for="">+444 6434 9000</label>
                        </div>
                        <div class="label-info">
                            <label class="align-self-end">coulomier@gmail.com</label>
                        </div>
                        <div class="label-info">
                        </div>
                        <div class="tag tag-customer-status">
                            prospect
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="item">
                            <h5>Trump Donald</h5>
                            <label for="">+444 8677 0099</label>
                        </div>
                        <div class="label-info">
                            <label class="align-self-end">cardamon@gmail.com</label>
                        </div>
                        <div class="label-info">
                            <label></label>
                        </div>
                        <div class="tag tag-contact-type">
                            client
                        </div>
                    </div>

                </section>

                <section class="devis">
                    
                    <div class="header">
                        <h4>Devis/Commande</h4>
                        <a href="#">Voir plus</a>
                    </div>

                    <div class="info-box">
                        <div class="item">
                            <h5>SocieteXXX</h5>
                            <label for=""></label>
                        </div>
                        <div class="label-info">
                            <label>23 rue de prince 31000 Toulouse</label>
                        </div>
                        <div class="label-info">
                            <label>24/02/2022</label>
                        </div>
                        <div class="label-info">
                            <label>3 000€ &nbsp; 12Hr</label>
                        </div>
                        <div class="tag tag-order-status">
                            en cours
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="item">
                            <h5>calimir Boris</h5>
                            <label for=""></label>
                        </div>
                        <div class="label-info">
                            <label>Delivery</label>
                        </div>
                        <div class="label-info">
                            <label>26/02</label>
                        </div>
                        <div class="label-info">
                            <label></label>
                        </div>
                        <div class="tag tag-order-status">
                            facturation
                        </div>
                    </div>

                </section>


            </div>
        </div>

    </transition>
</template>

<script setup>

    import lodash from 'lodash'
    import { useStore } from 'vuex'
    import { computed } from 'vue'    

    import { 
        SEARCH_MODULE,
    } from '../../store/types/types'

    defineProps({
        show: {
            required: false,
            type: Boolean,
            default: false
        }
    })

    const store = useStore()

    const loading = computed(() => {
        const { id, value } = store.getters[`${SEARCH_MODULE}/loading`]
        return id == 'search' && value
    })

    const results = computed(() => store.getters[`${SEARCH_MODULE}/results`])

</script>

<style lang="scss" scoped>
.search-enter-from {
    opacity: 0;
    height: 0;
    visibility: hidden;
}
.search-enter-to {
    opacity: 1;
    height: auto;
    visibility: visible;
}
.search-enter-active {
    transition: opacity ease 0.2s, visibility ease 0.2s, height ease 0.6s;
    transform-origin: top;
}
.search-leave-from {
    opacity: 1;
    height: auto;
    visibility: visible;
}
.search-leave-to {
    opacity: 0;
    height: 0;
    visibility: hidden;
}
.search-leave-active {
    transition: all ease 0.1s;
    transform-origin: top;
}

.search {

    &--results {

        position: absolute;
        top: 100%;
        right: 10%;
        background: #fff;
        border-radius: 5px;
        width: 700px;

        .societe, .contact, .devis {
            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-bottom: 1px solid #C3C3C3;
                h4 {
                    font-family: 'Almarai';
                    font-style: normal;
                    font-weight: 800;
                    font-size: 22px;
                    line-height: 110%;
                    display: flex;
                    align-items: center;
                    color: #000000; 
                }
                a {
                    font-family: 'Almarai';
                    font-style: normal;
                    font-weight: 300;
                    font-size: 18px;
                    line-height: 100%;
                    display: flex;
                    align-items: center;
                    text-decoration-line: underline;
                    color: #000000;
                }
            }

            .info-box {

                display: grid;
                grid-template-columns: 30% 20% 20% 30%;
                background: #F8F8F8;
                border-radius: 5px;
                padding: .93rem 1.35rem 1.12rem .8rem;
                margin-top: .75rem;

                .item {
                    font-family: 'Almarai';
                    font-style: normal;
                    font-weight: 700;
                    font-size: 16px;
                    line-height: 140%;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    label {
                        color: #868686 !important;
                    }
                    h5 {
                        color: #000000 !important;
                    }
                }

                .tag {
                    justify-self: right;
                    padding: 4px 1px;
                    text-transform: uppercase;
                    width: 77px;
                    height: 21px;
                    display: flex;
                    flex-direction: row;
                    justify-content: center;
                    align-items: center;
                    font-family: 'Almarai';
                    font-style: normal;
                    font-weight: 700;
                    font-size: 12px;
                    line-height: 13px;
                    display: flex;
                    align-items: center;
                    text-align: center;
                    color: #000000;
                    border-radius: 70px;


                    &-contact-type {
                        background: rgba(234, 214, 247, 0.7);
                    }

                    &-customer-status {
                        background: rgba(252, 107, 33, 0.26);
                    }

                    &-order-status {
                        width: 104px !important;
                        background: rgba(241, 210, 164, 0.7);
                    }


                }

                .label-info {
                    display: flex;
                    align-items: flex-start;
                }

                label {
                    font-family: 'Almarai';
                    font-style: normal;
                    font-weight: 700;
                    font-size: 16px;
                    line-height: 140%;
                    display: flex;
                    align-items: center;
                    color: #868686;
                }

            }

        }

        .societe {
            margin-top: .93rem;
        }

        .contact, .devis {
            margin-top: 2.5rem;
        }

        .devis {
            .info-box {
                grid-template-columns: 30% 15% 15% 15% 25%; 
            }
        }

        .contact {
            .label-info {
                label {
                    color: #000000 !important;
                }
            }
            .item {
                h5, label {
                    color: #868686 !important;
                }
            }
        }

    }
}
</style>