const sentBackgroundImageToShadows = (element) => {
    const backgroundImageElement = element.getElementsByClassName('item-background-image')[0]
    backgroundImageElement.classList.remove('hover')
}

const bringOutBackgroundImageFromShadows = (element) => {
    const backgroundImageElement = element.getElementsByClassName('item-background-image')[0]
    backgroundImageElement.classList.add('hover')
}

$(() => {
    const elementsWithGrayBackgroundImage = document.getElementsByClassName('item-with-background-image')
    for (let length = elementsWithGrayBackgroundImage.length, index = 0; index < length; index++) {
        try {
            const item = elementsWithGrayBackgroundImage.item(index)
            $(item).hover(() => bringOutBackgroundImageFromShadows(item), () => sentBackgroundImageToShadows(item))
            $(item).on('touchstart', () => bringOutBackgroundImageFromShadows(item))
            $(item).on('touchend', () => sentBackgroundImageToShadows(item))
        } catch (error) {
            console.warn(error)
        }
    }
})
