<template>
    
    <div class="box-top-right d-flex align-items-center shadow-sm">

        <div class="row m-0">

            <div class="col-5" >
                <div 
                class="pointer" 
                @click="generateElement('textarea', { 
                    class: 'title-bar',
                    content: `VUE D'ENSEMBLE DUE BATIMENT`
                 })">
                    <Icon name="file" class="d-inline" />
                    <p class="d-inline orange text-base" style="margin-left: .7rem;">Ajouter Titre</p>
                </div>
                <div 
                @click="generateElement('textarea')" 
                class="pointer" style="margin-top: 1rem">
                    <Icon name="file" class="d-inline" />
                    <p class="d-inline orange text-base" style="margin-left: .7rem;">Ajouter Zone texts</p>
                </div>
            </div>

            <div class="col-7">
                
                <div class="d-flex align-items-center gap-6">
                    <Icon 
                        class="library-item"
                        name="arrow-top"
                        height="20"
                        @click="generateElement('icon', { id: 'Icon', name: 'arrow-top' })"
                    />
                    
                    <Icon 
                        class="library-item"
                        name="egg"
                        height="20"
                        @click="generateElement('icon', { id: 'Icon', name: 'egg' })"
                    />

                    <Icon 
                        class="library-item"
                        name="plus-o"
                        height="20"
                        @click="generateElement('icon', { id: 'Icon', name: 'plus-o' })"
                    />

                    <Icon 
                        class="library-item flex-grow"
                        name="grid"
                        height="20"
                        @click="generateElement('icon', { id: 'Icon', name: 'grid' })"
                    />

                    <p class="orange text-base self-end">Ajouter Forme</p>
                </div>

                <div class="d-flex align-items-center">
                    
                    <BaseButton 
                        title="Ajouter Image"
                        class="image-button"
                        @click.prevent="promptImage"
                    />

                    <BaseButton 
                        title="Bank Image"
                        class="image-button"
                    />            

                </div>



            </div>

        </div>


    </div><!--  box-top-right -->

</template>

<script>
export default {
    name: 'adjouter-zone',
    emits: ['generateElement', 'promptImage'],

    setup (_, { emit }) {
        
        const generateElement = (name, attributes) => {
            emit('generateElement', name, attributes)
        }

        const promptImage = () => {
            emit('promptImage')
        }

        return {
            promptImage,
            generateElement
        }
    }
}
</script>

<style lang="scss" scoped>
.box-top-right {
    background: #fff;
    padding: 1rem;
    .image-button {
        background: rgba(168, 168, 168, 0.25);
        border-radius: 10px;
        border: 1px solid rgba(168, 168, 168, 0.25) !important;
        padding: 0;
        width: 8.75rem;
        height: 2.03rem;
        display: flex;
        place-content: center;
        margin: 1.6rem .3rem;
    }    
}
.text {
    font-family: Poppins;
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
        font-family: Poppins;
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