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

class SelectionHandler {


    /**
     * Feldname aus dem DCA
     * @type {string}
     * @private
     */
    _fieldname = ''


    /**
     * Das ausgewählte Icon
     * @type {string}
     * @private
     */
    _selected = ''


    /**
     * Hilfsklasse
     * @type {Helper}
     * @private
     */
    _helper = null


    /**
     * @param helper
     * @param fieldname
     */
    constructor(helper, fieldname) {
        this._helper    = helper
        this._fieldname = fieldname
    }



    /**
     * Initialiisert die Verarbeitet die Auswahl eines Icons.
     */
    initializeSelection(icons, selected) {
        this._selected = selected

        for (const icon of icons) {
            const icoElem = this._helper.getElem(icon)

            // Initiale Scrollen zum Icon, beim Laden der Seite
            if (icoElem.classList.contains('selected')) {
                this._helper.scrollToIcon(icoElem)
            }

            icoElem.addEventListener('click', (event) => {
                this._handleSelection(icoElem)
            })
        }
    }


    /**
     * Entfernt die Auswahl
     * @param icoElem
     * @private
     */
    _handleSelection(icoElem) {
        this.removeSelection()
        this._setSelection(icoElem)
    }


    /**
     * Entfernt die Auswahl von einem Icon.
     */
    removeSelection() {
        const icoElem   = this._helper.getElem(this._selected)
        this._selected  = ''

        if (icoElem) {
            icoElem.classList.remove('selected')
        }
    }


    /**
     * Setzt die Auswahl auf das übergebene Icon.
     * @param icoElem
     * @private
     */
    _setSelection (icoElem) {
        this._selected = icoElem.dataset.value
        document.getElementById('ctrl_' + this._fieldname).value = icoElem.dataset.value
        icoElem.classList.add('selected')
    }


    /**
     * Gibt den Namen des ausgewählten Icons zurück.
     * @returns {string}
     */
    getSelected () {
        return this._selected
    }
}