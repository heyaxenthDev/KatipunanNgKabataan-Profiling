  <!-- Modal -->
  <div class="modal fade" id="viewYouthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="viewYouthModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="viewYouthModalLabel">View Youth Details</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                  <input type="hidden" name="brgyCode" id="brgyCode" value="<?=$_GET['Code']?>">

                  <!-- Multi Columns Form -->
                  <div class="row g-3">
                      <label class="form-label fw-semibold">Name of Respondent</label>

                      <div class="col-md-8">
                          <div class="d-flex flex-column align-items-center">
                              <div class="w-100 border-dark border-bottom">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewLastName"
                                      name="lastName" readonly>
                              </div>
                              <label for="viewLastName" class="mt-2">Last Name</label>
                          </div>

                          <div class="d-flex flex-column align-items-center">
                              <div class="w-100 border-dark border-bottom">
                                  <input type="text" class="form-control text-center border-0 fw-bold"
                                      id="viewFirstName" name="firstName" readonly>
                              </div>
                              <label for="viewFirstName" class="mt-2">First Name</label>
                          </div>

                          <div class="d-flex flex-column align-items-center">
                              <div class="w-100 border-dark border-bottom">
                                  <input type="text" class="form-control text-center border-0 fw-bold"
                                      id="viewMiddleName" name="middleName" readonly>
                              </div>
                              <label for="viewMiddleName" class="mt-2">Middle Name</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="d-flex justify-content-center align-items-end">
                              <img src="" id="viewPicture" class="img-fluid" alt="Profile Picture">
                          </div>
                      </div>

                      <label for="Location" class="form-label fw-semibold mt-3">Location</label>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewStreet"
                                      name="street" readonly>
                              </div>
                              <label for="viewStreet">Street</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewRegion"
                                      name="Region" readonly>
                              </div>
                              <label for="viewRegion">Region</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewProvince"
                                      name="Province" readonly>
                              </div>
                              <label for="viewProvince">Province</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold"
                                      id="viewMunicipality" name="Municipality" readonly>
                              </div>
                              <label for="viewMunicipality">City/Municipality</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewBarangay"
                                      name="Barangay" readonly>
                              </div>
                              <label for="viewBarangay">Barangay</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewZip"
                                      name="Zip" readonly>
                              </div>
                              <label for="viewZip">Zip</label>
                          </div>
                      </div>


                      <label for="PersonalInformation" class="form-label fw-semibold">Personal Information</label>

                      <div class="col-md-4">
                          <label class="form-label d-block mb-2">Gender <span class="text-danger">*</span></label>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="viewGenderMale" value="0"
                                  disabled>
                              <label class="form-check-label" for="viewGenderMale">Male</label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="gender" id="viewGenderFemale" value="1"
                                  disabled>
                              <label class="form-check-label" for="viewGenderFemale">Female</label>
                          </div>
                          <!-- Optional: Uncomment the third option if needed -->
                          <!--
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other">
                                <label class="form-check-label" for="genderOther">Other</label>
                            </div>
                            -->
                      </div>


                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold" id="viewAge"
                                      name="Age" readonly>
                              </div>
                              <label for="viewAge">Age</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold"
                                      id="viewBirthdate" name="birthdate" readonly>
                              </div>
                              <label for="viewBirthdate">Birthdate</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center align-bottom">
                              <div class="border-bottom border-dark">
                                  <input type="text" class="form-control text-center border-0 fw-bold"
                                      id="viewCivilStatus" name="CivilStatus" readonly>
                              </div>
                              <label for="viewCivilStatus">Civil Status</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center align-bottom">
                              <div class="border-bottom border-dark">
                                  <input type="email" class="form-control text-center border-0 fw-bold" id="viewEmail"
                                      name="Email" readonly>
                              </div>
                              <label for="viewEmail">Email Address</label>
                          </div>
                      </div>

                      <div class="col-md-4">
                          <div class="text-center">
                              <div class="border-bottom border-dark">
                                  <input type="tel" class="form-control text-center border-0 fw-bold" id="viewContact"
                                      name="Contact" readonly>
                              </div>
                              <label for="viewContact">Contact Number</label>
                          </div>
                      </div>

                      <label for="Classification" class="form-label fw-semibold">Classifications</label>

                      <div class="row mt-2">

                          <div class="col-md-3">
                              <div class="text-center">
                                  <div class="border-bottom border-dark">
                                      <input type="text" class="form-control text-center border-0 fw-bold"
                                          id="viewYouthAgeGroup" name="YouthAgeGroup" readonly>
                                  </div>
                                  <label for="viewYouthAgeGroup">Youth Age Group</label>
                              </div>
                          </div>

                          <div class="col-md-3">
                              <div class="text-center">
                                  <div class="border-bottom border-dark">
                                      <input type="text" class="form-control text-center border-0 fw-bold"
                                          id="viewYouthClassification" name="YouthClassification" readonly>
                                  </div>
                                  <label for="viewYouthClassification">Youth Classification</label>
                              </div>
                          </div>

                          <!-- Educational Background Section -->
                          <div class="col-md-3">
                              <div class="text-center">
                                  <div class="border-bottom border-dark">
                                      <input type="text" class="form-control text-center border-0 fw-bold"
                                          id="viewEducationalBackground" name="educationalBackground" readonly>
                                  </div>
                                  <label for="viewEducationalBackground" class="form-label">Educational
                                      Background</label>
                              </div>
                          </div>

                          <!-- Work Status Section -->
                          <div class="col-md-3">
                              <div class="text-center">
                                  <div class="border-bottom border-dark">
                                      <input type="text" class="form-control text-center border-0 fw-bold"
                                          id="viewWorkStatus" name="workStatus" readonly>
                                  </div>
                                  <label for="viewWorkStatus" class="form-label">Work Status</label>
                              </div>
                          </div>
                      </div>



                      <!-- Voter Registration Section -->
                      <div class="mb-1">
                          <label for="VotersRegistration" class="form-label fw-semibold">Voter's
                              Registration</label>
                          <div class="row">
                              <div class="col-md-4">
                                  <label>Registered SK Voter?</label><br>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="skVoter" id="skVoterYes"
                                          value="Yes" disabled>
                                      <label class="form-check-label" for="skVoterYes">Yes</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="skVoter" id="skVoterNo"
                                          value="No" disabled>
                                      <label class="form-check-label" for="skVoterNo">No</label>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label>Registered National Voter?</label><br>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="nationalVoter"
                                          id="nationalVoterYes" value="Yes" disabled>
                                      <label class="form-check-label" for="nationalVoterYes">Yes</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="nationalVoter"
                                          id="nationalVoterNo" value="No" disabled>
                                      <label class="form-check-label" for="nationalVoterNo">No</label>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- Assembly Participation Section -->
                      <div class="mb-1">
                          <label for="AssemblyParticipation" class=" form-label fw-semibold">Assembly
                              Participation</label>
                          <div class="row">
                              <div class="col-md-6">
                                  <label>Have you already attended a KK Assembly?</label><br>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyYes"
                                          value="Yes" disabled>
                                      <label class="form-check-label" for="kkAssemblyYes">Yes</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyNo"
                                          value="No" disabled>
                                      <label class="form-check-label" for="kkAssemblyNo">No</label>
                                  </div>
                              </div>

                              <div class="col-md-6" id="ifYes" style="display: none;">
                                  <label>If Yes, how many times?</label><br>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssemblyTimes" id="times1to2"
                                          value="1-2" disabled>
                                      <label class="form-check-label" for="times1to2">1-2 times</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssemblyTimes" id="times3to4"
                                          value="3-4" disabled>
                                      <label class="form-check-label" for="times3to4">3-4 times</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                          id="times5plus" value="5 and above" disabled>
                                      <label class="form-check-label" for="times5plus">5 and above</label>
                                  </div>
                              </div>

                              <div class="col-md-6" id="ifNo" style="display: none;">
                                  <label>If No, Why?</label><br>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssemblyWhy" id="NoAssembly"
                                          value="There was no KK Assembly Meeting" disabled>
                                      <label class="form-check-label" for="NoAssembly">There was no KK Assembly
                                          Meeting</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="kkAssemblyWhy"
                                          id="NotInterested" value="Not interested to attend" disabled>
                                      <label class="form-check-label" for="NotInterested">Not interested to attend
                                      </label>
                                  </div>
                              </div>
                          </div>
                      </div>


                      <!-- Vote History Section -->
                      <div class="mb-1">
                          <label for="VoteHistory" class=" form-label fw-semibold">Did you vote last SK
                              Election?</label>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="vote" id="voteYes" value="Yes"
                                          disabled>
                                      <label class="form-check-label" for="voteYes">Yes</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="vote" id="voteNo" value="No"
                                          disabled>
                                      <label class="form-check-label" for="voteNo">No</label>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div><!-- End Multi Columns Form -->
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <!-- <button type="button" class="btn btn-primary" onclick="printModal()"><i class="bi bi-printer"></i>
                      Print this record</button> -->
              </div>
          </div>
      </div>
  </div>


  <!-- View Modal for SK Officials -->
  <div class="modal fade" id="viewSKOfficialsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="viewSKOfficialsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="viewSKOfficialsModalLabel">SK Official Details</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body row g-3">
                  <h5 class="card-title mx-2">Personal Information</h5>

                  <div class="col-md-4">
                      <label for="viewLastname" class="form-label">Last
                          Name</label>
                      <input type="text" class="form-control" id="viewLastname" name="viewLastname">
                  </div>

                  <div class="col-md-4">
                      <label for="viewFirstname" class="form-label">First
                          Name</label>
                      <input type="text" class="form-control" id="viewFirstname" name="viewFirstname">
                  </div>

                  <div class="col-md-4">
                      <label for="viewMiddlename" class="form-label">Middle
                          Name</label>
                      <input type="text" class="form-control" id="viewMiddlename" name="viewMiddlename">
                  </div>

                  <div class="col-md-4">
                      <label for="viewPosition" class="form-label">Position</label>
                      <input type="text" class="form-control" id="viewPosition" name="viewPosition" readonly>
                  </div>

                  <div class="col-md-3">
                      <label for="viewSex" class="form-label">Sex</label>
                      <input type="text" class="form-control" id="viewSex" name="viewSex" readonly>
                  </div>

                  <div class="col-md-2">
                      <label for="viewAge" class="form-label">Age</label>
                      <input type="text" class="form-control" id="viewSKAge" name="viewSKAge" readonly>
                  </div>

                  <div class="col-md-3">
                      <label for="viewDOB" class="form-label">Date of
                          Birth</label>
                      <input type="text" class="form-control" id="viewDOB" name="viewDOB">
                  </div>

                  <div class="col-md-4">
                      <label for="viewMobileNumber" class="form-label">Mobile
                          Number</label>
                      <input type="tel" class="form-control" id="viewMobileNumber" name="viewMobileNumber">
                  </div>

                  <div class="col-md-2">
                      <label for="viewStreetNumber" class="form-label">Street
                          Number</label>
                      <input type="text" class="form-control" id="viewStreetNumber" name="viewStreetNumber">
                  </div>

                  <div class="col-md-3">
                      <label for="viewAddress" class="form-label">Address</label>
                      <input type="text" class="form-control" id="viewAddress" name="viewAddress">
                  </div>

                  <div class="col-md-3">
                      <label for="viewBrgyAddressName" class="form-label">Barangay</label>
                      <input type="text" class="form-control" id="viewBrgyAddressName" value="<?= $_GET['Name']?>"
                          readonly>
                      <input type="hidden" class="form-control" id="viewBrgyAddressCode" name="barangay"
                          value="<?= $_GET['Code']?>" readonly>
                  </div>

                  <h5 class="card-title mx-2">Login Access</h5>

                  <div class="col-md-6">
                      <label for="viewUsername" class="form-label">Username</label>
                      <input type="text" class="form-control" id="viewUsername" name="viewUsername">
                  </div>

                  <div class="col-md-6">
                      <label for="viewPassword" class="form-label">Password</label>
                      <input type="password" class="form-control" id="viewPassword" name="viewPassword">
                  </div>

                  <div class="col-md-6">
                      <label for="viewSKEmail" class="form-label">Email</label>
                      <input type="email" class="form-control" id="viewSKEmail" name="viewSKEmail">
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-primary" name="createAcc">Submit</button> -->
              </div>
          </div>
      </div>
  </div>