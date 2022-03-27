<template>
    <table contenteditable="true" class="table">
        <tr v-if="headers">
            <th 
                v-for="col in cols" 
                :key="col"
            >
                <template v-if="dom == 'input'">
                    <input
                        :disabled="disabled" 
                        type="text" 
                        :value="getRowValue(1, col, 'header')" 
                        @input="update({ type: 'header', col, row: 1, value: $event.target.value })"
                    >
                </template>
                <template v-else>
                    <div> {{ getRowValue(1, col, 'header') }} </div>
                </template>
            </th>
        </tr>
        <tr v-for="row in rows" :key="row">
            <td v-for="col in cols" :key="col">
                <template v-if="dom == 'input'">
                    <input 
                        :disabled="disabled" 
                        type="text" 
                        :value="getRowValue(row, col, 'body')" 
                        @input="update({ type: 'body', col, row, value: $event.target.value })"
                    >
                </template>
                <template v-else>
                    <div> {{ getRowValue(1, col, 'body') }} </div>
                </template>
            </td>
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
        },
        content: {
            required: true,
            type: Object
        },
        disabled: {
            required: false,
            type: Boolean,
            default: false,
        },
        dom: {
            required: false,
            type: String,
            default: 'div'
        }
    },

    emits: ['update'],
    
    setup(props, { emit }) {

        const getRowValue = (row, col, type) => {
            const content = props.content[type][`tr-${row}${col}`]
            if(content == undefined) {
                return type == 'header' ? 'Title ' + col : 'Col ' + col
            }
            return content
        }

        const update = (data) => {
            emit('update', data)
        }

        return {
            update,
            getRowValue,
        }

    }

}

</script>

<style lang="scss" scoped>
.table {
    border-collapse: collapse;
    width: 350px;
    min-height: 50px;
    z-index: 10000;
    word-wrap: normal;
    input {
        &, 
        &:focus {
            border: 0;
            outline: 0;
            width: 100%;
            height: 100%;
            box-shadow: border-box;
        }
        &:disabled {
            background: #dddddd;
        }
    }
}

.table, .table th, .table td {
    border: 1px solid #ccc;
}
</style>