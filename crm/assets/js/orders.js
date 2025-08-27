function Orders_Controller($scope, $http, $mdSidenav, $q, $timeout, $filter) {
	"use strict";

	$scope.get_units();
	$scope.get_warehouse();
	globals.get_countries();
	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'order').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});

	$http.get(BASE_URL + 'api/table_columns/' + 'orders').then(function (Data) {
		$scope.table_columns = Data.data;
	});

	$scope.updateColumns = function (column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/orders';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
				}, function (error) { }
			);
	};

	$http.get(BASE_URL + 'api/staff').then(function (Staff) {
		$scope.staff = Staff.data;
	});
	//create
	$http.get(BASE_URL + 'api/products').then(function (Products) {
		Products.data.forEach(function (item, index) {
			Products.data[index].tax = Number(item.tax);
			Products.data[index].price = Number(item.price);
			Products.data[index].discount = Number(item.discount);
			Products.data[index].quantity = Number(item.quantity);
		})
		$scope.products = Products.data;
	});

	$http.get(BASE_URL + 'api/leads').then(function (Leads) {
		$scope.leads = Leads.data;
	});


	$scope.GetProduct = (function (search) {
		console.log(search);
		var deferred = $q.defer();
		$timeout(function () {
			deferred.resolve($scope.products);
		}, Math.random() * 500, false);
		return deferred.promise;
	});

	$scope.order = {
		items: [{
			name: new_item,
			product_id: 0,
			code: '',
			description: '',
			quantity: 1,
			unit: item_unit,
			price: 0,
			tax: 0,
			discount: 0,
			warehouse_id: '',
			product_type: ''
		}]
	};

	$scope.add = function () {
		$scope.order.items.push({
			name: new_item,
			product_id: 0,
			code: '',
			description: '',
			quantity: 1,
			unit: item_unit,
			price: 0,
			tax: 0,
			discount: 0,
			warehouse_id: '',
			product_type: ''
		});
	};

	$scope.remove = function (index) {
		$scope.order.items.splice(index, 1);
	};

	$scope.subtotal = function () {
		var subtotal = 0;
		angular.forEach($scope.order.items, function (item) {
			if (typeof item.price !== 'undefined') {
				subtotal += item.quantity * item.price;
			}
		});
		return subtotal.toFixed(2);
	};
	//1.function to check NaN.
	$scope.sub_val = function (item) {
		var sub_val = 0;
		sub_val = item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price);
		if (isNaN(sub_val)) {
			return 0;
		}
		else {
			return sub_val.toFixed(2);
		}
	};

	$scope.linediscount = function () {
		var linediscount = 0;
		var tempDis = 0;
		angular.forEach($scope.order.items, function (item) {
			if (typeof item.discount !== 'undefined') {
				linediscount += ((item.discount) / 100 * item.quantity * item.price);
				tempDis = linediscount > 0 ? linediscount : tempDis;
			}
		});
		return tempDis.toFixed(2);
	};


	$scope.totaltax = function () {
		var totaltax = 0;
		let tempVal = 0;
		angular.forEach($scope.order.items, function (item) {
			totaltax += ((item.tax) / 100 * item.quantity * item.price);
			tempVal = totaltax > 0 ? totaltax : tempVal;
		});
		return tempVal.toFixed(2);
	};

	$scope.grandtotal = function () {
		var grandtotal = 0;
		angular.forEach($scope.order.items, function (item) {
			if (typeof item.price !== 'undefined' && typeof item.tax !== 'undefined') {
				grandtotal += item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price) - ((item.discount) / 100 * item.quantity * item.price);
			} else {
				return 0;
			}
		});
		return grandtotal.toFixed(2);
	};

	$scope.saveAll = function () {
		console.log("Hello World")
		var order_recurring;
		if ($scope.order_recurring == true) {
			order_recurring = '1';
		} else {
			order_recurring = '0';
		}
		var EndRecurring;
		if ($scope.EndRecurring) {
			EndRecurring = moment($scope.EndRecurring).format("YYYY-MM-DD");
		} else {
			EndRecurring = 'Invalid date';
		}
		if ($scope.created) {
			$scope.created = moment($scope.created).format("YYYY-MM-DD");
		}  else{
			let datepicker = document.getElementById("input_31").value;
			$scope.created = moment(datepicker,"yyyy-mm-dd").format().split("T")[0]

		}
		if ($scope.opentill) {
			$scope.opentill = moment($scope.opentill).format("YYYY-MM-DD");
		}  else{
			let datepicker = document.getElementById("input_37").value;
			$scope.opentill = moment(datepicker,"yyyy-mm-dd").add(1, 'day').format().split("T")[0]

		}
		var data = tinyMCE.activeEditor.getContent({ format: 'text' });
		var dataObj = $.param({
			customer: $scope.customer.id,
			comment: $scope.comment,
			subject: $scope.subject,
			content: data.replace(/&nbsp;/g, ' ').replace(/;/g, '').replace(/&nbsp/g, ' '),
			date: $scope.created,
			created: $scope.created,
			opentill: $scope.opentill,
			status: $scope.status,
			assigned: $scope.assigned,
			sub_total: $scope.subtotal,
			total_discount: $scope.linediscount,
			total_tax: $scope.totaltax,
			total: $scope.grandtotal,
			items: $scope.order.items,
			total_items: $scope.order.items.length,
			// Billing Address
			billing_street: $scope.order.billing_street,
			billing_city: $scope.order.billing_city,
			billing_state_id: $scope.order.billing_state_id,
			billing_zip: $scope.order.billing_zip,
			billing_country: $scope.order.billing_country,
			billing_country: $scope.order.billing_country_id,
			// Shipping Address
			shipping_street: $scope.order.shipping_street,
			shipping_city: $scope.order.shipping_city,
			shipping_state_id: $scope.order.shipping_state_id,
			shipping_zip: $scope.order.shipping_zip,
			shipping_country: $scope.order.shipping_country,
			shipping_country: $scope.order.shipping_country_id,
			// START Recurring
			recurring: order_recurring,
			end_recurring: EndRecurring,
			recurring_type: $scope.recurring_type,
			recurring_period: $scope.recurring_period
		});
		var posturl = BASE_URL + 'orders/create';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if (response.data.success == true) {
						window.location.href = BASE_URL + 'orders/order/' + response.data.id;
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};

	var deferred = $q.defer();
	$scope.order_list = {
		order: '',
		limit: 5,
		page: 1
	};
	$scope.promise = deferred.promise;
	$http.get(BASE_URL + 'orders/get_orders').then(function (Orders) {
		$scope.orders = Orders.data.data;
		$scope.byCustomer = Orders.data.customers;
		$scope.byAssignee = Orders.data.assigned;
		deferred.resolve();

		$scope.limitOptions = [5, 10, 15, 20];
		if ($scope.orders.length > 20) {
			$scope.limitOptions = [5, 10, 15, 20, $scope.orders.length];
		}
		$scope.search = {
			subject: '',
		};
		// Filter Buttons //
		$scope.toggleFilter = buildToggler('ContentFilter');

		function buildToggler(navID) {
			return function () {
				$mdSidenav(navID).toggle();

			};
		}
		$scope.close = function () {
			$mdSidenav('ContentFilter').close();
		};
		// Filter Buttons //
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.orders || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		$scope.updateDropdown = function (_prop, flag = true) {
			if(_prop == 'all'){
				$http.get(BASE_URL + 'orders/get_orders/').then(function (Orders) {
					$scope.orders = Orders.data.data;
					$scope.byCustomer = Orders.data.customers;
					$scope.byAssignee = Orders.data.assigned;
					
				});	
			}	else{
				if(flag){
					$http.get(BASE_URL + 'orders/get_filtered_orders/' + _prop).then(function (Orders) {
						$scope.orders = Orders.data.data;
					});	
				}	else{
					$http.get(BASE_URL + 'orders/get_filtered_orders/' + _prop+"?status=false").then(function (Orders) {
						$scope.orders = Orders.data.data;
					});
				}
			}	
		};
		
	});

	$scope.getBillingStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.billingStates = States.data;
		});
	};

	$scope.getShippingStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.shippingStates = States.data;
		});
	};

	$scope.CopyBillingFromCustomer = function () {
		$scope.order.billing_street = $scope.customer.billing_street;
		$scope.order.billing_city = $scope.customer.billing_city;
		$scope.order.billing_state_id = $scope.customer.billing_state_id;
		$scope.order.billing_state = $scope.customer.billing_state;
		$scope.order.billing_country = $scope.customer.billing_country;
		$scope.order.billing_zip = $scope.customer.billing_zip;
		$scope.order.billing_country_id = $scope.customer.billing_country_id;
	};

	$scope.CopyShippingFromCustomer = function () {
		$scope.order.shipping_street = $scope.customer.shipping_street;
		$scope.order.shipping_city = $scope.customer.shipping_city;
		$scope.order.shipping_state_id = $scope.customer.shipping_state_id;
		$scope.order.shipping_state = $scope.customer.shipping_state;
		$scope.order.shipping_country = $scope.customer.shipping_country;
		$scope.order.shipping_zip = $scope.customer.shipping_zip;
		$scope.order.shipping_country_id = $scope.customer.shipping_country_id;
	};

	$scope.SelectedCustomer = $scope.customer;

	$scope.copy_shipping_from_bill_to = function () {

		// Copy from customer only after click
		// if (typeof $scope.customer_this !== 'undefined') {
		// 	$scope.customer = $scope.customer_this;
		// }

		$scope.order.shipping_street = $scope.order.billing_street;
		$scope.order.shipping_city = $scope.order.billing_city;
		$scope.order.shipping_zip = $scope.order.billing_zip;
		$scope.order.shipping_country = $scope.order.billing_country;
		$scope.order.shipping_country_id = $scope.order.billing_country_id;
		$scope.order.shipping_state = $scope.order.billing_state;
		$scope.order.shipping_state_id = $scope.order.billing_state_id;
	};
	$scope.SelectedCustomer = $scope.customer;
}

