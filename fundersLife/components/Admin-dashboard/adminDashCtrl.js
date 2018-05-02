app.controller("adminDashCtrl", function ($scope, $http, $location) {
   

    if (localStorage.getItem("Notify2") === "true") {
        SendMail(localStorage.getItem("emailFrom"), localStorage.getItem("to"), localStorage.getItem("nameTo"), localStorage.getItem("subject"), localStorage.getItem("msg"));
        localStorage.setItem("Notify2", false);
    }
   let user = JSON.parse(localStorage.getItem('UserData'));

   $scope.name = user.name;
   $scope.email = user.email;
    $scope.wait = "Please wait...";
    $scope.GetCounts = function () {
        Load();
      
            $http.post(GetApiUrl("GetAdminDashCounts"), {})
                .then(function (response, status) {
                    if (response !== undefined || response !== null) {
                        $scope.counts = response.data.data;
                        $scope.wait = "";
                        Stop();
                    } else {
                        //   $scope.message = "Oops! Your username or password is incorrect please CHECK and try again.";
                    }

                });
   
    };

    $scope.More = function (gh) {
        let key = gh.key.toLowerCase();
      
        switch (key) {
            case 'awaiting allocation': {

                $location.path('/Awaiting-allocation');
                break;
            }
            case 'paid': {
                $location.path('/Paid-dreams');
                break;
            }
            case 'active': {
                $location.path('/Active-dreams');
                break;
            }
            case 'allocated': {
                
                $location.path('/Allocated');
                break;
            }

            case 'users': {

                $location.path('/User-list');
                break;
            }
            case 'keepers': {

                $location.path('/Keepers');
                break;
            }
            case 'messages': {

                $location.path('/Messages');
                break;
            }

            case 'widrawls': {

                $location.path('/widrawls-list');
                break;
            }


        }
      
    }
})