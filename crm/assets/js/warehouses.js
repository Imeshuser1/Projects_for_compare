function Warehouses_Controller($http, $scope, $mdSidenav) {

	globals.get_countries();
	$scope.Create = buildToggler('Create') ;

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}



	$scope.drawChart = () => {
		$http.get(BASE_URL + 'warehouses/categories/').then(function (Data) {
			cdata = Data.data;
			titleName = Data.data[cdata.length-1]['message']
			var data = [];
			for(var i = 0; i<cdata.length-1; i++){
				data.push([cdata[i].name,parseInt(cdata[i].y)]);
			}

			Highcharts.chart('container', {
				chart: {
					polar: true,
					plotBackgroundColor: '#f3f3f3',
					plotBorderWidth: 0,
					plotShadow: false
				},
				title: { 
					text: titleName,
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
							menuItems: ['downloadPNG', 'downloadSVG','downloadPDF', 'downloadCSV', 'downloadXLS']
						}
					}
				}
			});
			function redrawchart(){
				var chart = $('#container').highcharts();
				var w = $('#container').closest(".wrapper").width()
				chart.setSize(       
					w,w * (3/4),false
				);
			}
			
			$(window).resize(redrawchart);
			redrawchart();
		});
	}
	$scope.drawChart();
	$scope.product_list = {
		order: '',
		limit: 10,
		page: 1
	};

	$scope.close = function() {
		$mdSidenav('Create').close();
	}

	$http.get(BASE_URL + 'api/table_columns/' + 'warehouse').then(function (Data) {
		$scope.table_columns = Data.data;
	});

	$scope.updateColumns = function(column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/warehouse';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
			}, function(error) {}
			);
	};

	$scope.getStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.states = States.data;
		});
	};

	$scope.warehouseLoader = true;
	$scope.warehouse_list = {
		order: '',
		limit: 5,
		page: 1
	};
	

	$scope.get_warehouses = function() {
		$http.get(BASE_URL + 'warehouses/get_warehouses').then(function(Warehouses) {
			$scope.warehouses = Warehouses.data;
			$scope.limitOptions = [5, 10, 15, 20];
			if($scope.warehouses.length > 20 ) {
				$scope.limitOptions = [5, 10, 15, 20, $scope.warehouses.length];
			}
			$scope.warehouseLoader = false;
		});
	}

	$scope.get_warehouses();
	$scope.add_warehouse = function() {
		if (!$scope.warehouse) {
			var dataObj = $.param({
				name: '',
				phone: '',
				country: '',
				state: '',
				city: '',
				zipcode: '',
				address: '',
			});
		} else {
			var dataObj = $.param({
				'name': $scope.warehouse.name,
				'phone': $scope.warehouse.phone,
				'country': $scope.warehouse.country_id,
				'state': $scope.warehouse.state_id,
				'city': $scope.warehouse.city,
				'zipcode': $scope.warehouse.zipcode,
				'address': $scope.warehouse.address,
			});
		}
		$http.post(BASE_URL + 'warehouses/add_warehouse/', dataObj, config)
		.then(
			function(response) {
				if(response.data.success) {
					$mdSidenav('Create').close();
					showToast(NTFTITLE, response.data.message, ' success');
					$scope.get_warehouses();
					$scope.emptyData();
				} else {
					showToast(NTFTITLE, response.data.message, ' danger');
				}
			}
		)
	}

	$scope.emptyData = function() {
		$scope.warehouse.name = '';
		$scope.warehouse.phone = '';
		$scope.warehouse.country_id = '';
		$scope.warehouse.state_id = '';
		$scope.warehouse.city = '';
		$scope.warehouse.zipcode = '';
		$scope.warehouse.address = '';
	}
}

function Warehouse_Controller($http, $scope, $mdSidenav) {

	globals.get_countries();
	$scope.getStates = function (country) {
		$http.get(BASE_URL + 'api/get_states/' + country).then(function (States) {
			$scope.states = States.data;
		});
	};

	$scope.Update = buildToggler('Update') ;

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function() {
		$mdSidenav('Update').close();
	}

	$scope.warehouseLoader = true;
	$scope.get_warehouses = function() {
		$http.get(BASE_URL + 'warehouses/get_warehouse/' + warehouse_id ).then(function(Warehouse) {
			$scope.warehouse = Warehouse.data;
			$scope.getStates($scope.warehouse.country);
			$scope.warehouseLoader = false;
		});
	}

	$scope.get_warehouses();
	$scope.update_warehouse = function() {
		if (!$scope.warehouse) {
			var dataObj = $.param({
				name: '',
				phone: '',
				country: '',
				state: '',
				city: '',
				zipcode: '',
				address: '',
			});
		} else {
			var dataObj = $.param({
				'name': $scope.warehouse.warehouse_name,
				'phone': $scope.warehouse.phone,
				'country': $scope.warehouse.country,
				'state': $scope.warehouse.state,
				'city': $scope.warehouse.city,
				'zipcode': $scope.warehouse.zip,
				'address': $scope.warehouse.address,
			});
		}
		$http.post(BASE_URL + 'warehouses/warehouse/' + warehouse_id, dataObj, config)
		.then(
			function(response) {
				if(response.data.success) {
					$mdSidenav('Update').close();
					showToast(NTFTITLE, response.data.message, ' success');
					$scope.get_warehouses();
				} else {
					showToast(NTFTITLE, response.data.message, ' danger');
				}
			}
		)
	}

	$scope.delete_warehouse = function (index) {
		globals.deleteDialog(lang.attention, lang.delete_message+'.?', warehouse_id, lang.doIt, lang.cancel, 'warehouses/remove_warehouse/' + warehouse_id, function(response) {
			if (response.success == true) {
				window.location.href = BASE_URL + 'warehouses';
				globals.mdToast('success',response.message);
			} else {
				globals.mdToast('error',response.message);
			}
		});
	};
}

CiuisCRM.controller('Warehouses_Controller', Warehouses_Controller);
CiuisCRM.controller('Warehouse_Controller', Warehouse_Controller);