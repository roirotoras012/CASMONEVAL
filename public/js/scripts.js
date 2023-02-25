window.addEventListener("DOMContentLoaded", (event) => {
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

$(document).ready(function () {
    var provincePlanning = $("#province_planning");
    var division_chief = $("#division_chief");
    var addUser = $("#btn-add");
    var provincePlanningParent = provincePlanning.parent();
    var division_chiefParent = division_chief.parent();
    var addUserParent = addUser.parent();

    provincePlanning.hide().detach();
    division_chief.hide().detach();
    addUser.hide().detach();

    $("#role").change(function () {
        if (
            $(this).val() === "3" ||
            $(this).val() === "4" ||
            $(this).val() === "5"
        ) {
            provincePlanning.appendTo(provincePlanningParent).show();
        } else {
            provincePlanning.hide().detach();
        }
    });
    $("#role").change(function () {
        if ($(this).val() === "5") {
            division_chief.appendTo(division_chiefParent).show();
        } else {
            division_chief.hide().detach();
        }
    });

    $("#btn-generate").click(function (e) {
        e.preventDefault();
        $("#input-userkey").val(Math.random().toString(36).slice(2));
        // $("#btn-add").show();
        addUser.appendTo(addUserParent).show();
    });

    $("#datatablesSimple").DataTable();

    // PASSWORD TOGGLE EYE
    $(document).ready(function () {
        $("#toggle-password").click(function () {
            var passwordField = $("#password");
            var passwordFieldType = passwordField.attr("type");
            if (passwordFieldType === "password") {
                passwordField.attr("type", "text");
                $(this)
                    .find("i")
                    .removeClass("fa-eye")
                    .addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this)
                    .find("i")
                    .removeClass("fa-eye-slash")
                    .addClass("fa-eye");
            }
        });
    });
});
