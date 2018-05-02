app.controller("BankingDetailsCtrl", function ($scope, $http, $location) {
    var me = this;
    $scope.banks = ['Absa',
        'African Bank Limited',
        'Capitec Bank',
        'First National Bank',
        'Bidvest Bank Limited',
        'Nedbank Limited',
        'Imperial Bank South Africa',
        'Investec Bank Limited',
        'Sasfin Bank Limited'
    ];

    $scope.accountTypes = ['Cheque', 'Savings'];
    $scope.Save = function () {
        $scope.message = undefined;
        $scope.isValid = true;
        //				bankname, accountnumber
        var bankname = $scope.bankname;
        var accountnumber = $scope.accountnumber;
        var accountType = $scope.accountType;
        var branch = $scope.branch;

        var data = {
            bankname: bankname,
            accountnumber: accountnumber,
            accountType: accountType,
            branch: branch,
            isAkeeper: 'Yes',
            email: localStorage.getItem("email")

        };
        if (bankname == undefined || accountnumber == undefined || accountType == undefined || branch == undefined) {
            $scope.isValid = false;
            $scope.message = "Please fill in the form completely";
            return;
        }

        if ($scope.isValid) {

            $http.post(GetApiUrl("UpdateBankingInfo"), data)
                .then(function (response, status) {
                    if (parseInt(response.data) === 1) {
                        localStorage.setItem("isLoggedIn", true);
                        localStorage.setItem("bankname", $scope.bankname);
                        localStorage.setItem("accountnumber", $scope.accountnumber);
                        localStorage.setItem("accountType", $scope.accountType);
                        localStorage.setItem("branch", $scope.branch);
                        localStorage.setItem("isAkeeper", 'Yes');
                        localStorage.getItem("isEmailVerified", 0);
                        alert('Your account was created successfully, please login to continue');
                        $location.path('/User-Login');
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