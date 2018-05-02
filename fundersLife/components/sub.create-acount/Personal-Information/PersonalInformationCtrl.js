app.controller("PersonalInformationCtrl", function ($scope, $http, $location) {
    //mail data
    if (parseInt(localStorage.getItem("code")) !== 0) {
        var maildata = {
            emailTo: localStorage.getItem("email"),
            emailFrom: "account@funderslife.com",
            subject: "Verification Code",
            name: localStorage.getItem("name"),
            msg: "Welcome to Funders Life,Your verification code is " + localStorage.getItem("code")
        }

        //send mail
        $http.post("https://www.funderslife.com/api/emailClient.php", maildata)
            .then(function (response, status) {
                console.log("Email sent");
            });
    }
    //send mail
    $scope.countries = ['South Africa', 'Unite States']
    $scope.Save = function () {
        $scope.message = undefined;
        $scope.isValid = true;

        var cell = $scope.cell;
        var address = $scope.address;
        var idnum = $scope.id;
        var country = $scope.selectCountry;
        var city = $scope.city;

        var data = {
            cell: cell,
            address: address,
            idnum: idnum,
            country: country,
            city: city,
            email: localStorage.getItem("email")

        };
        if (cell == undefined || address == undefined || idnum == undefined || country == undefined || city == undefined) {
            $scope.isValid = false;
            $scope.message = "Please fill in the form completely";
            return;
        }

        if ($scope.isValid) {

            $http.post(GetApiUrl("UpdatePersonalInfo"), data)
                .then(function (response, status) {
                    if (parseInt(response.data) === 1) {
                        localStorage.setItem("cell", $scope.cell);
                        localStorage.setItem("address", $scope.address);
                        localStorage.setItem("idnum", $scope.idnum);
                        localStorage.setItem("country", $scope.country);
                        localStorage.setItem("city", $scope.city);
                        $location.path('/Banking-Details');
                    } else {
                        $scope.message = response;
                    }

                });
        } else {
            $scope.message = "Please make sure that all required fields are NOT empty"
        }
    };

    function SendEmailToClient(message, emailFrom, subject) {
        var data = {
            emailTo: localStorage.getItem("email"),
            emailFrom: emailFrom,
            subject: subject
        }
        $http.post(GetApiUrl("EmailClient"), data)
            .then(function (response, status) {
                console.log("Email send");
            });
    }
})