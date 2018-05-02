
app.controller("logoutCtrl", function ($location) {
    localStorage.clear();
    $location.path('/Home');
})