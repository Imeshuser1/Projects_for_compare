function Inventories_Controller($scope, $http, $mdSidenav, $element, $q, $timeout) {

	$http.get(BASE_URL + 'api/table_columns/' + 'inventories').then(function (Data) {
		$scope.table_columns = Data.data;
	});

	$scope.updateColumns = function (column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/inventories';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
				}, function (error) { }
			);
	};

	$scope.Create = buildToggler('Create');
	$scope.CreateWarehouse = buildToggler('CreateWarehouse');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function () {
		$mdSidenav('Create').close();
		$mdSidenav('CreateWarehouse').close();
	}

	// $http.get(BASE_URL + 'api/get_product_categories').then(function (Categories) {
	// 	$scope.categories = Categories.data;
	// });

	$http.get(BASE_URL + 'inventories/get_movement_type').then(function (Movements) {
		$scope.movements = Movements.data;
	});

	$scope.clearSearchTerm = function () {
		$scope.searchTerm = '';
	};

	$element.find('input').on('keydown', function (ev) {
		ev.stopPropagation();
	});

	$http.get(BASE_URL + 'api/products').then(function (Products) {
		Products.data.forEach(function (item, index) {
			Products.data[index].tax = Number(item.tax);
			Products.data[index].price = Number(item.price);
			Products.data[index].discount = Number(item.discount);
			Products.data[index].quantity = Number(item.quantity);
		})
		$scope.products = Products.data;
	});
	// $scope.GetProduct = (function (q) {
	// 	var q = q ? q : '';
	// 	if (q.length > 0) {
	// 		$http.get(BASE_URL + 'api/search_products/' + q).then(function (Products) {
	// 			$scope.products = Products.data;
	// 			//lib.url.bind();
	// 		});
	// 	} else {
	// 		$scope.products = [];
	// 	}
	// 	var deferred = $q.defer();
	// 	$timeout(function () {
	// 		deferred.resolve($scope.products);
	// 	}, Math.random() * 500, false);
	// 	return deferred.promise;
	// });

	//SEARCH
	$scope.GetProduct = (function (q) {
		var deferred = $q.defer();
		$timeout(function () {
			deferred.resolve($scope.products);
		}, Math.random() * 500, false);
		return deferred.promise;
	});

	$scope.inventoryLoader = true;
	$scope.inventory_list = {
		order: '',
		limit: 5,
		page: 1
	};

	$scope.drawChart = () => {
		$http.get(BASE_URL + 'inventories/inventory_by_product_category/').then(function (Data) {
			var cdata  = Data.data;
			var data = [];
			for (var i = 0; i < cdata.length; i++) {
				data.push([cdata[i].name, parseInt(cdata[i].count)]);
			}

			Highcharts.chart('inven_container', {
				chart: {
					polar: true,
					plotBackgroundColor: '#f3f3f3',
					plotBorderWidth: 0,
					plotShadow: false
				},
				title: {
					text: lang.inventories,
					align: 'center',
					verticalAlign: 'middle',
					y: -18
				},
				tooltip: {
					pointFormat: '<b>{point.y}</b>'
				},
				credits: {
					enabled: false
				},
				plotOptions: {
					pie: {
						dataLabels: {
							enabled: true,
							distance: -50,
							style: {
								fontWeight: 'bold',
								color: 'white'
							}
						},
						// startAngle: -90,
						// endAngle: 90,
						center: ['50%', '47%'],
						size: '100%'
					}
				},
				series: [
					{
						type: 'pie',
						name: '',
						innerSize: '42%',
						data: data
					}],
				exporting: {
					buttons: {
						contextButton: {
							menuItems: ['downloadPNG', 'downloadSVG', 'downloadPDF', 'downloadCSV', 'downloadXLS']
						}
					}
				}
			});
			function redrawchart() {
				var chart = $('#inven_container').highcharts();
				var w = $('#inven_container').closest(".wrapper").width()
				chart.setSize(
					w, w * (3 / 4), false
				);
			}

			$(window).resize(redrawchart);
			redrawchart();
		});
	}
	
	$scope.product_list = {
		order: '',
		limit: 10,
		page: 1
	};

	$http.get(BASE_URL + 'inventories/get_inventories').then(function (Inventories) {
		$scope.inventories = Inventories.data;
		$scope.limitOptions = [5, 10, 15, 20];
		if ($scope.inventories.length > 20) {
			$scope.limitOptions = [5, 10, 15, 20, $scope.inventories.length];
		}
		$scope.inventoryLoader = false;
	});

	if (!globals.chartFlag) {
		$scope.drawChart();
		globals.chartFlag = true;
	}
	$scope.get_warehouses = function () {
		$http.get(BASE_URL + 'warehouses/get_warehouses').then(function (Warehouses) {
			$scope.warehouses = Warehouses.data;
		});
	}

	$scope.get_warehouses();

	$scope.AddInventory = function () {
		if (!$scope.inventory || !$scope.selectedProduct) {
			var dataObj = $.param({
				product_id: '',
				product_type: '',
				category_id: '',
				cost_price: '',
				stock: '',
				warehouse: '',
				move_type: ''
			});
		} else {

			var dataObj = $.param({
				product_id: $scope.selectedProduct.product_id,
				product_type: $scope.selectedProduct.product_type,
				category_id: $scope.selectedProduct.categoryid,
				cost_price: $scope.selectedProduct.purchase_price,
				stock: $scope.inventory.stock,
				warehouse: $scope.selectedProduct.warehouse_id,
				warehouse_to: $scope.inventory.warehouse_to,
				move_type: $scope.inventory.move_type,
				product_code: $scope.selectedProduct.product_code,

			});

		}
		var posturl = BASE_URL + 'inventories/create_inventory/';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if (response.data.success == true) {
						$mdSidenav('Create').close();
						globals.mdToast('success', response.data.message);
						$http.get(BASE_URL + 'inventories/get_inventories').then(function (Inventories) {
							$scope.inventories = Inventories.data;
							$scope.emptyData();
						});
						$scope.drawChart();
					} else {
						globals.mdToast('error', response.data.message);
					}
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.emptyData = function () {
		$scope.selectedProduct.product_id = '';
		$scope.selectedProduct.product_type = '';
		$scope.selectedProduct.categoryid = '';
		$scope.selectedProduct.purchase_price = '';
		$scope.selectedProduct.product_type_value = '';
		$scope.inventory.stock = '';
		$scope.selectedProduct.warehouse_name = '';
		$scope.inventory.move_type = '';

	}
}

