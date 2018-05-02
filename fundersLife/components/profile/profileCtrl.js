app.controller("profileCtrl", function ($scope, $http, $location) {

    let user = JSON.parse(localStorage.getItem('UserData'));
    $scope.name = user.name;
    $scope.email = user.email;
    $scope.code = user.code;
    $scope.cell = parseFloat(user.cell);

    $scope.bankname = user.bankname;
    $scope.accountnumber = parseFloat(user.accountnumber);
    $scope.accountType = user.accountType;
    $scope.branch = user.branch;
    $scope.isAkeeper = user.isAkeeper;
    $scope.address = user.address;
    $scope.id = parseFloat(user.idnum);
    $scope.country = user.country;
    $scope.city = user.city;
    
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
    $scope.countries = ['South Africa', 'Unite States']
    $scope.keeperLS = ['Yes', 'No'];

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
            email: $scope.email,
            isAkeeper: $scope.isAkeeper

        };
        if (bankname == undefined || accountnumber == undefined || accountType == undefined || branch == undefined) {
            $scope.isValid = false;
            $scope.message = "Please fill in the form completely";
            return;
        }

        if ($scope.isValid) {

            $http.post(GetApiUrl("UpdateBankingInfo"), data)
                .then(function (response, status) {
                    if (response.statusText == "OK") {
                        alert("Details Updated");
                        $location.path('/Dashboard');
                    } else {
                        $scope.message = response;
                    }

                });
        } else {
            $scope.message = "Please make sure that all required fields are NOT empty"
        }
    };
})