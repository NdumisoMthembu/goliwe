app.controller("createdreamCtrl", function ($scope, $http, $location ) {
    $scope.packeges = [200, 300, 400, 500, 1000, 1500, 2000, 3000, 5000, 8000, 10000, 15000, 20000, 30000, 40000, 50000];
    $scope.peroids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $scope.showDonateButton = true;
    $scope.showDashteButton = false;
    $scope.GoToDashboard = function () {
        $location.path('/Dashboard');

    }
    $scope.Donate = function () {
        $scope.message = undefined;
        $scope.isValid = true;
        //				bankname, accountnumber
        let dream = $scope.dream;
        let amount = $scope.amount;
        let peroid = $scope.peroid;
        let user = JSON.parse(localStorage.getItem('UserData'));
        let isAkeeper = user.isAkeeper;
        let userID = user.id;


        let data = {
            dream: dream,
            amount: amount,
            peroid: peroid,
            userID: userID,
            isAkeeper: isAkeeper

        };
        if (peroid == undefined || amount == undefined || dream == undefined) {
            $scope.isValid = false;
            $scope.message = "Please fill in the form completely";
            return;
        }

        if ($scope.isValid) {

            $http.post(GetApiUrl("Invest"), data)
                .then(function (response, status) {
                    if (parseInt(response.data) === 1) {
                        $scope.message = undefined;
                        $scope.showDonateButton = false;
                        $scope.showDashteButton = true;
                        $scope.success = "Your dream was created successfully, Please wait for a member to be assigned to you.";
                        SendMail("noreply@funderslife.com", localStorage.getItem("email"), localStorage.getItem("name"), "New Dream created", $scope.success);
                    } else {
                        $scope.message = response;
                    }

                });
        } else {
            $scope.message = "Please make sure that all required fields are NOT empty"
        }
    };

})