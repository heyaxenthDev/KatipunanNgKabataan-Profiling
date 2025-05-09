document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".edit-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-edit-id");

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
          const editPicture = document.getElementById("editPicture");

          if (editPicture !== null) {
            // Set fallback image if the user image fails to load
            editPicture.onerror = function () {
              this.onerror = null; // prevent infinite loop if fallback also fails
              this.src = "assets/img/user-profile.png";
            };

            // Set the image source
            editPicture.src =
              data.user_image && data.user_image.trim() !== ""
                ? data.user_image
                : "assets/img/user-profile.png";
          }
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

          if (data.gender === 1) {
            document.getElementById("editGenderFemale").checked = true;
          } else {
            document.getElementById("editGenderMale").checked = true;
          }

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
          } else if (age < 0) {
            age = 0; // Set age to 0 if negative
          }
          document.getElementById("editAge").value = age;

          document.getElementById("editCivilStatus").value = data.civil_status;
          document.getElementById("editEmail").value = data.email;
          document.getElementById("editContact").value = data.contact;

          document.getElementById("editYouthAgeGroup").value =
            data.youth_age_group;

          document.getElementById("editYouthClassification").value =
            data.youth_classification;

          let edu_background = data.educational_background;
          switch (edu_background) {
            case "Elementary Level":
              document.getElementById("editElementaryLevel").checked = true;
              break;
            case "Elementary Graduate":
              document.getElementById("editElementaryGraduate").checked = true;
              break;
            case "High School Level":
              document.getElementById("editHighSchoolLevel").checked = true;
              break;
            case "High School Graduate":
              document.getElementById("editHighSchoolGraduate").checked = true;
              break;
            case "Vocational Graduate":
              document.getElementById("editVocationalGraduate").checked = true;
              break;
            case "College Level":
              document.getElementById("editCollegeLevel").checked = true;
              break;
            case "College Graduate":
              document.getElementById("editCollegeGraduate").checked = true;
              break;
            case "Master Level":
              document.getElementById("editMasterLevel").checked = true;
              break;
            case "Master Graduate":
              document.getElementById("editMasterGraduate").checked = true;
              break;
            case "Doctorate Level":
              document.getElementById("editDoctorateLevel").checked = true;
              break;
            case "Doctorate Graduate":
              document.getElementById("editDoctorateGraduate").checked = true;
              break;
            default:
              break;
          }

          let work_status = data.work_status;
          switch (work_status) {
            case "Employed":
              document.getElementById("editEmployed").checked = true;
              break;
            case "Self-Employed":
              document.getElementById("editSelfEmployed").checked = true;
              break;
            case "Unemployed":
              document.getElementById("editUnemployed").checked = true;
              break;
            case "Currently looking for a job":
              document.getElementById("editCurrentlyLooking").checked = true;
              break;
            case "Not interested in looking for a job":
              document.getElementById("editNotInterested").checked = true;
              break;
            case "Still Studying":
              document.getElementById("editStillStudying").checked = true;
              break;
            default:
              break;
          }

          let sk_voter = data.sk_voter;
          if (sk_voter === "Yes") {
            document.getElementById("editSkVoterYes").checked = true;
          } else {
            document.getElementById("editSkVoterNo").checked = true;
          }

          let national_voter = data.national_voter;
          if (national_voter === "Yes") {
            document.getElementById("editNationalVoterYes").checked = true;
          } else {
            document.getElementById("editNationalVoterNo").checked = true;
          }

          let kk_assembly = data.kk_assembly;
          if (kk_assembly === "Yes") {
            document.getElementById("editKkAssemblyYes").checked = true;
            $("#editIfYes").show();
            $("#editIfNo").hide();

            let kk_assembly_times = data.kk_assembly_times;
            switch (kk_assembly_times) {
              case "1-2":
                document.getElementById("editTimes1to2").checked = true;
                break;
              case "3-4":
                document.getElementById("editTimes3to4").checked = true;
                break;
              case "5 and above":
                document.getElementById("editTimes5plus").checked = true;
                break;
              default:
                break;
            }
          } else {
            document.getElementById("editKkAssemblyNo").checked = true;
            $("#editIfYes").hide();
            $("#editIfNo").show();

            let kk_assembly_why = data.kk_assembly_why;
            switch (kk_assembly_why) {
              case "There was no KK Assembly Meeting":
                document.getElementById("editNoAssembly").checked = true;
                break;
              case "Not interested to attend":
                document.getElementById("editNotInterested").checked = true;
              default:
                break;
            }
          }

          let voted = data.vote;
          if (voted === "Yes") {
            document.getElementById("editVoteYes").checked = true;
          } else {
            document.getElementById("editVoteNo").checked = true;
          }
          //Show the modal
          new bootstrap.Modal(document.getElementById("editYouthModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
