<?php 
include 'authentication.php';
checkLogin();
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
?>


<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center  mb-3">
        <h1>Comprehensive Barangay Youth Development Plan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#NewEntryModal"><i
                class="bi bi-plus-circle"></i> New Entry</button>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card pt-3">
                    <div class="card-body">
                        <!-- Comprehensive Barangay Youth Development Plan -->
                        <?php
                        if (isset($_GET['Code'])) {
                            $code = $_GET['Code'];
                            $stmt = $conn->prepare("SELECT * FROM cbydp WHERE brgyCode = ?");
                            $stmt->bind_param("s", $code);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        ?>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>PYDP Center</th>
                                    <th>Reference Code</th>
                                    <th>PPAS</th>
                                    <th>MOOE Allocated</th>
                                    <th>MOOE Spent</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        switch ($row['programArea']) {
                                            case 'governance':
                                                $programArea = "Governance";
                                                break;
                                            case 'active_citizenship':
                                                $programArea = "Active Citizenship";
                                                break;
                                            case 'environment':
                                                $programArea = "Environment";
                                                break;
                                            case 'global_mobility':
                                                $programArea = "Global Mobility";
                                                break;
                                            case 'health':
                                                $programArea = "Health";
                                                break;
                                            case 'education':
                                                $programArea = "Education";
                                                break;
                                            case 'economic_empowerment':
                                                $programArea = "Economic Empowerment";
                                                break;
                                            case 'social_inclusion':
                                                $programArea = "Social Inclusion and Equity";
                                                break;
                                            case 'peace_building':
                                                $programArea = "Peace Building and Security";
                                                break;
                                            case 'agriculture':
                                                $programArea = "Agriculture";
                                                break;
                                            default:
                                                $programArea = "Unknown Program Area";
                                                break;
                                        }

                                        // Status badge
                                        $statusBadge = '';
                                        switch ($row['status']) {
                                            case 'pending':
                                                $statusBadge = '<span class="badge bg-warning">Pending</span>';
                                                break;
                                            case 'approved':
                                                $statusBadge = '<span class="badge bg-success">Approved</span>';
                                                break;
                                            case 'rejected':
                                                $statusBadge = '<span class="badge bg-danger">Rejected</span>';
                                                break;
                                            default:
                                                $statusBadge = '<span class="badge bg-secondary">Not Set</span>';
                                        }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($programArea) ?></td>
                                    <td><?= htmlspecialchars($row['referenceCode']) ?></td>
                                    <td><?= htmlspecialchars($row['ppa']) ?></td>
                                    <td><?= htmlspecialchars($row['mooeAllocated']) ?></td>
                                    <td><?= htmlspecialchars($row['mooeSpent']) ?></td>
                                    <td><?= $statusBadge ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success btn-sm view-details"
                                                data-id="<?= $row['id'] ?>">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <?php if ($row['status'] !== 'approved' && $row['status'] !== 'rejected'): ?>
                                            <button class="btn btn-primary btn-sm edit-details"
                                                data-edit-id="<?= $row['id'] ?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <?php endif; ?>
                                            <button class="btn btn-secondary btn-sm"
                                                onclick="printForm('printableCard')" type="button"><i
                                                    class="bi bi-printer"></i> Print</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                            $stmt->close();
                        } else {
                            echo "<p class='text-warning'>No code specified in the URL.</p>";
                        }
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="NewEntryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">New Entry for CBYDP</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="cbydp_add.php" method="POST" enctype="multipart/form-data">

                            <h6>Report Information:</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="brgyCode" id="brgyCode" value="<?= $brgyCode?>">
                                        <input class="form-control" id="brgyName" name="brgyName"
                                            placeholder="Barangay Name" value="<?= $brgyName?>" type="text" readonly>
                                        <label for="brgyName">Barangay Name</label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="programArea" name="programArea"
                                            aria-label="Program Area Select">
                                            <option selected disabled>Select PYDP</option>
                                            <option value="governance">Governance</option>
                                            <option value="active_citizenship">Active Citizenship</option>
                                            <option value="environment">Environment</option>
                                            <option value="global_mobility">Global Mobility</option>
                                            <option value="health">Health</option>
                                            <option value="education">Education</option>
                                            <option value="economic_empowerment">Economic Empowerment</option>
                                            <option value="social_inclusion">Social Inclusion and Equity</option>
                                            <option value="peace_building">Peace Building and Security</option>
                                            <option value="agriculture">Agriculture</option>
                                        </select>
                                        <label for="programArea">SELECT PYDP</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="referenceCode" name="referenceCode"
                                            placeholder="Reference Code" type="text">
                                        <label for="referenceCode">Reference Code</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ppa" name="ppa"
                                            placeholder="Programs/Projects/Activities (PPA)" type="text">
                                        <label for="ppa">Programs/Projects/Activities (PPA)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="objectiveDescription"
                                            name="objectiveDescription" placeholder="Objective Description" type="text">
                                        <label for="objectiveDescription">Objective Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="expectedResult" name="expectedResult"
                                            placeholder="Expected Result" type="text">
                                        <label for="expectedResult">Expected Result</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="performanceIndicator"
                                            name="performanceIndicator" placeholder="Performance Indicator" type="text">
                                        <label for="performanceIndicator">Performance Indicator</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="implementationPeriod"
                                            name="implementationPeriod" placeholder="Period of Implementation"
                                            type="text">
                                        <label for="implementationPeriod">Period of Implementation</label>
                                    </div>
                                </div>
                            </div>

                            <h6>Budget:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="mooeAllocated" name="mooeAllocated"
                                            placeholder="MOOE Allocated" type="text">
                                        <label for="mooeAllocated">MOOE Allocated</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="mooeSpent" name="mooeSpent"
                                            placeholder="MOOE Spent" type="text">
                                        <label for="mooeSpent">MOOE Spent</label>
                                    </div>
                                </div>
                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="newCbydp" class="btn btn-primary">Sumbit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- View Entry Modal -->
        <div class="modal fade" id="ViewEntryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewEntryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewEntryModalLabel">View CBYDP Entry</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Report Information:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewBrgyName" placeholder="Barangay Name"
                                        type="text" readonly>
                                    <label for="viewBrgyName">Barangay Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewProgramArea" placeholder="Program Area"
                                        type="text" readonly>
                                    <label for="viewProgramArea">Program Area</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewReferenceCode" placeholder="Reference Code"
                                        type="text" readonly>
                                    <label for="viewReferenceCode">Reference Code</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewPPA"
                                        placeholder="Programs/Projects/Activities (PPA)" type="text" readonly>
                                    <label for="viewPPA">Programs/Projects/Activities (PPA)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewObjectiveDescription"
                                        placeholder="Objective Description" type="text" readonly>
                                    <label for="viewObjectiveDescription">Objective Description</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewExpectedResult" placeholder="Expected Result"
                                        type="text" readonly>
                                    <label for="viewExpectedResult">Expected Result</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewPerformanceIndicator"
                                        placeholder="Performance Indicator" type="text" readonly>
                                    <label for="viewPerformanceIndicator">Performance Indicator</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewImplementationPeriod"
                                        placeholder="Period of Implementation" type="text" readonly>
                                    <label for="viewImplementationPeriod">Period of Implementation</label>
                                </div>
                            </div>
                        </div>
                        <h6>Budget:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewMooeAllocated" placeholder="MOOE Allocated"
                                        type="text" readonly>
                                    <label for="viewMooeAllocated">MOOE Allocated</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewMooeSpent" placeholder="MOOE Spent" type="text"
                                        readonly>
                                    <label for="viewMooeSpent">MOOE Spent</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="viewStatus" placeholder="Status" type="text"
                                        readonly>
                                    <label for="viewStatus">Status</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="viewRemarks" placeholder="Remarks"
                                        style="height: 100px" readonly></textarea>
                                    <label for="viewRemarks">Remarks</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/view_cbydp.js"></script>

        <!-- Edit Entry Modal -->
        <div class="modal fade" id="EditEntryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editEntryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editEntryModalLabel">Edit CBYDP Entry</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="update_cbydp.php" method="POST">
                        <div class="modal-body">
                            <h6>Report Information:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="hidden" name="id" id="editId">
                                        <input class="form-control" id="editBrgyName" name="brgyName"
                                            placeholder="Barangay Name" type="text" readonly>
                                        <label for="editBrgyName">Barangay Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="editProgramArea" name="programArea"
                                            aria-label="Program Area Select">
                                            <option selected disabled>Select PYDP</option>
                                            <option value="governance">Governance</option>
                                            <option value="active_citizenship">Active Citizenship</option>
                                            <option value="environment">Environment</option>
                                            <option value="global_mobility">Global Mobility</option>
                                            <option value="health">Health</option>
                                            <option value="education">Education</option>
                                            <option value="economic_empowerment">Economic Empowerment</option>
                                            <option value="social_inclusion">Social Inclusion and Equity</option>
                                            <option value="peace_building">Peace Building and Security</option>
                                            <option value="agriculture">Agriculture</option>
                                        </select>
                                        <label for="programArea">SELECT PYDP</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editReferenceCode" name="referenceCode"
                                            placeholder="Reference Code" type="text">
                                        <label for="editReferenceCode">Reference Code</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editPPA" name="ppa"
                                            placeholder="Programs/Projects/Activities (PPA)" type="text">
                                        <label for="editPPA">Programs/Projects/Activities (PPA)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editObjectiveDescription"
                                            name="objectiveDescription" placeholder="Objective Description" type="text">
                                        <label for="editObjectiveDescription">Objective Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editExpectedResult" name="expectedResult"
                                            placeholder="Expected Result" type="text">
                                        <label for="editExpectedResult">Expected Result</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editPerformanceIndicator"
                                            name="performanceIndicator" placeholder="Performance Indicator" type="text">
                                        <label for="editPerformanceIndicator">Performance Indicator</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editImplementationPeriod"
                                            name="implementationPeriod" placeholder="Period of Implementation"
                                            type="text">
                                        <label for="editImplementationPeriod">Period of Implementation</label>
                                    </div>
                                </div>
                            </div>
                            <h6>Budget:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editMooeAllocated" name="mooeAllocated"
                                            placeholder="MOOE Allocated" type="text">
                                        <label for="editMooeAllocated">MOOE Allocated</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="editMooeSpent" name="mooeSpent"
                                            placeholder="MOOE Spent" type="text">
                                        <label for="editMooeSpent">MOOE Spent</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="editCbydp" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="assets/js/edit_cbydp.js"></script>

    </section>

    <!-- Hidden Printable Card for CBYDP -->
    <div id="printableCardCBYDP" style="display:none;">
        <div style="font-family: Arial, sans-serif; width: 100%;">
            <div style="text-align:center; font-weight:bold; font-size:18px; margin-bottom:10px;">ANNEX 5 |
                COMPREHENSIVE BARANGAY YOUTH DEVELOPMENT PLAN (CBYDP)</div>
            <div style="font-size:14px; margin-bottom:5px;">Region: VI-Western Visayas &nbsp;&nbsp; Province: ANTIQUE
                &nbsp;&nbsp; City/Municipality: SEBASTE</div>
            <div style="text-align:center; font-weight:bold; font-size:16px; margin-bottom:10px;">AMENDED COMPREHENSIVE
                BARANGAY YOUTH DEVELOPMENT PLAN (CBYDP) CY <span id="printYearCBYDP"></span></div>
            <div style="text-align:center; font-weight:bold; font-size:15px; margin-bottom:10px;">CENTER OF
                PARTICIPATION: <span id="printCenterCBYDP"></span></div>
            <table border="1" cellspacing="0" cellpadding="4"
                style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead style="background:#eee;">
                    <tr>
                        <th>Youth Development Concern</th>
                        <th>Object</th>
                        <th>Perf. Indicator</th>
                        <th>Target</th>
                        <th>PPAs</th>
                        <th>Budget</th>
                        <th>Person Responsible</th>
                    </tr>
                </thead>
                <tbody id="printTableBodyCBYDP"></tbody>
            </table>
            <div style="margin-top:30px; display:flex; justify-content:space-between;">
                <div>
                    <div>Prepared by:</div>
                    <div style="margin-top:30px; text-decoration:underline; font-weight:bold;"
                        id="printPreparedByCBYDP"></div>
                    <div style="font-size:12px;">SK SECRETARY</div>
                </div>
                <div style="text-align:right;">
                    <div>Approved by:</div>
                    <div style="margin-top:30px; text-decoration:underline; font-weight:bold;"
                        id="printApprovedByCBYDP"></div>
                    <div style="font-size:12px;">SK CHAIRMAN</div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/print_cbydp.js"></script>

</main><!-- End #main -->

<?php include "includes/footer.php"; ?>