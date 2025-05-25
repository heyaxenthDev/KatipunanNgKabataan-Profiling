function printCbydpRow(rowData) {
  // Fill the printable card fields
  document.getElementById("printYearCBYDP").textContent =
    new Date().getFullYear();
  document.getElementById("printCenterCBYDP").textContent =
    rowData.programArea || "ENVIRONMENT";
  document.getElementById("printPreparedByCBYDP").textContent =
    rowData.prepared_by || "";
  document.getElementById("printApprovedByCBYDP").textContent =
    rowData.approved_by || "";

  // Table body
  let tbody = "";
  tbody += `<tr>
      <td>${rowData.programAreaLabel || ""}</td>
      <td>${rowData.objectiveDescription || ""}</td>
      <td>${rowData.performanceIndicator || ""}</td>
      <td>${rowData.target || ""}</td>
      <td>${rowData.ppa || ""}</td>
      <td style='text-align:right;'>${
        parseFloat(rowData.mooeAllocated).toLocaleString(undefined, {
          minimumFractionDigits: 2,
        }) || ""
      }</td>
      <td>${
        rowData.person_responsible || "SK Barangay Council; KK Members"
      }</td>
    </tr>`;
  document.getElementById("printTableBodyCBYDP").innerHTML = tbody;

  // Print
  let printContents = document.getElementById("printableCardCBYDP").innerHTML;
  let printWindow = window.open("", "", "width=900,height=600");
  printWindow.document.write(
    "<html><head><title>Print CBYDP</title></head><body>" +
      printContents +
      "</body></html>"
  );
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
}

// Attach to print buttons
document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelectorAll(".btn.btn-secondary.btn-sm")
    .forEach(function (btn) {
      btn.addEventListener("click", function (e) {
        const row = btn.closest("tr");
        const cells = row.querySelectorAll("td");
        // You may want to fetch the full data from the server if not all fields are in the table
        // For now, we use the visible table data
        printCbydpRow({
          programArea: cells[0] ? cells[0].textContent.trim() : "",
          programAreaLabel: cells[0] ? cells[0].textContent.trim() : "",
          referenceCode: cells[1] ? cells[1].textContent.trim() : "",
          ppa: cells[2] ? cells[2].textContent.trim() : "",
          mooeAllocated: cells[3]
            ? cells[3].textContent.replace(/,/g, "")
            : "0",
          mooeSpent: cells[4] ? cells[4].textContent.replace(/,/g, "") : "0",
          objectiveDescription: cells[2] ? cells[2].textContent.trim() : "",
          performanceIndicator: cells[2] ? cells[2].textContent.trim() : "",
          target: "", // You can add logic to fetch target if available
          person_responsible: "SK Barangay Council; KK Members",
          prepared_by: "", // Optionally fetch from modal or DB
          approved_by: "", // Optionally fetch from modal or DB
        });
      });
    });
});
