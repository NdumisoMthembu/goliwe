app.controller("dashboardCtrl", function ($scope, $http, $window, $location) {
    //Load Old user
    $scope.user = JSON.parse(localStorage.getItem('UserData'));
    $scope.userWidrawals = JSON.parse(localStorage.getItem('myWithdrawals'));
    $scope.email = $scope.user.email;
    $scope.ShowNotification = true;


    //Refresh user data
   
    $scope.RefreshUser = function () {
        let data = {
            email: $scope.user.email,
            password: $scope.user.password
        }
        $http.post(GetApiUrl("LoginUser"), data)
            .then(function (response) {
                console.log(response);
                if (response.data.id) {
                    localStorage.setItem("UserData", JSON.stringify(response.data));
                    $scope.LoadPage(response.data);

                } else {
                    $scope.LoadPage($scope.user);
                }
            });
    }
   

    $scope.LoadPage = function (user) {
        // Parse Object - new
        if (user.userstatus=='locked') {
            $(".lock").show();
        }
        $scope.name = user.name;
        //ng shows
        $scope.showContent = true;
        $scope.showDonateLink = true;

        // dashboard data 
        $scope.investments = user.dreams.data;
        $scope.mylink =user.mylink;

        //side menu
        $scope.myrefferals = user.myrefferals;
        $scope.bonus = user.bonus;
        $scope.amountkept = user.amountkept;
        if ($scope.userWidrawals) {
            $scope.myWithdrawals = $scope.userWidrawals.length;
        } else {
            $scope.myWithdrawals = 0;
        }
      


        $scope.isEmailVerified = localStorage.getItem("isEmailVerified");

        // Check if email verified
        if (parseInt($scope.isEmailVerified) === 0) {
            $location.path('/Verify-Email');
        }

    }

    // CLICK THE DREAM 
    $scope.InvestmentDetails = function (investment) {
        $http.get(GetApiUrlForID(`GetInvestmentById.php?id=${investment.id}`))
            .then(function (response) {
                if (response.statusText == "OK") {
                    localStorage.setItem("investmentDetails", JSON.stringify(response));
                    $location.path('/Dream-Details');
                }
                

            });
    }

    // Get Notification 
    $scope.GetNotifications = function () {
        var data = {
            email: $scope.email
        };
        $http.post(GetApiUrl("GetNotification"), data)
            .then(function (response, status) {
                $scope.wait = undefined;

                if (response.data.data) {
                    $scope.notifications = response.data.data;
                    $scope.notCount = $scope.notifications.length;
                } else {
                    $scope.notCount = 0;
                }
            });
    }; 
    $scope.ConfirmPayment = function (not) {
        //1. must go and update keeper status to confimed 
        //3. must go and update notifucation to  status to old , and updadated date to now  
        var data = {
            keeperID: not.keeperID,
            id: not.id
        };
        console.log("Not: ", not);
        $http.post(GetApiUrl("ConfirmPayment"), data)
            .then(function (response, status) {
                alert("Thanks! Payment confirmed");
                $scope.GetNotifications();
            });

    }
    $scope.GetNotifications();
})