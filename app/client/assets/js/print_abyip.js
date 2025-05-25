function printAbyipRow(rowData) {
  // Fill the printable card fields
  document.getElementById("printYear").textContent = new Date().getFullYear();
  document.getElementById("printCenter").textContent = "ENVIRONMENT";
  document.getElementById("printPreparedBy").textContent =
    rowData.prepared_by || "";
  document.getElementById("printApprovedBy").textContent =
    rowData.approved_by || "";

  // Table body
  let tbody = "";
  let total = 0;
  tbody += `<tr>
        <td>${rowData.reference_code || ""}</td>
        <td>${rowData.ppa || ""}</td>
        <td>${rowData.description || ""}</td>
        <td>${rowData.expected_result || ""}</td>
        <td>${rowData.performance_indicator || ""}</td>
        <td>${rowData.period_implementation || ""}</td>
        <td style='text-align:right;'>${
          parseFloat(rowData.mooe).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          }) || ""
        }</td>
        <td style='text-align:right;'>${
          parseFloat(rowData.co).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          }) || ""
        }</td>
        <td style='text-align:right;'>${
          parseFloat(rowData.total).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          }) || ""
        }</td>
        <td>${rowData.person_responsible || ""}</td>
    </tr>`;
  total += parseFloat(rowData.total) || 0;
  document.getElementById("printTableBody").innerHTML = tbody;
  document.getElementById("printTotal").textContent = total.toLocaleString(
    undefined,
    { minimumFractionDigits: 2 }
  );

  // Print
  let printContents = document.getElementById("printableCard").innerHTML;
  let printWindow = window.open("", "", "width=900,height=600");
  printWindow.document.write(
    "<html><head><title>Print ABYIP</title></head><body>" +
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
        printAbyipRow({
          reference_code: cells[1].textContent.trim(),
          ppa: cells[2].textContent.trim(),
          description: cells[3].textContent.trim(),
          expected_result: cells[4].textContent.trim(),
          performance_indicator: cells[5].textContent.trim(),
          period_implementation: cells[6].textContent.trim(),
          mooe: cells[7] ? cells[7].textContent.replace(/,/g, "") : "0",
          co: cells[8] ? cells[8].textContent.replace(/,/g, "") : "0",
          total: cells[9] ? cells[9].textContent.replace(/,/g, "") : "0",
          person_responsible: cells[10] ? cells[10].textContent.trim() : "",
          prepared_by: "", // Optionally fetch from modal or DB
          approved_by: "", // Optionally fetch from modal or DB
        });
      });
    });
});
