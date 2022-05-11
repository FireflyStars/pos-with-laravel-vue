<template>
    <div 
        :class="getCategoryClassName(category)" 
        v-for="(gedDetail, category) in orderOuvrages" 
        :key="category"
    >

        <template v-if="Object.entries(gedDetail).length">
            
            <div class="title-section d-flex align-items-center gap-4" style="margin-bottom: 1.31rem">
                <div class="icon">
                    <Icon name="marker" />
                </div>
                <h4 class="title">{{ category }}</h4>
            </div>

            <div 
            :class="getCategoryClassName(category) + '-content'">
                
                <h4 class="text-base orange main-title">{{ gedDetail.name }}</h4>

                <div class="main-body row m-0">
                    
                    <h4 
                    class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                    style="margin-bottom: .56rem">
                        Avant
                    </h4>

                    <div class="col-12"></div>

                    <div class="d-flex gap-2 col">
                        <ged-detail-files :gedDetail="gedDetail" />
                    </div> 

                </div>

                <div class="main-body row mx-0" style="margin-top: 1.75rem">
                    
                    <h4 
                    class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                    style="margin-bottom: .56rem">
                        apres
                    </h4>

                    <div class="col-12"></div>

                    <div class="d-flex gap-2 col">
                        <ged-detail-files :gedDetail="gedDetail" />
                    </div> 

                </div>
                
            </div>

        </template>

    </div>
</template>

<script>

import gedDetailFiles from './ged-detail-files.vue'

export default {
    name: 'order-ouvrage',
    components: {
        gedDetailFiles
    },

    props: {
        orderOuvrages: {
            required: true,
            type: [Array, Object]
        }
    },

    setup () {
        
        const getCategoryClassName = (category) => {
            const categories = {
                installation: 'installation',
                securite: 'security',
                prestation: 'prestation'
            }
            return category !='' ? `${categories[category.toLowerCase()]}-section` : ''
        }

        return {
            getCategoryClassName,
        }

    }

}
</script>

<style lang="scss" scoped>

.installation-section-content, 
.security-section-content {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.installation-section, .security-section {
    margin-top: 2.875rem;
    .title-section {
        .icon {
            background: #FFF0E6;
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

    &-content {
        
        margin-top: 2.03rem;
        .main-body {
            margin-top: 1.125rem;
        }

    }

}

.security-section {
    .title-section {
        .icon {
            background: #ECEAFE;
        }
        .title {
            font-weight: 900;
            font-family: 'Mullish ExtraBold', sans-serif;
        }
    }
}

.black-box {
    border-radius: 8px;
    width: 3.43rem !important;
    height: 3.43rem !important;
    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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