<template>
    <div 
    @click.prevent="togglechkbox"
     class="chkbox_wrap">
        <span class="chkbox" :class="{ 'checked': checked }"></span>
        <label class="noselect body_regular">{{ title }}</label>
     </div>
</template>

<script>

export default {
    
    name: "CheckBox",

    props: {
        id: [String, Number],
        checked: Boolean,
        name: String,
        title: String
    },

    emits: ['changed'],

    setup(props, { emit }) { 

        const togglechkbox = () => {
            const check = !props.checked
            emit('changed', { value: check, id: props.id, name: props.name })
        }
        
        return {
            togglechkbox
        }
    }
}

</script>

<style scoped>
    span.chkbox{
        width: 20px;
        height: 20px;
        display: inline-block;
        position: relative;
        border: #868686 2px solid;
    }
    span.chkbox.checked{
        background: #47454B;
        border:none;
    }
    span.chkbox:after{
      opacity: 0;
        position: absolute;
        content: " ";
        left: 6px;
        top: 2px;
        width: 8px;
        height: 13px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    span.chkbox.checked:after{

        opacity: 1;
        transition: opacity 0.3s ease-out;
        -webkit-transition: opacity 0.3s ease-out;
        -moz-transition:  opacity 0.3s ease-out;
    }
    .filters span.chkbox,thead span.chkbox,header span.chkbox{
        border:#868686 2px solid;
    }
    .filters span.chkbox.checked,header span.chkbox.checked{
        background: #47454B;
        border:none;
    }
    .chkbox_wrap {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: .3rem 0;
    }
    .filters span.chkbox{
        margin: 14px 22px 14px 22px;
    }
    .filters .chkbox_wrap{
    display: flex;
    }
    .filters .chkbox_wrap label{
        margin: 14px 22px 14px 0;
        font-weight: lighter;
    }
</style>