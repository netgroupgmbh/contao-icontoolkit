"use strict";


/**
 * @since       09.12.2025 - 09:38
 *
 * @author      Patrick Froch <info@netgroup.de>
 *
 * @see         http://www.netgroup.de
 *
 * @copyright   NetGroup GmbH 2025
 */

class StyleHandler {


    /**
     * Url zum Laden der Icons
     * @type {string}
     * @private
     */
    _icoUrl = '/contao/ng-fetch-icon-list/' // + '{style}/{search}


    /**
     * Array mit den geladenen Icons
     * @type {[]}
     * @private
     */
    _icons = []


    /**
     * @type {SearchHandler}
     * @private
     */
    _searchHandler = null


    /**
     * @type {SelectionHandler}
     * @private
     */
    _selectionHandler = null


    /**
     * @type {Helper}
     * @private
     */
    _helper = null


    /**
     * @param selectionHandler
     * @param searchHandler
     * @param helper
     */
    constructor(selectionHandler, searchHandler, helper) {
       this._selectionHandler   = selectionHandler
       this._searchHandler      = searchHandler
        this._helper            = helper
    }


    /**
     * Initialisiert das Feld für die Auswahl des Styles.
     * @private
     */
    initializeStyle(fieldname, icons) {
        const styleField    = document.getElementById('ng_icon_styles_' + fieldname)
        const searchField   = document.getElementById('ctrl_' + fieldname)

        styleField.addEventListener('change', () => {
            searchField.disabled = true
            const value = styleField.value
            this.__loadData(this._icoUrl + value, (data) => {
                if (data) {
                    this._generateIconList(fieldname, searchField, JSON.parse(data))
                }
            })
        })
    }


    /**
     * Generiert die Icon-Liste nach dem Laden eines Styles.
     * @param fieldname
     * @param searchField
     * @param icons
     * @private
     */
    _generateIconList(fieldname, searchField, icons) {
        this._helper.clearHidden()
        const listContainer = document.getElementById('ng_iconpicker_list_' + fieldname)
        const ul            = document.createElement('ul')
        this._icons         = []

        if (listContainer) {

            for (const index in icons){
                const ico           = icons[index]
                const li            = document.createElement('li')
                const i             = document.createElement('i')
                const span          = document.createElement('span')
                this._icons.push(ico)

                span.innerHTML      = ico
                span.setAttribute('class', 'label')

                i.setAttribute('class', ico)

                li.id               = ico.replace(' ', '_')
                li.dataset.value    = ico

                li.appendChild(i)
                li.appendChild(span)
                ul.appendChild(li)
            }

            searchField.value       = ''
            listContainer.innerHTML = ''
            listContainer.appendChild(ul)

            this._searchHandler.initializeSearch(fieldname, this._icons)
            this._selectionHandler.initializeSelection(this._icons, '')
            searchField.disabled = false
            searchField.focus()
        }
    }


    /**
     * Lädt Daten vom Server nach.
     * @param url
     * @param callback
     * @private
     */
    __loadData(url, callback) {
        // Styles laden /contao/ng-fetch-icon-styles
        // Icons laden /contao/ng-fetch-icon-list/solid/{search}
        const xhttp = new XMLHttpRequest()

        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === XMLHttpRequest.DONE) {
                if (xhttp.status === 200) {
                    callback(xhttp.responseText)
                } else {
                    console.error(xhttp.responseText)
                }
            }
        };


        xhttp.open("GET", url, true)
        xhttp.send()
    }
}

