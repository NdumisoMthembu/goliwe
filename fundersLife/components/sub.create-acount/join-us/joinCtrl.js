app.controller("joinCtrl", function ($scope, $http, $location) {

    //Logout the user if any
    localStorage.clear();
    // CHECK FOR THE PARENT Link
    let baseUrlMain = $location.absUrl();
    if (baseUrlMain.toLowerCase().includes("link=")) {
        $scope.parentlink = baseUrlMain.toLowerCase();
    } else {
        $scope.parentlink = "";
    }

    $scope.Join = function () {
        $scope.message = undefined;
        $scope.isValid = true;

        var name = $scope.name;
        var surname = $scope.surname;
        var email = $scope.email;
        var password = $scope.password;
        var passwordConfirm = $scope.passwordConfirm;
        var code = Math.floor(4000 * (Math.random() + 1));
        var data = {
            name: name,
            surname: surname,
            email: email,
            password: password,
            code: code,
            baseUrl: base,
            parentlink: $scope.parentlink,

        };
        console.log('data to send', data)
        if (name == undefined || surname == undefined) {
            $scope.isValid = false;
            $scope.message = "Please your name and surname";
            return;
        }
        if (email === undefined) {
            $scope.message = "Please enter a valid email address!"
            $scope.isValid = false;
            return;
        }
        if (password == undefined) {
            $scope.message = "Please create your password!"
            $scope.isValid = false;
            return;
        }
        if (password.length < 8) {
            $scope.message = "Your password has to be at least 8 characters long."
            $scope.isValid = false;
            return;
        }
        if (passwordConfirm == undefined) {
            $scope.message = "Please confirm your password!"
            $scope.isValid = false;
            return;
        }
        if (password !== passwordConfirm) {
            $scope.message = "Password do not match!"
            $scope.isValid = false;
            return;
        }

        if ($scope.isValid) {

            $http.post(GetApiUrl("Reg"), data)
                .then(function (response, status) {
                    if (parseInt(response.data) === 1) {
                        localStorage.setItem("name", $scope.name);
                        localStorage.setItem("email", $scope.email);
                        localStorage.setItem("code", code);
                        localStorage.setItem("isEmailVerified", 0);
                        $location.path('/Personal-Information');
                        
                    } else {
                        $scope.message = response;
                    }

                });
        } else {
            $scope.message = "Please make sure that all required fields are NOT empty"
        }
    };

})