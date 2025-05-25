document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".edit-details").forEach((button) => {
    button.addEventListener("click", () => {
      const entryId = button.getAttribute("data-abyip-edit-id");

      fetch(`get_abyip_details.php?id=${entryId}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          document.getElementById("editId").value = data.id;
          document.getElementById("editReferenceCode").value =
            data.reference_code;
          document.getElementById("editPPA").value = data.ppa;
          document.getElementById("editDescription").value = data.description;
          document.getElementById("editExpectedResult").value =
            data.expected_result;
          document.getElementById("editPerformanceIndicator").value =
            data.performance_indicator;
          document.getElementById("editPeriodImplementation").value =
            data.period_implementation;
          document.getElementById("editMooe").value = data.mooe;
          document.getElementById("editCo").value = data.co;
          document.getElementById("editTotal").value = data.total;
          document.getElementById("editPersonResponsible").value =
            data.person_responsible;
          document.getElementById("editPreparedBy").value = data.prepared_by;
          document.getElementById("editApprovedBy").value = data.approved_by;

          //Show the modal
          new bootstrap.Modal(document.getElementById("editAbyipModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
