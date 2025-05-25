document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".edit-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-edit-id");

      // Show loading state
      button.disabled = true;
      button.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
          // Reset button state
          button.disabled = false;
          button.innerHTML = '<i class="bi bi-pencil-square"></i> Edit';

          if (!data) {
            alert("Error: Could not fetch youth details");
            return;
          }

          const editPicture = document.getElementById("editPicture");
          if (editPicture !== null) {
            editPicture.onerror = function () {
              this.onerror = null;
              this.src = "assets/img/user-profile.png";
            };
            editPicture.src =
              data.user_image && data.user_image.trim() !== ""
                ? data.user_image
                : "assets/img/user-profile.png";
          }

          // Populate form fields
          document.getElementById("editId").value = data.id;
          document.getElementById("editBrgyCode").value = data.brgyCode;
          document.getElementById("editLastName").value = data.last_name;
          document.getElementById("editFirstName").value = data.first_name;
          document.getElementById("editMiddleName").value = data.middle_name;
          document.getElementById("editStreet").value = data.street;
          document.getElementById("editBarangay").value = data.barangay;
          document.getElementById("editMunicipality").value = data.municipality;
          document.getElementById("editProvince").value = data.province;
          document.getElementById("editRegion").value = data.region;
          document.getElementById("editZip").value = data.zip;

          // Set gender
          if (data.gender === 1) {
            document.getElementById("editGenderFemale").checked = true;
          } else {
            document.getElementById("editGenderMale").checked = true;
          }

          // Set birthdate and calculate age
          document.getElementById("editBirthdate").value = data.birthdate;
          let currentDate = new Date();
          let birthDate = new Date(data.birthdate);
          let age = currentDate.getFullYear() - birthDate.getFullYear();
          let monthDiff = currentDate.getMonth() - birthDate.getMonth();
          if (
            monthDiff < 0 ||
            (monthDiff === 0 && currentDate.getDate() < birthDate.getDate())
          ) {
            age--;
          }
          document.getElementById("editAge").value = age;

          // Set other fields
          document.getElementById("editCivilStatus").value = data.civil_status;
          document.getElementById("editEmail").value = data.email;
          document.getElementById("editContact").value = data.contact;
          document.getElementById("editYouthAgeGroup").value =
            data.youth_age_group;
          document.getElementById("editYouthClassification").value =
            data.youth_classification;

          // Set educational background
          const eduBackground = data.educational_background;
          const eduRadios = document.querySelectorAll(
            'input[name="editEducationalBackground"]'
          );
          eduRadios.forEach((radio) => {
            radio.checked = radio.value === eduBackground;
          });

          // Set work status
          const workStatus = data.work_status;
          const workRadios = document.querySelectorAll(
            'input[name="editWorkStatus"]'
          );
          workRadios.forEach((radio) => {
            radio.checked = radio.value === workStatus;
          });

          // Set voter status
          document.getElementById("editSkVoterYes").checked =
            data.sk_voter === "Yes";
          document.getElementById("editSkVoterNo").checked =
            data.sk_voter === "No";
          document.getElementById("editNationalVoterYes").checked =
            data.national_voter === "Yes";
          document.getElementById("editNationalVoterNo").checked =
            data.national_voter === "No";

          // Set KK Assembly status
          if (data.kk_assembly === "Yes") {
            document.getElementById("editKkAssemblyYes").checked = true;
            $("#editIfYes").show();
            $("#editIfNo").hide();

            const timesRadios = document.querySelectorAll(
              'input[name="editKkAssemblyTimes"]'
            );
            timesRadios.forEach((radio) => {
              radio.checked = radio.value === data.kk_assembly_times;
            });
          } else {
            document.getElementById("editKkAssemblyNo").checked = true;
            $("#editIfYes").hide();
            $("#editIfNo").show();

            const whyRadios = document.querySelectorAll(
              'input[name="editKkAssemblyWhy"]'
            );
            whyRadios.forEach((radio) => {
              radio.checked = radio.value === data.kk_assembly_why;
            });
          }

          // Set vote status
          document.getElementById("editVoteYes").checked = data.vote === "Yes";
          document.getElementById("editVoteNo").checked = data.vote === "No";

          // Show the modal
          const editModal = new bootstrap.Modal(
            document.getElementById("editYouthModal")
          );
          editModal.show();
        })
        .catch((error) => {
          console.error("Error fetching youth details:", error);
          button.disabled = false;
          button.innerHTML = '<i class="bi bi-pencil-square"></i> Edit';
          alert("Error fetching youth details. Please try again.");
        });
    });
  });
});
