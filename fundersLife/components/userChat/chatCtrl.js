app.controller("chatCtrl", function ($scope, $http, $interval) {
    let user = JSON.parse(localStorage.getItem('UserData'));
    $scope.email = user.email;
    $scope.GetChats = function () {
        var data = {
            email: $scope.email
        };
        $http.post(GetApiUrl("GetChats"), data)
            .then(function (response, status) {
                $scope.chats = response.data.data;
                //alert($scope.members);
            });


    }
    $scope.Send = function () {
        if ($scope.messageBody) {
            var data = {
                senderEmail: $scope.email,
                senderName: $scope.name,
                receiverEmail: "admin@mail.com",
                receiverName: "Admin",
                messageBody: $scope.messageBody,
                clientId: $scope.email
            };
            $http.post(GetApiUrl("SendChat"), data)
                .then(function (response, status) {
                    $scope.GetChats();
                    $scope.messageBody = "";
                    //scroll
                    var height = 0;
                    $('.scrollable p').each(function (i, value) {
                        height += parseInt($(".scrollable").height());
                    });

                    height += '';

                    $('.scrollable').animate({
                        scrollTop: height
                    });

                    //end scroll
                });
        }
    }
    // send with enter
    var input = document.getElementById("txtMessageBody");
    input.addEventListener("keyup", function (event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            $scope.Send();
        }
    });
    //end  send with enter
    $scope.GetChats();
    /* $interval(function () {
        $scope.GetChats();
    }, 1000);*/
   
})