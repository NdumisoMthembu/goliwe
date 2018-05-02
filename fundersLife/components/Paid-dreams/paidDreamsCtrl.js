app.controller("paidDreamsCtrl", function ($scope, $http, $location) {
    $scope.GetNotifications = function () {
        let data = {

        }
            $http.post(GetApiUrl("GetAllNotifications"), data)
                .then(function (response, status) {
                    if (response !== undefined) {
                        $scope.nots = response.data.data;
                        console.log(response);

                    }

                });

        $scope.Confirm = function (not) {
            //1. must go and update keeper status to confimed 
            //3. must go and update notifucation to  status to old , and updadated date to now  
            var data = {
                keeperID: not.keeperID,
                id: not.id
            };

            $http.post(GetApiUrl("ConfirmPayment"), data)
                .then(function (response, status) {
                    alert("payment Verified by the admin");
                     $location.path('/Admin-dashboard');
                });

        }
    }

})