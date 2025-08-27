function Tickets_Controller($scope, $http, $mdSidenav, fileUpload, $filter, $mdToast) {
	"use strict";

	$http.get(BASE_URL + 'api/table_columns/' + 'tickets').then(function (Data) {
		$scope.table_columns = Data.data;
	});

	$http.get(BASE_URL + 'api/custom_fields_by_type/' + 'ticket').then(function (custom_fields) {
		$scope.all_custom_fields = custom_fields.data;
		$scope.custom_fields = ($scope.all_custom_fields, {
			active: 'true',
		});
	});

	$scope.updateColumns = function(column, value) {
		var dataObj = $.param({
			column: column,
			value: +value,
		});
		var posturl = BASE_URL + 'api/update_columns/tickets';
		$http.post(posturl, dataObj, config)
		.then(
			function (response) {
			}, function(error) {}
			);
	};

	$http.get(BASE_URL + 'api/table_columns/' + 'tickets').then(function (Data) {
		$scope.table_columns = Data.data;
		if ($scope.table_columns.list_view == true) {
			$scope.KanbanBoard = false;
		} else {
			$scope.KanbanBoard = true;
		}
	});

	$scope.ShowKanban = function () {
		$scope.KanbanBoard = true;
	};

	$scope.HideKanban = function () {
		$scope.KanbanBoard = false;
	};

	$scope.Create = buildToggler('Create');
	$scope.TicketsSettings = buildToggler('TicketsSettings');

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();

		};
	}
	$scope.close = function () {
		$mdSidenav('Create').close();
		$mdSidenav('TicketsSettings').close();
	};

	$http.get(BASE_URL + 'tickets/ticketstatuses').then(function (TicketStatuses) {
		$scope.ticketstatuses = TicketStatuses.data;

		$scope.NewStatus = function () {
			globals.createDialog($scope.lang.new_status, $scope.lang.type_status_name,$scope.lang.status_name,  event, $scope.lang.add, $scope.lang.cancel, 'tickets/add_status', function(response) {
				if (response.success == true) {
					showToast(NTFTITLE, response.message, ' success');
					$http.get(BASE_URL + 'tickets/ticketstatuses').then(function (TicketStatuses) {
						$scope.ticketstatuses = TicketStatuses.data;
						get_tickets();
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};

		$scope.EditStatus = function (status_id, ticket_status, event) { 
			globals.editDialog($scope.lang.edit+' '+$scope.lang.ticket+' '+$scope.lang.status, $scope.lang.ticket_title+' '+$scope.lang.ticket+' '+$scope.lang.status+' '+$scope.lang.name, $scope.lang.status+' '+$scope.lang.name, ticket_status,  event, $scope.lang.save, $scope.lang.cancel, 'tickets/update_status/'+status_id, function(response) {
				if (response.success == true) {
					showToast(NTFTITLE, response.message, ' success');
					$http.get(BASE_URL + 'tickets/ticketstatuses').then(function (TicketStatuses) {
						$scope.ticketstatuses = TicketStatuses.data;
						get_tickets();
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};
		
		$scope.DeleteTicketStatus = function (index) { 
			var status = $scope.ticketstatuses[index];
			globals.deleteDialog($scope.lang.delete+' '+$scope.lang.status, $scope.lang.delete_meesage+' '+$scope.lang.status+'?', status.id, $scope.lang.delete, $scope.lang.cancel, 'tickets/remove_status/'+status.id, function(response) {
				if (response.success == true) {
					showToast(NTFTITLE, response.message, ' success');
					$http.get(BASE_URL + 'tickets/ticketstatuses').then(function (TicketStatuses) {
						$scope.ticketstatuses = TicketStatuses.data;
						get_tickets();
					});
				} else {
					globals.mdToast('error', response.message);
				}
			});
		};
	});

	globals.get_departments();
	$scope.createTicket = function() {
		$scope.uploading = true;
		if (!$scope.ticket) {
			var dataObj = {
				subject: '',
				customer: '',
				contact: '',
				department: '',
				priority: '',
				message: '',
				file: ''
			};
		} else {
			var dataObj = {
				subject: $scope.ticket.subject,
				customer: $scope.ticket.customer,
				contact: $scope.ticket.contact,
				department: $scope.ticket.department,
				priority: $scope.ticket.priority,
				message: $scope.ticket.message,
			//Changed from $scope.ticket.ticket_attachment to $scope.ticket.acttachment
				file: $scope.ticket.attachment
			};
		}
		var uploadUrl = BASE_URL+'tickets/create/';
		fileUpload.uploadFileWithData(dataObj, uploadUrl, function(response) {
			if (response.success == true) {
				$mdSidenav('Create').close();
				globals.mdToast('success', response.message);
				$scope.ticketsLoader = true;
				$http.get(BASE_URL + 'tickets/get_tickets').then(function (Tickets) {
					$scope.tickets = Tickets.data;
					$scope.ticketsLoader = false;
				});
			} else {
				globals.mdToast('error', response.message);
			}
			$scope.uploading = false;
		});
	};

	function get_tickets() {
		$http.get(BASE_URL + 'tickets/get_tickets').then(function (Tickets) {
			$scope.tickets = Tickets.data;
		});
	}

	$scope.ticket_list = {
		order: '',
		limit: 5,
		page: 1
	};
	$scope.ticketsLoader = true;
	$http.get(BASE_URL + 'tickets/get_tickets').then(function (Tickets) {
		$scope.tickets = Tickets.data;
		$scope.limitOptions = [5, 10, 15, 20];
		if ($scope.tickets.length > 20) {
			$scope.limitOptions = [5, 10, 15, 20, $scope.tickets.length];
		}
		$scope.ticketsLoader = false;
		$scope.GoTicket = function (TICKETID) {
			window.location.href = BASE_URL + 'tickets/ticket/' + TICKETID;
		};

		$scope.dropSuccessHandler = function ($event, index, array) {
			$scope.selected_ticket = $scope.tickets[index];
			$scope.tickets.splice($scope.tickets.indexOf($scope.selected_ticket), 1);
		};

		$scope.onDrop = function ($event, $data, array) {
			$scope.moved_ticket = $data;
			var dataObj = $.param({
				ticket_id: $scope.moved_ticket.id,
				status_id: array,
			});
			$http.post(BASE_URL + 'tickets/move_ticket/', dataObj, config)
				.then(
					function (response) {
						get_tickets();
					},
					function () {}
				);
		};

		$scope.search = {
			subject: '',
			message: ''
		};

		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
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
			return Math.ceil($scope.tickets.length / $scope.itemsPerPage) - 1;
		};
	});

	$scope.ShowKanban = function () {
		$scope.KanbanBoard = true;
	};

	$scope.HideKanban = function () {
		$scope.KanbanBoard = false;
	};

	$scope.get_contacts = function(customer_id) {
		$http.get(BASE_URL + 'api/contact/' + customer_id).then(function (Contacts) {
			$scope.contacts = Contacts.data;
		});
	};
}

function Ticket_Controller($scope, $http, $mdDialog, fileUpload, $mdSidenav) {
	"use strict";

	function buildToggler(navID) {
		return function () {
			$mdSidenav(navID).toggle();
		};
	}

	$scope.close = function () {
		$mdDialog.hide();

	};

	$scope.get_staff();

	$scope.AssigneStaff = function (ev) {
		$mdDialog.show({
			templateUrl: 'insert-member-template.html',
			scope: $scope,
			preserveScope: true,
			targetEvent: ev
		});
	};

	$http.get(BASE_URL + 'api/custom_fields_data_by_type/' + 'ticket/' + TICKETID).then(function (custom_fields) {
		$scope.custom_fields = custom_fields.data;
	});

	globals.get_departments();
	$scope.replying = false;
	$scope.replyToTicket = function() { 
		$scope.replying = true;
		if (!$scope.reply) {
			var dataObj = {
				message: '',
				file: ''
			};
		} else {
			var dataObj = {
				message: $scope.reply.message,
				file: $scope.reply.attachment
			};
		}

		var uploadUrl = BASE_URL+'tickets/reply/'+TICKETID;
		fileUpload.uploadFileWithData(dataObj, uploadUrl, function(response) {
			if (response.success == true) {
				$('#chooseFile').val('');
				$scope.reply.message = '';
				//showToast(NTFTITLE, response.message, ' success');
				$http.get(BASE_URL + 'tickets/get_ticket/' + TICKETID).then(function (TicketDetails) {
					$scope.ticket = TicketDetails.data;
				});
			} else {
				showToast(NTFTITLE, response.message, ' danger');
			}
			$scope.replying = false;
		});
	};

	$scope.ticketsLoader = true;
	$http.get(BASE_URL + 'tickets/get_ticket/' + TICKETID).then(function (TicketDetails) {
		$scope.ticket = TicketDetails.data;
		$scope.ticketsLoader = false;
		$scope.AssignStaff = function () {
			var dataObj = $.param({
				staff: $scope.AssignedStaff,
			});
			var posturl = BASE_URL + 'tickets/assign_staff/' + TICKETID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						if(response.data.success == true) {
							$mdDialog.hide();
							$scope.ticket.assigned_staff_name = response.data.name;
						} else {
							$mdDialog.hide();
							globals.mdToast('error', response.data.message);
						}
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.Reply = function () {
			var dataObj = $.param({
				message: $scope.reply.message,
				attachment: $scope.reply.attachment,
			});
			var posturl = BASE_URL + 'tickets/reply/' + TICKETID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$scope.ticket.replies.push({
							'message': $scope.reply.message,
							'name': LOGGEDINSTAFFNAME,
							'date': new Date(),
							'attachment': $scope.reply.attachment,
						});
						$scope.reply.attachment = '';
						$scope.reply.message = '';
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
				.textContent(lang.ticketattentiondetail)
				.ariaLabel(lang.delete +' ' + lang.ticket)
				.targetEvent(TICKETID)
				.ok(lang.doIt)
				.cancel(lang.cancel);

			$mdDialog.show(confirm).then(function () {
				$http.post(BASE_URL + 'tickets/remove/' + TICKETID, config)
					.then(
						function (response) {
							if(response.data.success == true){
								window.location.href = BASE_URL + 'tickets';
								globals.mdToast('error', response.data.message);
							} else {
								globals.mdToast('error', response.data.message);
							}
						},
						function (response) {
							console.log(response);
						}
					);

			}, function () {
				//
			});
		};
	});

	$scope.MarkAs = function (id, name) {
		var dataObj = $.param({
			status_id: id,
			ticket_id: TICKETID,
			name: name,
		});
		var posturl = BASE_URL + 'tickets/markas/';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					if(response.data.success == true){
						globals.mdToast('success', response.data.message);
						$http.get(BASE_URL + 'tickets/get_ticket/' + TICKETID).then(function (TicketDetails) {
							$scope.ticket = TicketDetails.data;
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
}

CiuisCRM.controller('Tickets_Controller', Tickets_Controller);
CiuisCRM.controller('Ticket_Controller', Ticket_Controller);
