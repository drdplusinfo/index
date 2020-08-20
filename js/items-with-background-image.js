/**
 * @param {HTMLElement} element
 */
const moveBackgroundImageToLowerLayer = (element) => {
    const originalBackgroundImage = jQuery(element).css("background-image")
    if (!originalBackgroundImage) {
        throw new Error(`No background image for an element: '${element}'`)
    }
    const originalBackgroundSize = jQuery(element).css("background-size")
    const originalBackgroundRepeat = jQuery(element).css("background-repeat")
    const originalBackgroundPosition = jQuery(element).css("background-position")

    const blogBackgroundContainer = document.createElement('div')
    blogBackgroundContainer.className = 'item-background-image'
    blogBackgroundContainer.style.backgroundImage = originalBackgroundImage
    blogBackgroundContainer.style.backgroundSize = originalBackgroundSize
    blogBackgroundContainer.style.backgroundRepeat = originalBackgroundRepeat
    blogBackgroundContainer.style.backgroundPosition = originalBackgroundPosition
    element.prepend(blogBackgroundContainer)
}

const sentBackgroundImageToShadows = (element) => {
    const backgroundImageElement = element.getElementsByClassName('item-background-image')[0]
    backgroundImageElement.style.opacity = '40%'
    backgroundImageElement.style.filter = 'grayscale(100)'
    backgroundImageElement.style.zIndex = '-1'
    element.style.backgroundImage = 'none'
    element.style.filter = 'none'
    element.style.opacity = '100%'
}

const bringOutBackgroundImageFromShadows = (element) => {
    const backgroundImageElement = element.getElementsByClassName('item-background-image')[0]
    backgroundImageElement.style.opacity = '0%'
    element.style.backgroundImage = backgroundImageElement.style.backgroundImage
}

$(() => {
    const elementsWithGrayBackgroundImage = document.getElementsByClassName('item-with-background-image')
    for (let length = elementsWithGrayBackgroundImage.length, index = 0; index < length; index++) {
        try {
            const item = elementsWithGrayBackgroundImage.item(index)
            moveBackgroundImageToLowerLayer(item)
            sentBackgroundImageToShadows(item)
            $(item).hover(() => bringOutBackgroundImageFromShadows(item), () => sentBackgroundImageToShadows(item))
            $(item).on('touchstart', () => bringOutBackgroundImageFromShadows(item))
            $(item).on('touchend', () => sentBackgroundImageToShadows(item))
        } catch (error) {
            console.warn(error)
        }
    }
    const event = new Event('ItemsHaveBackgroundImagesInShadows')
    window.dispatchEvent(event)
})
