// Make this function globally available
function autoSelectSuggestedProgramAndType(dominant) {
  let program = "";
  let type = "";
  // Example mapping logic
  if (dominant.classification === "In School") {
    program = "EDUCATION";
    type = "LIBRARY HUB";
  } else if (dominant.classification === "Out of School Youth") {
    program = "EDUCATION";
    type = "FREE PRINTING";
  } else if (dominant.classification === "Working Youth") {
    program = "EDUCATION";
    type = "DISTRIBUTION OF SCHOOL SUPPLIES";
  } else if (dominant.classification === "Person with Disability") {
    program = "HEALTH ENVIRONMENT";
    type = "HEALTH ENVIRONMENT";
  } else if (dominant.classification === "Children in conflict with Law") {
    program = "SPORTS";
    type = "TOURNAMENT PLAYING MOBILE LEGEND";
  } else if (dominant.classification === "Indigenous People") {
    program = "TREE PLANTING";
    type = "TREE PLANTING";
  }
  // Gender/Age-based sports suggestion
  if (
    dominant.gender === "Male" &&
    ["15-20", "21-25", "26-30"].includes(dominant.age)
  ) {
    program = "SPORTS";
    type = "BASKETBALL";
  } else if (
    dominant.gender === "Female" &&
    ["15-20", "21-25", "26-30"].includes(dominant.age)
  ) {
    program = "SPORTS";
    type = "VOLLEYBALL";
  }
  // Set the dropdowns
  const suggestedProgram = document.getElementById("suggestedProgram");
  const types = document.getElementById("types");
  if (suggestedProgram && types) {
    suggestedProgram.value = program;
    // Trigger change to populate types
    suggestedProgram.dispatchEvent(new Event("change"));
    // Wait a tick for types to populate, then set type
    setTimeout(() => {
      types.value = type;
    }, 50);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Function to update suggested program based on selections
  function updateSuggestedProgram() {
    // Get the select elements
    const youthClassSelect = document.getElementById("youthClassification");
    const genderSelect = document.getElementById("dominantGender");
    const ageSelect = document.getElementById("ageCategory");

    // Check if elements exist before accessing their values
    if (!youthClassSelect || !genderSelect || !ageSelect) {
      console.error("Required form elements not found");
      return;
    }

    let youthClass = youthClassSelect.value;
    let gender = genderSelect.value;
    let age = ageSelect.value;
    let suggestedProgram = "";

    // Decision Logic
    if (youthClass === "In School") {
      suggestedProgram =
        "Library Hub, School Supplies Distribution, Tutorial Programs";
    } else if (youthClass === "Out of School Youth") {
      suggestedProgram =
        "Alternative Learning System (ALS), Vocational Training, Job Assistance";
    } else if (youthClass === "Working Youth") {
      suggestedProgram =
        "Job Fairs, Skills Training, Entrepreneurship Workshops";
    } else if (youthClass === "Youth with Special Needs") {
      suggestedProgram = "Inclusive Education, Disability Support Programs";
    } else if (youthClass === "Person with Disability") {
      suggestedProgram = "PWD Support Programs, Skills Development";
    } else if (youthClass === "Children in conflict with Law") {
      suggestedProgram = "Rehabilitation Programs, Legal Assistance";
    } else if (youthClass === "Indigenous People") {
      suggestedProgram =
        "Cultural Preservation Programs, Livelihood Assistance";
    }

    // Additional logic based on gender and age
    if (
      gender === "Male" &&
      (age === "15-20" || age === "21-25" || age === "26-30")
    ) {
      suggestedProgram += ", Basketball Tournament (Sports)";
    } else if (
      gender === "Female" &&
      (age === "15-20" || age === "21-25" || age === "26-30")
    ) {
      suggestedProgram += ", Volleyball Tournament (Sports)";
    }

    // Update the suggested program field
    const suggestedProgramField = document.getElementById("suggestedProgram");
    if (suggestedProgramField) {
      suggestedProgramField.value = suggestedProgram;
    }
  }

  // Add event listeners only if elements exist
  const youthClassSelect = document.getElementById("youthClassification");
  const genderSelect = document.getElementById("dominantGender");
  const ageSelect = document.getElementById("ageCategory");

  if (youthClassSelect) {
    youthClassSelect.addEventListener("change", updateSuggestedProgram);
  }
  if (genderSelect) {
    genderSelect.addEventListener("change", updateSuggestedProgram);
  }
  if (ageSelect) {
    ageSelect.addEventListener("change", updateSuggestedProgram);
  }

  // Initial call to set suggested program
  updateSuggestedProgram();
});
