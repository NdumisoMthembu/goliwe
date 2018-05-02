app.controller("createAllocationCtrl", function ($scope, $http, $location) {
    $scope.GetUsers = function (withdrowal) {
      

            var data = { table: "user", condition: " role <> 'admin'" }
            $http.post(GetApiUrl("Get"), data)
                .then(function (response, status) {
                    if (response !== undefined || response !== null) {
                        $scope.users = response.data.data;
                        $scope.wait = "";
                    } else {
                        //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                    }

                });



      
    };
    $scope.Select = function (user) {
        $scope.email = user.email;
        $scope.userName = user.name;
        $scope.cellNo = user.cell;
        $scope.search = user.email;
        $scope.userID = user.id;
    }

    $scope.Withdraw = function () {
        if ($scope.email) {
            if (!$scope.amount) {
                alert("Enter amount");
                return false;
            }
            var data = {
                userID: $scope.userID,
                email: $scope.email,
                investemntId: 0,
                amount: $scope.amount,
                name: $scope.userName,
                balance: $scope.amount,
                dream: "Allocated dream"
            };
            $http.post(GetApiUrl("CreateAllocationForAUser"), data)
                .then(function (response, status) {
                    $scope.message = "Your request has been submitted, we will notify you as soon as allocation is found!"
                    $scope.showDonateButton = false;
                    $scope.showDashteButton = true;

                    // notify
                    var msg = "Your request has been submitted, we will notify you as soon as allocation is found!";
                    SendMail("noreply@funderslife.com", $scope.email, $scope.name, "Withdrawal Notification " + $scope.dream, msg);
                    alert("withdrawal request  created!");
                    $location.path('/Allocate');

                });
        } else {
            alert("Select the user first or create a new user");
        }
    };
})