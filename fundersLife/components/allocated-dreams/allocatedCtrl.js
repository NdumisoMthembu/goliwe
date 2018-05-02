app.controller("allocatedCtrl", function ($scope, $http, $window, $location) {
    $scope.GetInvestments = function () {
        let data = { status: 'allocated' }
        $http.post(GetApiUrl("GetInvestmentsByStatus"), data)
            .then(function (response, status) {
                console.log('awaitingallocationCtrl', response.data.data);
                if (response) {
                    $scope.dreams = response.data.data;
                    $scope.wait = "";
                    Stop();
                } else {
                    //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                }

            });
    }

    $scope.More = function (data) {
        localStorage.setItem("dreamObj", JSON.stringify(data))
        $location.path('/More-in-Active');
    }

})