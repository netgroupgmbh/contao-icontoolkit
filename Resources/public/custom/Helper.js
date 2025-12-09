"use strict";


/**
 * @since       09.12.2025 - 08:44
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

class Helper {

    /**
     * Array mit den ausgeblendeten Icons.
     * @type {[]}
     * @private
     */
    _hidden = [];


    /**
     * Setzt die Liste der versteckten Icons zurück.
     */
    clearHidden() {
        this._hidden = []
    }


    /**
     * Entfernt die Klasse hidden
     */
    removeHidden() {
        for (const icon of this._hidden) {
            const icoElem   = this.getElem(icon)
            const index     = this._hidden.indexOf(icon)

            if (undefined !== icoElem) {
                icoElem.classList.remove('hidden')
            }

            if (index > -1) {
                this._hidden.splice(index, 1)
            }
        }
    }


    /**
     * Setzt die Klasse hidden
     * @param icon
     */
    setHidden(icon) {
        if (false === this._hidden.includes(icon)) {
            const icoElem = this.getElem(icon)

            if (null !== icoElem) {
                icoElem.classList.add('hidden')

                if (false === this._hidden.includes(icon)) {
                    this._hidden.push(icon)
                }
            }
        }
    }


    /**
     * Scrollt zu einem Icon
     * @param icoElem
     */
    scrollToIcon(icoElem) {
        if (icoElem.classList.contains('selected')) {
            icoElem.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            })
        }
    }


    /**
     * Scrollt zum ersten Element der Liste
     * @param fieldname
     */
    scrollToTop(fieldname) {
        const elemList      = document.getElementById('ng_iconpicker_list_' + fieldname)
        const iconsOfList   = elemList.querySelectorAll('li')

        if (iconsOfList[0]) {
            iconsOfList[0].parentNode.scrollTo({
                behavior: 'smooth',
                top: 0
            })
        }
    }


    /**
     * Gibt das Element eines Icons zurück.
     * @param icon
     * @returns {HTMLElement}
     */
    getElem(icon) {
        if (icon) {
            return document.getElementById(icon.replace(' ', '_'))
        }

        return null
    }
}
