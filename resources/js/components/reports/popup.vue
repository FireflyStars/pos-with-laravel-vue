<template>
    <div class="popup">
        <span @click.prevent="close" class="close">&times;</span>
        <div class="popup-header">
            <h5 class="h5">Update Zone</h5>
        </div>
        <div class="popup-body">
            <form @submit.prevent="submit">

                <div class="popup-body-item">
                    
                    <p class="label h6">Item:</p>

                    <div class="item">

                        <div class="d-flex align-items-center gap-2" v-if="isTextarea">
                            
                            <div>
                                <label for="">Size</label>
                                <select @change="commitAction('fontsize', $event.target.value)">
                                    <option class="heading" selected>- size -</option>
                                    <option value="1">Very small</option>
                                    <option value="2">A bit small</option>
                                    <option value="3">Normal</option>
                                    <option value="4">Medium-large</option>
                                    <option value="5">Big</option>
                                    <option value="6">Very big</option>
                                    <option value="7">Maximum</option>
                                </select>
                            </div>

                            <div>
                                <label for="">Color</label>
                                <input 
                                    type="color" 
                                    @change="commitAction('forecolor', $event.target.value)"
                                    title="color"
                                >
                            </div>
                            
                            <div>
                                <label for="">Background</label>
                                <input 
                                    type="color" 
                                    @change="commitAction('backcolor', $event.target.value)"
                                    title="Background color"
                                >
                            </div>

                        </div>
                        
                        <div class="display-block" v-if="isTextarea" >
                            <Icon
                                v-for="action in actions"
                                :key="action"
                                :name="action"
                                @click.prevent="action == 'blockquote' ? commitAction('formatblock', action) : commitAction(action)"
                                :title="action"
                            />
                        </div>

                        <component 
                            :is="isTextarea ? 'div' : item.item"
                            :class="[item.attributes?.class, { 'editable': isTextarea }]"
                            :src="item.attributes?.src"
                            :name="item.attributes?.name"
                            :contenteditable="isTextarea"
                        >
                            <p v-html="textValue" v-if="isTextarea"></p>
                        </component>
                    </div>

                </div>

                <div class="popup-body-attributes">
                    <div class="attribute">
                        <div>Width:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.width">
                            <span class="unit">px</span>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Height:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.heigth">
                            <span class="unit">px</span>
                        </div>
                    </div>
                
                    <div class="attribute">
                        <div>Top:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.top">
                            <span class="unit">px</span>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Left:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.left">
                            <span class="unit">px</span>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Font size:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.fontSize">
                            <span class="unit">px</span>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Line heigth:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" v-model="itemAttributes.lineHeight">
                            <span class="unit"></span>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Font family:</div>
                        <div class="d-flex align-items-center gap-1">
                            <select name="font_family" v-model="itemAttributes.fontFamily">
                                <option value="times">Times</option>
                                <option value="mullish">Mullish</option>
                                <option value="poppins">Poppins</option>
                            </select>
                        </div>
                    </div>
                    <div class="attribute" v-if="!isTextarea">
                        <div>Color:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="color" name="color" v-model="itemAttributes.color" style="width: 5rem">
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Text align:</div>
                        <div class="d-flex align-items-center gap-1">
                            <select name="text_align" v-model="itemAttributes.textAlign">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                                <option value="center">Center</option>
                            </select>
                        </div>
                    </div>
                    <div class="attribute">
                        <div>Z-index:</div>
                        <div class="d-flex align-items-center gap-1">
                            <input type="text" name="zindex" v-model="itemAttributes.zIndex">
                        </div>
                    </div>
                </div>

                <base-button title="Update" class="float-end mt-2" />
                <div class="clearfix"></div>    

            </form>

        </div>
    </div>
</template>

<script>

import { ref, computed, onMounted } from 'vue'
import useStyles from '../../composables/reports/useStyles'


export default {

    props: {
        item: {
            required: true,
            type: [Object, Array]
        }
    },

    emits: ['close', 'update'],
    
    setup (props, { emit }) {

        const { itemAttributes, loadDefaultStyles } = useStyles()
        const textValue = ref('')
        const actions = [
            'brush', 
            'undo', 
            'redo', 
            'foramtting', 
            'bold', 
            'italic', 
            'underline', 
            'justifyleft', 
            'justifycenter', 
            'justifyright',
            'insertorderedlist',
            'insertunorderedlist',
            'blockquote',
            'outdent',
            'indent',
            'cut',
            'copy',
            'paste',
        ]

        const isTextarea = computed(() => props.item.name == 'textarea')

        const close = () => {
            emit('close')
        }

        const submit = () => {
            emit('update', { 
                id: props.item.attributes.id, 
                textValue: isTextarea.value ? document.querySelector('.editable').innerHTML : ''
            })
        }

        const loadDefaultValue = () => {
            if(props.item.name == 'textarea' && props.item.content != '') {
                textValue.value = props.item.content 
            }
        }

        const commitAction = (sCmd, sValue) => {
            document.execCommand(sCmd, false, sValue)
            document.querySelector('.editable').focus()
        }

        onMounted(() => {
            loadDefaultStyles(props.item)
            loadDefaultValue()
        })

        return {
            close,
            submit,
            actions,
            textValue,
            isTextarea,
            commitAction,
            itemAttributes
        }

    }

}
</script>

<style lang="scss" scoped>
.popup {
    background: #E5E5E5;
    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%) !important;
    z-index: 999999;
    width: 22rem;
    min-height: 25rem;
    font-family: Mullish, sans-serif;
    position: relative;
    .close {
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        position: absolute;
        top: -0.4rem;
        right: -0.4rem;
        padding: 0;
        margin: 0;
        background: #000;
        border: 3px solid #fff;
        border-radius: 50%;
        width: 1.7rem;
        height: 1.7rem;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        &:hover {
            opacity: .8;
        }
    }
    &-header {
        padding: 1rem;
    }
    &-body {
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
        img {
            width: 90%;
            height: 100%;
        }
        &-item {
            display: grid;
            align-content: center;
            grid-template-columns: 15% 85%;
            gap: 1rem;
            border-bottom: 1px solid #ccc;
            margin: 0 0 1rem 0;
            padding-bottom: .5rem;
            .item {
                flex-grow: 1;
                label {
                    font-size: 9px;
                }
            }
            .editable {
                width: 95%;
                height: 6rem;
                background: white;
                overflow: auto;
                p {
                    margin: 0;
                }
            }
        }
        &-attributes {
            .attribute {
                display: grid;
                justify-items: flex-start;
                align-content: center;
                grid-template-columns: 15% 85%;
                gap: 1rem;
                margin: .4rem 0;
                .unit {
                    font-size: 12px;
                } 
            }
        }
    }
    textarea {
        height: 4rem;
        width: 95%;
        resize: none;
    }
    .attribute input {
        box-sizing: border-box;
        width: 30%;
    }
    select {
        width: 100%;
    }
}
</style>