import MainHeader from '../components/layout/MainHeader';
import SideBar from '../components/layout/SideBar';
import BreadCrumb from '../components/layout/BreadCrumb';
import Icon from '../components/miscellaneous/Icon'
import CheckBox from '../components/miscellaneous/CheckBox'
import BaseButton from '../components/miscellaneous/BaseButton'
import SelectBox from '../components/miscellaneous/SelectBox'
import Dropdown from '../components/miscellaneous/Dropdown'
import Modal from '../components/miscellaneous/Modal'
import MultiSelect from "../components/miscellaneous/MultiSelect.vue"

export default function globalComponents(app) {
    app.component('MultiSelect', MultiSelect)
    app.component('MainHeader', MainHeader)
    app.component('SideBar', SideBar)
    app.component('BreadCrumb', BreadCrumb)
    app.component('Icon', Icon)
    app.component('CheckBox', CheckBox)
    app.component('BaseButton', BaseButton)
    app.component('SelectBox', SelectBox)
    app.component('Dropdown', Dropdown)
    app.component('Modal', Modal)
}