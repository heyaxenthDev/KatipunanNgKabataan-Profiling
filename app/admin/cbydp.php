<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>


<main id="main" class="main">
    <div class="pagetitle mb-3">
        <h1>Comprehensive Barangay Youth Development Plan</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card pt-3">
                    <div class="card-body">
                        <!-- Registered Youth -->
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM cbydp");
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
                                            <button class="btn btn-primary btn-sm approve-plan"
                                                data-id="<?= $row['id'] ?>">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm reject-plan"
                                                data-id="<?= $row['id'] ?>">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                            <?php endif; ?>
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
                        <h6>Status:</h6>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="viewStatus" placeholder="Status" type="text" readonly>
                            <label for="viewStatus">Status</label>
                        </div>
                        <h6>Remarks:</h6>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="viewRemarks" name="remarks" style="height: 100px"
                                readonly></textarea>
                            <label for="viewRemarks">Remarks</label>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve/Reject Modal -->
        <div class="modal fade" id="StatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="statusModalLabel">Update Plan Status</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="update_cbydp_status.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="statusId">
                            <input type="hidden" name="status" id="statusValue">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="remarks" name="remarks" style="height: 100px"
                                    required></textarea>
                                <label for="remarks">Remarks</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="assets/js/view_cbydp.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Approve button click handler
            document.querySelectorAll('.approve-plan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    document.getElementById('statusId').value = id;
                    document.getElementById('statusValue').value = 'approved';
                    document.getElementById('statusModalLabel').textContent = 'Approve Plan';
                    new bootstrap.Modal(document.getElementById('StatusModal')).show();
                });
            });

            // Reject button click handler
            document.querySelectorAll('.reject-plan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    document.getElementById('statusId').value = id;
                    document.getElementById('statusValue').value = 'rejected';
                    document.getElementById('statusModalLabel').textContent = 'Reject Plan';
                    new bootstrap.Modal(document.getElementById('StatusModal')).show();
                });
            });
        });
        </script>

    </section>


</main><!-- End #main -->

<?php include "includes/footer.php"; ?>