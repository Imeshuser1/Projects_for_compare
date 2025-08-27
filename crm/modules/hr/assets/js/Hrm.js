var CiuisCRM = angular.module('Hrm', ['Ciuis.datepicker', 'ngMaterial', 'ngMaterialDatePicker', 'currencyFormat', 'md.data.table'])
	.config(function ($mdGestureProvider) {
		"use strict";
		$mdGestureProvider.skipClickHijack();
	}).config(function ($mdAriaProvider) {
		"use strict";
		$mdAriaProvider.disableWarnings();
	});

var globals = {};

var config = {
	headers: {
		'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
	}
};
globals.config = {
	headers: {
		'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
	}
};
globals.notification_links = {
	'tickets': 'tickets/ticket/',
	'invoice': 'invoices/invoice/',
	'order': 'orders/order/',
	'proposal': 'proposals/proposal/',
	'project': 'projects/project/'
}


function Hrm_Controller($scope, $http, $mdSidenav, $filter, $interval, $mdDialog, $element, $mdToast, $log) {
	"use strict";

	$scope.lang = {};

	$scope.date = new Date();
	$scope.tick = function () { 
		$scope.clock = Date.now();
	};
	$scope.tick();
	$interval($scope.tick, 1000);
	var curDate = new Date();
	var y = curDate.getFullYear();
	var m = curDate.getMonth() + 1; 
	if (m < 10) {
		m = '0' + m;
	}
	var d = curDate.getDate();
	if (d < 10) {
		d = '0' + d;
	}
	$scope.curDate = y + '-' + m + '-' + d;
	$scope.appurl = BASE_URL;
	$scope.UPIMGURL = UPIMGURL;
	//$scope.IMAGESURL = BASE_URL + 'assets/img/';
	//$scope.SETFILEURL = BASE_URL + 'uploads/ciuis_settings/';
	$scope.ONLYADMIN = SHOW_ONLY_ADMIN;
	$scope.USERNAMEIN = LOGGEDINSTAFFNAME;
	$scope.USERAVATAR = LOGGEDINSTAFFAVATAR;
	$scope.activestaff = ACTIVESTAFF;
	$scope.cur_symbol = CURRENCY;
	$scope.cur_code = CURRENCY; 
	$scope.cur_lct = LOCATE_SELECTED;
	var setting_date;
	var setting_time;
	if (dateFormat == 'Y.m.d') {
		setting_date = 'YYYY.MM.DD';
		setting_time = 'YYYY.MM.DD HH:mm:ss';
	} else if(dateFormat == 'd.m.Y') {
		setting_date = 'DD.MM.YYYY';
		setting_time = 'DD.MM.YYYY HH:mm:ss';
	} else if(dateFormat == 'Y-m-d') {
		setting_date = 'YYYY-MM-DD';
		setting_time = 'YYYY-MM-DD HH:mm:ss';
	} else if(dateFormat == 'd-m-Y') {
		setting_date = 'DD-MM-YYYY';
		setting_time = 'DD-MM-YYYY HH:mm:ss';
	} else if(dateFormat == 'Y/m/d') {
		setting_date = 'YYYY/MM/DD';
		setting_time = 'YYYY/MM/DD HH:mm:ss';
	} else if(dateFormat == 'd/m/Y') {
		setting_date = 'DD/MM/YYYY';
		setting_time = 'DD/MM/YYYY HH:mm:ss';
	}

	$scope.DateTimeFormat = setting_time;
	$scope.locale = {
		formatDate: function(date) {
			var m = moment(date);
			return m.isValid() ? m.format(setting_date) : '';
		}
	};

	$http.get(BASE_URL + 'api/settings').then(function (Settings) {
		$scope.settings = Settings.data;
		var setapp = $scope.settings;
		$scope.applogo = (setapp.logo);
		$scope.staff_timezone = $scope.settings.default_timezone;
	});

	$http.get(BASE_URL + 'api/user').then(function (Userman) {
		$scope.user = Userman.data;

		if ($scope.user.appointment_availability === '1') {
			$scope.appointment_availability = true;
		} else {
			$scope.appointment_availability = false;
		}

		$http.get(BASE_URL + 'api/lang/' + $scope.user.language).then(function (Language) {
			$scope.lang = Language.data;
		});

	});

	$scope.goToLink = function(url) {
		window.location.href = BASE_URL+url;
	};

	$scope.ChangeLanguage = function (lang) {
		$http.get(BASE_URL + 'api/lang/' + lang).then(function (Language) {
			$scope.lang = Language.data;
		});
	};


	$scope.clearSearchTerm = function() {
		$scope.searchTerm = '';
	};

	$element.find('input').on('keydown', function(ev) {
		ev.stopPropagation();
	});

	$scope.search_customers = function(q) {
		if (q.length > 0) {
			$http.get(BASE_URL + 'api/search_customers/'+q).then(function (Customers) {
				$scope.all_customers = Customers.data;
			});
		} else {
			$scope.all_customers = [];
		}
	};

	$scope.get_staff = function () {
		$http.get(BASE_URL + 'api/staff').then(function (Staff) {
			$scope.staff = Staff.data;
		});
	};


	globals.get_countries = function() {
		$http.get(BASE_URL + 'api/countries').then(function (Countries) {
			$scope.countries = Countries.data; 
		});
	};


	// Global dialog for create, you can use this for any delete dialog popup.
	// eg: globals.deleteDialog(title, content, id, ok_text, cancel_text, api, function(reponse){}
	globals.deleteDialog = function(title, content, id, ok_text, cancel_text, api, callback) {
		var confirm = $mdDialog.confirm()
		.title(title)
		.textContent(content)
		.ariaLabel(title)
		.targetEvent(id)
		.ok(ok_text)
		.cancel(cancel_text);
		$mdDialog.show(confirm).then(function () {
			$http.post(BASE_URL + api, config)
			.then(
				function (response) {
					callback(response.data);
				},
				function (response) {
					callback(response.data);
				}
				);
		}, function () {
		});
	};

	// Global dialog for edit, it'll be useful only when your db column name is 'name'
	// eg: globals.editDialog(title, content, placeholder, value, event, ok_text, cancel_text, api, function(reponse){}
	globals.editDialog = function(title, content, placeholder, value, event, ok_text, cancel_text, api, callback) {
		var confirm = $mdDialog.prompt()
		.title(title)
		.textContent(content)
		.placeholder(placeholder)
		.ariaLabel(placeholder)
		.initialValue(value)
		.targetEvent(event)
		.required(true)
		.ok(ok_text)
		.cancel(cancel_text);
		$mdDialog.show(confirm).then(function (result) {
			var dataObj = $.param({
				name: result,
			});
			$http.post(BASE_URL + api, dataObj, config)
			.then(
				function (response) {
					callback(response.data);
				},
				function (response) {
					callback(response.data);
				}
				);
		}, function () {
		});
	};

	// Global dialog for create, it'll be useful only when your db column name is 'name'
	// eg: globals.createDialog(title, content, placeholder, event, ok_text, cancel_text, api, function(reponse){}
	globals.createDialog = function(title, content, placeholder, event, ok_text, cancel_text, api, callback) {
		var confirm = $mdDialog.prompt()
		.title(title)
		.textContent(content)
		.placeholder(placeholder)
		.ariaLabel(placeholder)
		.targetEvent(event)
		.required(true)
		.ok(ok_text)
		.cancel(cancel_text);
		$mdDialog.show(confirm).then(function (result) {
			var dataObj = $.param({
				name: result,
			});
			$http.post(BASE_URL + api, dataObj, config)
			.then(
				function (response) {
					callback(response.data);
				},
				function (response) {
					callback(response.data);
				}
				);
		}, function () {
		});
	};



	$scope.OpenMenu = function () {
		$('#mobile-menu').show();
	};

	// type = success or error
	// message = your message, that you want to display in toast
	// eg: globals.mdToast('success', 'Timer has been deleted successfully');
	globals.mdToast = function (type, message, time = 4000) {
	    $mdToast.show({
	        template: '<md-toast class="md-toast ' + type + '">' + message + '</md-toast>',
	        hideDelay: time,
	        position: 'top center'
	    });
	};

	$scope.neweventtype = false;

	$scope.Notifications = buildToggler('Notifications');
	$scope.Profile = buildToggler('Profile');
	$scope.PickUpTo = buildToggler('PickUpTo');

	$scope.get_notifications = function() {
		$scope.loadingnotification = true;
		$http.get(BASE_URL + 'api/notifications').then(function (Notifications) {
			$scope.notifications = Notifications.data;
			$scope.loadingnotification = false;
		});
	};
	

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}


	$scope.searchNav = function() {
		$mdSidenav('searchNav').toggle();
		$scope.searchInputMsg = 1;
	};

	$scope.close = function () {
		$mdSidenav('Notifications').close();
		$mdSidenav('Profile').close();
		$mdDialog.hide();
		$('#mobile-menu').hide();
	};

	$scope.markAllAsRead = function() {
		var dataObj = $.param({});
		var posturl = BASE_URL + 'api/mark_read_ntf';
		$http.post(posturl, dataObj, config)
		.then(function (response) {
			$http.get(BASE_URL + 'api/notifications').then(function (Notifications) {
				$scope.notifications = Notifications.data;
			});
			$scope.stats.tbs = '0';
		}, function (error) {}
		);
	};


	if ($scope.ONLYADMIN) {
		setTimeout(function(){
			checkForUpdate();
		},20000);
	}

	function checkForUpdate() {
		var posturl = BASE_URL + 'settings/check_for_update';
		$http.post(posturl, config).then(function(res){},function(res){});
	}




	$scope.NotificationRead = function (index) {
		var notification = $scope.notifications[index];
		var posturl = BASE_URL + 'trivia/mark_read_notification/' + notification.id;
		$http.post(posturl, config)
			.then(
				function (response) {
					console.log(response);
					if (typeof globals.notification_links[notification.relation_type] !== 'undefined') {
						let link = BASE_URL + globals.notification_links[notification.relation_type] + notification.relation;
						window.location.href = link;
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.ChangeTicketStatus = function () {
		var dataObj = $.param({
			statusid: $scope.item.code,
			ticketid: $(".tickid").val(),
		});
		$http.post(BASE_URL + 'tickets/chancestatus', dataObj, config)
			.then(
				function (response) {
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: TICKSTATUSCHANGE,
						class_name: 'color success'
					});
					$(".label-status").text($scope.item.name);
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.ciuisTooltip = {
		showTooltip: false,
		tipDirection: 'bottom'
	};

	$scope.ciuisTooltip.delayTooltip = undefined;

	$scope.$watch('demo.delayTooltip', function (val) {
		$scope.ciuisTooltip.delayTooltip = parseInt(val, 10) || 0;
	});

	$scope.passwordLength = 12;
	$scope.addUpper = true;
	$scope.addNumbers = true;
	$scope.addSymbols = true;

	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function shuffleArray(array) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}

	$scope.createPassword = function () {
		var lowerCharacters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		var upperCharacters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
		var numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
		var symbols = ['!', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~'];
		var noOfLowerCharacters = 0,
			noOfUpperCharacters = 0,
			noOfNumbers = 0,
			noOfSymbols = 0;
		var noOfneededTypes = $scope.addUpper + $scope.addNumbers + $scope.addSymbols;
		var noOfLowerCharacters = getRandomInt(1, $scope.passwordLength - noOfneededTypes);
		var usedTypeCounter = 1;
		if ($scope.addUpper) {
			noOfUpperCharacters = getRandomInt(1, $scope.passwordLength - noOfneededTypes + usedTypeCounter - noOfLowerCharacters);
			usedTypeCounter++;
		}
		if ($scope.addNumbers) {
			noOfNumbers = getRandomInt(1, $scope.passwordLength - noOfneededTypes + usedTypeCounter - noOfLowerCharacters - noOfUpperCharacters);
			usedTypeCounter++;
		}
		if ($scope.addSymbols) {
			noOfSymbols = $scope.passwordLength - noOfLowerCharacters - noOfUpperCharacters - noOfNumbers;
		}
		var passwordArray = [];
		for (var i = 0; i < noOfLowerCharacters; i++) {
			passwordArray.push(lowerCharacters[getRandomInt(1, lowerCharacters.length - 1)]);
		}
		for (var i = 0; i < noOfUpperCharacters; i++) {
			passwordArray.push(upperCharacters[getRandomInt(1, upperCharacters.length - 1)]);
		}
		for (var i = 0; i < noOfNumbers; i++) {
			passwordArray.push(numbers[getRandomInt(1, numbers.length - 1)]);
		}
		for (var i = 0; i < noOfSymbols; i++) {
			passwordArray.push(symbols[getRandomInt(1, symbols.length - 1)]);
		}
		passwordArray = shuffleArray(passwordArray);
		return passwordArray.join("");
	};

	$scope.passwordNew = $scope.createPassword();

	$scope.getNewPass = function () {
		$scope.passwordNew = $scope.createPassword();
	};
}



function Sidebar_Controller($scope, $http, $mdSidenav, $filter, $interval, $mdDialog, $element, $mdToast, $log) {


	
	$http.get(BASE_URL + 'api/logs').then(function (Logs) {
		$scope.logs = Logs.data;
	});

}

function Panel_controller($scope, $http, $mdSidenav, $filter, $interval, $mdDialog, $element, $mdToast, $log) {

	$http.get(BASE_URL + 'api/stats').then(function (Stats) {
		$scope.stats = Stats.data;


	});

}

CiuisCRM.controller('Hrm_Controller', Hrm_Controller);
CiuisCRM.controller('Sidebar_Controller', Sidebar_Controller);
CiuisCRM.controller('Panel_controller', Panel_controller);

// ALL FILTERS

CiuisCRM.filter('trustAsHtml', ['$sce', function ($sce) {
	"use strict";

	return function (text) {
		return $sce.trustAsHtml(text);
	};
}]);

CiuisCRM.filter('pagination', function () {
	"use strict";

	return function (input, start) {
		if (!input || !input.length) {
			return;
		}
		start = +start; //parse to int
		return input.slice(start);
	};
});

CiuisCRM.filter('time', function () {
	"use strict";

	var conversions = {
		'ss': angular.identity,
		'mm': function (value) {
			return value * 60;
		},
		'hh': function (value) {
			return value * 3600;
		}
	};

	var padding = function (value, length) {
		var zeroes = length - ('' + (value)).length,
			pad = '';
		while (zeroes-- > 0) pad += '0';
		return pad + value;
	};

	return function (value, unit, format, isPadded) {
		var totalSeconds = conversions[unit || 'ss'](value),
			hh = Math.floor(totalSeconds / 3600),
			mm = Math.floor((totalSeconds % 3600) / 60),
			ss = totalSeconds % 60;

		format = format || 'hh:mm:ss';
		isPadded = angular.isDefined(isPadded) ? isPadded : true;
		hh = isPadded ? padding(hh, 2) : hh;
		mm = isPadded ? padding(mm, 2) : mm;
		ss = isPadded ? padding(ss, 2) : ss;

		return format.replace(/hh/, hh).replace(/mm/, mm).replace(/ss/, ss);
	};
});

// ALL DIRECTIVES

CiuisCRM.directive('loadMore', function () {
	"use strict";

	return {
		template: "<a ng-click='loadMore()' id='loadButton' class='activity_tumu'><i style='font-size:22px;' class='icon ion-android-arrow-down'></i></a>",
		link: function (scope) {
			scope.LogLimit = 2;
			scope.loadMore = function () {
				scope.LogLimit += 5;
				if (scope.logs.length < scope.LogLimit) {
					CiuisCRM.element(loadButton).fadeOut();
				}
			};
		}
	};
});

CiuisCRM.directive("bindExpression", function ($parse) {
	"use strict";
	var directive = {};
	directive.restrict = 'E';
	directive.require = 'ngModel';
	directive.link = function (scope, element, attrs, ngModel) {
		scope.$watch(attrs.expression, function (newValue) {
			ngModel.$setViewValue(newValue);
		});
		ngModel.$render = function () {
			$parse(attrs.expression).assign(ngModel.viewValue);
		};
	};
	return directive;
});

CiuisCRM.directive('onErrorSrc', function () {
	"use strict";

	return {
		link: function (scope, element, attrs) {
			element.bind('error', function () {
				if (attrs.src !== attrs.onErrorSrc) {
					attrs.$set('src', attrs.onErrorSrc);
				}
			});
		}
	};
});

CiuisCRM.directive('ciuisReady', function () {
	"use strict";
	return {
		link: function ($scope) {
			setTimeout(function () {
				$scope.$apply(function () {
					var milestone_projectExpandablemilestonetitle = $('.milestone_project-action.is-expandable .milestonetitle');
					$(milestone_projectExpandablemilestonetitle).attr('tabindex', '0');
					// Give milestone_projects ID's
					$('.milestone_project').each(function (i, $milestone_project) {
						var $milestone_projectActions = $($milestone_project).find('.milestone_project-action.is-expandable');
						$($milestone_projectActions).each(function (j, $milestone_projectAction) {
							var $milestoneContent = $($milestone_projectAction).find('.content');
							$($milestoneContent).attr('id', 'milestone_project-' + i + '-milestone-content-' + j).attr('role', 'region');
							$($milestoneContent).attr('aria-expanded', $($milestone_projectAction).hasClass('expanded'));
							$($milestone_projectAction).find('.milestonetitle').attr('aria-controls', 'milestone_project-' + i + '-milestone-content-' + j);
						});
					});
					$(milestone_projectExpandablemilestonetitle).click(function () {
						$(this).parent().toggleClass('is-expanded');
						$(this).siblings('.content').attr('aria-expanded', $(this).parent().hasClass('is-expanded'));
					});
					// Expand or navigate back and forth between sections
					$(milestone_projectExpandablemilestonetitle).keyup(function (e) {
						if (e.which === 13) { //Enter key pressed
							$(this).click();
						} else if (e.which === 37 || e.which === 38) { // Left or Up
							$(this).closest('.milestone_project-milestone').prev('.milestone_project-milestone').find('.milestone_project-action .milestonetitle').focus();
						} else if (e.which === 39 || e.which === 40) { // Right or Down
							$(this).closest('.milestone_project-milestone').next('.milestone_project-milestone').find('.milestone_project-action .milestonetitle').focus();
						}
					});
				});
			}, 5000);
			angular.element(document).ready(function () {
				$('.transform_logo').addClass('animated rotateIn'); // Logo Transform
				$('#chooseFile').bind('change', function () {
					var filename = $("#chooseFile").val();
					if (/^\s*$/.test(filename)) {
						$(".file-upload").removeClass('active');
						$("#noFile").text("None Chosen");
					} else {
						$(".file-upload").addClass('active');
						$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
					}
				});
				var $btns = $('.pbtn').click(function () {
					if (this.id == 'all') {
						$('#ciuisprojectcard > div').fadeIn(450);
					} else {
						var $el = $('.' + this.id).fadeIn(450);
						$('#ciuisprojectcard > div').not($el).hide();
					}
					$btns.removeClass('active');
					$(this).addClass('active');
				});

				$('.add-file-cover').hide();

				$(document).on('click', function (e) {
					if ($(e.target).closest('.add-file').length) {
						$(".add-file-cover").show();
					} else if (!$(e.target).closest('.add-file-cover').length) {
						$('.add-file-cover').hide();
					}
				});
				$('.form-field-file').each(function () {
					var label = $('label', this);
					var labelValue = $(label).html();
					var fileInput = $('input[type="file"]', this);
					$(fileInput).on('change', function () {
						var fileName = $(this).val().split('\\').pop();
						if (fileName) {
							$(label).html(fileName);
						} else {
							$(label).html(labelValue);
						}
					});
				});
				$(document).ready(function () {
					$('input[name=type]').change(function () {
						if (!$(this).is(':checked')) {
							return;
						}
						if ($(this).val() === '0') {
							$('.bank').hide();
						} else if ($(this).val() === '1') {
							$('.bank').show();
						}
					});
				});
				$('#ciuisloader').hide();
			});
		}
	};
});
CiuisCRM.directive("strToTime", function () {
	"use strict";
	return {
		require: 'ngModel',
		link: function (scope, element, attrs, ngModelController) {
			ngModelController.$parsers.push(function (data) {
				if (!data) {
					return "";
				}
				return ("0" + data.getHours().toString()).slice(-2) + ":" + ("0" + data.getMinutes().toString()).slice(-2);
			});
			ngModelController.$formatters.push(function (data) {
				if (!data) {
					return null;
				}
				var d = new Date(1970, 1, 1);
				var splitted = data.split(":");
				d.setHours(splitted[0]);
				d.setMinutes(splitted[1]);
				return d;
			});
		}
	};
});
CiuisCRM.directive('ciuisSidebar', function () {
	"use strict";
	return {
		templateUrl: "ciuis-sidebar.html"
	};
});
CiuisCRM.directive('customFieldsVertical', function () {
	"use strict";
	return {
		templateUrl: "custom-fields.html"
	};
});
CiuisCRM.directive("uiDraggable", [
	'$parse',
	'$rootScope',
	function ($parse, $rootScope) {
		"use strict";
		return function (scope, element, attrs) {
			if ($.jQuery && !$.jQuery.event.props.dataTransfer) {
				$.jQuery.event.props.push('dataTransfer');
			}
			element.attr("draggable", false);
			attrs.$observe("uiDraggable", function (newValue) {
				element.attr("draggable", newValue);
			});
			var dragData = "";
			scope.$watch(attrs.drag, function (newValue) {
				dragData = newValue;
			});
			element.bind("dragstart", function (e) {
				var sendData = angular.toJson(dragData);
				var sendChannel = attrs.dragChannel || "defaultchannel";
				e.dataTransfer.setData("Text", sendData);
				$rootScope.$broadcast("ANGULAR_DRAG_START", sendChannel);

			});

			element.bind("dragend", function (e) {
				var sendChannel = attrs.dragChannel || "defaultchannel";
				$rootScope.$broadcast("ANGULAR_DRAG_END", sendChannel);
				if (e.dataTransfer && e.dataTransfer.dropEffect !== "none") {
					if (attrs.onDropSuccess) {
						var fn = $parse(attrs.onDropSuccess);
						scope.$apply(function () {
							fn(scope, {
								$event: e
							});
						});
					}
				}
			});


		};
	}
]);
CiuisCRM.directive("uiOnDrop", [
	'$parse',
	'$rootScope',
	function ($parse, $rootScope) {
		"use strict";
		return function (scope, element, attr) {
			var dropChannel = "defaultchannel";
			var dragChannel = "";
			var dragEnterClass = attr.dragEnterClass || "on-drag-enter";
			var dragHoverClass = attr.dragHoverClass || "on-drag-hover";

			function onDragOver(e) {

				if (e.preventDefault) {
					e.preventDefault(); // Necessary. Allows us to drop.
				}

				if (e.stopPropagation) {
					e.stopPropagation();
				}
				e.dataTransfer.dropEffect = 'move';
				return false;
			}

			function onDragEnter(e) {
				$rootScope.$broadcast("ANGULAR_HOVER", dropChannel);
				element.addClass(dragHoverClass);
			}

			function onDrop(e) {
				if (e.preventDefault) {
					e.preventDefault(); // Necessary. Allows us to drop.
				}
				if (e.stopPropagation) {
					e.stopPropagation(); // Necessary. Allows us to drop.
				}
				var data = e.dataTransfer.getData("Text");
				data = angular.fromJson(data);
				var fn = $parse(attr.uiOnDrop);
				scope.$apply(function () {
					fn(scope, {
						$data: data,
						$event: e
					});
				});
				element.removeClass(dragEnterClass);
			}


			$rootScope.$on("ANGULAR_DRAG_START", function (event, channel) {
				dragChannel = channel;
				if (dropChannel === channel) {

					element.bind("dragover", onDragOver);
					element.bind("dragenter", onDragEnter);

					element.bind("drop", onDrop);
					element.addClass(dragEnterClass);
				}

			});

			$rootScope.$on("ANGULAR_DRAG_END", function (e, channel) {
				dragChannel = "";
				if (dropChannel === channel) {

					element.unbind("dragover", onDragOver);
					element.unbind("dragenter", onDragEnter);

					element.unbind("drop", onDrop);
					element.removeClass(dragHoverClass);
					element.removeClass(dragEnterClass);
				}
			});

			$rootScope.$on("ANGULAR_HOVER", function (e, channel) {
				if (dropChannel === channel) {
					element.removeClass(dragHoverClass);
				}
			});

			attr.$observe('dropChannel', function (value) {
				if (value) {
					dropChannel = value;
				}
			});


		};
	}
]);

// New model type for file upload i.e. file-model instead of ng-model
CiuisCRM.directive('fileModel', ['$parse', function ($parse) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			var model = $parse(attrs.fileModel);
			var modelSetter = model.assign;
			element.bind('change', function(){
				scope.$apply(function(){
					modelSetter(scope, element[0].files[0]);
				});
			});
		}
	};
}]);

// ------------------------------------------------
// File upload service
// ------------------------------------------------
// Code to use file upload function in angular: 
// ================================================
// var file = $scope.project_file;
// var uploadUrl = BASE_URL+'projects/add_file/'+PROJECTID;
// fileUpload.uploadFileToUrl(file, uploadUrl, function(response) {
// });
// ================================================

CiuisCRM.service('fileUpload', ['$http', function ($http) {
	this.uploadFileToUrl = function(file, uploadUrl, callback) {
		var fd = new FormData();
		fd.append('file', file);
		$http.post(uploadUrl, fd, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		}).then(function (response) {
			callback(response.data);
		}, function (response) {
			callback(response.data);
		});
	};

	this.uploadFileWithData = function(data, uploadUrl, callback) {
		var formData = new FormData();
		angular.forEach(data, function (value, key) {
			formData.append(key, (value?value:''));
		});
		$http.post(uploadUrl, formData, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined}
		}).then(function (response) {
			callback(response.data);
		}, function (response) {
			callback(response.data);
		});
	};
}]);


// Global Toaster function
function showToast(title, message, type) {
	$.gritter.add({
		title: '<b>' + title + '</b>',
		text: message,
		class_name: 'color '+type,
	});
}


