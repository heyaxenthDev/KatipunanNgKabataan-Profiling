document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-id");

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
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
          // switch (data.educational_background;) {
          //   case "Elementary Level":
          //     document.getElementById("elementaryLevel").checked = true;
          //     break;
          //   case "Elementary Graduate":
          //     document.getElementById("elementaryGraduate").checked = true;
          //     break;
          //   case "High School Level":
          //     document.getElementById("highSchoolLevel").checked = true;
          //     break;
          //   case "High School Graduate":
          //     document.getElementById("highSchoolGraduate").checked = true;
          //     break;
          //   case "Vocational Graduate":
          //     document.getElementById("vocationalGraduate").checked = true;
          //     break;
          //   case "College Level":
          //     document.getElementById("collegeLevel").checked = true;
          //     break;
          //   case "College Graduate":
          //     document.getElementById("collegeGraduate").checked = true;
          //     break;
          //   case "Master Level":
          //     document.getElementById("masterLevel").checked = true;
          //     break;
          //   case "Master Graduate":
          //     document.getElementById("masterGraduate").checked = true;
          //     break;
          //   case "Doctorate Level":
          //     document.getElementById("doctorateLevel").checked = true;
          //     break;
          //   case "Doctorate Graduate":
          //     document.getElementById("doctorateGraduate").checked = true;
          //     break;
          //   default:
          //     break;
          // }

          document.getElementById("viewWorkStatus").value = data.work_status;

          // let work_status = data.work_status;
          // switch (work_status) {
          //   case "Employed":
          //     document.getElementById("employed").checked = true;
          //     break;
          //   case "Self-Employed":
          //     document.getElementById("selfEmployed").checked = true;
          //     break;
          //   case "Unemployed":
          //     document.getElementById("unemployed").checked = true;
          //     break;
          //   case "Currently looking for a job":
          //     document.getElementById("currentlyLooking").checked = true;
          //     break;
          //   case "Not interested in looking for a job":
          //     document.getElementById("notInterested").checked = true;
          //     break;
          //   case "Still Studying":
          //     document.getElementById("stillStudying").checked = true;
          //     break;
          //   default:
          //     break;
          // }

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
            document.getElementById("kkAssemblyYes").checked = true;
            $("#ifYes").show();
            $("#ifNo").hide();

            let kk_assembly_times = data.kk_assembly_times;
            switch (kk_assembly_times) {
              case "1-2":
                document.getElementById("times1to2").checked = true;
                break;
              case "3-4":
                document.getElementById("times3to4").checked = true;
                break;
              case "5 and above":
                document.getElementById("times5plus").checked = true;
                break;
              default:
                break;
            }
          } else {
            document.getElementById("kkAssemblyNo").checked = true;
            $("#ifYes").hide();
            $("#ifNo").show();

            let kk_assembly_why = data.kk_assembly_why;
            switch (kk_assembly_why) {
              case "There was no KK Assembly Meeting":
                document.getElementById("NoAssembly").checked = true;
                break;
              case "Not interested to attend":
                document.getElementById("NotInterested").checked = true;
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
          new bootstrap.Modal(document.getElementById("viewYouthModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const youthId = button.getAttribute("data-id");

      fetch(`get_youth_details.php?id=${youthId}`)
        .then((response) => response.json())
        .then((data) => {
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
          // switch (data.educational_background;) {
          //   case "Elementary Level":
          //     document.getElementById("elementaryLevel").checked = true;
          //     break;
          //   case "Elementary Graduate":
          //     document.getElementById("elementaryGraduate").checked = true;
          //     break;
          //   case "High School Level":
          //     document.getElementById("highSchoolLevel").checked = true;
          //     break;
          //   case "High School Graduate":
          //     document.getElementById("highSchoolGraduate").checked = true;
          //     break;
          //   case "Vocational Graduate":
          //     document.getElementById("vocationalGraduate").checked = true;
          //     break;
          //   case "College Level":
          //     document.getElementById("collegeLevel").checked = true;
          //     break;
          //   case "College Graduate":
          //     document.getElementById("collegeGraduate").checked = true;
          //     break;
          //   case "Master Level":
          //     document.getElementById("masterLevel").checked = true;
          //     break;
          //   case "Master Graduate":
          //     document.getElementById("masterGraduate").checked = true;
          //     break;
          //   case "Doctorate Level":
          //     document.getElementById("doctorateLevel").checked = true;
          //     break;
          //   case "Doctorate Graduate":
          //     document.getElementById("doctorateGraduate").checked = true;
          //     break;
          //   default:
          //     break;
          // }

          document.getElementById("viewWorkStatus").value = data.work_status;

          // let work_status = data.work_status;
          // switch (work_status) {
          //   case "Employed":
          //     document.getElementById("employed").checked = true;
          //     break;
          //   case "Self-Employed":
          //     document.getElementById("selfEmployed").checked = true;
          //     break;
          //   case "Unemployed":
          //     document.getElementById("unemployed").checked = true;
          //     break;
          //   case "Currently looking for a job":
          //     document.getElementById("currentlyLooking").checked = true;
          //     break;
          //   case "Not interested in looking for a job":
          //     document.getElementById("notInterested").checked = true;
          //     break;
          //   case "Still Studying":
          //     document.getElementById("stillStudying").checked = true;
          //     break;
          //   default:
          //     break;
          // }

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
            document.getElementById("kkAssemblyYes").checked = true;
            $("#ifYes").show();
            $("#ifNo").hide();

            let kk_assembly_times = data.kk_assembly_times;
            switch (kk_assembly_times) {
              case "1-2":
                document.getElementById("times1to2").checked = true;
                break;
              case "3-4":
                document.getElementById("times3to4").checked = true;
                break;
              case "5 and above":
                document.getElementById("times5plus").checked = true;
                break;
              default:
                break;
            }
          } else {
            document.getElementById("kkAssemblyNo").checked = true;
            $("#ifYes").hide();
            $("#ifNo").show();

            let kk_assembly_why = data.kk_assembly_why;
            switch (kk_assembly_why) {
              case "There was no KK Assembly Meeting":
                document.getElementById("NoAssembly").checked = true;
                break;
              case "Not interested to attend":
                document.getElementById("NotInterested").checked = true;
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
          new bootstrap.Modal(document.getElementById("viewYouthModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
