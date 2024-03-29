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
    let updateID = $(this).data("update-id");
    let division_chief = $("#division_chief-" + updateID);
    let division_chiefParent = division_chief.parent();
    var provincePlanningUpdate = $("#province-planning-update-" + updateID);
    var provincePlanningUpdateParent = provincePlanningUpdate.parent();

    provincePlanningUpdate.hide().detach();
    division_chief.hide().detach();

    $(".generate-password-btn").click(function () {
        var generateId = $(this).data("generate-id");
        var password = generatePasswordWithNumber();
        $(".user-password." + generateId).val(password);
    });

    function generatePasswordWithNumber() {
        var password = "";
        var numbersCount = 0;
        var letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var numbers = "0123456789";
        var allCharacters = letters + numbers;

        while (numbersCount < 2) {
            password = "";
            numbersCount = 0;

            for (var i = 0; i < 8; i++) {
                password += allCharacters.charAt(
                    Math.floor(Math.random() * allCharacters.length)
                );
            }

            for (var j = 0; j < password.length; j++) {
                if (numbers.includes(password[j])) {
                    numbersCount++;
                }
            }
        }

        return password;
    }

    $("#role-update-" + $(this).data("update-id")).change(function () {
        if (
            $(this).val() === "3" ||
            $(this).val() === "4" ||
            $(this).val() === "5"
        ) {
            provincePlanningUpdate
                .appendTo(provincePlanningUpdateParent)
                .show();
        } else {
            provincePlanningUpdate.hide().detach();
        }
    });
    $("#role-update-" + $(this).data("update-id")).change(function () {
        if ($(this).val() === "5") {
            division_chief.appendTo(division_chiefParent).show();
        } else {
            division_chief.hide().detach();
        }
    });

    if (
        $("#updatemodal-" + $(this).data("update-id"))
            .find("[data-user-role='user-role-type']")
            .val() === "5"
    ) {
        division_chief.appendTo(division_chiefParent).show();
        provincePlanningUpdate.appendTo(provincePlanningUpdateParent).show();
    } else {
        division_chief.hide().detach();
        provincePlanningUpdate.hide().detach();
    }

    if (
        $("#updatemodal-" + $(this).data("update-id"))
            .find("[data-user-role='user-role-type']")
            .val() === "3" ||
        $("#updatemodal-" + $(this).data("update-id"))
            .find("[data-user-role='user-role-type']")
            .val() === "4" ||
        $("#updatemodal-" + $(this).data("update-id"))
            .find("[data-user-role='user-role-type']")
            .val() === "5"
    ) {
        provincePlanningUpdate.appendTo(provincePlanningUpdateParent).show();
    } else {
        provincePlanningUpdate.hide().detach();
    }
});

