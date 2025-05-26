<?php 
include 'authentication.php';
checkLogin();
include "includes/conn.php";
include "includes/header.php";
include "includes/sidebar.php";
include "alert.php";
?>


<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center  mb-3">
        <h1>Annual Barangay Youth Investment Program</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card pt-3">
                    <div class="card-body">
                        <!-- Registered Youth -->
                        <?php
                            $stmt = $conn->prepare("SELECT * FROM abyip");
                            $stmt->execute();
                            $result = $stmt->get_result();
                                            
                        ?>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Reference Code</th>
                                    <th>PPAS</th>
                                    <th>Description</th>
                                    <th>Expected Result</th>
                                    <th>Performance Indicator</th>
                                    <th>Period Implementation</th>
                                    <th>MOOE</th>
                                    <th>CO</th>
                                    <th>Total</th>
                                    <th>Person Responsible</th>
                                    <!-- <th>Remarks</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $status = $row['status'] == 'pending' ? '<span class="badge bg-warning">Pending</span>' : ($row['status'] == 'approved' ? '<span class="badge bg-success">Approved</span>' : '<span class="badge bg-danger">Rejected</span>');
                                ?>
                                <tr>
                                    <td><?=$status ?></td>
                                    <td><?=$row['reference_code'] ?></td>
                                    <td><?=htmlspecialchars($row['ppa']) ?></td>
                                    <td><?=htmlspecialchars($row['description']) ?></td>
                                    <td><?=htmlspecialchars($row['expected_result']) ?></td>
                                    <td><?=htmlspecialchars($row['performance_indicator']) ?></td>
                                    <td><?=htmlspecialchars($row['period_implementation']) ?></td>
                                    <td><?=htmlspecialchars($row['mooe']) ?></td>
                                    <td><?=htmlspecialchars($row['co']) ?></td>
                                    <td><?=htmlspecialchars($row['total']) ?></td>
                                    <td><?=htmlspecialchars($row['person_responsible']) ?></td>
                                    <!-- <td><?=htmlspecialchars($row['remarks']) == '' ? 'No remarks' : htmlspecialchars($row['remarks']) ?> -->
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success btn-sm view-details"
                                                data-abyip-id="<?=$row['id']?>"><i class="bi bi-eye"></i>
                                                View</button>
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
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- ABYIP Modal -->
        <div class="modal fade" id="abypModal" tabindex="-1" aria-labelledby="abypModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <form action="save_abyip.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="abypModalLabel">Add ABYIP Entry - Environment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-md-4">
                                <input type="hidden" name="brgyCode" value="<?=$brgyCode?>">
                                <input type="hidden" name="brgyName" value="<?=$brgyName?>">
                                <label for="reference_code" class="form-label">Reference Code</label>
                                <input type="text" class="form-control" name="reference_code" required>
                            </div>

                            <div class="col-md-8">
                                <label for="ppa" class="form-label">PPAs</label>
                                <input type="text" class="form-control" name="ppa" required>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>

                            <div class="col-12">
                                <label for="expected_result" class="form-label">Expected Result</label>
                                <textarea class="form-control" name="expected_result" rows="2" required></textarea>
                            </div>

                            <div class="col-12">
                                <label for="performance_indicator" class="form-label">Performance Indicator</label>
                                <textarea class="form-control" name="performance_indicator" rows="2"
                                    required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="period_implementation" class="form-label">Period Implementation</label>
                                <input type="text" class="form-control" name="period_implementation" required>
                            </div>

                            <div class="col-md-2">
                                <label for="mooe" class="form-label">MOOE</label>
                                <input type="number" class="form-control" name="mooe" step="0.01" required>
                            </div>

                            <div class="col-md-2">
                                <label for="co" class="form-label">CO</label>
                                <input type="number" class="form-control" name="co" step="0.01" required>
                            </div>

                            <div class="col-md-2">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" class="form-control" name="total" step="0.01" required>
                            </div>

                            <div class="col-12">
                                <label for="person_responsible" class="form-label">Person Responsible</label>
                                <input type="text" class="form-control" name="person_responsible" required>
                            </div>


                            <div class="col-md-6">
                                <label for="prepared_by" class="form-label">Prepared By</label>
                                <select name="prepared_by" class="form-select" id="prepared_by" required>
                                    <option>Loading...</option>
                                </select>
                            </div>

                            <script>
                            $(document).ready(function() {
                                $('#prepared_by').load('get_sk_officials.php');
                            });
                            </script>


                            <div class="col-md-6">
                                <label for="approved_by" class="form-label">Approved By</label>
                                <input type="text" class="form-control" name="approved_by">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit ABYIP Plan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Entry Modal -->
        <div class="modal fade" id="viewAbyipModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewEntryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewEntryModalLabel">View ABYIP Entry</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="hidden" name="brgyCode" value="<?= $brgyCode ?>">
                                <label for="viewReferenceCode" class="form-label">Reference Code</label>
                                <input type="text" class="form-control" name="reference_code" id="viewReferenceCode"
                                    readonly>
                            </div>

                            <div class="col-md-8">
                                <label for="viewPPA" class="form-label">PPAs</label>
                                <input type="text" class="form-control" name="ppa" id="viewPPA" readonly>
                            </div>

                            <div class="col-12">
                                <label for="viewDescription" class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" id="viewDescription"
                                    readonly></textarea>
                            </div>

                            <div class="col-12">
                                <label for="viewExpectedResult" class="form-label">Expected Result</label>
                                <textarea class="form-control" name="expected_result" rows="2" id="viewExpectedResult"
                                    readonly></textarea>
                            </div>

                            <div class="col-12">
                                <label for="viewPerformanceIndicator" class="form-label">Performance Indicator</label>
                                <textarea class="form-control" name="performance_indicator" rows="2"
                                    id="viewPerformanceIndicator" readonly></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="viewPeriodImplementation" class="form-label">Period Implementation</label>
                                <input type="text" class="form-control" name="period_implementation"
                                    id="viewPeriodImplementation" readonly>
                            </div>

                            <div class="col-md-2">
                                <label for="viewMooe" class="form-label">MOOE</label>
                                <input type="number" class="form-control" name="mooe" step="0.01" id="viewMooe"
                                    readonly>
                            </div>

                            <div class="col-md-2">
                                <label for="viewCo" class="form-label">CO</label>
                                <input type="number" class="form-control" name="co" step="0.01" id="viewCo" readonly>
                            </div>

                            <div class="col-md-2">
                                <label for="viewTotal" class="form-label">Total</label>
                                <input type="number" class="form-control" name="total" step="0.01" id="viewTotal"
                                    readonly>
                            </div>

                            <div class="col-12">
                                <label for="viewPersonResponsible" class="form-label">Person Responsible</label>
                                <input type="text" class="form-control" name="person_responsible"
                                    id="viewPersonResponsible" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="viewPreparedBy" class="form-label">Prepared By</label>
                                <input type="text" class="form-control" name="prepared_by" id="viewPreparedBy" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="viewApprovedBy" class="form-label">Approved By</label>
                                <input type="text" class="form-control" name="approved_by" id="viewApprovedBy" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="viewStatus" class="form-label">Status</label>
                                <input type="text" class="form-control" name="status" id="viewStatus" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="viewRemarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="2" id="viewRemarks"
                                    readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <script src="assets/js/view_abyip.js"></script>

        <!-- Edit Entry Modal -->
        <div class="modal fade" id="editAbyipModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editEntryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editEntryModalLabel">Edit ABYIP Entry</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="update_abyip.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editId">
                            <input type="hidden" name="brgyCode" value="<?= $brgyCode ?>">
                            <input type="hidden" name="brgyName" value="<?= $brgyName ?>">

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="reference_code"
                                            id="editReferenceCode" readonly placeholder="Reference Code">
                                        <label for="editReferenceCode">Reference Code</label>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="ppa" id="editPPA" readonly
                                            placeholder="PPAs">
                                        <label for="editPPA">PPAs</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="description" id="editDescription" readonly
                                            placeholder="Description" style="height: 100px"></textarea>
                                        <label for="editDescription">Description</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="expected_result" id="editExpectedResult"
                                            readonly placeholder="Expected Result" style="height: 80px"></textarea>
                                        <label for="editExpectedResult">Expected Result</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="performance_indicator"
                                            id="editPerformanceIndicator" readonly placeholder="Performance Indicator"
                                            style="height: 80px"></textarea>
                                        <label for="editPerformanceIndicator">Performance Indicator</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="period_implementation"
                                            id="editPeriodImplementation" readonly placeholder="Period Implementation">
                                        <label for="editPeriodImplementation">Period Implementation</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="mooe" step="0.01" id="editMooe"
                                            readonly placeholder="MOOE">
                                        <label for="editMooe">MOOE</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="co" step="0.01" id="editCo"
                                            readonly placeholder="CO">
                                        <label for="editCo">CO</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="total" step="0.01"
                                            id="editTotal" readonly placeholder="Total">
                                        <label for="editTotal">Total</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="person_responsible"
                                            id="editPersonResponsible" readonly placeholder="Person Responsible">
                                        <label for="editPersonResponsible">Person Responsible</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="prepared_by" class="form-select" id="editPreparedBy" required
                                            aria-label="Prepared By">
                                            <option value="" disabled selected>Loading...</option>
                                        </select>
                                        <label for="editPreparedBy">Prepared By</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="approved_by" id="editApprovedBy"
                                            readonly placeholder="Approved By">
                                        <label for="editApprovedBy">Approved By</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="updateAbyip" class="btn btn-primary">Update ABYIP
                                Plan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Script to load SK officials -->
            <script>
            $(document).ready(function() {
                $('#editPreparedBy').load('get_sk_officials.php');
            });
            </script>

            <script src="assets/js/edit_abyip.js"></script>
    </section>

    <!-- Hidden Printable Card for ABYIP -->
    <div id="printableCard" style="display:none;">
        <div style="font-family: Arial, sans-serif; width: 100%;">
            <div style="text-align:center; font-weight:bold; font-size:18px; margin-bottom:10px;">ANNEX 6 | ANNUAL
                BARANGAY YOUTH INVESTMENT PROGRAM (ABYIP)</div>
            <div style="font-size:14px; margin-bottom:5px;">Region: VI-Western Visayas &nbsp;&nbsp; Province: ANTIQUE
                &nbsp;&nbsp; MUNICIPALITY: SEBASTE</div>
            <div style="text-align:center; font-weight:bold; font-size:16px; margin-bottom:10px;">ANNUAL BARANGAY YOUTH
                INVESTMENT PROGRAM (ABYIP) CY <span id="printYear"></span></div>
            <div style="text-align:center; font-weight:bold; font-size:15px; margin-bottom:10px;">CENTER OF
                PARTICIPATION: <span id="printCenter"></span></div>
            <table border="1" cellspacing="0" cellpadding="4"
                style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead style="background:#eee;">
                    <tr>
                        <th>Reference Code</th>
                        <th>PPAs</th>
                        <th>Description</th>
                        <th>Expected Result</th>
                        <th>Performance Indicator</th>
                        <th>Period Implementation</th>
                        <th colspan="3">Budget</th>
                        <th>Person Responsible</th>
                    </tr>
                    <tr>
                        <th colspan="6"></th>
                        <th>MOOE</th>
                        <th>CO</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="printTableBody"></tbody>
            </table>
            <div style="margin-top:10px; text-align:right; font-weight:bold;">TOTAL ENVIRONMENTAL: <span
                    id="printTotal"></span></div>
            <div style="margin-top:30px; display:flex; justify-content:space-between;">
                <div>
                    <div>Prepared by:</div>
                    <div style="margin-top:30px; text-decoration:underline; font-weight:bold;" id="printPreparedBy">
                    </div>
                    <div style="font-size:12px;">SK TREASURER</div>
                </div>
                <div style="text-align:right;">
                    <div>Approved by:</div>
                    <div style="margin-top:30px; text-decoration:underline; font-weight:bold;" id="printApprovedBy">
                    </div>
                    <div style="font-size:12px;">SK CHAIRMAN</div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/print_abyip.js"></script>

    <!-- Approve/Reject Modal -->
    <div class="modal fade" id="StatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="statusModalLabel">Update Plan Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_abyip_status.php" method="POST">
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

</main><!-- End #main -->

<?php include "includes/footer.php"; ?>