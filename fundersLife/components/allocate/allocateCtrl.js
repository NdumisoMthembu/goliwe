app.controller("allocateCtrl", function ($scope, $http) {
    let dream = JSON.parse(localStorage.getItem('dreamObj'));
    $scope.investmentId = dream.id;
    $scope.investorEmail = localStorage.getItem("pendingbalance");
    $scope.pendingbalance = localStorage.getItem("pendingbalance");
    $scope.userID = localStorage.getItem("userID");
    $scope.cell = localStorage.getItem("investorCell");
    $scope.GetWithdrawals = function () {
            $http.post(GetApiUrl("GetWithdraw"), { investmentId: $scope.investmentId })
                .then(function (response, status) {
                    if (response !== undefined || response !== null) {
                        $scope.withdrawals = response.data.data;
                        $scope.GetInvestmentById($scope.investmentId);
                        Stop();
                        $scope.wait = "";
                    } else {
                        //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                    }

                });
      

    };

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
                if ($scope.pendingbalance == 0 || $scope.pendingbalance == "0") {
                    alert("All amount was allocated successfully");
                    //set the dream to allocated   UpdateDreamToAllocated
                    let data = {
                        id: parseInt($scope.investmentId)
                    };
                    $http.post(GetApiUrl("UpdateDreamToAllocated"), data)
                        .then(function (response, status) { });
                }
                //  console.log(investementObj );
            });

    };


    $scope.Allocate = function (withdrawal) {
        Load();
        let amountInvested = parseFloat($scope.amountInvested);
        let amount = parseFloat(withdrawal.balance);
        let pendingbalance = $scope.pendingbalance;
        // zero case - exit
        if (pendingbalance <= 0) {
            alert("All amount is kept!");
            Stop();
            return false;
        }
        // case one : donate R1000 to person who need to get paid R3000, correct!
        if (pendingbalance <= amount) {
            let data = {
                amount: pendingbalance,
                investmentID: parseInt($scope.investmentId),
                witdrawalID: parseInt(withdrawal.id),
                balance: withdrawal.balance - pendingbalance
            };
            console.log(withdrawal);
            $http.post(GetApiUrl("AllocateAkeeper"), data)
                .then(function (response, status) {
                    console.log(response);
                    $scope.GetWithdrawals();

                });

        }

        if (pendingbalance > amount) {
            let data = {
                amount: amount,
                investmentID: parseInt($scope.investmentId),
                witdrawalID: parseInt(withdrawal.id),
                balance: withdrawal.balance - amount
            };
            console.log(withdrawal);
            $http.post(GetApiUrl("AllocateAkeeper"), data)
                .then(function (response, status) {
                    console.log(response);
                    if (pendingbalance <= 0) {
                        alert("All amount is kept!");
                        $scope.GetWithdrawals();
                        return false;
                    }
                });

        }
        if (amountInvested > amount) {
            console.log($scope.amountInvested);
        }
        $scope.GetWithdrawals();
    }

})