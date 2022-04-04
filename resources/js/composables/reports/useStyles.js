
import { unref, reactive, computed } from 'vue'
import { camelCase, isEmpty } from 'lodash'

const itemAttributes = reactive({
    width: '',
    height: '',
    fontSize: '',
    // lineHeight: '',
    fontFamily: 'poppins',
    color: '',
    textAlign: 'left',
    top: 0,
    left: 0,
    transform: 0,
    zIndex: 0,
    borderColor: '',
    borderWidth: 0,
    borderStyle: 'solid'
})

export default function useStyles() {


    const loadDefaultStyles = (element, domStyles) => {
        
        resetItemAttributes()

        const item = unref(element)
        let styles = item.attributes?.style

        if(styles) {

            styles = styles.split(';')

            if(styles.length) {

                let trimmedStyles = styles.map(style => style.trim().split(':')).filter(n => n != '')

                trimmedStyles.forEach(( [ style, value ] ) => {

                    style = camelCase(style).replace(/ /g, '')
                    
                    itemAttributes[style] = getComputedAttributeValue(style, value)

                })

            }

            // for(let attribute in itemAttributes) {
            //    if(itemAttributes[attribute] == '') {
            //         itemAttributes[attribute] = getComputedAttributeValue(attribute, oldStyles[attribute])
            //    }
            // }


        }
    }

    const getComputedAttributeValue = (style, value) => {
        let parsedValue = value == '' ? value : parseInt(value)
        parsedValue =  isNaN(parsedValue) ? value : parsedValue
        
        if(typeof parsedValue == 'string') {
            if(parsedValue.indexOf('!important') != -1) {
                parsedValue = parsedValue.replace(/!important/ig, '').trim()
            }
            if(parsedValue.indexOf('"') != -1) {
                parsedValue = parsedValue.replace(/"/ig, '').trim()
            }
            if(style == 'textAlign') {
                if(parsedValue == 'start') parsedValue == 'left'
                if(parsedValue == 'end') parsedValue == 'right'
            }
        }
        return parsedValue
    }


    const resetItemAttributes = () => {
        itemAttributes.width = '',
        itemAttributes.height = '',
        itemAttributes.fontSize = '',
        // itemAttributes.lineHeight = '',
        itemAttributes.fontFamily = 'poppins',
        itemAttributes.color = '',
        itemAttributes.textAlign = 'left',
        itemAttributes.top = 0,
        itemAttributes.left = 0,
        itemAttributes.transform = 0,
        itemAttributes.zIndex = 0,
        itemAttributes.borderColor = '',
        itemAttributes.borderWidth = 0,
        itemAttributes.borderStyle = 'solid'
    }

    const getStylesOfElement = (element) => {
        
        const computedStyles = window.getComputedStyle(element)

        return {
            left: element.style.left,
            right: element.style.right,
            top: element.style.top,
            bottom: element.style.bottom,
            transform: element.style.transform,
            width: element.clientWidth,
            height: element.clientHeight,
            fontSize: computedStyles.fontSize,
            // lineHeight: computedStyles.lineHeight, 
            fontFamily: computedStyles.fontFamily,
            color: computedStyles.color,
            textAlign: computedStyles.textAlign,
            zIndex: computedStyles.zIndex,
            borderColor: computedStyles.borderColor,
            borderWidth: computedStyles.borderWidth,
            borderStyle: computedStyles.borderStyle,
        }

    }

    const getComputedStyle = (styles, elementOldStyles, item = '') => {
        
        styles = {
            top: styles.top ? `${styles.top}px` : elementOldStyles.top,
            left: styles.left ? `${styles.left}px` : elementOldStyles.left,
            transform: styles.transform ? styles.transform : elementOldStyles.transform,
            width: styles.width ? `${styles.width}px` : elementOldStyles.width,
            height: styles.height ? `${styles.height}px` : elementOldStyles.height,
            fontSize: styles.fontSize ? `${styles.fontSize}px` : elementOldStyles.fontSize,
            // lineHeight: styles.lineHeight ? styles.lineHeight : elementOldStyles.lineHeight,
            fontFamily: styles.fontFamily ? styles.fontFamily : elementOldStyles.fontFamily,
            color: styles.color ? styles.color : elementOldStyles.color,
            textAlign: styles.textAlign ? styles.textAlign : elementOldStyles.textAlign,
            zIndex: styles.zIndex ? styles.zIndex : elementOldStyles.zIndex,
            borderColor: styles.borderColor ? styles.borderColor : elementOldStyles.borderColor,
            borderStyle: styles.borderStyle ? styles.borderStyle : elementOldStyles.borderStyle,
            borderWidth: styles.borderWidth ? `${styles.borderWidth}px` : elementOldStyles.borderWidth,
        }

        if(item == 'table') delete styles.lineHeight

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