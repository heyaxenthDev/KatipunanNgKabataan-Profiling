document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      const entryId = button.getAttribute("data-id");

      fetch(`get_cbydp_details.php?id=${entryId}`)
        .then((response) => response.json())
        .then((data) => {
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
            data.performaceIndicator;
          document.getElementById("viewImplementationPeriod").value =
            data.implementationPeriod;
          document.getElementById("viewMooeAllocated").value =
            data.mooeAllocated;
          document.getElementById("viewMooeSpent").value = data.mooeSpent;

          //Show the modal
          var myModal = new bootstrap.Modal(
            document.getElementById("ViewEntryModal")
          );
          myModal.show();
        })
        .catch((error) =>
          console.error("Error fetching youth details:", error)
        );
    });
  });
});
