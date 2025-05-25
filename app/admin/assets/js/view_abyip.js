document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const entryId = button.getAttribute("data-abyip-id");

      fetch(`get_abyip_details.php?id=${entryId}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          document.getElementById("viewReferenceCode").value =
            data.reference_code;
          document.getElementById("viewPPA").value = data.ppa;
          document.getElementById("viewDescription").value = data.description;
          document.getElementById("viewExpectedResult").value =
            data.expected_result;
          document.getElementById("viewPerformanceIndicator").value =
            data.performance_indicator;
          document.getElementById("viewPeriodImplementation").value =
            data.period_implementation;
          document.getElementById("viewMooe").value = data.mooe;
          document.getElementById("viewCo").value = data.co;
          document.getElementById("viewTotal").value = data.total;
          document.getElementById("viewPersonResponsible").value =
            data.person_responsible;
          document.getElementById("viewPreparedBy").value = data.prepared_by;
          document.getElementById("viewApprovedBy").value = data.approved_by;

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
          new bootstrap.Modal(document.getElementById("viewAbyipModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
