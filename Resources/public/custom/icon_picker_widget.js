'use strict';

/**
 * @since       23.11.2025 - 09:13
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */
class IconPcikerWidget {


    /**
     * Liest die Icons aus und speichert die Auswahl
     * @private
     */
    initialize(fieldname, listElem) {
        const helper            = new Helper()
        const selectionHandler  = new SelectionHandler(helper, fieldname)
        const searchHandler     = new SearchHandler(selectionHandler, helper)
        const styleHandler      = new StyleHandler(selectionHandler, searchHandler, helper)

        const iconsOfList       = listElem.querySelectorAll('li')
        let icons               = []
        let selected            = ''

        for (const icoElem of iconsOfList) {
            icons.push(icoElem.dataset.value)

            if (icoElem.classList.contains('selected')) {
                selected = icoElem.dataset.value
            }
        }

        selectionHandler.initializeSelection(icons, selected)
        searchHandler.initializeSearch(fieldname, icons)
        styleHandler.initializeStyle(fieldname, icons)

        if (selected) {
            const icoElem = helper.getElem(selected)
            helper.scrollToIcon(icoElem)
        }
    }
}



/**
 * Widgets initialisieren
 */
document.addEventListener('DOMContentLoaded', function(event) {
    const iconLists = document.querySelectorAll('.ng_iconpicker_list')

    for (const icoList of iconLists) {
        const fieldname = icoList.dataset.fieldname

        if (undefined !== fieldname) {
            const ipw = new IconPcikerWidget()
            ipw.initialize(fieldname, icoList)
        }
    }
})