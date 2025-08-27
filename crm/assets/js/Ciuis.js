var App = (function () {
	'use strict';
	var config = {
		assetsPath: 'assets',
		imgPath: 'img',
		jsPath: 'js',
		libsPath: 'lib',
		leftSidebarSlideSpeed: 200,
		leftSidebarToggleSpeed: 300,
		enableSwipe: true,
		swipeTreshold: 100,
		scrollTop: true,
		openRightSidebarClass: 'open-right-sidebar',
		closeRsOnClickOutside: true,
		removeLeftSidebarClass: 'ciuis-body-nosidebar-left',
		transitionClass: 'ciuis-body-animate',
		openSidebarDelay: 400
	};
	return {
		init: function (options) {
			$.extend(config, options);
		}
	};
})();
//reset form function()
	/**
	 * [Reset AngularJS form and it's variables]
	 * @param  {[object]} form [AngularJS form]
	 * @param  {[object]} scope [AngularJS $scope variable]
	 * @return {[boolean]}      [Returns the status]
	 */
function	 form_reset(form, scope = null, ...vars) {
		// Filter all the input fields from the given form those are with a dollar sign
		let elements = Object.keys(form).filter(function (key) {
			return key.indexOf('$') !== 0;
		});

		// Check if scope has value and variables are specified and also set these to undefined
		if (scope) {
			if (vars.length) {
				for (let key of vars) {
					// Reset the scope variable
					scope[key] = undefined;
				}
			}
			// Clear the form variables
			else {
				for (let name of elements) {
					// Reset the form variable
					form[name].$setViewValue(undefined);
				}
			}
		}

		// Set the form to its initial state
		form.$setPristine();
		form.$setUntouched();
		return true;
	}