function Inventory_Controller($scope, $http, $mdSidenav, $element, $q, $timeout) {

	$scope.Update = buildToggler('Update');
	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}
	$scope.close = function () {
		$mdSidenav('Update').close();
	};

	$scope.inventoryLoader = true;
	$http.get(BASE_URL + 'inventories/get_inventory/' + INVENTORY_ID).then(function (InventoryDetails) {
		$scope.inventory = InventoryDetails.data;
		$scope.inventoryLoader = false;
	});

	$http.get(BASE_URL + 'api/products/inventory').then(function (Products) {
		$scope.products = Products.data;
	});

	$http.get(BASE_URL + 'warehouses/get_warehouses').then(function (Warehouses) {
		$scope.warehouses = Warehouses.data;
	});

	$http.get(BASE_URL + 'inventories/get_movement_type').then(function (Movements) {
		$scope.movements = Movements.data;
	});

	$scope.clearSearchTerm = function () {
		$scope.searchTerm = '';
	};

	$element.find('input').on('keydown', function (ev) {
		ev.stopPropagation();
	});

	$scope.GetProduct = (function (q) {
		var deferred = $q.defer();
		$timeout(function () {
			deferred.resolve($scope.products);
		}, Math.random() * 500, false);
		return deferred.promise;
	});
	$scope.DeleteInventory = function (index) {
		globals.deleteDialog(lang.attention, lang.delete_message + '.?', INVENTORY_ID, lang.doIt, lang.cancel, 'inventories/remove_inventory/' + INVENTORY_ID, function (response) {
			if (response.success == true) {
				window.location.href = BASE_URL + 'inventories';
				globals.mdToast('success', response.message);
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};

	$scope.UpdateInventory = function () {
		$scope.savingInventory = true;
		var dataObj = $.param({
			product_id: $scope.inventory.product_id,
			category_id: $scope.inventory.category_id,
			product_type: $scope.inventory.product_type_id,
			producttype:$scope.inventory.product_type_value,
			cost_price: $scope.inventory.cost_price,
			stock: $scope.inventory.stock_qty,
			warehouse: $scope.inventory.warehouse_id,
			warehouse_to: $scope.inventory.warehouse_to,
			move_type: $scope.inventory.move_type_id
		});
		/*function to lower case*/
		$http.post(BASE_URL + 'inventories/update_inventory/' + INVENTORY_ID, dataObj, config)
			.then(
				function (response) {
					$scope.savingInventory = false;
					if (response.data.success == true) {
						$mdSidenav('Update').close();
						globals.mdToast('success', response.data.message);
						$http.get(BASE_URL + 'inventories/get_inventory/' + INVENTORY_ID).then(function (InventoryDetails) {
							$scope.inventory = InventoryDetails.data;
						});
					} else {
						globals.mdToast('error', response.data.message);
					}
				}
			);
	}

}

CiuisCRM.controller('Inventories_Controller', Inventories_Controller);
CiuisCRM.controller('Inventory_Controller', Inventory_Controller);