<template>
    <!-- <div class="container">
        <h1>Custom Vue.js Select Component</h1>
        <CustomSelect
            :options="['go', 'python', 'rust', 'javascript']"
            :default="'go'"
            class="select"
            @input="message($event)"
        />
    </div> -->
    <div class="text-end">
        <filter-button />
    </div>
</template>

<script>
import Checkbox from "../components/Checkbox.vue";
import CustomSelect from "../components/Select.vue";
import FilterButton from "../components/FilterButton.vue";
export default {
    components: {
        CustomSelect,
        Checkbox,
        FilterButton,
    },
    setup() {
        function message(event) {
            // alert(event);
        }
        return {
            message,
        };
    },
};
</script>

<style lang="scss"></style>