function Order_Controller($scope, $http, $mdSidenav, $mdDialog, $q, $timeout,fileUpload) {
	"use strict";

	$scope.get_units();
	$scope.get_warehouse();
	globals.get_countries();
	$http.get(BASE_URL + 'api/staff').then(function (Staff) {
		$scope.staff = Staff.data;
	});

	$scope.getBillingStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.billingStates = States.data;
		});
	};

	$scope.getShippingStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.shippingStates = States.data;
		});
	};

	$scope.GeneratePDF = function (ev) {
		$mdDialog.show({
			templateUrl: 'generate-order.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$scope.sendingEmail = false;
	$scope.sendEmail = function () {
		$scope.sendingEmail = true;
		$http.post(BASE_URL + 'orders/send_order_email/' + ORDERID)
			.then(
				function (response) {
					showToast(NTFTITLE, response.data.message, 'success');
					$scope.order.mail_status= response.data.sent_on;
					$scope.sendingEmail = false;
				},
				function (response) {
					$scope.sendingEmail = false;
				}
			);
	};

	$scope.CreatePDF = function () {
		$scope.PDFCreating = true;
		$http.post(BASE_URL + 'orders/create_pdf/' + ORDERID)
			.then(
				function (response) {
					console.log(response);
					if (response.data.status === true) {
						$scope.PDFCreating = false;
						$scope.CreatedPDFName = response.data.file_name;
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$http.get(BASE_URL + 'orders/get_order/' + ORDERID).then(function (OrderDetails) {
		OrderDetails.data.items.forEach(function (item, index) {
			OrderDetails.data.items[index].price = Number(item.price);
			OrderDetails.data.items[index].tax = Number(item.tax);
			OrderDetails.data.items[index].quantity = Number(item.quantity);
			OrderDetails.data.items[index].discount = Number(item.discount);
		});
		$scope.order = OrderDetails.data;
		var cust = $scope.order.customername;
		var searchCustomer = $scope.order.customername ? cust.split(' ')[0] : '';
		$scope.search_customers(searchCustomer);
		$scope.getBillingStates($scope.order.billing_country_id);
		$scope.getShippingStates($scope.order.shipping_country_id);
		$http.get(BASE_URL + 'api/customers/').then(function (Data) {
			$scope.customers = Data.data;
		});

		$scope.customer_contacts = $scope.order.customer_contacts;
		$scope.checkCustomerContacts = function (customer_contacts) {
			$mdDialog.show({
				templateUrl: 'view_contacts.html',
				scope: $scope,
				preserveScope: true,
				targetEvent: customer_contacts
			});
		}

		$scope.sendingEmailToAll = false;
		$scope.sendEmailToAll = function (customer_contacts) {
			$scope.sendingEmailToAll = true;
			let emails = [];
			for (var i = 0; i < customer_contacts.length; i++) {
				let push_email = { email: customer_contacts[i].email };
				emails.push(push_email);
			}
			var dataObj = $.param({
				emails: emails,
				include_myself: +$scope.include_myself
			});
			$http.post(BASE_URL + 'orders/send_emails/' + ORDERID, dataObj, config).then(function (response) {
				
				if (response.data.success == true) {
					$scope.order.mail_status = response.data.sent_on;
				} else {
					globals.mdToast('error', response.data.message);
				}
				$scope.sendingEmailToAll = false;
			}, function (err) {
				$scope.sendingEmailToAll = false;
			});
		}

		$scope.Convert = function (index) {
				globals.deleteDialog($scope.lang.convert_order_to_invoice, $scope.lang.convertmsg + ' ' + $scope.lang.order + ' ' + $scope.lang.to + ' ' + $scope.lang.invoice + '.?', ORDERID, $scope.lang.convert, $scope.lang.cancel, 'orders/convert_invoice/' + ORDERID, function (response) {	
				if (response.success == true) {
					window.location.href = BASE_URL + 'invoices/invoice/' + response.id;
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		$scope.Update = function () {
			window.location.href = BASE_URL + 'orders/update/' + ORDERID;
		};

		$scope.ViewOrder = function () {
			window.location.href = BASE_URL + 'share/order/' + $scope.order.token;
		};

		$scope.Delete = function (index) {
			globals.deleteDialog(lang.attention, lang.delete_order, ORDERID, lang.doIt, lang.cancel, 'orders/remove/' + ORDERID, function (response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					window.location.href = BASE_URL + 'orders';
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		
		$scope.getOrderFiles = function () {
			$http.get(BASE_URL + 'orders/get_files/' + ORDERID).then(function (Files) {
				$scope.files = Files.data;

				$scope.ViewFile = function (index, image) {
					$scope.file = $scope.files[index];
					$mdDialog.show({
						templateUrl: 'view_image.html',
						scope: $scope,
						preserveScope: true,
						targetEvent: $scope.file.id
					});
				}

				$scope.itemsPerPage = 6;
				$scope.currentPage = 0;
				$scope.range = function () {
					var rangeSize = 6;
					var ps = [];
					var start = $scope.currentPage;

					if (start > $scope.pageCount() - rangeSize) {
						start = $scope.pageCount() - rangeSize + 1;
					}
					for (var i = start; i < start + rangeSize; i++) {
						if (i >= 0) {
							ps.push(i);
						}
					}
					return ps;
				};
				$scope.prevPage = function () {
					if ($scope.currentPage > 0) {
						$scope.currentPage--;
					}
				};
				$scope.DisablePrevPage = function () {
					return $scope.currentPage === 0 ? "disabled" : "";
				};
				$scope.nextPage = function () {
					if ($scope.currentPage < $scope.pageCount()) {
						$scope.currentPage++;
					}
				};
				$scope.DisableNextPage = function () {
					return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
				};
				$scope.setPage = function (n) {
					$scope.currentPage = n;
				};
				$scope.pageCount = function () {
					return Math.ceil($scope.files.length / $scope.itemsPerPage) - 1;
				};
			});
		}
		$scope.getOrderFiles();
		$scope.UploadFile = function (ev) {
			$mdDialog.show({
				templateUrl: 'addfile-template.html',
				scope: $scope,
				preserveScope: true,
				targetEvent: ev
			});
		};

		$scope.uploading = false;
		$scope.uploadOrderFile = function () {
			$scope.uploading = true;
			var file = $scope.invoice_file;
			var uploadUrl = BASE_URL + 'orders/add_file/' + ORDERID;
			fileUpload.uploadFileToUrl(file, uploadUrl, function (response) {
				if (response.success == true) {
					$scope.invoice_file = "";
					showToast(NTFTITLE, response.message, ' success');
					$mdDialog.hide();
					$scope.getOrderFiles();
				} else {
					showToast(NTFTITLE, response.message, ' danger');
				}
				$scope.uploading = false;
			});
		};

		$scope.DeleteFile = function (id) {
			globals.deleteDialog($scope.lang.delete_file_title, $scope.lang.delete_file_message, ORDERID, $scope.lang.delete, $scope.lang.cancel, 'orders/delete_file/' + id, function (response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$scope.getOrderFiles();
				} else {
					globals.mdToast('error', response.message);
				}
			});
		}

		$scope.DeleteFiles = function (id) {
			globals.deleteDialog($scope.lang.delete_file_title, $scope.lang.delete_file_message, ORDERID, $scope.lang.delete, $scope.lang.cancel, 'orders/delete_file/' + id, function (response) {
				if (response.success == true) {
					globals.mdToast('success', response.message);
					$scope.getOrderFiles();
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		$scope.MarkAs = function (id, name) {
			var dataObj = $.param({
				status_id: id,
				order_id: ORDERID,
				name: name,
			});
			var posturl = BASE_URL + 'orders/markas/';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if (response.data.success == true) {
							globals.mdToast('success', response.data.message);
							window.location.reload();
						} else {
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.subtotal = function () {
			var subtotal = 0;
			angular.forEach($scope.order.items, function (item) {
				if (typeof item.price !== 'undefined') {
					subtotal += item.quantity * item.price;
				}
			});
			return subtotal.toFixed(2);
		};
		$scope.linediscount = function () {
			var linediscount = 0;
			var tempDis = 0;
			angular.forEach($scope.order.items, function (item) {
				if (typeof item.discount !== 'undefined') {
					linediscount += ((item.discount) / 100 * item.quantity * item.price);
					tempDis = linediscount > 0 ? linediscount : tempDis;
				}
			});
			return tempDis.toFixed(2);
		};
		$scope.totaltax = function () {
			var totaltax = 0;
			let tempVal = 0;
			angular.forEach($scope.order.items, function (item) {
				totaltax += ((item.tax) / 100 * item.quantity * item.price);
				tempVal = totaltax > 0 ? totaltax : tempVal;
			});
			return tempVal.toFixed(2);
		};
		$scope.grandtotal = function () {
			var grandtotal = 0;
			angular.forEach($scope.order.items, function (item) {
				if (typeof item.price !== 'undefined' && typeof item.tax !== 'undefined') {
					grandtotal += item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price) - ((item.discount) / 100 * item.quantity * item.price);
				} else {
					return 0;
				}
			});
			return grandtotal.toFixed(2);
		};
		//.function to check NaN.
		$scope.sub_val = function (item) {
			var sub_val = 0;
			sub_val = item.quantity * item.price + ((item.tax) / 100 * item.quantity * item.price);
			if (isNaN(sub_val)) {
				return 0;
			}
			else {
				return sub_val.toFixed(2);
			}
		};

		$http.get(BASE_URL + 'api/products').then(function (Products) {
			$scope.products = Products.data;
		});

		$http.get(BASE_URL + 'api/leads').then(function (Leads) {
			$scope.leads = Leads.data;
		});

		$scope.GetProduct = (function (search) {
			console.log(search);
			var deferred = $q.defer();
			$timeout(function () {
				deferred.resolve($scope.products);
			}, Math.random() * 500, false);
			return deferred.promise;
		});

		$scope.add = function () {
			$scope.order.items.push({
				name: new_item,
				product_id: 0,
				code: '',
				description: '',
				quantity: 1,
				unit: item_unit,
				price: 0,
				tax: 0,
				discount: 0,
				warehouse_id: '',
				product_type: ''
			});
		};
		$scope.remove = function (index) {
			var item = $scope.order.items[index];
			$http.post(BASE_URL + 'orders/remove_item/' + item.id)
				.then(
					function (response) {
						console.log(response);
						$scope.order.items.splice(index, 1);
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.change_cus_address = function (id) {
			var customer = '';
			for (var i = 0; i < $scope.customers.length; i++) {
				if ($scope.customers[i].id == id) {
					customer = $scope.customers[i];
					$scope.order.billing_street = customer.billing_street;
					$scope.order.billing_country = customer.billing_country;
					$scope.order.billing_state = customer.billing_state;
					$scope.order.billing_zip = customer.billing_zip;
					$scope.order.billing_city = customer.billing_city;
					break;
				}
			}
		$scope.order.default_payment_method = customer.default_payment_method;
		};
		$scope.ProType = $scope.order.order_type;

		$scope.saveAll = function () {
			var EndRecurring;
			if ($scope.order.recurring_enddate) {
				EndRecurring = moment($scope.order.recurring_enddate).format("YYYY-MM-DD 00:00:00");
			} else {
				EndRecurring = 'Invalid date';
			}
			if ($scope.order.date_edit) {
				$scope.order.date = moment($scope.order.date_edit).format("YYYY-MM-DD");
			} else {
				let datepicker = document.getElementById("input_31").value
				$scope.order.date = moment(datepicker,"yyyy-mm-dd").format().split("T")[0];
				console.log($scope.order.date)
			}
			if ($scope.order.opentill_edit) {
				$scope.order.opentill = moment($scope.order.opentill_edit).format("YYYY-MM-DD");
			} else{
				let datepicker = document.getElementById("input_37").value;
				$scope.order.opentill = moment(datepicker,"yyyy-mm-dd").add(1, 'day').format().split("T")[0]
				console.log($scope.order.opentill)
	
			}
			var data = tinyMCE.activeEditor.getContent({ format: 'raw' });
			var dataObj = $.param({
				customer: $scope.order.customer,
				lead: $scope.order.lead,
				comment: $scope.order.comment,
				subject: $scope.order.subject,
				content: data.replace(/&nbsp;/g, ' ').replace(/;/g, '').replace(/&nbsp/g, ' '),
				date: $scope.order.date,
				opentill: $scope.order.opentill,
				status: $scope.order.status,
				assigned: $scope.order.assigned,
				sub_total: $scope.subtotal,
				total_discount: $scope.linediscount,
				total_tax: $scope.totaltax,
				total: $scope.grandtotal,
				items: $scope.order.items,
				// Billing Address
				billing_street: $scope.order.billing_street,
				billing_city: $scope.order.billing_city,
				billing_state_id: $scope.order.billing_state_id,
				billing_zip: $scope.order.billing_zip,
				billing_country: $scope.order.billing_country_id,
				// Shipping Address
				shipping_street: $scope.order.shipping_street,
				shipping_city: $scope.order.shipping_city,
				shipping_state_id: $scope.order.shipping_state_id,
				shipping_zip: $scope.order.shipping_zip,
				shipping_country: $scope.order.shipping_country_id,
				// START Recurring
				recurring_status: $scope.order.recurring_status,
				recurring: $scope.order.recurring_status,
				end_recurring: EndRecurring,
				recurring_type: $scope.order.recurring_type,
				recurring_period: $scope.order.recurring_period,
				recurring_id: $scope.order.recurring_id,
				total_items: $scope.order.items.length,
				// END Recurring
			});
			var posturl = BASE_URL + 'orders/update/' + ORDERID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if (response.data.success == true) {
							window.location.href = BASE_URL + 'orders/order/' + response.data.id;
						} else {
							$scope.savingInvoice = false;
							showToast(NTFTITLE, response.data.message, ' danger');
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
//for update function
	$scope.copy_shipping_from_bill_to = function () {

		// Copy from customer only after click
		// if (typeof $scope.customer_this !== 'undefined') {
		// 	$scope.customer = $scope.customer_this;
		// }

		$scope.order.shipping_street = $scope.order.billing_street;
		$scope.order.shipping_city = $scope.order.billing_city;
		$scope.order.shipping_zip = $scope.order.billing_zip;
		$scope.order.shipping_country = $scope.order.billing_country;
		$scope.order.shipping_country_id = $scope.order.billing_country_id;
		$scope.order.shipping_state = $scope.order.billing_state;
		$scope.order.shipping_state_id = $scope.order.billing_state_id;
	};
	$scope.ReminderForm = buildToggler('ReminderForm');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();

		};
	}
	$scope.close = function () {
		$mdSidenav('ReminderForm').close();
	};

	$scope.CloseModal = function () {
		$mdDialog.hide();
	};

	$http.get(BASE_URL + 'api/products').then(function (Products) {
		Products.data.forEach(function (item, index) {
			Products.data[index].tax = Number(item.tax);
			Products.data[index].price = Number(item.price);
			Products.data[index].discount = Number(item.discount);
			Products.data[index].quantity = Number(item.quantity);
		})
		$scope.products = Products.data;
	});

	$http.get(BASE_URL + 'api/reminders_by_type/order/' + ORDERID).then(function (Reminders) {
		$scope.in_reminders = Reminders.data;
		$scope.AddReminder = function () {
			var dataObj = $.param({
				description: $scope.reminder_description,
				date: moment($scope.reminder_date).format("YYYY-MM-DD HH:mm:ss"),
				staff: $scope.reminder_staff,
				relation_type: 'order',
				relation: ORDERID,
			});
			var posturl = BASE_URL + 'trivia/addreminder';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$scope.in_reminders.push({
							'description': $scope.reminder_description,
							'creator': LOGGEDINSTAFFNAME,
							'avatar': UPIMGURL + LOGGEDINSTAFFAVATAR,
							'staff': LOGGEDINSTAFFNAME,
							'date': $scope.reminder_date,
						});
						$mdSidenav('ReminderForm').close();
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.DeleteReminder = function (index) {
			var reminder = $scope.in_reminders[index];
			var dataObj = $.param({
				reminder: reminder.id
			});
			var posturl = BASE_URL + 'trivia/removereminder';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.in_reminders.splice($scope.in_reminders.indexOf(reminder), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});

	$http.get(BASE_URL + 'api/notes/order/' + ORDERID).then(function (Notes) {
		$scope.notes = Notes.data;
		$scope.AddNote = function () {
			var dataObj = $.param({
				description: $scope.note,
				relation_type: 'order',
				relation: ORDERID,
			});
			var posturl = BASE_URL + 'trivia/addnote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if (response.data.success == true) {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color success'
							});
							$('.note-description').val('');
							$scope.note = '';
							$http.get(BASE_URL + 'api/notes/order/' + ORDERID).then(function (Notes) {
								$scope.notes = Notes.data;
							});
						} else {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color danger'
							});
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note.id
			});
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
}

CiuisCRM.controller('Orders_Controller', Orders_Controller);
CiuisCRM.controller('Order_Controller', Order_Controller);