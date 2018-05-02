app.controller("usersCtrl", function ($scope, $http, $location) {
    $scope.GetUsers = function () {
        var data = { table: "user", condition: " role <> 'admin'" }
        $http.post(GetApiUrl("Get"), data)
            .then(function (response, status) {
                if (response !== undefined || response !== null) {
                    $scope.users = response.data.data;
                    console.log(" $scope.users", $scope.users)
                    $scope.wait = "";
                    Stop();
                } else {
                    //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                }

            });
    }
    $scope.UnLock = function (user) {
        let data = {
            email: user.email
        }
        $http.post(GetApiUrl("UnlockUser"), data).then(function (data, status) {
            if (data) {
                alert(user.name + " Unlocked");
                $location.path('/Admin-dashboard');

            } else {
                $scope.error = "Something went wrong, please try again.";
            }
        })
        $scope.UnLock = function (user) {

        }

    }    

    $scope.Lock = function (user) {
        let data = {
            email: user.email
        }
        $http.post(GetApiUrl("LockUser"), data).then(function (data, status) {
            if (data) {
                alert(user.name + " Locked");
                $location.path('/Admin-dashboard');
            } else {
                $scope.error = "Something went wrong, please try again.";
            }
        })
        $scope.UnLock = function (user) {

        }
    }
})