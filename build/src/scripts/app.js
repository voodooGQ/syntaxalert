// Application
'use strict';

window.$ = window.jQuery = require('jquery');
var Prism = require('../vendor/prism/prism');
var PrismPHP = require('../vendor/prism/components/prism-php');
var SearchFormView = require('./views/SearchForm');

var $searchForm = $('.js-searchFormContainer');
if($searchForm.length > 0) {
	var $searchForm = new SearchFormView($('.js-searchFormContainer'));
}
