app.controller("proofOfPaymentCtrl", function ($scope, $http, $location, $timeout) {
   
    $scope.investmentID = localStorage.getItem("_investmentID");
    $scope.keeperID = localStorage.getItem("keeperID");
    $scope.upload = true;
    $scope.back = false;
    $scope.senderName = localStorage.getItem("senderName");
    $scope.toEmail = localStorage.getItem("toEmail");
    $scope.toName = localStorage.getItem("toName");
    $scope.amount = localStorage.getItem("amount");
    $scope.filesChanged = function (eml) {
        $scope.files = eml.files;
        $scope.filename = $scope.files[0].name;
        //  alert($scope.filename);
        $scope.$apply();
    };
    $scope.Invest = function () {
        console.log($scope.filename);
        if ($scope.filename !== undefined) {
            var doc = "";
            var formData = new FormData();
            angular.forEach($scope.files, function (file) {
                formData.append('file', file);
                formData.append('name', file.name)
            });

            $http.post(GetApiUrl("upload"), formData, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            })
                .then(function (resp) {
                    var expectedDate = new Date();
                    doc = GetHost(resp.data);
                   
                    // alert(doc);
                    var data = {
                        doc: doc,
                        keeperID: $scope.keeperID,
                        senderName: $scope.senderName,
                        toEmail: $scope.toEmail,
                        amount: $scope.amount,
                        toName: $scope.toName
                    };

                    $http.post(GetApiUrl("UpdatePOP"), data).then(function (response, status) {
                        if (response.statusText == "OK") {
                            //$window.location.href = "Dashboard";
                            Stop();
                            $scope.success = "Thanks for your Proof of payment, we will verify and let you know as soon as possible.";
                            $scope.msg = localStorage.getItem("name") + " Uploaded the proof of payment , please check your account balance and confirm the payment!";
                            $scope.error = undefined;
                            $scope.upload = false;
                            $scope.back = true;

                            SendMail("noreply@funderslife.com", localStorage.getItem("keeperemail"), localStorage.getItem("keepername"), "Proof of payment", $scope.msg);

                        } else {
                            $scope.message = "Something went wrong, please try again.";
                        }
                    })
                })
        } else {
            $scope.message = "Please select the files!";
        }

    }

    $scope.Back = function () {
        $scope.InvestmentDetails();
    }

    //InvestmentDetails
    $scope.InvestmentDetails = function () {
        $timeout(function () {
            $http.get(GetApiUrlForID(`GetInvestmentById.php?id=${$scope.investmentID}`))
                .then(function (response) {
                    // console.log(response);
                    localStorage.setItem("investmentDetails", JSON.stringify(response));
                    // if(investment.status==="allocated"){
                    $location.path('/Dream-Details');
                    //   }

                })
        }, 300)
    }
})