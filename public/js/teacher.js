$(document).ready(function () {
    var mode, id, coreJSON;
    var currentPage = 0;
    // ***************************[Get] ********************************************************************
    Getteacher();

    function Getteacher() {

        $.ajax({
            url: baseUrl + "/teacher-get",
            type: "GET",
            dataType: "json",
            success: function (response) {
                disteacher(response);
                coreJSON = response.teacherdetails;
                console.log(coreJSON);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching teacher details:", error);
            },
        });
    }

    function disteacher(data) {
        if ($.fn.DataTable.isDataTable("#datatable")) {
            $('#datatable').DataTable().clear().destroy();
        }

        var table = $("#datatable").dataTable({
            aaSorting: [],
            aaData: data.teacherdetails,
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
        $.when(Getteacher()).done(function () {
            var table = $('#datatable').DataTable();
            table.destroy();
            disteacher(coreJSON);
        });
    }

    // ***************************[Add] ********************************************************************

    $(".add_teacher_btn").click(function () {
        mode = "new";
        $("#add_teacher").modal("show");
    });

    $("#add_teacher").on("show.bs.modal", function () {
        $(this).find("form").trigger("reset");
        $(".form-control").removeClass("danger-border success-border");
        $(".error-message").html("");
        $("#previewImage").attr("src", "");

    });



    $("#teacher_add_form input").on("keyup", function () {
        validateField($(this));
    });

    // Form submission

    $("#teacher_add_form").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var isValid = true;
        var firstInvalidField = null;

        // Validate all fields
        if (!validateField($("#name"))) {
            isValid = false;
            firstInvalidField = $("#name");
        } else if (!validateField($("#email"))) {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#email");
        }
        else if (!validateField($("#password")) && mode != 'update') {
            isValid = false;
            if (firstInvalidField === null)
                firstInvalidField = $("#password");
        }


        if (isValid) {
            var formData = new FormData(this);
            console.log(formData);
            if (mode == "new") {
                // showToast("add");
                // return;
                if ($('#password').val() !== "") {
                    formData.append('password', $('#password').val());
                }
                AjaxSubmit(formData, baseUrl + "/teacher-add", "POST");

            } else if (mode == "update") {

                // formData.append("teacher_id", id);
                AjaxSubmit(formData, baseUrl + "/teacher-update/" + id, "POST");
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

        if (fieldId === "name") {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Teacher Name is required";
            }
        }
        else if (fieldId === "email") {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Email is required";
            } else if (!emailRegex.test(fieldValue)) {
                isValid = false;
                errorMessage = "Enter a valid Email";
            }
        }
        else if (fieldId === "password" && mode !='update') {
            if (fieldValue === "") {
                isValid = false;
                errorMessage = "Password is required";
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
                if (response.status === "teacher_add_success") {
                    if (response.status_value) {

                        $("#add_teacher").modal("hide");

                        showToast(response.message);
                        // window.location.reload();
                        Getteacher();

                    } else {
                        showToast(response.message);
                    }
                }
                if (response.status === "teacher_update_success") {
                    if (response.status_value) {
                        $("#add_teacher").modal("hide");
                        showToast(response.message);
                        // refreshDetails();
                        Getteacher();
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
        $("#add_teacher").modal("show");

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
                deleteteacher: {
                    text: "delete teacher",
                    action: function () {
                        $.ajax({
                            url: baseUrl + "/teacher-delete",
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
