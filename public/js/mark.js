$(document).ready(function () {
    var mode, id, coreJSON;
    var currentPage = 0;
    // ***************************[Get] ********************************************************************
    // Getmark();

    function Getmark() {

        $.ajax({
            url: baseUrl + "/mark-get",
            type: "GET",
            dataType: "json",
            success: function (response) {
                dismark(response);
                coreJSON = response.markdetails;
                console.log(coreJSON);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching mark details:", error);
            },
        });
    }

    function dismark(data) {
        if ($.fn.DataTable.isDataTable("#datatable")) {
            $('#datatable').DataTable().clear().destroy();
        }

        var table = $("#datatable").dataTable({
            aaSorting: [],
            aaData: data.markdetails,
            aoColumns: [
                {
                    mData: function (data, type, full, meta) {
                        return data.name;
                    },
                },


                {
                    mData: function (data, type, full, meta) {
                        return data.email;
                    },
                },
                {
                    mData: function (data, type, full, meta) {
                        return `<button class="edit-btn btn btn-primary" id="${meta.row}">Edit</button> 
                        <button class="delete-btn" id="${data.id}">Delete</button>`;
                    },
                },
            ],
            drawCallback: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


        $('[data-toggle="tooltip"]').tooltip();
    }


    function refreshDetails() {
        currentPage = $('#datatable').DataTable().page(); // Capture the current page number
        $.when(Getmark()).done(function () {
            var table = $('#datatable').DataTable();
            table.destroy();
            dismark(coreJSON);
        });
    }

    // ***************************[Add] ********************************************************************

    $(".add_mark_btn").click(function () {
        mode = "new";
        $("#add_mark").modal("show");
    });

    $("#add_mark").on("show.bs.modal", function () {
        $(this).find("form").trigger("reset");
        $(".form-control").removeClass("danger-border success-border");
        $(".error-message").html("");
        $("#previewImage").attr("src", "");

    });



    $("#mark_add_form input").on("keyup", function () {
        validateField($(this));
    });

    // Form submission

    $("#mark_add_form").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var isValid = true;
        var firstInvalidField = null;

        // Validate all fields
        if (!validateField($("#student_id"))) {
            isValid = false;
            firstInvalidField = $("#student_id");
        } else if (!validateField($("#marks"))) {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#marks");
        }
        else if (!validateField($("#subject"))) {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#subject");
        }
        else if (!validateField($("#date"))) {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#date");
        }

        if (isValid) {
            var formData = new FormData(this);
            console.log(formData);
            if (mode == "new") {
                // showToast("add");
                // return;
              
                AjaxSubmit(formData, baseUrl + "/mark-add", "POST");

            } else if (mode == "update") {
               
                // formData.append("mark_id", id);
                AjaxSubmit(formData, baseUrl + "/mark-update/" + id, "POST");
            }
        } else {
            firstInvalidField.focus();
        }
    });

    // Field validation function

    function validateField(field) {
        var fieldId = field.attr("id");
        var fieldValue = field.val().trim();
        var isValid = true;
        var errorMessage = "";

        if (fieldId === "student_id") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Student Name is required";
            }
        }
        
       else if (fieldId === "marks") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Mark is required";
            }
        }
        else if (fieldId === "subject") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Subject	is required";
            }
        }
        else if (fieldId === "date") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Date is required";
            }
        }
        

        if (isValid) {
            field.removeClass("danger-border").addClass("success-border");
            $("#" + fieldId + "_error").text("");
        } else {
            field.removeClass("success-border").addClass("danger-border");
            $("#" + fieldId + "_error").text(errorMessage);
            // field.focus();
        }

        return isValid;
    }


    // AJAX submit function
    function AjaxSubmit(formData, url, method) {

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                // Handle success
                if (response.status === "mark_add_success") {
                    if (response.status_value) {

                        $("#add_mark").modal("hide");

                        showToast(response.message);
                        window.location.reload();
                        // Getmark();

                    } else {
                        showToast(response.message);
                    }
                }
                if (response.status === "mark_update_success") {
                    if (response.status_value) {
                        $("#add_mark").modal("hide");
                        showToast(response.message);
                        // refreshDetails();
                        Getmark();
                        // window.location.reload();

                    } else {
                        showToast(response.message);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Error submitting form:", error);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, message) {
                        showToast(message);
                    });
                } else if (xhr.status === 500) {
                    alert("An internal server error occurred. Please try again later.");
                } else {
                    alert("An error occurred: " + xhr.status + " - " + error);
                }
            },
        });
    }

    // ***************************[Edit] ********************************************************************

    $(document).on("click", ".edit-btn", function () {
        var r_index = $(this).attr("id");
        mode = "update";
        $("#add_mark").modal("show");

        $("#name").val(coreJSON[r_index].name);
        $("#email").val(coreJSON[r_index].email);
        $(".password_group").hide();
        console.log(coreJSON);
        id = coreJSON[r_index].id;
    });

    // ***************************[Delete] ********************************************************************

    $(document).on("click", ".delete-btn", function () {
        var selectedId = $(this).attr("id");
        $.confirm({
            title: "Confirmation!",
            content: "Are you sure want to delete?",
            type: "red",
            typeAnimated: true,
            // autoClose: 'cancelAction|8000',
            buttons: {
                deletemark: {
                    text: "delete mark",
                    action: function () {
                        $.ajax({
                            url: baseUrl + "/mark-delete",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            data: { selectedId: selectedId }, // Send data as an object
                            success: function (data) {
                                if (data.status) {
                                    showToast(data.message);
                                    location.reload();
                                } else {
                                    showToast(data.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                // Handle error response
                            },
                        });
                    },
                    btnClass: "btn-red",
                },
                cancel: function () {
                    // $.showToast('action is canceled');
                },
            },
        });
    });



});
