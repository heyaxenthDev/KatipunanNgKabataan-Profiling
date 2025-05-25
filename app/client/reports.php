<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


    $brgyCode = $_GET['Code'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM `barangay` WHERE barangay_code = ?");
    $stmt->bind_param("s", $brgyCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $getBrgy = $result->fetch_assoc();
    $brgyName = $getBrgy['barangay_name'];

    // Fetch notifications for the logged-in user
    $notif_query = "SELECT * FROM notifications WHERE user_id = '$id' ORDER BY created_at DESC LIMIT 10";
    $notif_result = mysqli_query($conn, $notif_query);
    $notifications = [];
    $unread_count = 0;
    if ($notif_result && mysqli_num_rows($notif_result) > 0) {
        while ($notif = mysqli_fetch_assoc($notif_result)) {
            $notifications[] = $notif;
            if ($notif['status'] == 'unread') $unread_count++;
        }
    }
    ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reports Generation</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Select the type of data you want to generate</h4>

                <form id="reportForm" class="needs-validation" novalidate>
                    <div class="d-flex justify-content-between gap-3">
                        <!-- Select for type of data -->
                        <div class="flex-grow-1">
                            <label for="type" class="form-label">Report Type</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="registered">Registered Youth</option>
                                <option value="unregistered">Unregistered Youth</option>
                                <option value="activities_program">Activities Program</option>
                            </select>
                            <div class="invalid-feedback">Please select a report type.</div>
                        </div>

                        <!-- Select for Category -->
                        <div class="flex-grow-1">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                                <option value="indigenous_people">Indigenous People</option>
                                <option value="pwd">PWD</option>
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        <!-- Select for purok/street -->
                        <div class="flex-grow-1">
                            <label for="purok" class="form-label">Purok/Street</label>
                            <select name="purok" id="purok" class="form-select" required>
                                <option value="">Select Purok/Street</option>
                                <?php
                                    $brgyCode = $_GET['Code'] ?? '';
                                    // Get the list of available purok/street from the database
                                    $stmt = $conn->prepare("SELECT DISTINCT street FROM registered WHERE brgyCode = ?");
                                    $stmt->bind_param("s", $brgyCode);
                                    $stmt->execute();
                                    $getStreet = $stmt->get_result();

                                    if ($getStreet->num_rows > 0) {
                                        while ($row = $getStreet->fetch_assoc()){
                                            echo '<option value="' . htmlspecialchars($row['street']) . '">' . htmlspecialchars($row['street']) . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select a purok/street.</div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary" id="generateBtn">Generate Report</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div id="report-table" class="mt-4"></div>
    <button id="print-btn" class="btn btn-primary mt-3" style="display:none;">Print Report</button>

</main><!-- End #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reportForm');
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');
    const purokSelect = document.getElementById('purok');
    const generateBtn = document.getElementById('generateBtn');
    const reportTable = document.getElementById('report-table');
    const printBtn = document.getElementById('print-btn');

    const brgyCode = <?php echo json_encode($_GET['Code'] ?? ''); ?>;
    const brgyName = <?php echo json_encode($brgyName ?? ''); ?>;

    const getTableHeaders = (type) => {
        const headers = {
            registered: ['Name', 'Age', 'Gender', 'Status', 'Address', 'Employment'],
            unregistered: ['Name', 'Age', 'Gender', 'Status', 'Address', 'Employment'],
            activities_program: ['Program Name', 'Participants', 'Date', 'Status']
        };
        return headers[type] || [];
    };

    const keyMapping = {
        'Name': 'name',
        'Age': 'age',
        'Gender': 'gender',
        'Status': 'status',
        'Address': 'address',
        'Employment': 'employment',
        'Program Name': 'program_name',
        'Participants': 'participants',
        'Date': 'date',
        'Status': 'status'
    };

    const generateTable = (data, type) => {
        const headers = getTableHeaders(type);
        let tableHTML = `
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>
                    </thead>
                    <tbody>
        `;

        data.forEach(row => {
            tableHTML += '<tr>';
            headers.forEach(header => {
                let key = keyMapping[header];
                let value = row[key] ?? '';

                if (header === 'Gender') {
                    value = row.gender == '1' ? 'Female' : 'Male';
                }

                tableHTML += `<td>${value}</td>`;
            });
            tableHTML += '</tr>';
        });

        tableHTML += '</tbody></table></div>';
        return tableHTML;
    };

    const validateForm = () => {
        if (typeSelect.value === 'activities_program') {
            if (!typeSelect.value) {
                typeSelect.classList.add('is-invalid');
                return false;
            } else {
                typeSelect.classList.remove('is-invalid');
            }
            return true;
        } else {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return false;
            }
            return true;
        }
    };

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateForm()) return;

        const formData = new FormData();
        formData.append('type', typeSelect.value);
        formData.append('brgyCode', brgyCode);
        formData.append('brgyName', brgyName);

        if (typeSelect.value !== 'activities_program') {
            formData.append('category', categorySelect.value);
            formData.append('purok', purokSelect.value);
        }

        generateBtn.disabled = true;
        generateBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status"></span> Generating...';

        fetch('get_report_data.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    reportTable.innerHTML = generateTable(data.data, typeSelect.value);
                    printBtn.style.display = 'inline-block';
                } else {
                    Swal.fire('Error', data.message || 'Failed to generate report', 'error');
                    reportTable.innerHTML = '';
                    printBtn.style.display = 'none';
                }
            })
            .catch(err => {
                console.error('Fetch Error:', err);
                Swal.fire('Error', 'An error occurred while generating the report', 'error');
            })
            .finally(() => {
                generateBtn.disabled = false;
                generateBtn.innerHTML = 'Generate Report';
            });
    });

    printBtn.addEventListener('click', () => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Report - ${typeSelect.options[typeSelect.selectedIndex].text} of Barangay ${brgyName}</title>
                    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                    <style>
                        body { padding: 20px; font-family: Arial, sans-serif; }
                        .table th, .table td { border: 1px solid #000 !important; padding: 8px; }
                        .table { width: 100%; border-collapse: collapse; }
                        h2 { text-align: center; margin-bottom: 20px; }
                        @media print {
                            .table-responsive { overflow: visible !important; }
                        }
                    </style>
                </head>
                <body>
                    <h2>${typeSelect.options[typeSelect.selectedIndex].text} Report of Barangay ${brgyName}</h2>
                    ${categorySelect.parentElement.style.display !== 'none' ? `<p>Category: ${categorySelect.options[categorySelect.selectedIndex].text}</p>` : ''}
                    ${purokSelect.parentElement.style.display !== 'none' ? `<p>Purok/Street: ${purokSelect.options[purokSelect.selectedIndex].text}</p>` : ''}
                    <div>${reportTable.innerHTML}</div>
                    <p>Generated on: ${new Date().toLocaleString()}</p>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

    form.addEventListener('reset', () => {
        form.classList.remove('was-validated');
        reportTable.innerHTML = '';
        printBtn.style.display = 'none';
    });

    typeSelect.addEventListener('change', () => {
        const isActivity = typeSelect.value === 'activities_program';
        categorySelect.parentElement.style.display = isActivity ? 'none' : '';
        purokSelect.parentElement.style.display = isActivity ? 'none' : '';
        categorySelect.required = !isActivity;
        purokSelect.required = !isActivity;
    });

    // Trigger change on load
    typeSelect.dispatchEvent(new Event('change'));
});
</script>


<?php 
include "includes/footer.php";
?>