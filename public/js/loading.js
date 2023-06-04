$(document).ready(function () {
    // get the current page url
    var currentUrl = window.location.href;

    $.ajax({
        url: currentUrl, // modify the url based on the current page url
        type: "GET",
        dataType: "html",
        beforeSend: function () {
            $(".loading-screen").show();
        },
        success: function (response) {
            $(".loading-screen").hide();
            $(".dashboard-content").html(response).show();
        },
        error: function (xhr) {
            $(".loading-screen").hide();
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        },
    });
});