$(document).ready(function () {
    var provincePlanning = $("#province_planning");
    var addUser = $("#btn-add");
    let division_chief = $("#division_chief");

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
        let userKeyGenerated = generateUserKey();
        $("#input-userkey").val(userKeyGenerated);

        addUser.appendTo(addUserParent).show();
    });
    function generateUserKey() {
        var password = "";
        var numbersCount = 0;
        var letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var numbers = "0123456789";
        var allCharacters = letters + numbers;

        while (numbersCount < 2) {
            password = "";
            numbersCount = 0;

            for (var i = 0; i < 8; i++) {
                password += allCharacters.charAt(
                    Math.floor(Math.random() * allCharacters.length)
                );
            }

            for (var j = 0; j < password.length; j++) {
                if (numbers.includes(password[j])) {
                    numbersCount++;
                }
            }
        }

        return password;
    }
    // PASSWORD TOGGLE EYE
    $(".toggle-password").click(function () {
        var passwordField = $(this)
            .closest(".input-group")
            .find(".eye-password");
        var passwordFieldType = passwordField.attr("type");
        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
    $("#home1").each(function () {
        var $parent = $(this);
        var $button = $parent.find("#profile-btn");

        $button.prop("disabled", true);

        $parent.find(".form-update").on("input", function () {
            var $inputs = $parent.find(".form-update");
            var isButtonEnabled = false;

            $inputs.each(function () {
                var initialValue = $(this).data("initialValue");
                var currentValue = $(this).val().trim();

                if (currentValue !== initialValue) {
                    isButtonEnabled = true;
                    return false; // Exit the loop if a different value is found
                }
            });

            $button.prop("disabled", !isButtonEnabled);
        });

        $parent.find(".form-update").each(function () {
            var $input = $(this);
            var initialValue = $input.val().trim();
            $input.data("initialValue", initialValue);
        });
    });

    $("#profile1").each(function () {
        var $parent = $(this);
        var $button = $parent.find("#profile-email-btn");

        $button.prop("disabled", true);

        $parent.find(".form-update").on("input", function () {
            var $inputs = $parent.find(".form-update");
            var isButtonEnabled = false;

            $inputs.each(function () {
                var initialValue = $(this).data("initialValue");
                var currentValue = $(this).val().trim();

                if (currentValue !== initialValue) {
                    isButtonEnabled = true;
                    return false; // Exit the loop if a different value is found
                }
            });

            $button.prop("disabled", !isButtonEnabled);
        });

        $parent.find(".form-update").each(function () {
            var $input = $(this);
            var initialValue = $input.val().trim();
            $input.data("initialValue", initialValue);
        });
    });
    $("#contact1").each(function () {
        var $parent = $(this);
        var $button = $parent.find("#profile-pass-btn");

        $button.prop("disabled", true);

        $parent.find(".form-update").on("input", function () {
            var $inputs = $parent.find(".form-update");
            var isButtonEnabled = false;

            $inputs.each(function () {
                var initialValue = $(this).data("initialValue");
                var currentValue = $(this).val().trim();

                if (currentValue !== initialValue) {
                    isButtonEnabled = true;
                    return false; // Exit the loop if a different value is found
                }
            });

            $button.prop("disabled", !isButtonEnabled);
        });

        $parent.find(".form-update").each(function () {
            var $input = $(this);
            var initialValue = $input.val().trim();
            $input.data("initialValue", initialValue);
        });
    });
    var printButton = document.getElementById("print-button");
    printButton.addEventListener("click", function () {
        var table = document.getElementById("table").outerHTML;
        var rating = document.getElementById("rating_table");
        var win = window.open("", "_blank");
        var fileName = printButton.dataset.fileName;
        win.document.write("<html><head><title>" + fileName + "</title>");
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
                
            @page {
                size: A4 landscape;
                margin: 10px;
              }
         
            #rpo_scoreCard, #rating_table {
        
            width: 100%;
            max-width: 100%;
     
            background-color: #fff;
            }
            td,
            th {
            background-color: #f7f7f7;
            word-wrap: break-word;
            padding: 3px !important;
            font-size: 10px;
            line-height: 1.2;
            text-align: center;
            border-collapse: collapse !important;
            page-break-inside: avoid;
            }
            
            #rating_table td, th {
            background-color: #f7f7f7;
            word-wrap: break-word;
            padding: 3px !important;
            font-size: 10px;
            line-height: 1.2;
            text-align: left !important;    
            page-break-inside: avoid;
            }
            th {
            white-space: nowrap;
            page-break-inside: avoid;
            page-break-after: auto;
            }
            .ratings_table td{
                text-align: left !important; 
                width: calc(100% / 24); /* 24 is the number of columns in the table */

            }
            
        
            .page-break {
            page-break-after: always;
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
        if (rating) {
            win.document.write(rating.outerHTML);
        }

        // Create anchor element with file name
        // var anchor = document.createElement("a");
        // anchor.setAttribute("href", "#");
        // anchor.setAttribute("download", fileName);
        // anchor.textContent = fileName;

        // // Add anchor element to document body
        // win.document.body.appendChild(anchor);
        // win.document.write(
        //     '<script src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>'
        // );
        win.document.write("</body></html>");
        win.document.close();
        setTimeout(() => {
            win.print(fileName);
        }, 1000);
    });

    var printScoreCard = document.getElementById("print-scoreCard");

    if (printScoreCard) {
        printScoreCard.addEventListener("click", function () {
            var rpo_scoreCard = document.getElementById("rpo_scoreCard");
            var rating = document.getElementById("rating_table");
            rpo_scoreCard.classList.remove("d-none");
            var contentWidth = rpo_scoreCard.offsetWidth;
            var contentHeight = rpo_scoreCard.offsetHeight;
            var winScorecard = window.open("", "_blank");
            var fileNameScorecard = printScoreCard.dataset.fileName;
            var type = printScoreCard.dataset.fileType;
            var preparedby  = printScoreCard.dataset.filePreparedby;
            var reviewedbdd  = printScoreCard.dataset.fileReviewedbdd;
            var reviewedcpd  = printScoreCard.dataset.fileReviewedcpd;
            var approvedby  = printScoreCard.dataset.fileApprovedby;
            // console.log(preparedby);

            if (rpo_scoreCard.offsetWidth > window.innerWidth) {
                // Calculate the font size adjustment ratio
                var ratio = window.innerWidth / rpo_scoreCard.offsetWidth;
                var newFontSize = 10 * ratio;

                // Adjust the font size of the table cells
                var cells = rpo_scoreCard.querySelectorAll("td, th");
                for (var i = 0; i < cells.length; i++) {
                    cells[i].style.fontSize = newFontSize + "px";
                }
            }
            winScorecard.document.write(
                "<html><head><title>" + fileNameScorecard + "</title>"
            );
            winScorecard.document.write(
                '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />'
            );
            winScorecard.document.write(
                '<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>'
            );
            winScorecard.document.write(
                '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />'
            );

            winScorecard.document.write("<style>");
            winScorecard.document.write(`
            
            @media print {
                
                @page {
                    size: A4 landscape;
                    margin: 10px;
                  }
             
                #rpo_scoreCard, #rating_table {
            
                width: 100%;
                max-width: 100%;
         
                background-color: #fff;
                }
                td,
                th {
                background-color: #f7f7f7;
                word-wrap: break-word;
                padding: 3px !important;
                font-size: 10px;
                line-height: 1.2;
                text-align: center;
                border-collapse: collapse !important;
                page-break-inside: avoid;
                }
                
                #rating_table td, th {
                background-color: #f7f7f7;
                word-wrap: break-word;
                padding: 3px !important;
                font-size: 10px;
                line-height: 1.2;
                text-align: left !important;    
                page-break-inside: avoid;
                }
                th {
                white-space: nowrap;
                page-break-inside: avoid;
                page-break-after: auto;
                }
                .ratings_table td{
                    text-align: left !important; 
                    width: calc(100% / 24); /* 24 is the number of columns in the table */

                }
            
                .page-break {
                page-break-after: always;
                }
                
                
            }
            
            `);
            winScorecard.document.write("</style>");
            winScorecard.document.write("</head><body>");
            winScorecard.document.write(
                "<div class='header' style='display:flex;align-items:center;justify-content:space-between; page-break-inside: avoid;'>"
            );
            winScorecard.document.write(
                "<img style='height:auto;width:70px;' src='/images/dti-logo.png' />"
            );
            winScorecard.document.write(
                "<p style='text-align:center;font-size:10px;'>Republic of the Philippines<br>Department of Trade and Industry</p>"
            );
            winScorecard.document.write("<div></div>");
            winScorecard.document.write("</div>");

            winScorecard.document.write("<div id='content'>");
            winScorecard.document.write(rpo_scoreCard.outerHTML);
            if (rating) {
                winScorecard.document.write(rating.outerHTML);
            }
            winScorecard.document.write("</div>");
            if (type == "Provincial" ) {
                    winScorecard.document
                    .write(`<div style="display: flex; justify-content: space-around; align-items: center; font-size: 12px;margin-top: 45px">
                    <div >
                        <div><p>Prepared by:</p></div>
                        <div>
                        <p style="margin-bottom: -10px">${preparedby}</p>
                        <p style="margin-bottom: 0">______________________________</p>
                        <p>Planning Officer</p>
                        </div>
                
                    </div>
                    <div>
                        <div><p>Reviewed by:</p></div>
                        <div>
                        <p style="margin-bottom: -10px">${reviewedbdd}</p>
                            <p style="margin-bottom: 0">_______________________________________________________________</p>
                            <p>OIC Chief, BDD</p>
                        </div>
                    </div>
                    <div>
                        <div><p>Reviewed by:</p></div>
                        <div>
                            <p style="margin-bottom: -10px">${reviewedcpd}</p>
                            <p style="margin-bottom: 0">_______________________________________________________________</p>
                            <p>Chief, CPD</p>
                        </div>
                    </div>
                
                
                <div>
                    <div><p>Approved by:</p></div>
                    <div>
                        <p style="margin-bottom: -10px">${approvedby}</p>
                        <p style="margin-bottom: 0">______________________________</p>
                        <p>OIC Provincial Director</p>
                    </div>
                </div>
                
                </div>
                `);
                
            }

            winScorecard.document.write("</body></html>");
            winScorecard.document.close();
            rpo_scoreCard.classList.add("d-none");
            var printWindow = function (win) {
                win.print(fileNameScorecard);
                if (win.innerHeight > win.outerHeight) {
                    winScorecard.location.reload();
                }
            };

            var adjustContentSize = function (win) {
                var content = win.document.getElementById("content");
                var scale = Math.min(
                    win.innerWidth / contentWidth,
                    win.innerHeight / contentHeight
                );
            };

            winScorecard.onload = function () {
                adjustContentSize(winScorecard);
                printWindow(winScorecard);
            };
        });
    }
});

// var button = document.getElementById('disableWhenClicked');
