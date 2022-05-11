<template>

    <div class="row mx-0" style="margin-top: 2rem">

        <template v-if="fetching">
            <div class="d-flex gap-2 align-items-center">
                <loader type="thumbnail" />
                <div>
                    <loader :count="2" />
                </div>
                <loader type="icon" />    
            </div>
        </template>
        
        <template v-else>
            
            <div class="col">
                <div class="d-flex gap-2 align-items-center">
                    <div class="thumbnail"></div>
                    <div class="title-section title-section-right">
                        <p>Contact</p>
                        <h4>{{ order.contact?.name || 'Contact' }}</h4>
                    </div>
                    <Icon 
                        name="circle-plus" 
                        class="pointer" 
                        @click.prevent="generateElement('textarea', { 
                            content: `
                                <h4 class='title'>Contact</h4>
                                <div>${order.contact?.name || ''}</div>
                                <div>${order.contact?.email || ''}</div>
                                <div>${order.contact?.mobile || ''}</div>
                                <div>${order.contact?.type || ''}</div>
                                <div>${order.contact?.comment || ''}</div>
                            `
                        })" 
                    />
                </div>
            </div>
            
        </template>

    </div>

</template>

<script>
import { inject } from 'vue'

export default {

    name: 'contact-info',

    props: {
        order: {
            required: true,
            type: Object
        }
    },

    setup () {
        const generateElement = inject('generateElement')
        const fetching = inject('fetching')
        return {
            fetching,
            generateElement
        }
    }
}
</script>

<style lang="scss" scoped>

.thumbnail {
    background: #7998C7;
    width: 2.95rem;
    height: 3.15rem;
    border-radius: 50%;
}
.title-section {
    p {
        font-family: 'Mulish Regular';
        font-weight: 600;
        font-style: normal;
        font-size: 0.625rem;
        line-height: 13px;
        color: rgba(0, 24, 51, 0.22);
        transform: matrix(1, 0, 0, 1, 0, 0);
        margin-bottom: .4rem;
    }
    h4 {
        font-family: 'Mulish Regular';
        font-style: normal;
        font-weight: 800;
        font-size: 16px;
        line-height: 162.7%;
        color: #324A59;
    }

    &-right {
        p {
            font-family: 'Almarai Bold';
            font-weight: bold;
            font-size: 14px;
            line-height: 140%;
            color: #C3C3C3;
        }

        h4 {
            font-family: 'Almarai Light';
            font-weight: 300;
            font-size: 14px;
            line-height: 140%;
            color: #000000;
        }

    }

}

.text {
    font-family: 'Poppins', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 22px;
    display: flex;
    align-items: center;
    margin-bottom: 3px;
    text-decoration: none;
    color: #000000;
    &-base {
        font-family: 'Poppins', sans-serif;
        font-style: normal;
        font-weight: 600;
        line-height: 22px;
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        font-size: 16px;
    }
}

</style>