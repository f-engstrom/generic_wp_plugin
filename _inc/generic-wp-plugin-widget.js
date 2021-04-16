//jQuery(document).ready(function ($) {
//    $(function () {
//        $("#postButton").click(function () {
//            let email = $("#email").val();
//
//            console.log("myajax", MyAjax);
//
//            var data = {
//                action: "my_action",
//                security: MyAjax.security,
//                email: email,
//            };
//
//            $.post(MyAjax.ajaxurl, data, function (response) {
//                var obj = jQuery.parseJSON(response);
//
//                const event = new Date(obj.nps_date);
//
//                $("#searched_email").html(`<span>Email:</span>${obj.email}`);
//                $("#nps_score").html(`<span>Score:</span>${obj.nps_score}`);
//                $("#nps_date").html(`<span>Date:</span>${event.toDateString()}`);
//
//                console.log("click", response);
//                //alert("Got this from the server: " + response);
//            });
//        });
//    });
//});

jQuery(document).ready(function ($) {

    console.log("myajax", MyAjax);

    var data = {
        action: "my_action",
        security: MyAjax.security,
    };

    $.post(MyAjax.ajaxurl, data, function (response) {
        var obj = jQuery.parseJSON(response);

        $("#points").html(`<span>Loalty Points:</span> <strong>${obj.points}</strong>`);


        console.log("click", response);
        //alert("Got this from the server: " + response);
    });
});