"use strict";


/**
 * @since       09.12.2025 - 09:15
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

class SearchHandler {


    /**
     * Helper
     * @type {Helper}
     * @private
     */
    _helper = null


    /**
     * SelectionHandler
     * @type {SelectionHandler}
     * @private
     */
    _selectionHandler = null


    /**
     * @param selectionHandler
     * @param helper
     */
    constructor(selectionHandler, helper) {
        this._helper            = helper
        this._selectionHandler  = selectionHandler
    }



    /**
     * Initialisiert die Suche
     * @private
     */
    initializeSearch(fieldname, icons) {
        const searchField = document.getElementById('ctrl_' + fieldname)

        if (undefined !== searchField) {
            searchField.addEventListener('input', (event) => {
                this.handleSearch(searchField.value, icons, fieldname)
            })
        }
    }


    /**
     * Verarbeitet die Suche.
     * @param searchTerm
     * @param icons
     * @param fieldname
     */
    handleSearch(searchTerm, icons, fieldname) {
        this._selectionHandler.removeSelection()
        this._helper.removeHidden()

        for (const icon of icons) {
            if (icon && false === icon.includes(searchTerm)) {
                this._helper.setHidden(icon)
            }
        }

        this._helper.scrollToTop(fieldname)
    }
}