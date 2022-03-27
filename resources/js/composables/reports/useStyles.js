
import { unref, reactive } from 'vue'
import { camelCase } from 'lodash'

const itemAttributes = reactive({
    width: '',
    heigth: '',
    fontSize: '',
    lineHeight: '',
    fontFamily: 'poppins',
    color: '',
    textAlign: 'left',
    top: 0,
    left: 0,
    transform: 0,
    zIndex: 0
})

export default function useStyles() {


    const loadDefaultStyles = (element) => {

        resetItemAttributes()

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
                    if(style == 'transform') itemAttributes[style] = value
                    else itemAttributes[style] = parsedValue
                })
            }
        }
    }

    const resetItemAttributes = () => {
        itemAttributes.width = '',
        itemAttributes.heigth = '',
        itemAttributes.fontSize = '',
        itemAttributes.lineHeight = '',
        itemAttributes.fontFamily = 'poppins',
        itemAttributes.color = '',
        itemAttributes. textAlign = 'left',
        itemAttributes.top = 0,
        itemAttributes.left = 0,
        itemAttributes.transform = 0,
        itemAttributes.zIndex = 0
    }

    const getStylesOfElement = (element) => {
        return {
            left: element.style.left,
            right: element.style.right,
            top: element.style.top,
            bottom: element.style.bottom,
            transform: element.style.transform,
            width: element.style.width,
            height: element.style.heigth,
            fontSize: element.style.fontSize,
            lineHeight: element.style.lineHeight, 
            fontFamily: element.style.fontFamily,
            color: element.style.color,
            textAlign: element.style.textAlign,
            zIndex: element.style.zIndex
        }
    }

    const getComputedStyle = (styles, elementOldStyles) => {
        styles = {
            top: styles.top ? `${styles.top}px` : elementOldStyles.top,
            left: styles.left ? `${styles.left}px` : elementOldStyles.left,
            transform: styles.transform ? styles.transform : elementOldStyles.transform,
            width: styles.width ? `${styles.width}px` : elementOldStyles.width,
            height: styles.height ? `${styles.height}px` : elementOldStyles.height,
            fontSize: styles.fontSize ? `${styles.fontSize}px` : elementOldStyles.fontSize,
            lineHeight: styles.lineHeight ? styles.lineHeight : elementOldStyles.lineHeight,
            fontFamily: styles.fontFamily ? styles.fontFamily : elementOldStyles.fontFamily,
            color: styles.color ? styles.color : elementOldStyles.color,
            textAlign: styles.textAlign ? styles.textAlign : elementOldStyles.textAlign,
            zIndex: styles.zIndex ? styles.zIndex : elementOldStyles.zIndex,
        }

        let computedStyles = ''

        Object.keys(styles).forEach(key => {
            let value = styles[key]
            if(value != undefined && value != '' && value != null) {
                computedStyles += ` ${key}: ${styles[key]} !important; `
            }
        })

        return computedStyles

    }


    return {
        itemAttributes,
        getComputedStyle,
        loadDefaultStyles,
        getStylesOfElement,
    }

}