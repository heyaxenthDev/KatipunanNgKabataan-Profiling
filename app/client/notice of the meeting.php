<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>

<main id="main" class="main">

    <section class="section">

        <div class="card">
            <div class="card-body">

                <div class="pt-5 pb-5">
                    <h6 class="text-center">Republic of the Philippines</h6>
                    <h6 class="text-center">Province of Antique</h6>
                    <h5 class="text-center">MUNICIPALITY OF SEBASTE</h5>
                    <h5 class="text-center fw-bold">BARANGAY <span class="text-uppercase"><?= $barangayName?></span>
                    </h5>
                </div>

                <div class="pb-5">
                    <h5 class="text-center fw-bold">OFFICE OF THE SANGGUNIANG KABATAAN</h5>
                </div>

                <div class="pb-5">
                    <h5 class="text-center fw-bold">NOTICE OF THE MEETING</h5>
                </div>

                <form action="" class="m-5">

                    <div class="pb-5">
                        <!-- Multi Columns Form -->
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="Name">
                            </div>
                        </div><!-- End Multi Columns Form -->

                        <div class="row">
                            <div class="col-md-4">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation">
                            </div>
                        </div>
                    </div>

                    <div class="pb-5">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">FOR : </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputText">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">SUBJECT : </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" style="height: 100px;"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="agenda">Agenda includes the following:</label>
                            <textarea class="form-control" id="agenda" style="height: 100px;"></textarea>
                        </div>
                    </div>

                    <div class="pt-5">
                        <!-- Multi Columns Form -->
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="assignedBy" class="form-label">By</label>
                                <input type="text" class="form-control" id="assignedBy">
                            </div>
                        </div><!-- End Multi Columns Form -->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="designationSK" class="form-label">Designation</label>
                                <select class="form-control" id="designationSK">
                                    <option value="" selected disabled>Select Designation</option>
                                    <option value="SK Chairman">SK Chairman</option>
                                    <option value="Sk Kagawad">Sk Kagawad</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="pt-5 pb-5">
                        <label>Copy Furnished:</label> </br>
                        <label>Sangguniang Barangay</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>

                </form>

            </div>
        </div>

    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>