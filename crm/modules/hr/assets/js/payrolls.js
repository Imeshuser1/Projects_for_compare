function Payrolls_Controller($scope, $compile, $http, $mdSidenav, $q, $timeout, $filter) {
  "use strict";

  $http.get(BASE_URL + 'api/table_columns/' + 'payrolls').then(function (Data) {
    $scope.table_columns = Data.data;
  });

  $scope.payroll = {
    allowances: [{
      name: new_item,
      description: '',
      time: 1,
      quantity: 1,
      price: 0,
    }],
    deductions: [{
      name: new_item,
      description: '',
      time: 1,
      quantity: 1,
      price: 0,
    }]
  };

  $scope.add_allowance = function () {
    $scope.payroll.allowances.push({
      name: new_item,
      description: '',
      time: 1,
      quantity: 1,
      price: 0,
    });
  };

  $scope.add_deduction = function () {
    $scope.payroll.deductions.push({
      name: new_item,
      description: '',
      time: 1,
      quantity: 1,
      price: 0,
    });
  };

  $scope.remove_allowance = function (index) {
    $scope.payroll.allowances.splice(index, 1);
  };

  $scope.remove_deduction = function (index) {
    $scope.payroll.deductions.splice(index, 1);
  };

  $scope.run_days = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];

  $scope.allowancetotal = function () {
    var allowancetotal = 0;
    angular.forEach($scope.payroll.allowances, function (allowance) {
      allowancetotal += allowance.quantity * allowance.price * allowance.time;
    });
    return allowancetotal.toFixed(2);
  };

  $scope.deductiontotal = function () {
    var deductiontotal = 0;
    angular.forEach($scope.payroll.deductions, function (deduction) {
      deductiontotal += deduction.quantity * deduction.price * deduction.time;
    });
    return deductiontotal.toFixed(2);
  };

  $scope.grandtotal = function () {
    var grandtotal = 0;
    var allowance = 0;
    var deduction = 0;
    allowance = $scope.allowancetotal();
    deduction = $scope.deductiontotal();
    grandtotal = $scope.base_salary + (allowance - deduction);
    return grandtotal.toFixed(2);
  };

  $http.get(BASE_URL + 'api/expensescategories').then(function (Expense_Categories) {
    $scope.expense_categories = Expense_Categories.data;
  });

  $http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
    $scope.accounts = Accounts.data;
  });

  $scope.get_staff();

  $scope.payrollLoader = true;
  var deferred = $q.defer();
  $scope.payroll_list = {
    order: '',
    limit: 10,
    page: 1
  };


  $scope.saveAll = function () {
    $scope.savingPayroll = true;

    var payroll_recurring;
    if ($scope.payroll_recurring == true) {
      payroll_recurring = '1';
    } else {
      payroll_recurring = '0';
    }
    if ($scope.enddate) {
      $scope.enddate = moment($scope.enddate).format("YYYY-MM-DD");
    }
    if ($scope.startdate) {
      $scope.startdate = moment($scope.startdate).format("YYYY-MM-DD");
    }

    var dataObj = $.param({
      recurring: payroll_recurring,
      staff: $scope.member.id,
      expense_categories: $scope.expense_category,
      startdate: $scope.startdate,
      base_salary: +$scope.base_salary,
      account: $scope.account,
      run_day: $scope.run_day,
      enddate: $scope.enddate,
      payrollnote: $scope.payrollnote,
      total_allowance: $scope.allowancetotal,
      total: $scope.grandtotal,
      total_deduction: $scope.deductiontotal,
      allowances: $scope.payroll.allowances,
      deductions: $scope.payroll.deductions,
    });

    var posturl = BASE_URL + 'hr/payrolls/create';
    $http.post(posturl, dataObj, config)
      .then(
        function (response) {
          if (response.data.success == true) {
            window.location.href = BASE_URL + 'hr/payrolls/payroll/' + response.data.id;
          } else {
            $scope.savingPayroll = false;
            showToast(NTFTITLE, response.data.message, ' danger');
          }
        },
        function (response) {
          $scope.savingPayroll = false;
        }
      );
  };


  $scope.promise = deferred.promise;
  $http.get(BASE_URL + 'hr/api/payrolls').then(function (Payrolls) {
    $scope.payrolls = Payrolls.data;
    deferred.resolve();

    $scope.limitOptions = [5, 10, 15, 20];
    if ($scope.payrolls.length > 20) {
      $scope.limitOptions = [5, 10, 15, 20, $scope.payrolls.length];
    }

    $scope.payrollLoader = false;
    $scope.search = {
      customer: ''
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
    // $scope.filter = {};
    // $scope.getOptionsFor = function (propName) {
    // 	return ($scope.invoices || []).map(function (item) {
    // 		return item[propName];
    // 	}).filter(function (item, idx, arr) {
    // 		return arr.indexOf(item) === idx;
    // 	}).sort();
    // };
    // $scope.FilteredData = function (item) {
    // 	// Use this snippet for matching with AND
    // 	var matchesAND = true;
    // 	for (var prop in $scope.filter) {
    // 		if (noSubFilter($scope.filter[prop])) {
    // 			continue;
    // 		}
    // 		if (!$scope.filter[prop][item[prop]]) {
    // 			matchesAND = false;
    // 			break;
    // 		}
    // 	}
    // 	return matchesAND;

    // };

    // function noSubFilter(subFilterObj) {
    // 	for (var key in subFilterObj) {
    // 		if (subFilterObj[key]) {
    // 			return false;
    // 		}
    // 	}
    // 	return true;
    // }
    $scope.updateDropdown = function (_prop) {
      var _opt = this.filter_select,
        _optList = this.getOptionsFor(_prop),
        len = _optList.length;

      if (_opt == 'all') {
        for (let j = 0; j < len; j++) {
          $scope.filter[_prop][_optList[j]] = true;
        }
      } else {
        for (let j = 0; j < len; j++) {
          $scope.filter[_prop][_optList[j]] = false;
        }
        $scope.filter[_prop][_opt] = true;
      }
    };
  });

}

