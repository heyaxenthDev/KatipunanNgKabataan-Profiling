document.addEventListener("DOMContentLoaded", function () {
  function fetchReport() {
    const type = document.getElementById("type").value;
    const category = document.getElementById("category").value;
    const purok = document.getElementById("purok").value;
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get("Code");

    fetch(
      `fetch_report.php?type=${type}&category=${category}&purok=${purok}&Code=${code}`
    )
      .then((res) => res.text())
      .then((html) => {
        document.getElementById("report-table").innerHTML = html;
        // Show print button only if there is content
        if (html.trim() !== "" && html.includes("<table")) {
          document.getElementById("print-btn").style.display = "inline-block";
        } else {
          document.getElementById("print-btn").style.display = "none";
        }
      });
  }

  document.getElementById("type").addEventListener("change", fetchReport);
  document.getElementById("category").addEventListener("change", fetchReport);
  document.getElementById("purok").addEventListener("change", fetchReport);

  // Print button
  document.getElementById("print-btn").addEventListener("click", function () {
    const printContents = document.getElementById("report-table").innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload();
  });
});
