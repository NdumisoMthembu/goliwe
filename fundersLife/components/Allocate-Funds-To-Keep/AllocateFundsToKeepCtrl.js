app.controller("AllocateFundsToKeepCtrl", function ($scope, $http, $location) {
    $scope.id = localStorage.getItem("keep_id");
    $scope.amountkeepable = localStorage.getItem("keep_amountkeepable");
    $scope.name = localStorage.getItem("keep_name");
    $scope.email = localStorage.getItem("keep_email");
    $scope.keptamountID = localStorage.getItem("keptamountID");
    $scope.userID = localStorage.getItem("userID");
    $scope.Allocate = function () {
        $scope.error = undefined;
        if ($scope.amount_requested_to_keep <= $scope.amountkeepable) {
            let data = {
                keptamountID: $scope.keptamountID,
                userID: $scope.userID,
                amount: $scope.amount_requested_to_keep
            }

            $http.post(GetApiUrl("AllocateAmountToKeep"), data)
                .then(function (response, status) {
                    if (response !== undefined) {
                        let subject = "You have been allocated to keep funds";
                        let msg = `You have been allocated to keep funds of R ${$scope.amount_requested_to_keep}. Please confirm the payment as soon as you receive it.`;
                        SendMail("no-reply@funderslife.com", $scope.email, $scope.name, subject, msg);
                        // Create withdrwal
                        //$scope.CreateWithDrawalForFundKeepings();
                        alert("Amount was located successfuly");
                        $location.path('/Admin-dashboard');
                    }

                });

        } else {
            $scope.error = "Opps that amount is no valid!";
        }
    }

})