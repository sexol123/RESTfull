app.factory("recordsFactory", function($http){
 
    var factory = {};
 
    // read all Records
    factory.readRecords = function(){
        return $http({
            method: 'GET',
            url: 'http://localhost/restfull/api/record/read.php'
        });
    };
     
   // create product
factory.createRecord = function($scope){
    return $http({
        method: 'POST',
        data: {
            'host' : $scope.host,
            'code' : $scope.code,
            'message' : $scope.message
        },
        url: 'http://localhost/restfull/api/record/create.php'
    });
};

// read one product
factory.readOneRecord = function(id){
    return $http({
        method: 'GET',
        url: 'http://localhost/restfull/api/record/read_one.php?id=' + id
    });
};
     // update product
factory.updateRecord = function($scope){
 
    return $http({
        method: 'PUT',
        data: {
            'id' : $scope.id,
            'host' : $scope.host,
            'code' : $scope.code,
            'message' : $scope.message,
            'created' : $scope.created
            
        },
        url: 'http://localhost/restfull/api/record/update.php'
    });
};

factory.deleteRecord = function(id){
    return $http({
        method: 'DELETE',
        data: { 'id' : id },
        url: 'http://localhost/restfull/api/record/delete.php'
    });
};

    return factory;
});

