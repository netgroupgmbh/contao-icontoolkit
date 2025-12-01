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

class IconPickerWidget {


    /**
     * Initialisiert die Widgets
     * @param selector
     */
    initialize(selector) {
        const iconLists = document.querySelectorAll(selector)

        for (const icoList of iconLists) {
            const fieldname = icoList.dataset.fieldname

            if (undefined !== fieldname) {
                this._initializeList(icoList, fieldname)
                this._initializeSearch(icoList, fieldname)
            }
        }
    }


    /**
     * Initialisiert die Liste.
     *
     * @param icoList
     * @param fieldname
     * @private
     */
    _initializeList(icoList, fieldname) {
        const iconsOfList = icoList.querySelectorAll('li')

        for (const icon of iconsOfList) {
            if (icon.classList.contains('selected')) {
                icon.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                })
            }

            icon.addEventListener('click', (event) => {
                const iconsOfList = icoList.querySelectorAll('li')

                for (const ico of iconsOfList) {
                    ico.classList.remove('selected')
                }

                document.getElementById('ctrl_' + fieldname).value = icon.dataset.value
                icon.classList.add('selected')
            })
        }
    }


    /**
     * Initialisiert die Suche
     *
     * @param icoList
     * @param fieldname
     * @private
     */
    _initializeSearch(icoList, fieldname) {
        const searchField = document.getElementById('ctrl_' + fieldname)

        if (undefined !== searchField) {
            searchField.addEventListener('input', (event) => {
                const iconsOfList = icoList.querySelectorAll('li')
                const searchTerm = searchField.value.toLowerCase()

                if (searchTerm.length > 0) {

                    for (const icon of iconsOfList) {
                        icon.classList.remove('selected')

                        if (false === icon.dataset.value.toLowerCase().includes(searchTerm)) {
                            icon.classList.add('hidden')
                        } else {
                            icon.classList.remove('hidden')
                        }

                        this._scroll(icon)
                    }
                }
            })
        }
    }


    /**
     * Scrollt zum ausgewählen Element oder nach oben in der Liste.
     *
     * @param ico
     * @private
     */
    _scroll(ico) {
        if (ico.classList.contains('selected')) {
            ico.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            })
        } else {
            ico.parentNode.scrollTo({
                behavior: 'smooth',
                top: 0
            })
        }
    }
}


/**
 * Widgets initialisieren
 */
document.addEventListener('DOMContentLoaded', function(event) {
    const ipw = new IconPickerWidget()
    ipw.initialize('.ng_iconpicker_list')
})