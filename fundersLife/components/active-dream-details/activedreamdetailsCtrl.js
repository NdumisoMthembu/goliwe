app.controller("activedreamdetailsCtrl", function ($scope, $http, $window) {
    let dream = JSON.parse(localStorage.getItem('dreamObj'));
    $scope.investmentId = dream.id;
    $scope.investorEmail = localStorage.getItem("pendingbalance");
    $scope.pendingbalance = localStorage.getItem("pendingbalance");
    $scope.userID = localStorage.getItem("userID");
    $scope.cell = localStorage.getItem("investorCell");
   
    $scope.GetInvestmentById = function (id) {
        $http.get(GetApiUrlForID(`GetInvestmentById.php?id=${id}`))
            .then(function (response) {
                console.log(GetApiUrlForID(`GetInvestmentById.php?id=${id}`));
                console.log(response);
                let investementObj = response.data.data[0];
                $scope.numberOfKeepers = investementObj.numberOfKeepers;
                $scope.amountInvested = investementObj.amountInvested;

                $scope.keepersLS = investementObj.keepers.keepers;
                $scope.keeperSumAmount = investementObj.amountKept;
                $scope.pendingbalance = $scope.amountInvested - $scope.keeperSumAmount;
                $scope.investmentName = investementObj.name;
                
            });

    };
    $scope.Init = function () {
        $scope.GetInvestmentById($scope.investmentId);
    }
    $scope.Back = function () {
        $window.history.back();
    }
    

})