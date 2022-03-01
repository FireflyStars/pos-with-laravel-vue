
import { unref, reactive } from 'vue'
import { camelCase } from 'lodash'

const itemAttributes = reactive({
    width: '',
    heigth: '',
    fontSize: '',
    lineHeight: '',
    fontFamily: 'poppins',
    color: '#fff',
    textAlign: 'left',
    top: 0,
    left: 0,
    transform: 0
})

export default function useStyles() {


    const loadDefaultStyles = (element) => {
        const item = unref(element)
        let styles = item?.attributes?.style
        if(styles) {
            styles = styles.split(';')
            if(styles.length) {
                let trimmedStyles = styles.map(style => style.split(':'))
                trimmedStyles.forEach(( [ style, value ] ) => {
                    style = camelCase(style).replace(/ /g, '')
                    let parsedValue = value == '' ? '' : parseInt(value)
                    parsedValue =  isNaN(parsedValue) ? '' : parsedValue
                    console.log(style)
                    if(style == 'transform') itemAttributes[style] = value
                    else itemAttributes[style] = parsedValue
                })
            }
        }
    }


    return {
        itemAttributes,
        loadDefaultStyles
    }

}