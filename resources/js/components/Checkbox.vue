<template>
    <div class="container">
        <div class="custom-checkboxes">
            <div class="items">
                <div
                    v-for="(item, index) in nb_checkboxes"
                    :key="index"
                    class="form-check"
                >
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        id="flexCheckDefault"
                    />
                    <label class="form-check-label" for="flexCheckDefault">
                        Default checkbox
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
export default {
    setup() {
        let nb_checkboxes = ref(5);
        return {
            nb_checkboxes,
        };
    },
};
</script>

<style scoped>
.custom-checkboxes {
    position: relative;
    width: 100%;
    text-align: left;
    outline: none;
    height: 47px;
    line-height: 47px;
}

.custom-checkboxes .items {
    color: #fff;
    border-radius: 0px 0px 6px 6px;
    overflow: hidden;
    border-right: 1px solid #ad8225;
    border-left: 1px solid #ad8225;
    border-bottom: 1px solid #ad8225;
    position: absolute;
    background-color: #eeeeee;
    left: 0;
    right: 0;
    z-index: 1;
}
</style>
