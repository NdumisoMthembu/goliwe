app.controller("referralsCtrl", function ($scope) {
    let user = JSON.parse(localStorage.getItem('UserData'));
  
    $scope.users = user.myrefferalsLS.data;
     console.log($scope.users);
})