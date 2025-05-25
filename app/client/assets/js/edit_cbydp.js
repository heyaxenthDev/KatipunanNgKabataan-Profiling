document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".edit-details").forEach((button) => {
    button.addEventListener("click", () => {
      const entryId = button.getAttribute("data-edit-id");

      fetch(`get_cbydp_details.php?id=${entryId}`)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          document.getElementById("editId").value = data.id;
          document.getElementById("editBrgyName").value = data.brgyName;
          document.getElementById("editProgramArea").value = data.programArea;
          document.getElementById("editReferenceCode").value =
            data.referenceCode;
          document.getElementById("editPPA").value = data.ppa;
          document.getElementById("editObjectiveDescription").value =
            data.objectiveDescription;
          document.getElementById("editExpectedResult").value =
            data.expectedResult;
          document.getElementById("editPerformanceIndicator").value =
            data.performaceIndicator;
          document.getElementById("editImplementationPeriod").value =
            data.implementationPeriod;
          document.getElementById("editMooeAllocated").value =
            data.mooeAllocated;
          document.getElementById("editMooeSpent").value = data.mooeSpent;

          //Show the modal
          new bootstrap.Modal(document.getElementById("EditEntryModal")).show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
