<template>
    <multi-select 
                                        id="multiSelect"
                                       
                                        width="116px"
                                        tagBackground="orange"
                                        tagColor="white"
                                        :numtag="1"
                                        classes="almarai_700_normal"
                                        :styles="{}" 
                                        dropdownClasses="almarai_700_normal"
                                        :dropdownStyles="{ width: '167px' }"
                                        v-model:options="options"
                                        transformOrigin="top center"
                                    />
</template>

<script>
import ItemListDatePicker from './ItemListDatePicker.vue';
import {ref} from 'vue';

export default {
    name: "ItemListDateFilter",
    components:{
        ItemListDatePicker
    },

    props:{
                name:{
                    type: String,
                    required: true
                },
                col:{
                    type:Object,
                    required:true
                }
    },
    emits: ['onDateFiltered'],
    setup(props,context){
        const options = ref([
            { id: 1, value: 'Perdu', check: false},
            { id: 2, value: 'Gagne', check: false},
            { id: 3, value: 'Abondonne', check: false},
            { id: 4, value: 'Laravel', check: false},
        ]);

        return {
          options
        }
    }
}
</script>

<style lang="scss" scoped>

</style>