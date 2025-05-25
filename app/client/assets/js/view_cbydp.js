document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const entryId = button.getAttribute("data-id");

      fetch(`get_cbydp_details.php?id=${entryId}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          document.getElementById("viewBrgyName").value = data.brgyName;
          document.getElementById("viewProgramArea").value = data.programArea;
          document.getElementById("viewReferenceCode").value =
            data.referenceCode;
          document.getElementById("viewPPA").value = data.ppa;
          document.getElementById("viewObjectiveDescription").value =
            data.objectiveDescription;
          document.getElementById("viewExpectedResult").value =
            data.expectedResult;
          document.getElementById("viewPerformanceIndicator").value =
            data.performanceIndicator;
          document.getElementById("viewImplementationPeriod").value =
            data.implementationPeriod;
          document.getElementById("viewMooeAllocated").value =
            data.mooeAllocated;
          document.getElementById("viewMooeSpent").value = data.mooeSpent;

          // Set status
          let statusText = "";
          switch (data.status) {
            case "pending":
              statusText = "Pending";
              break;
            case "approved":
              statusText = "Approved";
              break;
            case "rejected":
              statusText = "Rejected";
              break;
            default:
              statusText = "Not Set";
          }

          document.getElementById("viewStatus").value = statusText;

          // Set remarks
          document.getElementById("viewRemarks").value =
            data.remarks || "No remarks";

          // Show the modal
          new bootstrap.Modal(document.getElementById("ViewEntryModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