function Payroll_Controller($scope, $compile, $http, $mdSidenav, $q, $timeout, $filter) {
  "use strict";

  $scope.payrollLoader = true;
  $http.get(BASE_URL + 'hr/payrolls/get_payroll/' + PAYROLLID).then(function (PayrollData) {
    $scope.payroll = PayrollData.data;

    $http.get(BASE_URL + 'hr/payrolls/payslips_for_payroll/' + PAYROLLID).then(function (PayslipsData) {
      $scope.payslips = PayslipsData.data;
    });

    $http.get(BASE_URL + 'api/staff/').then(function (Data) {
      $scope.staff = Data.data;
    });

    $http.get(BASE_URL + 'api/expensescategories').then(function (Expense_Categories) {
      $scope.expense_categories = Expense_Categories.data;
    });

    $http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
      $scope.accounts = Accounts.data;
    });

    $scope.add_allowance = function () {
      $scope.payroll.allowances.push({
        payroll_item_name: new_item,
        payroll_item_description: '',
        payroll_item_time: 1,
        payroll_item_quantity: 1,
        payroll_item_price: 0,
      });
    };

    $scope.add_deduction = function () {
      $scope.payroll.deductions.push({
        payroll_item_name: new_item,
        payroll_item_description: '',
        payroll_item_time: 1,
        payroll_item_quantity: 1,
        payroll_item_price: 0,
      });
    };

    $scope.run_days = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];

    $scope.allowancetotal = function () {
      var allowancetotal = 0;
      angular.forEach($scope.payroll.allowances, function (allowance) {
        allowancetotal += allowance.payroll_item_quantity * allowance.payroll_item_price * allowance.payroll_item_time;
      });
      return allowancetotal.toFixed(2);
    };

    $scope.deductiontotal = function () {
      var deductiontotal = 0;
      angular.forEach($scope.payroll.deductions, function (deduction) {
        deductiontotal += deduction.payroll_item_quantity * deduction.payroll_item_price * deduction.payroll_item_time;
      });
      return deductiontotal.toFixed(2);
    };

    $scope.grandtotal = function () {
      var grandtotal = 0;
      var allowance = 0;
      var deduction = 0;
      allowance = $scope.allowancetotal();
      deduction = $scope.deductiontotal();
      grandtotal = $scope.payroll.payroll_base_salary + (allowance - deduction);
      return grandtotal.toFixed(2);
    };

    $scope.Delete = function () {
      // Appending dialog to document.body to cover sidenav in docs app
      var confirm = $mdDialog.confirm()
        .title($scope.lang.delete_payroll)
        .textContent($scope.lang.payroll_rmv_msg)
        .ariaLabel('Delete Payroll')
        .targetEvent(PAYROLLID)
        .ok($scope.lang.delete)
        .cancel($scope.lang.cancel);

      $mdDialog.show(confirm).then(function () {
        $http.post(BASE_URL + 'hr/payrolls/remove/' + PAYROLLID, config)
          .then(
            function (response) {
              if (response.data.success == true) {
                window.location.href = BASE_URL + 'hr/payrolls';
                globals.mdToast('success', response.data.message);
              } else {
                globals.mdToast('error', response.data.message);
              }
            },
            function (response) {
              console.log(response);
            }
          );
      });
    };

    $scope.remove_allowance = function (index) {
      var item = $scope.payroll.allowances[index];
      $http.post(BASE_URL + 'hr/payrolls/remove_allowance/' + item.payroll_item_id)
        .then(
          function (response) {
            $scope.payroll.allowances.splice(index, 1);
            // $scope.payroll.balance = $scope.payroll.balance - item.total;
            // $scope.amount = $scope.payroll.balance;
          },
          function (response) {
            console.log(response);
          }
        );
    };

    $scope.remove_deduction = function (index) {
      var item = $scope.payroll.deductions[index];
      $http.post(BASE_URL + 'hr/payrolls/remove_deduction/' + item.payroll_item_id)
        .then(
          function (response) {
            console.log(response);
            $scope.payroll.deductions.splice(index, 1);
            // $scope.payroll.balance = $scope.payroll.balance - item.total;
            // $scope.amount = $scope.payroll.balance;
          },
          function (response) {
            console.log(response);
          }
        );
    };

    $scope.saveAll = function () {
      $scope.savingPayroll = true;

      if ($scope.payroll.payroll_end_date) {
        $scope.payroll.payroll_end_date = moment($scope.payroll.payroll_end_date).format("YYYY-MM-DD");
      }
      if ($scope.payroll.payroll_start_date) {
        $scope.payroll.payroll_start_date = moment($scope.payroll.payroll_start_date).format("YYYY-MM-DD");
      }
      var dataObj = $.param({
        payroll_recurring: $scope.payroll.payroll_recurring,
        staff: $scope.payroll.payroll_relation_id,
        expense_categories: $scope.payroll.payroll_expense_category,
        startdate: $scope.payroll.payroll_start_date,
        base_salary: $scope.payroll.payroll_base_salary,
        account: $scope.payroll.payroll_account,
        run_day: $scope.payroll.payroll_run_day,
        enddate: $scope.payroll.payroll_end_date,
        payrollnote: $scope.payroll.payroll_note,
        total_allowance: $scope.allowancetotal,
        total: $scope.grandtotal,
        total_deduction: $scope.deductiontotal,
        allowances: $scope.payroll.allowances,
        deductions: $scope.payroll.deductions,
      });

      var posturl = BASE_URL + 'hr/payrolls/update/' + PAYROLLID;
      $http.post(posturl, dataObj, config)
        .then(
          function (response) {
            if (response.data.success == true) {
              window.location.href = BASE_URL + 'hr/payrolls/payroll/' + response.data.id;
            } else {
              $scope.savingPayroll = false;
              showToast(NTFTITLE, response.data.message, ' danger');
            }
          },
          function (response) {
            $scope.savingPayroll = false;
            console.log(response);
            showToast(NTFTITLE, response.data.message, ' danger');
          }
        );
    };

    $scope.convert_payroll = function ($payroll_id) {

      $http.post(BASE_URL + 'hr/payrolls/convert_payroll/' + $payroll_id)
        .then(
          function (response) {
            if (response.data.success == true) {
              window.location.href = BASE_URL + 'hr/payslips/payslip/' + response.data.id;
            } else {
              $scope.savingPayroll = false;
              showToast(NTFTITLE, response.data.message, ' danger');
            }
          },
          function (response) {
            $scope.savingPayroll = false;
            console.log(response);
            showToast(NTFTITLE, response.data.message, ' danger');
          }
        );
    };

    $scope.send_payslip_email = function ($payslip_id) {
      $http.post(BASE_URL + 'hr/payrolls/send_payslip_email/' + $payslip_id)
        .then(
          function (response) {
            if (response.data.success == true) {
              showToast(NTFTITLE, response.data.message, ' success');
            } else {
              showToast(NTFTITLE, response.data.message, ' danger');
            }
          },
          function (response) {
            console.log(response);
          }
        );
    };




    $scope.show_payslip = function ($payslip_id) {
      window.location.href = BASE_URL + 'hr/payslips/payslip/' + $payslip_id;
    };

    $scope.UpdatePayroll = function (id) {
      window.location.href = BASE_URL + 'hr/payrolls/update/' + id;
    };


  });



  //});

}


CiuisCRM.controller('Payrolls_Controller', Payrolls_Controller);
CiuisCRM.controller('Payroll_Controller', Payroll_Controller);