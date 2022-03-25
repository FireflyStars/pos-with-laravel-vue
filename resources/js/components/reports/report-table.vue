<template>
    <table contenteditable="true" class="table">
        <tr v-if="headers">
            <th 
                v-for="n in cols" 
                :key="n"
            >
                Title {{ n }}
            </th>
        </tr>
        <tr v-for="n in rows" :key="n">
            <td v-for="n in cols" :key="n">Col {{ n }}</td>
        </tr>
    </table>
</template>

<script>
export default {
    props: {
        headers: {
            required: false,
            type: Boolean,
            default: true,
        },
        rows: {
            required: false,
            type: [Number],
            default: 1
        },
        cols: {
            required: false,
            type: [Number],
            default: 2
        }
    }
}
</script>

<style lang="scss" scoped>
.table {
    border-collapse: collapse;
    width: 350px;
    height: 50px;
    z-index: 10000;
    word-wrap: normal;
    padding: .5rem;
}

.table, .table th, .table td {
    border: 1px solid #ccc;
}
</style>