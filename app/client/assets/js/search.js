$(document).ready(function () {
  $(".search-form").submit(function (e) {
    e.preventDefault();

    let query = $('input[name="query"]').val();

    if (query.trim() !== "") {
      // Optional: Show a loading SweetAlert while the request is processed
      Swal.fire({
        title: "Searching...",
        text: "Please wait while we fetch the data.",
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        url: "search_data.php",
        type: "POST",
        data: {
          query: query,
        },
        success: function (response) {
          Swal.close(); // Close the loading alert

          try {
            let data = JSON.parse(response);

            if (data.error) {
              // Show error feedback using SweetAlert
              Swal.fire({
                title: "Error",
                text: data.message || "No record found.",
                icon: "error",
                confirmButtonText: "OK",
              });
            } else {
              // Show success feedback using SweetAlert
              Swal.fire({
                title: "Record Found!",
                text: "The details have been successfully fetched.",
                icon: "success",
                confirmButtonText: "OK",
              });

              // Populate fields with returned data
              $("#userImage").attr("src", data.user_image || "");
              $("#LastName").val(data.last_name || "");
              $("#FirstName").val(data.first_name || "");
              $("#MiddleName").val(data.middle_name || "");
              $("#Street").val(data.street || "");
              $("#Municipality").val(data.municipality || "");
              $("#Province").val(data.province || "");
              $("#Region").val(data.region || "");
              $("#Zip").val(data.zip || "");
              $("#Barangay").val(data.barangay || "");
              $("#Age").val(data.age || "");
              if (data.gender === 1) {
                $("#genderFemale").prop("checked", true);
              } else {
                $("#genderMale").prop("checked", true);
              }
              $("#birthdate").val(data.birthdate || "");
              $("#CivilStatus").val(data.civil_status || "");
              $("#Email").val(data.email || "");
              $("#Contact").val(data.contact || "");

              let youthAgeGroup = data.youth_age_group || "";
              switch (youthAgeGroup) {
                case "core":
                  $("#YouthAgeGroup").val("Core Youth (18-24 years old)");
                  break;
                case "child":
                  $("#YouthAgeGroup").val("Child Youth (15-17 years old)");
                  break;
                case "young_adult":
                  $("#YouthAgeGroup").val("Young Adult (25-30 years old)");
                case "unregistered":
                  $("#YouthAgeGroup").val(
                    "Unregistered Youth (below 15 years old)"
                  );
                  break;
                default:
                  break;
              }
              $("#YouthClassification").val(data.youth_classification || "");
              $("#EducationalBackground").val(
                data.educational_background || ""
              );
              $("#WorkStatus").val(data.work_status || "");

              if (data.sk_voter === "Yes") {
                $("#skVoterYes").prop("checked", true);
              } else {
                $("#skVoterNo").prop("checked", true);
              }

              if (data.national_voter === "Yes") {
                $("#nationalVoterYes").prop("checked", true);
              } else {
                $("#nationalVoterNo").prop("checked", true);
              }

              if (data.kk_assembly === "Yes") {
                $("#kkAssemblyYes").prop("checked", true);
                $("#ifYes").show();
                $("#ifNo").hide(); // Hide 'No' section if 'Yes' is selected

                switch (data.kk_assembly_times) {
                  case "1-2":
                    $("#times1to2").prop("checked", true);
                    break;
                  case "3-4":
                    $("#times3to4").prop("checked", true);
                    break;
                  case "5 and above":
                    $("#times5plus").prop("checked", true);
                  default:
                    break;
                }
              } else {
                $("#kkAssemblyNo").prop("checked", true);
                $("#ifNo").show();
                $("#ifYes").hide(); // Hide 'Yes' section if 'No' is selected

                switch (data.kk_assembly_why) {
                  case "There was no KK Assembly Meeting":
                    $("#NoAssembly").prop("checked", true);
                    break;
                  case "Not interested to attend":
                    $("#NotInterested").prop("checked", true);
                  default:
                    break;
                }
              }

              if (data.vote === "Yes") {
                $("#voteYes").prop("checked", true);
              } else {
                $("#voteNo").prop("checked", true);
              }
            }
          } catch (err) {
            // Show unexpected error message using SweetAlert
            Swal.fire({
              title: "Failed",
              text: "An unexpected error occurred. Please try again.",
              icon: "warning",
              confirmButtonText: "OK",
            });
            console.error(err);
          }
        },
        error: function () {
          Swal.close(); // Close the loading alert
          // Show network error feedback using SweetAlert
          Swal.fire({
            title: "Connection Error",
            text: "Failed to connect to the server. Please try again.",
            icon: "error",
            confirmButtonText: "OK",
          });
        },
      });
    } else {
      // Show validation error using SweetAlert
      Swal.fire({
        title: "Validation Error",
        text: "Please enter an Employee/Student ID.",
        icon: "warning",
        confirmButtonText: "OK",
      });
    }
  });
});
