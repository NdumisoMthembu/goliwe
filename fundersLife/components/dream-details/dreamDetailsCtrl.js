app.controller("dreamDetailsCtrl", function ($scope, $location, $http) {
    let Res = JSON.parse(localStorage.getItem("investmentDetails"));
    $scope.dream = Res.data.data[0];
    $scope.keepers = Res.data.data[0].keepers;
    // console.log("$scope.dream", $scope.dream);
    localStorage.setItem("_investmentID", $scope.dream.id);


    //
    $scope.UploadProofOfPayment = function (keeper) {
        console.log(keeper)
        localStorage.setItem("keeperID", keeper.id);

        localStorage.setItem("senderName", $scope.dream.name);
        localStorage.setItem("toEmail", keeper.user.email);
        localStorage.setItem("amount", keeper.amount);
        localStorage.setItem("toName", keeper.user.name);
        $location.path('/Proof-Of-Payment');
    }

    // check for pending keeper for alloacted dream
    if ($scope.dream.status === "allocated") {
        let numberOfPendings = 0;
        $.each($scope.dream.keepers.keepers, function (index, keeper) {
            let status = keeper.status;
            if (status == 'pending') {
                numberOfPendings++;
            }
        });
        if (numberOfPendings == 0) {
            // All dreams are paid  - change dream status to paid
            let data = {
                id: parseInt($scope.dream.id)
            };
            $http.post(GetApiUrl("UpdateDreamToPaid"), data)
                .then(function (response, status) {
                    $scope.dream.status = "paid";
                    alert("Dream status changed to : Paid");

                });
        } else {
            if ($scope.dream.status == 'allocated') {
                CountDownTimer($scope.dream.timeAllocated, "timeCountDown");
            }
        }
    }
})