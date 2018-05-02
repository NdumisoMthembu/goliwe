app.controller("KeeperCtrl", function ($scope, $http, $location) {
    // get users list 
    $scope.GetKeepers = function () {
     
            $http.post(GetApiUrl("GetKeepers"), {})
                .then(function (response, status) {
                    if (response !== undefined) {
                        $scope.investments = response.data.data;

                    }
                    console.log(response);
                });



      
    };

    $scope.MoreOptions = function (investment) {
        localStorage.setItem("keep_id", investment.id);
        localStorage.setItem("keep_amountkeepable", investment.amount);
        localStorage.setItem("keep_name", investment.name);
        localStorage.setItem("keep_email", investment.email);
        localStorage.setItem("keptamountID", investment.id);
        localStorage.setItem("userID", investment.userID);
        $location.path('/Allocate-Funds-To-Keep');
    }

    $scope.AllocateKeptFunder = function (investment) {
        localStorage.setItem("keptamountID", investment.id);
        localStorage.setItem("amountKept", investment.amount);
        localStorage.setItem("userID", investment.userID);
        localStorage.setItem("keepername", investment.name);
        $location.path('/Allocate-Kept-Funds-To-Dreamer');
    }


})