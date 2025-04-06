function printModal() {
  var modalContent = document
    .querySelector("#viewYouthModal .modal-body")
    .cloneNode(true);

  // Copy values from input fields and textareas into the cloned modal
  modalContent.querySelectorAll("input, textarea").forEach((el) => {
    if (
      el.id !== "modalComplaints" &&
      el.id !== "modalReferredTo" &&
      el.id !== "modalReferralPurpose"
    ) {
      // Convert other input fields to plain text
      var textValue = document.createElement("p");
      textValue.textContent = el.value || "-"; // Fallback if empty
      textValue.className = "print-value"; // Optional styling
      el.replaceWith(textValue);
    } else {
      // Retain "Complaints", "Referred To", and "Purpose of Referral" fields
      el.setAttribute("value", el.value); // Ensure input value is retained
      el.textContent = el.value; // For textareas
    }
  });

  // Create a new print window
  var printWindow = window.open("", "", "width=900,height=600");

  printWindow.document.write(`
      <html>
      <head>
          <title>Referral Details</title>
          <link
          href="assets/vendor/bootstrap/css/bootstrap.min.css"
          rel="stylesheet"
          />
      
          <style>
          @media print {
              @page {
              margin: 25px;
              }
              body {
              margin: 0;
              }
              .no-print,
              .no-print * {
              display: none !important;
              }
              header,
              footer {
              display: none;
              }
              .modal-body {
              padding: 20px;
              }
              .col-md-3 {
              width: 25%;
              float: left;
              }
              .col-md-4 {
              width: 33.333333%;
              float: left;
              }
              .col-md-6 {
              width: 50%;
              float: left;
              }
              .text-center {
              width: 50%;
              float: left;
              }
              .col-md-8 {
              width: 66.666667%;
              float: left;
              }
              .mb-3 {
              margin-bottom: 2rem;
              }
              .mb-5 {
              margin-bottom: 3rem;
              }
              .form-label {
              display: block;
              margin-bottom: 0.3rem;
              }
              .container-fluid {
                margin-bottom: 20px;
              }
              .row.align-items-center {
                margin-bottom: 1rem;
              }
              .text-header h5 {
                margin: 0;
              }
              .sebaste-logo img, .img-prev img {
                width: 100px;
              }
              .division {
                margin-top: 10px;
              }
              .img-fluid {
                max-width: 100%;
                height: auto;
              }
              .img-thumbnail {
                border-radius: 50%;
              }
          }
          </style>
      </head>
      <body>
          <div class="container-fluid mb-2">
                  <div class="row align-items-center p-2">
                      <!-- Logo Section -->
                      <div class="col-4 text-center text-md-start sebaste-logo">
                          <img class="img-fluid " src="assets/img/sebaste-logo-1x1.png" alt="">
                      </div>
  
                      <!-- Text Section -->
                      <div class="col-4 text-center text-header">
                          <h5>Republic of the Philippines</h5>
                          <h5>Province of Antique</h5>
                          <h5 class="fw-bold">MUNICIPALITY OF SEBASTE</h5>
                      </div>
  
                      <!-- User Profile Section -->
                      <div class="col-4 text-center text-md-end img-prev">
                          <div class="division">
                              <img src="assets/img/user-profile.png" id="userImage"
                                  class="img-fluid rounded img-thumbnail" alt="User Image">
                          </div>
                      </div>
                  </div>
              </div>
              ${modalContent.innerHTML}
      </body>
      </html>
    `);

  printWindow.document.close();
  printWindow.focus();
  setTimeout(() => {
    printWindow.print();
    printWindow.close();
  }, 500);
}
