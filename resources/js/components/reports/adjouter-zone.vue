<template>
    
    <div class="box-top-right d-flex align-items-center shadow-sm">

        <div class="row m-0">

            <div class="col">
                <div>
                    <Icon name="file" class="d-inline" />
                    <p class="d-inline orange text-base">Ajouter Titre</p>
                </div>
                <div 
                @click="generateElement('textarea')" 
                class="pointer" style="margin-top: 1rem">
                    <Icon name="file" class="d-inline" />
                    <p class="d-inline orange text-base">Ajouter Zone texts</p>
                </div>
            </div>

            <div class="col">
                
                <div class="d-flex align-items-center gap-3">
                    <Icon 
                        class="library-item"
                        name="arrow-top"
                        @click="generateElement('icon', { id: 'Icon', name: 'arrow-top' })"
                    />
                    
                    <Icon 
                        class="library-item"
                        name="egg"
                        @click="generateElement('icon', { id: 'Icon', name: 'egg' })"
                    />

                    <Icon 
                        class="library-item"
                        name="plus-o"
                        @click="generateElement('icon', { id: 'Icon', name: 'plus-o' })"
                    />

                    <p class="orange text-base">Ajouter Forme</p>
                </div>

                <BaseButton 
                    title="Ajouter Image"
                    class="image-button"
                    @click.prevent="promptImage"
                />            


            </div>

        </div>


    </div><!--  box-top-right -->

</template>

<script>
export default {

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