function Payslips_Controller($scope, $compile, $http, $mdSidenav, $q, $timeout, $filter, $mdDialog) {
  "use strict";

  $http.get(BASE_URL + 'api/table_columns/' + 'payslips').then(function (Data) {
    $scope.table_columns = Data.data;
  });

  $scope.payslipLoader = true;
  var deferred = $q.defer();
  $scope.payslip_list = {
    order: '',
    limit: 10,
    page: 1
  };

  $scope.promise = deferred.promise;
  $http.get(BASE_URL + 'hr/api/payslips').then(function (Payslips) {
    $scope.payslips = Payslips.data;
    deferred.resolve();

    $scope.payslipLoader = false;

    $scope.limitOptions = [5, 10, 15, 20];
    if ($scope.payslips.length > 20) {
      $scope.limitOptions = [5, 10, 15, 20, $scope.payslips.length];
    }

    $scope.payslipLoader = false;
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


  });

}

function Payslip_Controller($scope, $compile, $http, $mdSidenav, $q, $timeout, $filter, $mdDialog) {
  "use strict";

  $scope.payslipLoader = true;
  $http.get(BASE_URL + 'hr/payslips/get_payslip/' + PAYSLIPID).then(function (PayslipData) {
    $scope.payslip = PayslipData.data;
    $scope.payslipLoader = false;

  });


  $scope.RecordPayment = buildToggler('RecordPayment');

  function buildToggler(navID) {
    return function () {
      $mdSidenav(navID).toggle();
    };
  }

  $scope.close = function () {
    $mdSidenav('RecordPayment').close();
  };
  $scope.CloseModal = function () {
    $mdDialog.hide();
  };


  $scope.AddPayment = function () {
    $scope.doing = true;
    var dataObj = $.param({
      date: moment($scope.date).format("YYYY-MM-DD HH:mm:ss"),
      balance: $scope.payslip.balance - $scope.amount,
      amount: $scope.amount,
      paysliptotal: $scope.payslip.payslip_grand_total,
      not: $scope.not,
      staff: ACTIVESTAFF,
      payslip: PAYSLIPID,
      relation: $scope.payslip.payslip_relation_id,
      account: $scope.payslip.payslip_account,
      category: $scope.payslip.payslip_expense_category,
    });

    var posturl = BASE_URL + 'hr/payslips/record_payment';
    $http.post(posturl, dataObj, config)
      .then(
        function (response) {
          if (response.data.success == true) {
            $http.get(BASE_URL + 'hr/payslips/get_payslip/' + PAYSLIPID).then(function (PayslipDetails) {
              $scope.payslip = PayslipDetails.data;
            });
            $scope.doing = false;
            $mdSidenav('RecordPayment').close();
            globals.mdToast('success', response.data.message);
          } else {
            globals.mdToast('error', response.data.message);
            $scope.doing = false;
          }
        },
        function (response) {
          $scope.doing = false;
        }
      );
  };

  $scope.Delete = function () {
    var confirm = $mdDialog.confirm()
      .title($scope.lang.deletepayslip)
      .textContent($scope.lang.payslip_rmv_msg)
      .ariaLabel('Delete Payslip')
      .targetEvent(PAYSLIPID)
      .ok($scope.lang.delete)
      .cancel($scope.lang.cancel);

    $mdDialog.show(confirm).then(function () {
      $http.post(BASE_URL + 'hr/payslips/delete_payslip/' + PAYSLIPID, config)
        .then(
          function (response) {
            if (response.data.success == true) {
              window.location.href = BASE_URL + 'hr/payslips';
              globals.mdToast('success', response.data.message);
            } else {
              globals.mdToast('error', response.data.message);
            }
          },
          function (response) {
            console.log(respones);
          }
        );
    });
  };

  $scope.send = function() {
    $http.post(BASE_URL + 'hr/payslips/send_payslip_email/' + PAYSLIPID, config)
    .then(
      function (response) {
        if (response.data.success == true) {
          globals.mdToast('success', response.data.message);
        } else {
          globals.mdToast('erroe', response.data.message);
        }
      },
      function (response) {
        console.log(response);
      }
    );
  };



}


CiuisCRM.controller('Payslips_Controller', Payslips_Controller);
CiuisCRM.controller('Payslip_Controller', Payslip_Controller);