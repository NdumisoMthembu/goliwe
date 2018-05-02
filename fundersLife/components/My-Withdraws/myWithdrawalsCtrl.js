app.controller("myWithdrawalsCtrl", function ($scope) {
    $scope.myWithdrals = JSON.parse(localStorage.getItem("myWithdrawals"));
})