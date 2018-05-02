app.controller("WithdrawalsListCtrl", function ($location, $scope, $http) {
 //GetAllWithdrals.php
    $scope.GetAllWithdrals = function () {
        var data = { }
        $http.post(GetApiUrl("GetAllWithdrals"), data)
            .then(function (response, status) {
                if (response !== undefined || response !== null) {
                    $scope.myWithdrals = response.data.data;
                    console.log(" $scope.users", $scope.users)
                    $scope.wait = "";
                    Stop();
                } else {
                    //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                }

            });
    }
   
   
})