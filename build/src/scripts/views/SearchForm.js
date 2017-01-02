/**
 * Handles searchForm class additions on search trigger click
 * 
 * @author Shane Smith <ssmith@nerdery.com>
 * @since 1.0
 */

'use strict';

/**
 * The jQuery library
 *
 * @type {object}
 * @since 1.0
 */
var $ = require('jquery');

/**
 * The class for the form element
 *
 * @const
 * @type {string}
 * @since 1.0
 */
var FORM_SELECTOR = 'js-searchForm';

/**
 * The class selector for the trigger element
 *
 * @const
 * @type {string}
 * @since 1.0
 */
var TRIGGER_SELECTOR = 'js-searchFormTrigger';

/**
 * The class selector for the close button
 *
 * @const
 * @type {string}
 * @since 1.0
 */
var CLOSE_SELECTOR = 'js-searchFormClose';

/**
 * The class selctor when the searchForm is hidden
 *
 * @const
 * @type {string}
 * @since 1.0
 */
var HIDDEN_SELECTOR = 'isHidden';

/**
 * Constructor
 *
 * @param {object} $element The jQuery Element
 * @type {module.exports}
 * @since 1.0
 */
var SearchForm = module.exports = function ($element) {
    this.$element = $element;
    this.init();
};

/**
 * The prototype object
 *
 * @type {module.exports}
 * @since 1.0
 */
var proto = SearchForm.prototype;

/**
 * Initialize the Component
 *
 * @returns {proto}
 * @since 1.0
 */
proto.init = function () {

    return this.setupHandlers()
        .createChildren()
        .enable();
};

/**
 * Setup event handlers bound to the module
 *
 * @returns {proto}
 * @since 1.0
 */
proto.setupHandlers = function () {
    this.onClickHandler = this.onClick.bind(this);
    return this;
};

/**
 * Create any child elements of the main module element
 *
 * @returns {proto}
 * @since 1.0
 */
proto.createChildren = function () {
	this.$navList = this.$element.siblings('ul');
    this.$form = this.$element.find('.' + FORM_SELECTOR);
    this.$trigger = $('body').find('.' + TRIGGER_SELECTOR);
    this.$close = this.$form.find('.' + CLOSE_SELECTOR);
    return this;
};

/**
 * Enable the module and activate any event handlers
 *
 * @returns {proto}
 * @since 1.0
 */
proto.enable = function () {
    if (this.isEnabled) {
        return this;
    }

    this.isEnabled = true;
    this.$trigger.on('click', this.onClickHandler);
    this.$close.on('click', this.onClickHandler);

    return this;
};

/**
 * Disable the module and destroy any event handlers
 *
 * @returns {proto}
 * @since 1.0
 */
proto.disable = function () {
    if (!this.isEnabled) {
        return this;
    }

    this.isEnabled = false;
    this.$trigger.off('click', this.onClickHandler);
    this.$trigger.off('click', this.onClickHandler);
    return this;
};

/**
 * On trigger element change
 *
 * @param {MouseEvent} event The mouse event
 * @returns {proto}
 */
proto.onClick = function(event) {
    event.preventDefault();
    this.$element.toggleClass(HIDDEN_SELECTOR);
    this.$form.toggleClass(HIDDEN_SELECTOR);
	this.$navList.toggleClass(HIDDEN_SELECTOR);
    return this;
};

