app.controller('recordsController', function($scope, $mdDialog, $mdToast, recordsFactory){
 
    // read records
    $scope.readRecords = function(){
 
        // use records factory
        recordsFactory.readRecords().then(function successCallback(response){
            $scope.records = response.data.records;
        }, function errorCallback(response){
            $scope.showToast("Unable to read record.");
        });
 
    }
     
  // show 'create Record form' in dialog box
$scope.showCreateRecordForm = function(event){
 
    $mdDialog.show({
        controller: DialogController,
        templateUrl: '../app/records/create_record.template.html',
        parent: angular.element(document.body),
        clickOutsideToClose: true,
        scope: $scope,
        preserveScope: true,
        fullscreen: true // Only for -xs, -sm breakpoints.
    });
}
// create new Record
$scope.createRecord = function() {
 
    recordsFactory.createRecord($scope).then(function successCallback(response){
 
        // tell the user new Record was created
        $scope.showToast(response.data.message);
 
        // refresh the list
        $scope.readRecords();
 
        // close dialog
        $scope.cancel();
 
        // remove form values
        $scope.clearRecordForm();
 
    }, function errorCallback(response){
        $scope.showToast("Unable to create record.");
    });
}
// show toast message
$scope.showUpdateRecordForm = function(id){
 
    // get Record to be edited
    recordsFactory.readOneRecord(id).then(function successCallback(response){
 
        // put the values in form
        $scope.id = response.data.id;
        $scope.host = response.data.host;
        $scope.code = response.data.code;
        $scope.message = response.data.message;
        $scope.created = response.data.created;
 
        $mdDialog.show({
            controller: DialogController,
            templateUrl: '../app/records/update_record.template.html',
            parent: angular.element(document.body),
            targetEvent: event,
            clickOutsideToClose: true,
            scope: $scope,
            preserveScope: true,
            fullscreen: true
        }).then(
            function(){},
 
            // user clicked 'Cancel'
            function() {
                // clear modal content
                $scope.clearRecordForm();
            }
        );
 
    }, function errorCallback(response){
        $scope.showToast("Unable to retrieve record.");
    });
 
}
$scope.readOneRecord = function(id){
 
    // get product to be edited
    recordsFactory.readOneRecord(id).then(function successCallback(response){
 
        // put the values in form
        $scope.id = response.data.id;
        $scope.host = response.data.host;
        $scope.code = response.data.code;
        $scope.message = response.data.message;
        $scope.created = response.data.created;
 
        $mdDialog.show({
            controller: DialogController,
            templateUrl: '../app/records/read_one_record.template.html',
            parent: angular.element(document.body),
            clickOutsideToClose: true,
            scope: $scope,
            preserveScope: true,
            fullscreen: true
        }).then(
            function(){},
 
            // user clicked 'Cancel'
            function() {
                // clear modal content
                $scope.clearRecordForm();
            }
        );
 
    }, function errorCallback(response){
        $scope.showToast("Unable to retrieve record.");
    });
 
}
 


$scope.confirmDeleteRecord = function(event, id){
 
    // set id of record to delete
    $scope.id = id;
 
    // dialog settings
    var confirm = $mdDialog.confirm()
        .title('Are you sure?')
        .textContent('Record will be deleted.')
        .targetEvent(event)
        .ok('Yes')
        .cancel('No');
 
    // show dialog
    $mdDialog.show(confirm).then(
        // 'Yes' button
        function() {
            // if user clicked 'Yes', delete product record
            $scope.deleteRecord();
        },
 
        // 'No' button
        function() {
            // hide dialog
        }
    );

    // delete product

}
$scope.deleteRecord = function(){
 
    recordsFactory.deleteRecord($scope.id).then(function successCallback(response){
 
        // tell the user product was deleted
        $scope.showToast(response.data.message);
 
        // refresh the list
        $scope.readRecords();
 
    }, function errorCallback(response){
        $scope.showToast("Unable to delete record.");
    });
 
}

// update Record record / save changes
$scope.updateRecord = function(){
 
    recordsFactory.updateRecord($scope).then(function successCallback(response){
 
        // tell the user Record record was updated
        $scope.showToast(response.data.message);
 
        // refresh the Record list
        $scope.readRecords();
 
        // close dialog
        $scope.cancel();
 
        // clear modal content
        $scope.clearRecordForm();
 
    },
    function errorCallback(response) {
        $scope.showToast("Unable to update record.");
    });
 
}
// clear variable / form values
$scope.clearRecordForm = function(){
    $scope.id = "";
    $scope.host = "";
    $scope.code = "";
    $scope.message = "";
    $scope.created = "";
}
$scope.showToast = function(message){
    $mdToast.show(
        $mdToast.simple()
            .textContent(message)
            .hideDelay(3000)
            .position("top right")
    ).catch(() => {
        return;
    });;
}
    // DialogController will be here
    function DialogController($scope, $mdDialog) {
        $scope.cancel = function() {
            $mdDialog.cancel();
        };
    }
});

