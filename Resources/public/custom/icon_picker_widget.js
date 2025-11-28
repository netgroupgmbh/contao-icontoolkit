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
        const icosOfList = icoList.querySelectorAll('li')

        for (const ico of icosOfList) {
            if (ico.classList.contains('selected')) {
                ico.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                })
            }

            ico.addEventListener('click', (event) => {
                const icosOfList = icoList.querySelectorAll('li')

                for (const ico of icosOfList) {
                    ico.classList.remove('selected')
                }

                document.getElementById('ctrl_' + fieldname).value = ico.dataset.value
                ico.classList.add('selected')
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
        const searchField   = document.getElementById('ctrl_' + fieldname)
        const listElem      = icoList.querySelectorAll('ul')

        if (undefined !== searchField) {
            searchField.addEventListener('input', (event) => {
                const icosOfList = icoList.querySelectorAll('li')
                const searchTerm = searchField.value.toLowerCase()

                if (searchTerm.length > 0) {

                    for (const ico of icosOfList) {
                        if (false === ico.dataset.value.toLowerCase().includes(searchTerm)) {
                            ico.classList.add('hidden')
                        } else {
                            ico.classList.remove('hidden')
                        }

                        this._scroll(ico)
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