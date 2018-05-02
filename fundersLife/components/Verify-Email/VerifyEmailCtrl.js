app.controller("VerifyEmailCtrl", function ($scope, $http, $window, $location) {
    //Load Old user

    $scope.user = JSON.parse(localStorage.getItem('UserData'));
    $scope.code = $scope.user.code;
    $scope.Verify = function () {
        $scope.email = $scope.user.email;
        $scope.success = undefined;
        $scope.error = undefined;
        if (parseInt($scope.mycode) === parseInt($scope.code)) {
            var data = {
                email: $scope.email,
                code: $scope.code
            }
            $http.post(GetApiUrl("VerifyEmail"), data)
                .then(function (response, status) {
                    localStorage.setItem("isEmailVerified", 1);
                    localStorage.setItem("isEmailVerified", 1);
                    $scope.isEmailVerified = 1;
                    // send welcome email with a link
                    var msg = "Your email address was verified successfully, Here is your link " + response + ". To get bonuses share this link and get 10% bonus on there first active dream!";
                    localStorage.setItem("emailFrom", "noreply@funderslife.com");
                    localStorage.setItem("to", $scope.email);
                    localStorage.setItem("send_name", $scope.name);
                    localStorage.setItem("subject", "Welcome- Email verified");
                    localStorage.setItem("msg", msg);
                    localStorage.setItem("sendWelcomeEmail", true);
                    $location.path('/Dashboard');


                });

        } else {
            $scope.error = "Code does not match!";
        }
    }


    $scope.Resend = function () { //UpdateVerificationCode
        $scope.code = Math.floor(4000 * (Math.random() + 1));
        var maildata = {
            emailTo: $scope.user.email,
            emailFrom: "account@funderslife.com/",
            subject: "Verification Code",
            name: $scope.user.name,
            msg: "Welcome to Funders Life,Your verification code is " + $scope.code
        }

        //send mail
        $http.post("https://www.funderslife.com/api/emailClient.php", maildata)
            .then(function (response, status) {

                $scope.success = "The code was sent ,please check your emails";
                console.log("Email sent");
            });
    }
})