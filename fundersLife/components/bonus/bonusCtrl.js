app.controller("bonusCtrl", function ($scope, $http) {
    let user = JSON.parse(localStorage.getItem('UserData'));
    $scope.email = user.email;
    $scope.name = user.name;
    $scope.mylink = user.mylink;
    $scope.userID = user.id;
    $scope.showBonus = true;
    $scope.bonus = user.bonus;
    $scope.GetBonus = function () {
        var data = {
            userID: $scope.userID,
            status: 'active'
        };
        $http.post(GetApiUrl("GetBonuses"), data)
            .then(function (response, status) {
                $scope.bonuses = response.data.data;
            });

    }

    $scope.CashOut = function () {
        $scope.error = "";
        if ($scope.bonus >= 500) {
            var data = {
                amount: $scope.bonus,
                userID: $scope.userID
            };
            $http.post(GetApiUrl("CashOutABonus"), data)
                .then(function (response, status) {
                    //    console.log(response);
                    $scope.message = "Your request has been submitted, we will notify you as soon as allocation is found!"
                    $scope.showBonus = false;

                    // notify
                    $scope.msg = "Your request has been submitted, we will notify you as soon as allocation is found!";
                    SendMail("noreply@funderslife.com", $scope.email, $scope.name, "Withdrawal Notification " + "My Bonus", $scope.msg);
                    $interval(function () {
                        $window.location.href = "My-Bonuses";
                    }, 3000);
                });
        } else {
            $scope.error = "Sorry, Your bonus is withdrawable once it reaches R500! Refer more people to get more bonuses";
        }
    }

})