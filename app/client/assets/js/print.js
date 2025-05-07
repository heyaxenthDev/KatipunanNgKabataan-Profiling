function printModal() {
  // Clone the modal body content
  const modalContent = document
    .querySelector("#viewYouthModal .modal-body")
    .cloneNode(true);

  // Convert input and textarea fields to plain text or retain their values
  modalContent.querySelectorAll("input, textarea").forEach((el) => {
    const keepEditable = [
      "modalComplaints",
      "modalReferredTo",
      "modalReferralPurpose",
    ];

    if (!keepEditable.includes(el.id)) {
      const textValue = document.createElement("p");
      textValue.textContent = el.value || "-";
      textValue.className = "print-value"; // Optional styling
      el.replaceWith(textValue);
    } else {
      el.setAttribute("value", el.value); // Retain value for inputs
      el.textContent = el.value; // Retain value for textareas
    }
  });

  // Create a print window
  const printWindow = window.open("", "", "width=900,height=600");

  printWindow.document.write(`
    <html>
      <head>
        <title>Referral Details</title>
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" />
        <style>
          @media print {
            @page {
              margin: 0;
            }
            body * {
              visibility: hidden;
              margin: 0;
            }
            header, footer, .buttons {
              display: none;
            }
            #printableCard, #printableCard * {
              visibility: visible;
              box-shadow: none;
            }
            #printableCard {
              position: absolute;
              top: 0;
              left: 0;
              padding: 20px;
              font-size: 12px;
              height: auto;
            }
            .text-header h5 {
              font-size: 14px;
            }
            .sebaste-logo img {
              max-width: 85px;
            }
            .img-prev .division {
              margin: 0;
              padding-right: 60px;
            }
            .img-prev img {
              margin-top: 10px;
              max-width: 120px;
            }
            .col-md-4 {
              width: 33.3333%;
              float: left;
            }
            .col-md-3 {
              width: 25%;
              float: left;
            }
          }
        </style>
      </head>
      <body>
        <div class="container-fluid mb-2">
          <div class="row align-items-center p-2">
            <!-- Logo Section -->
            <div class="col-4 text-center text-md-start sebaste-logo">
              <img class="img-fluid" src="assets/img/sebaste-logo-1x1.png" alt="Sebaste Logo">
            </div>

            <!-- Header Text Section -->
            <div class="col-4 text-center text-header">
              <h5>Republic of the Philippines</h5>
              <h5>Province of Antique</h5>
              <h5 class="fw-bold">MUNICIPALITY OF SEBASTE</h5>
            </div>

            <!-- Profile Picture -->
            <div class="col-4 text-center text-md-end img-prev">
              <div class="division">
                <img src="assets/img/user-profile.png" id="viewPicture" 
                  class="img-fluid rounded img-thumbnail" alt="User Image">
              </div>
            </div>
          </div>
        </div>
        <div id="printableCard">
          ${modalContent.innerHTML}
        </div>
      </body>
    </html>
  `);

  printWindow.document.close();
  printWindow.focus();

  // Delay print to ensure rendering
  setTimeout(() => {
    printWindow.print();
    printWindow.close();
  }, 500);
}
