document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-id");

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          const viewPicture = document.getElementById("viewPicture");

          if (viewPicture !== null) {
            // Set fallback image if the user image fails to load
            viewPicture.onerror = function () {
              this.onerror = null; // prevent infinite loop if fallback also fails
              this.src = "assets/img/user-profile.png";
            };

            // Set the image source
            viewPicture.src =
              data.user_image && data.user_image.trim() !== ""
                ? data.user_image
                : "assets/img/user-profile.png";
          }

          document.getElementById("viewLastName").value = data.last_name;
          document.getElementById("viewFirstName").value = data.first_name;
          document.getElementById("viewMiddleName").value = data.middle_name;
          document.getElementById("viewStreet").value = data.street;
          document.getElementById("viewBarangay").value = data.barangay;
          document.getElementById("viewMunicipality").value = data.municipality;
          document.getElementById("viewProvince").value = data.province;
          document.getElementById("viewRegion").value = data.region;
          document.getElementById("viewZip").value = data.zip;

          if (data.gender === 1) {
            document.getElementById("viewGenderFemale").checked = true;
          } else {
            document.getElementById("viewGenderMale").checked = true;
          }

          const birthdate = new Date(data.birthdate);
          const options = { year: "numeric", month: "long", day: "numeric" };
          document.getElementById("viewBirthdate").value =
            birthdate.toLocaleDateString("en-US", options);

          let currentDate = new Date();
          let birthDate = new Date(data.birthdate);
          let age = currentDate.getFullYear() - birthDate.getFullYear();
          let monthDiff = currentDate.getMonth() - birthDate.getMonth();
          if (
            monthDiff < 0 ||
            (monthDiff === 0 && currentDate.getDate() < birthDate.getDate())
          ) {
            age--;
          } else if (age < 0) {
            age = 0; // Set age to 0 if negative
          }
          document.getElementById("viewAge").value = age;

          document.getElementById("viewCivilStatus").value = data.civil_status;
          document.getElementById("viewEmail").value = data.email;
          document.getElementById("viewContact").value = data.contact;

          const ageGroupMap = {
            core: "Core Youth",
            child: "Child Youth",
            young_adult: "Young Adult",
            unregistered: "Unregistered Youth",
          };

          const youth_age_group =
            ageGroupMap[data.youth_age_group] || "Unknown";
          document.getElementById("viewYouthAgeGroup").value = youth_age_group;

          document.getElementById("viewYouthClassification").value =
            data.youth_classification;

          document.getElementById("viewEducationalBackground").value =
            data.educational_background;

          document.getElementById("viewWorkStatus").value = data.work_status;

          let sk_voter = data.sk_voter;
          if (sk_voter === "Yes") {
            document.getElementById("skVoterYes").checked = true;
          } else {
            document.getElementById("skVoterNo").checked = true;
          }

          let national_voter = data.national_voter;
          if (national_voter === "Yes") {
            document.getElementById("nationalVoterYes").checked = true;
          } else {
            document.getElementById("nationalVoterNo").checked = true;
          }

          let kk_assembly = data.kk_assembly;
          if (kk_assembly === "Yes") {
            document.getElementById("viewKKAssemblyYes").checked = true;
            $("#ifYes").show();
            $("#ifNo").hide();

            let kk_assembly_times = data.kk_assembly_times;
            switch (kk_assembly_times) {
              case "1-2":
                document.getElementById("viewTimes1to2").checked = true;
                break;
              case "3-4":
                document.getElementById("viewTimes3to4").checked = true;
                break;
              case "5 and above":
                document.getElementById("viewTimes5plus").checked = true;
                break;
              default:
                break;
            }
          } else {
            document.getElementById("viewKKAssemblyNo").checked = true;
            $("#ifYes").hide();
            $("#ifNo").show();

            let kk_assembly_why = data.kk_assembly_why;
            switch (kk_assembly_why) {
              case "There was no KK Assembly Meeting":
                document.getElementById("viewNoAssembly").checked = true;
                break;
              case "Not interested to attend":
                document.getElementById("viewNotInterested").checked = true;
              default:
                break;
            }
          }

          let voted = data.vote;
          if (voted === "Yes") {
            document.getElementById("voteYes").checked = true;
          } else {
            document.getElementById("voteNo").checked = true;
          }

          //Show the modal
          var myModal = new bootstrap.Modal(
            document.getElementById("viewYouthModal")
          );
          myModal.show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  // View Details Handler
  document.querySelectorAll(".view-sk-details").forEach((button) => {
    button.addEventListener("click", () => {
      const skID = button.getAttribute("data-viewSK-id");

      fetch(`get_sk_details.php?id=${skID}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          const viewPicture = document.getElementById("viewSKPicture");

          if (viewPicture !== null) {
            // Set fallback image if the user image fails to load
            viewPicture.onerror = function () {
              this.onerror = null; // prevent infinite loop if fallback also fails
              this.src = "assets/img/user-profile.png";
            };

            // Set the image source
            viewPicture.src =
              "../../app/client/" + data.picture && data.picture.trim() !== ""
                ? "../../app/client/" + data.picture
                : "assets/img/user-profile.png";
          }
          // Set basic information
          document.getElementById("viewLastname").value = data.lastname || "";
          document.getElementById("viewFirstname").value = data.firstname || "";
          document.getElementById("viewMiddlename").value =
            data.middlename || "";
          document.getElementById("viewStreetNumber").value =
            data.street_num || "";

          // Set sex
          document.getElementById("viewSex").value =
            data.sex === 0 ? "Female" : "Male";

          // Set dob and age
          if (data.dob) {
            const dob = new Date(data.dob);
            const options = { year: "numeric", month: "long", day: "numeric" };
            document.getElementById("viewDOB").value = dob.toLocaleDateString(
              "en-US",
              options
            );

            // Calculate age
            let currentDate = new Date();
            let birthDate = new Date(data.dob);
            let age = currentDate.getFullYear() - birthDate.getFullYear();
            let monthDiff = currentDate.getMonth() - birthDate.getMonth();
            if (
              monthDiff < 0 ||
              (monthDiff === 0 && currentDate.getDate() < birthDate.getDate())
            ) {
              age--;
            }
            document.getElementById("viewSKAge").value = age;
          }
          document.getElementById("viewSKEmail").value = data.email || "";
          document.getElementById("viewMobileNumber").value =
            data.mobile_num || "";
          document.getElementById("viewAddress").value = data.address || "";
          document.getElementById("viewPosition").value = data.role || "";

          document.getElementById("viewUsername").value = data.username || "";

          document.getElementById("viewPassword").value = data.password || "";

          // Show the modal using getOrCreateInstance for accessibility
          const viewModal = document.getElementById("viewSKOfficialsModal");
          const modalInstance = bootstrap.Modal.getOrCreateInstance(viewModal);
          modalInstance.show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});

// Add delete functionality
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".delete-youth").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-delete-id");

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading state
          Swal.fire({
            title: "Deleting...",
            text: "Please wait while we delete the record.",
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            },
          });

          fetch(`delete_youth.php?id=${youthId}`, {
            method: "DELETE",
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                // Remove the row from the table
                button.closest("tr").remove();
                // Show success message
                Swal.fire(
                  "Deleted!",
                  "Youth record has been deleted.",
                  "success"
                );
              } else {
                Swal.fire(
                  "Error!",
                  data.message || "Error deleting youth record.",
                  "error"
                );
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              Swal.fire(
                "Error!",
                "Error deleting youth record. Please try again.",
                "error"
              );
            });
        }
      });
    });
  });
});
