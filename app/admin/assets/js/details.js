document.addEventListener("DOMContentLoaded", () => {
  // View Details Handler
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-id");

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
          // Set profile picture
          const viewPicture = document.getElementById("viewPicture");
          if (viewPicture) {
            viewPicture.onerror = function () {
              this.onerror = null;
              this.src = "../../../client/assets/img/user-profile.png";
            };
            viewPicture.src =
              data.user_image && data.user_image.trim() !== ""
                ? data.user_image
                : "../../../client/assets/img/user-profile.png";
          }

          // Set basic information
          document.getElementById("viewLastName").value = data.last_name || "";
          document.getElementById("viewFirstName").value =
            data.first_name || "";
          document.getElementById("viewMiddleName").value =
            data.middle_name || "";
          document.getElementById("viewStreet").value = data.street || "";
          document.getElementById("viewBarangay").value = data.barangay || "";
          document.getElementById("viewMunicipality").value =
            data.municipality || "";
          document.getElementById("viewProvince").value = data.province || "";
          document.getElementById("viewRegion").value = data.region || "";
          document.getElementById("viewZip").value = data.zip || "";

          // Set gender
          if (data.gender === 1) {
            document.getElementById("viewGenderFemale").checked = true;
          } else {
            document.getElementById("viewGenderMale").checked = true;
          }

          // Set dob and age
          if (data.birthdate) {
            const birthdate = new Date(data.birthdate);
            const options = { year: "numeric", month: "long", day: "numeric" };
            document.getElementById("viewBirthdate").value =
              birthdate.toLocaleDateString("en-US", options);

            // Calculate age
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
            document.getElementById("viewAge").value = age;
          }

          // Set other personal information
          document.getElementById("viewCivilStatus").value =
            data.civil_status || "";
          document.getElementById("viewEmail").value = data.email || "";
          document.getElementById("viewContact").value = data.contact || "";

          // Set youth classifications
          const ageGroupMap = {
            core: "Core Youth",
            child: "Child Youth",
            young_adult: "Young Adult",
            unregistered: "Unregistered Youth",
          };
          document.getElementById("viewYouthAgeGroup").value =
            ageGroupMap[data.youth_age_group] || "";
          document.getElementById("viewYouthClassification").value =
            data.youth_classification || "";
          document.getElementById("viewEducationalBackground").value =
            data.educational_background || "";
          document.getElementById("viewWorkStatus").value =
            data.work_status || "";

          // Set voter information
          if (data.sk_voter === "Yes") {
            document.getElementById("skVoterYes").checked = true;
          } else {
            document.getElementById("skVoterNo").checked = true;
          }

          if (data.national_voter === "Yes") {
            document.getElementById("nationalVoterYes").checked = true;
          } else {
            document.getElementById("nationalVoterNo").checked = true;
          }

          // Show the modal using getOrCreateInstance for accessibility
          const viewModal = document.getElementById("viewYouthModal");
          const modalInstance = bootstrap.Modal.getOrCreateInstance(viewModal);
          modalInstance.show();
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
