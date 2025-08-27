function Products_Controller($scope, $http, $mdSidenav, $filter, $mdDialog, $compile, fileUpload) {
	"use strict";

	$http.get(BASE_URL + 'api/table_columns/' + 'products').then(function (Data) {
		$scope.table_columns = Data.data;
	});

	$http.get(BASE_URL + 'warehouses/get_warehouses').then(function(Warehouses) {
		$scope.warehouses = Warehouses.data;
	});

	$scope.updateColumns = function(column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/products';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
			}, function(error) {}
			);
	};
	
	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'product').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = $filter('filter')($scope.all_custom_fields, {
			active: 'true',
		});
	});

	$scope.Create = buildToggler('Create');
	$scope.CreateCategory = buildToggler('CreateCategory');
	$scope.ImportProductsNav = buildToggler('ImportProductsNav');
	$scope.addUnit = buildToggler('addUnit');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.importing = false;
	$scope.importerror = false;
	$scope.importProduct = function(){
		$scope.importing = true;
		var file = $scope.product_file;
		var uploadUrl = BASE_URL+'products/productsimport/';
		fileUpload.uploadFileToUrl(file, uploadUrl, function(response){			
			if((response.success == true) && (response.errors.length == 0)){
				globals.mdToast('success', response.message);
				$mdSidenav('ImportProductsNav').close();
			} else if ((response.success == false) && (response.errors.length > 0)) {
				$scope.importerror = true;
				$scope.errors = response.errors;
				console.log(response.errors);
				globals.mdToast('error', response.message);
			} else {
				$scope.importerror = true;
				$scope.errors = response.errors;
				globals.mdToast('error', response.message);
				console.log(response.errors);
			}
			$http.get(BASE_URL + 'products/get_products').then(function (Products) {
				$scope.products = Products.data;
			});
			$scope.productFiles = true;
			$scope.importing = false;
			
		});
	};

	$scope.close = function () {
		$mdSidenav('Create').close();
		$mdSidenav('CreateCategory').close();
		$mdSidenav('ImportProductsNav').close();
		$mdSidenav('addUnit').close();
	};

	var cdata;
	
	$scope.drawChart = () => {
		$http.get(BASE_URL + 'products/categories/').then(function (Data) {
			cdata = Data.data;
			var data = [];
			for(var i = 0; i<cdata.length; i++){
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
					text: lang.product+'<br>'+lang.categories,
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
	$http.get(BASE_URL + 'products/get_products').then(function (Products) {
		for (let key in Products.data) {
			Products.data[key].stock = (Products.data[key].stock == -1)? "":Products.data[key].stock
		}
		$scope.products = Products.data;
		$scope.limitOptions = [10, 15, 20];
		if ($scope.products.length > 20) {
			$scope.limitOptions = [10, 15, 20, $scope.products.length];
		}

		$http.get(BASE_URL + 'products/get_product_categories').then(function (Categories) {
			$scope.category = Categories.data;

			$scope.NewCategory = function () {
				globals.createDialog( lang.addProductCategory , lang.type_categoryname, lang.categoryname, '', lang.add, lang.cancel, 'products/add_category/',  function(response) {
					if (response.success == true) {
						globals.mdToast('success', response.message);
					} else {
						globals.mdToast('error', response.message);
					}
					$http.get(BASE_URL + 'products/get_product_categories').then(function (Categories) {
						$scope.category = Categories.data;
					});
				});
			};

			$scope.EditCategory = function (id, name, event) {
				globals.editDialog( lang.edit + lang.categoryname , lang.type_categoryname, lang.categoryname, name, event, lang.save, lang.cancel, 'products/update_category/' + id, function(response) {
					if (response.success == true) {
						globals.mdToast('success', response.message);
						$http.get(BASE_URL + 'products/get_product_categories').then(function (Categories) {
							$scope.category = Categories.data;
						});
					} else {
						globals.mdToast('error', response.message);
					}
				});
			};

			$scope.DeleteProductCategory = function (index) {
				var name = $scope.category[index];
				globals.deleteDialog(lang.attention, lang.confirm_product_category_delete, name.id, lang.doIt, lang.cancel, 'products/remove_category/' + name.id, function(response) {
					if (response.success == true) {
						globals.mdToast('success', response.message);
						$http.get(BASE_URL + 'products/get_product_categories').then(function (Categories) {
							$scope.category = Categories.data;
						});
					} else {
						globals.mdToast('error', response.message);
					}
				});
			};

			$scope.deleteProduct = function (PRODUCTID) {
				// Appending dialog to document.body to cover sidenav in docs app
				var confirm = $mdDialog.confirm()
					.title(lang.attention)
					.textContent(lang.productattentiondetail)
					.ariaLabel(lang.delete + ' ' + lang.product)
					.targetEvent(PRODUCTID)
					.ok(lang.doIt)
					.cancel(lang.cancel);

				$mdDialog.show(confirm).then(function () {
					$http.post(BASE_URL + 'products/remove/' + PRODUCTID, config)
						.then(
							function (response) {
								if (response.data.success == true) {
									$.gritter.add({
										title: '<b>' + NTFTITLE + '</b>',
										text: response.data.message,
										class_name: 'color success'
									});
								}
								$http.get(BASE_URL + 'products/get_products').then(function (Products) {
									$scope.products = Products.data;
								});
							},
							function (response) {
								console.log(response);
							}
						);

				}, function () {
				});
			};
		});

		$scope.AddProduct = function () {
			$scope.tempArr = [];
			angular.forEach($scope.custom_fields, function (value) {
				if (value.type === 'input') {
					$scope.field_data = value.data;
				}
				if (value.type === 'textarea') {
					$scope.field_data = value.data;
				}
				if (value.type === 'date') {
					$scope.field_data = moment(value.data).format("YYYY-MM-DD");
				}
				if (value.type === 'select') {
					$scope.field_data = JSON.stringify(value.selected_opt);
				}
				$scope.tempArr.push({
					id: value.id,
					name: value.name,
					type: value.type,
					order: value.order,
					data: $scope.field_data,
					relation: value.relation,
					permission: value.permission,
				});
			});

			if (!$scope.product) {
				var dataObj = $.param({
					name: '',
					category: '',
					purchaseprice: '',
					saleprice: '',
					code: '',
					tax: '',
					stock: '',
					description: '',
					custom_fields: ''
				});
			} else {
				var dataObj = $.param({
					name: $scope.product.productname,
					categoryid: $scope.product.categoryid,
					purchaseprice: $scope.product.purchase_price,
					saleprice: $scope.product.sale_price,
					code: $scope.product.code,
					tax: $scope.product.vat,
					stock: $scope.product.stock,
					description: $scope.product.description,
					custom_fields: $scope.tempArr,
					product_type: $scope.product.type,
					unit_measure: $scope.product.unit,
					warehouse: $scope.product.warehouse,
				});
			}
			var posturl = BASE_URL + 'products/create/';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if (response.data.success == true) {
							$.gritter.add({
								title: '<b>' + NTFTITLE + '</b>',
								text: response.data.message,
								class_name: 'color success'
							});
							$mdSidenav('Create').close();
							$http.get(BASE_URL + 'products/get_products').then(function (Products) {
								$scope.products = Products.data;
								$scope.emptyData();
								$scope.drawChart();
							});
						} else {
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});

	$scope.emptyData = function() {
		$scope.product.productname =  '';
		$scope.product.categoryid = '';
		$scope.product.purchase_price = '';
		$scope.product.sale_price = '';
		$scope.product.code = '';
		$scope.product.vat = '';
		$scope.product.stock = '';
		$scope.product.description = '';
		$scope.product.type = '';
		$scope.product.unit = '';
		$scope.product.warehouse = '';
	}

	$scope.get_units();
	
	$scope.NewUnit = function () {
		globals.createDialog($scope.lang.uom, $scope.lang.type_uom,$scope.lang.uom,  event, $scope.lang.add, $scope.lang.cancel, 'products/add_unit', function(response) {
			if (response.success == true) {
				globals.mdToast('success', response.message);
				$scope.get_units();
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};
/*lower case for editunit link*/
	$scope.EditUnit= function (unit_id, unit_name, event) { 
		globals.editDialog($scope.lang.edit+' '+$scope.lang.uom, $scope.lang.type_uom, $scope.lang.uom, unit_name, event, $scope.lang.save, $scope.lang.cancel, 'products/edit_unit/'+unit_id, function(response) {
			if (response.success == true) {
				globals.mdToast('success', response.message);
				$scope.get_units();
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};
/*lower case for deleteunit link*/
	$scope.DeleteUnit = function (unitId) { 
		globals.deleteDialog($scope.lang.delete+' '+$scope.lang.uom, $scope.lang.delete_meesage+' '+$scope.lang.uom+'?', unitId, $scope.lang.delete, $scope.lang.cancel, 'products/delete_unit/'+unitId, function(response) {
			if (response.success == true) {
				globals.mdToast('success', response.message);
				$scope.get_units();
			} else {
				globals.mdToast('error', response.message);
			}
		});
	};
	
}

function Product_Controller($scope, $http, $mdSidenav, $mdDialog) {
	"use strict";

	$http.get(BASE_URL + 'warehouses/get_warehouses').then(function(Warehouses) {
		$scope.warehouses = Warehouses.data;
	});

	$scope.Update = buildToggler('Update');
	$scope.toggleFilter = buildToggler('ContentFilter');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function () {
		$mdSidenav('Update').close();
	};

	$http.get(BASE_URL + 'api/custom_fields_data_by_type/' + 'product/' + PRODUCTID).then(function (custom_fields) {
		$scope.custom_fields = custom_fields.data;
	});

	$http.get(BASE_URL + 'products/get_product/' + PRODUCTID).then(function (Product) {
		Product.data.stock = (Product.data.stock == -1)? '':Product.data.stock;
		$scope.product = Product.data;
	});

	$http.get(BASE_URL + 'products/get_product_categories').then(function (Categories) {
		$scope.category = Categories.data;
	});

	$scope.UpdateProduct = function () {
		$scope.tempArr = [];
		angular.forEach($scope.custom_fields, function (value) {
			if (value.type === 'input') {
				$scope.field_data = value.data;
			}
			if (value.type === 'textarea') {
				$scope.field_data = value.data;
			}
			if (value.type === 'date') {
				$scope.field_data = moment(value.data).format("YYYY-MM-DD");
			}
			if (value.type === 'select') {
				$scope.field_data = JSON.stringify(value.selected_opt);
			}
			$scope.tempArr.push({
				id: value.id,
				name: value.name,
				type: value.type,
				order: value.order,
				data: $scope.field_data,
				relation: value.relation,
				permission: value.permission,
			});
		});
		if($scope.product.type == '1' || $scope.product.type == '3' || $scope.product.type == '4') {
			$scope.product.stock = '';
		}
		if (!$scope.product) {
			var dataObj = $.param({
				name: '',
				category: '',
				purchaseprice: '',
				saleprice: '',
				code: '',
				tax: '',
				stock: '',
				description: '',
				custom_fields: '',
			});
		} else {

			let stockStatus = ($scope.product.stock == '')? -1:$scope.product.stock;

			var dataObj = $.param({
				name: $scope.product.productname,
				categoryid: $scope.product.categoryid,
				purchaseprice: $scope.product.purchase_price,
				saleprice: $scope.product.sale_price,
				code: $scope.product.code,
				tax: $scope.product.vat,
				stock: stockStatus,
				description: $scope.product.description,
				custom_fields: $scope.tempArr,
				product_type: $scope.product.type,
				unit_measure: $scope.product.unit_id,
				warehouse: $scope.product.warehouse_id,
			});
		}

		var posturl = BASE_URL + 'products/update/' + PRODUCTID;
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
				if (response.data.success == true) {
					globals.mdToast('success', response.data.message );
					$mdSidenav('Update').close();
					$http.get(BASE_URL + 'products/get_product/' + PRODUCTID).then(function (Product) {
						Product.data.stock =
            Product.data.stock == -1 ? "" : Product.data.stock;
            $scope.product = Product.data;
					});
				} else {
					globals.mdToast('error', response.data.message );
				}
			},
			function (response) {
				console.log(response);
			}
			);
	};

	$scope.Delete = function () {
		// Appending dialog to document.body to cover sidenav in docs app
		var confirm = $mdDialog.confirm()
		.title(lang.attention)
		.textContent(lang.productattentiondetail)
		.ariaLabel(lang.delete + ' ' + lang.product)
		.targetEvent(PRODUCTID)
		.ok(lang.doIt)
		.cancel(lang.cancel);

		$mdDialog.show(confirm).then(function () {
			$http.post(BASE_URL + 'products/remove/' + PRODUCTID, config)
			.then(
					function (response) {
						console.log(response);
						window.location.href = BASE_URL + 'products';
					},
					function (response) {
						console.log(response);
					}
			);
		});
	};

	
	$scope.get_units();
}

CiuisCRM.controller('Products_Controller', Products_Controller);
CiuisCRM.controller('Product_Controller', Product_Controller);
