// Application
'use strict';

window.$ = window.jQuery = require('jquery');

var Prism = [];
Prism['core'] 		= require('../vendor/prism/prism');
Prism['bash'] 		= require('../vendor/prism/components/prism-bash');
Prism['json'] 		= require('../vendor/prism/components/prism-json');
Prism['php']		= require('../vendor/prism/components/prism-php');
Prism['css']		= require('../vendor/prism/components/prism-css');
Prism['scss']		= require('../vendor/prism/components/prism-scss');
Prism['sass']		= require('../vendor/prism/components/prism-sass');
Prism['ruby']		= require('../vendor/prism/components/prism-ruby');
Prism['vim']        = require('../vendor/prism/components/prism-vim');
Prism['nginx']		= require('../vendor/prism/components/prism-nginx');
var SearchFormView = require('./views/SearchForm');

var $searchForm = $('.js-searchFormContainer');
if($searchForm.length > 0) {
	var $searchForm = new SearchFormView($('.js-searchFormContainer'));
}
