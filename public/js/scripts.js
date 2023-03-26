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
$(document).on("show.bs.modal", ".modal-update-rpo", function () {
    $(".generate-password-btn").click(function () {
        console.log("button click");
        var generateId = $(this).data("generate-id");
        var password = Math.random().toString(36).slice(2);
        $(".user-password." + generateId).val(password);
    });
    var updateId = $(this).data("update-id");

    var provincePlanning = $("#province_planning");
    var provincePlanningUpdate = $("#province-planning-update");

    var division_chief = $("#division_chief");
    var addUser = $("#btn-add");

    var provincePlanningParent = provincePlanning.parent();
    var provincePlanningUpdateParent = provincePlanningUpdate.parent();

    var division_chiefParent = division_chief.parent();
    var addUserParent = addUser.parent();

    provincePlanning.hide().detach();
    provincePlanningUpdate.hide().detach();

    division_chief.hide().detach();
    addUser.hide().detach();

    $("#role,#role-update").change(function () {
        console.log(updateId);
        if (
            $(this).val() === "3" ||
            $(this).val() === "4" ||
            $(this).val() === "5"
        ) {
            provincePlanning.appendTo(provincePlanningParent).show();
            provincePlanningUpdate
                .appendTo(provincePlanningUpdateParent)
                .show();
        } else {
            provincePlanning.hide().detach();
            provincePlanningUpdate.hide().detach();
        }
    });
    $("#role,#role-update").change(function () {
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
});
$(document).ready(function () {
    // PASSWORD TOGGLE EYE
    $("#toggle-password").click(function () {
        console.log("clicke eye");
        var passwordField = $("#password");
        var passwordFieldType = passwordField.attr("type");
        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
    var printButton = document.getElementById("print-button");
    printButton.addEventListener("click", function () {
        var table = document.getElementById("table").outerHTML;
        var win = window.open("", "_blank");
        win.document.write("<html><head><title>Print Table</title>");
        win.document.write(
            '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />'
        );
        win.document.write(
            '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>            '
        );
        win.document.write(
            '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />'
        );
        win.document.write("<style>");
        win.document.write(`
            @media print {
                table {
                    background-color: #fff; 
                }
                td, th {
                    background-color: #f7f7f7; 
                }
            }
            `);
        win.document.write("</style>");
        win.document.write("</head><body>");
        win.document.write(
            "<div style='display:flex;align-items:center;justify-content:space-between;'>"
        );
        win.document.write(
            "<img style='height:auto;width:100px;' src='/images/dti-logo.png' />"
        );
        win.document.write(
            "<p style='text-align:center;'>Republic of the Philippines<br>Department of Trade and Industry</p>"
        );
        win.document.write("<div></div>");
        win.document.write("</div>");
        win.document.write(table);
        // win.document.write(
        //     '<script src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>'
        // );
        win.document.write("</body></html>");
        win.document.close();
        setTimeout(() => {
            win.print();
        }, 1000);
    });
});
