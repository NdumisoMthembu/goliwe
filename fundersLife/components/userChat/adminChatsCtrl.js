app.controller("adminChatsCtrl", function ($scope, $http, $interval) {
    $scope.id = localStorage.getItem("userToDelete");
    $scope.name = localStorage.getItem("userToName");
    $scope.GetChats = function () {

        $http.post(GetApiUrl("GetChatsAdmins"), { id: $scope.id })
            .then(function (response, status) {
                $scope.chats = response.data.data;

            });
    }
    $scope.GetChats();
    $scope.OpenChats = function (chat) {
        //alert(chat.senderEmail); 
        chat.status = "read";
        $scope.showTextArea = true;

        $scope.receiverEmail = chat.senderEmail;
        $scope.clientId = chat.clientId;
        $scope.receiverName = chat.senderName;
        $http.post(GetApiUrl("GetMessagesOneOnOnes"), { clientId: chat.clientId })
            .then(function (response, status) {
                $scope.messages = response.data.data;

            });
    }

    $scope.RefreshCurrectChat = function () {
        $http.post(GetApiUrl("GetMessagesOneOnOnes"), { clientId: $scope.clientId })
            .then(function (response, status) {
                $scope.messages = response.data.data;

            });
    }

    $scope.Send = function () {
        if ($scope.messageBody) {
            var data = {
                senderEmail: "admin@mail.com",
                senderName: "Admin",
                receiverEmail: $scope.receiverEmail,
                receiverName: $scope.receiverName,
                messageBody: $scope.messageBody,
                clientId: $scope.receiverEmail
            };
            $http.post(GetApiUrl("SendChat"), data)
                .then(function (response, status) {
                    $scope.RefreshCurrectChat();
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
    let input = document.getElementById("txtMessageBodyAdmin");
    input.addEventListener("keyup", function (event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            $scope.Send();
        }
    });
    //end  send with enter
    /*
    $interval(function () {
        if ($scope.clientId !== undefined) {
            $scope.RefreshCurrectChat();
        }
    }, 1000);

    */
})