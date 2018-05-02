app.controller("AllocateKeptFundsToDreamerCtrl", function ($scope, $http, $location) {
    // get users list 
    $scope.keptamountID = parseInt(localStorage.getItem("keptamountID"));
    $scope.userID = localStorage.getItem("userID");
    $scope.amountKept = localStorage.getItem("amountKept");
    $scope.keepername = localStorage.getItem("keepername");
    $scope.keep_status = 'allocated';
    //AllocateKeptAmountToSomeOne

    $scope.Allocate = function () {
        $scope.error = undefined;
        if ($scope.amountToAllocate) {
            if ($scope.amountToAllocate <= parseFloat($scope.amountKept)) {
                $scope.balance = $scope.amountKept - $scope.amountToAllocate;
                console.log("Balance", $scope.balance);
                if ($scope.balance <= 0) {
                    $scope.kept_amount_status = 'allocated';
                    $scope.balance = $scope.amountToAllocate;
                }
                else {
                    $scope.kept_amount_status = 'kept';
                }

                var data = {
                    userID: $scope.userID,
                    amount: $scope.amountToAllocate,
                    keptamountID: $scope.keptamountID,
                    keep_status: $scope.kept_amount_status,
                    balance: $scope.balance
                }
                console.log("data", data);
                $http.post(GetApiUrl("AllocateKeptAmountToSomeOne"), data)
                    .then(function (response, status) {
                        console.log("New Id", response);
                        // redirect to allocate
                        if (response) {
                            let dreamObj = {
                                id: response.data
                            };
                            localStorage.setItem("dreamObj", JSON.stringify(dreamObj));

                            $location.path('/Allocate');
                        }
                        //$window.location.href = "Thanks-for-Verification -Admin";
                    });
            } else {
                $scope.error = `Amount to allocate must be less or equal to ${$scope.amountKept}`;
            }
        } else {
            $scope.error = "Enter the amount to allocate";
        }

    }
})