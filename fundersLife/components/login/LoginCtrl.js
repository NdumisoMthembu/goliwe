app.controller("LoginCtrl", function ($scope, $http, $window,$location ) {
    var me = this;
    $scope.Login = function () {
        $scope.message = undefined;
        $scope.isValid = true;
        var email = $scope.email;
        var password = $scope.password;


        var data = {
            email: email,
            password: password
        };

        if (email === undefined) {
            $scope.message = "Please enter a valid email address!"
            $scope.isValid = false;
            return;
        }
        if (password == undefined) {
            $scope.message = "Enter your password!"
            $scope.isValid = false;
            return;
        }

        if ($scope.isValid) {
            $http.post(GetApiUrl("LoginUser"), data)
                .then(function (response) {
                    console.log(response);
                    if (response.data.id) {
                        let user = response.data;
                        localStorage.setItem("UserData", JSON.stringify(user));
                        localStorage.setItem("isEmailVerified", user.isEmailVerified);
                        if (user.role === "admin") {
                            $location.path('/Admin-dashboard');
                        } else {
                            $scope.GetWithdrals(user.id);
                           
                           
                        }
                        me.message = undefined;
                    } else {
                        $scope.message = "Oops! Your user name or password is incorrect please CHECK and try again.";
                    }

                });
        } else {
            $scope.message = "Please make sure that all required fields are NOT empty"
        }
    };

    // reset password

    $scope.SendOTP = function () {
        $scope.message = ""

        if ($scope.emailforotp) {
            // CHECK IF EMAIL EXISTS
            var data = {

                table: "user",
                condition: ` email = '${$scope.emailforotp}'`
            }
            $http.post(GetApiUrl("Get"), data)
                .success(function (response, status) {
                    if (response != undefined) {
                        if (response.length != 0) {
                            $scope.user = response.data[0];

                            $scope.code = Math.floor(4000 * (Math.random() + 1));
                            var msg = ` 

                            So, you forgot your password?  <br><br>
                            
                            Well, it happens to the best of us. <br> <br>
                            
                            To change your password, click the link below:   <br><br>
                            
                            <a href='https://www.funderslife.com/Create_New_Password?code=${$scope.code}&email=${$scope.emailforotp}'><b>Reset Password </b></a> <br><br>
                            
                            Funder Life `;
                            localStorage.setItem("code", $scope.code);
                            SendMail("password-reset@funderslife.com", $scope.emailforotp, "There", "Password Reset Code", msg);

                            $scope.success = "Password reset Link was sent to your emails!"

                            // update code on a db
                            $http.post(GetApiUrl("UpdateCode"), {
                                email: $scope.emailforotp,
                                code: $scope.code
                            })
                                .success(function (response, status) {
                                    //alert(response)
                                });

                        } else {
                            $scope.message = "The email your entered does not exist!"
                            return false;
                        }

                        // alert($scope.user.name);
                    }
                });



        } else {
            $scope.message = "Please enter a valid email address!"

        }
    }

    // this function will be called before redirect to the user dashboard
    $scope.GetWithdrals = function (userID) {
        $http.get(GetApiUrlForID(`GetWithdralsForTheUser.php?id=${userID}`))
            .then(function (response) {
                if (response.data) {

                    $scope.dreams = [];
                    $.each(response.data.data, function (i, item) {

                        if (item.hasWithdrawals === 1) {
                            $scope.dreams.push(item);
                        }
                    });

                    localStorage.setItem("myWithdrawals", JSON.stringify($scope.dreams));
                    $scope.pendingWithdrawals = $scope.dreams.length;
                    $location.path('/Dashboard');
                } else {

                    console.log("No investmenst yet");
                    $location.path('/Dashboard');
                }

            }, function (response) {
                // console.log(response);
            });
    }
})