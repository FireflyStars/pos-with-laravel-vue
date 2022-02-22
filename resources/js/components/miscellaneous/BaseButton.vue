<template>
    <button 
        :class="[kind, ...classes.split(',')]"
        :title="$attrs.htmlTitle"
    >
        <div 
            class="text" 
            :class="[{ 'order-1': prepend }, ...textClass.split(',')]"
            :style="textStyle"
        >
            {{ title }}
        </div>

        <div class="icon" :style="iconStyle">
            <slot></slot>
        </div>
    
    </button>
</template>

<script>
    export default {
        name: "BaseButton",
        props: {
            title: {
                required: true,
                type: String
            },
            textClass: {
                type: String,
                default: ''
            },
            kind: {
                type: String,
                default: 'default' 
            },
            prepend: {
                type: Boolean,
                required: false,
                default: false
            },
            textStyle: {
                type: Object,
                default: () => {}
            },
            iconStyle: {
                type: Object,
                default: () => {}
            },
            classes: {
                type: String,
                default: ''
            }
        }
    }
</script>



<style lang="scss" scoped>
    button {
        display: flex;
        align-items:center;
        gap: 4px;
        padding: 7px 18px;
        position: relative;
        background: #ECECEC;
        border: 1px solid #47454B;
        box-sizing: border-box;
        border-radius: 4px;
        text-align: left;
        font-family: 'Almarai';
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 140%;
        transition: all .1s;
        &:hover {
            opacity: 0.9;
        }
    }
    button.danger {
        background: #FF0000;
        color: white;
    }
    button.green {
        background: #A1FA9F;
        color: #3E9A4D;
    }
    button.light-green, button.lightgreen {
        background: rgba(161, 250, 159, 0.47);
        color: rgba(0, 0, 0, 0.2);
    }
    button.primary {
        background: #1FB9FC;
        color: #fff;
    }
    button.success {
        background: #3E9A4D;
        color: white;
    }
    button.light-warning, button.lightWarning {
        background: rgba(232, 88, 27, 0.7);;
        color: white;
    }
    button.warning {
        background: #E8581B;
        color: white;
    }
    .order-1 {
        order: 1 !important;
    }
    
</style>