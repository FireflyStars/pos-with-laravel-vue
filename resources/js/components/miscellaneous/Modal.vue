
<template>

    <div 
        :id="id"
        class="popup"
        :class="{ 'popup__show': isOpenModal(id) || open }" 
    >
        <div 
            class="popup-inner" 
            :class="['popup-inner' + sizeClasses, classes]"
        >
            <!-- <div 
                class="popup__text"
                :class="'popup__text' + sizeClasses"
            > -->
                <slot></slot>
            <!-- </div>  -->
            <a 
                class="popup__close" 
                href="#" 
                @click.prevent="toggleModal(id, false)"
            >
                &times;
            </a>
        </div>
    </div>

</template>

<script>

import { computed } from 'vue'
import useModal from '../../composables/useModal'
import useKeydown from '../../composables/useKeydown'

export default {
    
    inheritAttrs: false,

    props: {
        open: {
            required: false,
            type: Boolean,
            default: false
        },
        backdrop: {
            type: Boolean,
            default: true
        },
        id: {
            required: true,
            type: String
        },
        size: {
            required: false,
            type: String,
            default: 'sm',
            validator(value) {
                return ['sm', 'md', 'lg'].includes(value)
            }
        },
        classes: {
            required: false,
            type: String,
            default: ''
        }
    },

    setup(props) {

        const { toggleModal, isOpenModal, modalConfig } = useModal()

        if(props.backdrop) {
            useKeydown([{ key: 'Escape', fn: () => toggleModal(props.id, false) }])
        }

        const sizeClasses = computed(() => {
            switch(props.size) {
                case 'lg': return '__lg'
                case 'sm': return '__sm'
                default: return ''
            }
        })
        
        return {
            toggleModal,
            isOpenModal,
            sizeClasses,
            modalConfig
        }

    }

}
</script>

<style scoped lang="scss">

@import url('https://fonts.googleapis.com/css?family=Raleway:300,400,600&subset=latin-ext');

$main-color: #9191E9;

.button {
  text-decoration: none;
  font-size: .875rem;
  font-weight: 300;
  text-transform: uppercase;
  display: inline-block;
  border-radius: 1.5rem;
  background-color: #fff;
  color: $main-color;
  padding: 1rem 2rem;
}

.popup {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  width: 100vw;
  height: 100vh;
  bottom: 0;
  right: 0;
  background-color: rgba(0, 0, 0, .80);
  z-index: 2;
  visibility: hidden;
  opacity: 0;
  overflow: hiden;
  transition: .64s ease-in-out;
  &-inner {
    position: relative;
    bottom: -100vw;
    right: -100vh;
    max-width: 700px;
    max-height: 500px;
    width: 100%;
    height: 100%;
    background-color: #fff;
    transform: rotate(32deg);
    transition: .64s ease-in-out;
    &__lg {
        max-width: 1000px;
        max-height: 600px;
    }
    &__sm {
        max-width: 450px;
        max-height: 250px;
    }
  }
  &__text {
    height: 100%;
    padding: 3rem;

    &__lg {
        padding: 4rem;
    }

    &__sm {
        padding: 1rem;
    }

    h1 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 2rem;
      text-transform: uppercase;
      color: #0A0A0A;
    }
    p {
      font-size: .875rem;
      color: #686868;
      line-height: 1.5;
    }
  }
  &__show {
    visibility: visible;
    opacity: 1;
    .popup-inner {
      bottom: 0;
      right: 0;
      transform: rotate(0);
    }
  }
  &__close {
    position: absolute;
    right: -.5rem;
    top: -.5rem;
    width: 1.5rem;
    height: 1.5rem;
    font-size: .875rem;
    font-weight: 300;
    border-radius: 100%;
    background-color: #0A0A0A;
    z-index: 4;
    color: #fff;
    line-height: 1.5rem;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
  }
}
</style>