import Icon from '../components/miscellaneous/Icon'
import CheckBox from '../components/miscellaneous/CheckBox'
import BaseButton from '../components/miscellaneous/BaseButton'
import SelectBox from '../components/miscellaneous/SelectBox'
import Dropdown from '../components/miscellaneous/Dropdown/Index'
import Modal from '../components/miscellaneous/Modal'

export default function globalComponents(app) {
    app.component('Icon', Icon)
    app.component('CheckBox', CheckBox)
    app.component('BaseButton', BaseButton)
    app.component('SelectBox', SelectBox)
    app.component('Dropdown', Dropdown)
    app.component('Modal', Modal)
}