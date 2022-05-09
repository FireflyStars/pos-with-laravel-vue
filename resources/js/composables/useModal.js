import { reactive } from 'vue'

const modalConfig = reactive({
    id: '',
    state: false
})

export default function useModal() {
        
    const toggleModal = (id, close = true) => {
        if(close == false) { 
            modalConfig.state = false
            return
        }
        modalConfig.id = id
        modalConfig.state = !modalConfig.state
    }

    const isOpenModal = (id) => {
        return id.toLowerCase() === modalConfig.id.toLowerCase() && modalConfig.state === true
    }
    
    return {
        modalConfig,
        toggleModal,
        isOpenModal
    }

}