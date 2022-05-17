<template>

    <div class="prestations-section">

        <div class="title-section d-flex align-items-center gap-4">
            <div class="icon">
                <Icon name="settings" />
            </div>
            <h4 class="title">Prestations</h4>
        </div>
            
        <div class="image-grid-section ml-2">
            <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                <Icon name="camera" />
                <h4 class="text-base orange">Validation Chantier / Signature</h4>
            </div>

            <div class="row m-0">
                
                <div class="col">
                    <div class="black-box" style="background: black"></div>
                </div>
            
                <div class="col d-flex gap-2 align-items-start">
                    <p class="m-0">
                        Attention grosse poutre en haut
                    </p>
                    <Icon 
                        name="plus-circle" 
                        class="mt-2 pointer" 
                        @click="generateElement('textarea', {
                            content: 'Attention grosse poutre en haut'
                        })"
                    />
                </div>
            </div>    

        </div>

    </div>

</template>

<script>
import { inject } from 'vue'
export default {
    name: 'signature-section',
    setup () {
        
        const generateElement = inject('generateElement')

        return {
            generateElement
        }
    }

}
</script>

<style lang="scss" scoped>
.prestations-section {
    margin-bottom: 4rem;
    .title-section {
        margin-top: 3rem;
        margin-bottom: 3rem;

        .icon {
            background: #ECEAFE;
            width: 3.31rem;
            height: 3.31rem;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .title {
            font-family: 'Mulish ExtraBold';
            font-style: normal;
            font-weight: 900;
            font-size: 17px;
            line-height: 21px;
            color: #000000;
            opacity: 0.5;
        }
    }
}

 .image-grid-section {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}


.image-grid-section {
    margin-top: 2.845rem;
    h4 {
        margin-bottom: 0;
    }
}

</style>