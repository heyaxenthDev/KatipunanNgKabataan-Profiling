  <!-- Modal -->
  <div class="modal fade" id="editYouthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="editYouthModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editYouthModalLabel">Edit Youth Details</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                  <form action="update_details.php" method="POST" enctype="multipart/form-data">
                      <div class="row g-3">
                          <label class="form-label fw-semibold">Name of Respondent</label>

                          <input type="hidden" id="editId" name="id" value="">
                          <input type="hidden" id="editBrgyCode" name="brgyCode" value="">

                          <div class="col-md-8">
                              <div class="form-floating mb-2">
                                  <input type="text" class="form-control form-control-sm" id="editLastName"
                                      name="lastName" required>
                                  <label for="editLastName">Last Name</label>
                              </div>

                              <div class="form-floating mb-2">
                                  <input type="text" class="form-control form-control-sm" id="editFirstName"
                                      name="firstName" placeholder="First Name" required>
                                  <label for="editFirstName">First Name</label>
                              </div>

                              <div class="form-floating">
                                  <input type="text" class="form-control form-control-sm" id="editMiddleName"
                                      name="middleName" placeholder="Middle Name" required>
                                  <label for="editMiddleName">Middle Name</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <img src="" id="editPicture" class="img-fluid mb-2" alt="Profile Picture"
                                  style="max-height: 200px;">
                              <input type="file" id="editPictureInput" name="userImage" accept="image/*"
                                  class="form-control form-control-sm">
                          </div>


                          <label class="form-label fw-semibold">Location</label>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control form-control-sm" id="editStreet" name="street"
                                      placeholder="Street" required>
                                  <label for="editStreet">Street</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control form-control-sm" id="editRegion" name="Region"
                                      readonly>
                                  <label for="editRegion">Region</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control form-control-sm" id="editProvince"
                                      name="Province" readonly>
                                  <label for="editProvince">Province</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control form-control-sm" id="editMunicipality"
                                      name="Municipality" readonly>
                                  <label for="editMunicipality">City/Municipality</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="editBarangay" name="Barangay" readonly>
                                  <label for="editBarangay">Barangay</label>
                              </div>
                          </div>


                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" class="form-control" id="editZip" name="inputZip" readonly>
                                  <label for="editZip">Zip</label>
                              </div>
                          </div>

                          <label class="form-label fw-semibold">Personal Information</label>

                          <div class="col-md-4">
                              <label class="form-label d-block mb-2">Gender <span class="text-danger">*</span></label>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="gender" id="editGenderMale"
                                      value="0" required>
                                  <label class="form-check-label" for="editGenderMale">Male</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="gender" id="editGenderFemale"
                                      value="1">
                                  <label class="form-check-label" for="editGenderFemale">Female</label>
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
                              <div class="form-floating">
                                  <input type="date" class="form-control" id="editBirthdate" name="inputBirthdate"
                                      placeholder="Birthdate" required>
                                  <label for="editBirthdate">Birthdate</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="number" class="form-control" id="editAge" name="inputAge"
                                      placeholder="Age" readonly>
                                  <label for="editAge">Age</label>
                              </div>
                          </div>


                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="text" id="editCivilStatus" name="inputCivilStatus" class="form-control"
                                      placeholder="Enter Civil Status" required>
                                  <label for="editCivilStatus">Civil Status</label>
                              </div>
                          </div>



                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="email" class="form-control" id="editEmail" name="inputEmail"
                                      placeholder="name@example.com" required>
                                  <label for="editEmail">Email Address</label>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-floating">
                                  <input type="tel" class="form-control" id="editContact" name="inputContact"
                                      placeholder="09123456789" required>
                                  <label for="editContact">Contact Number</label>
                              </div>
                          </div>

                          <label class="form-label fw-semibold">Classification</label>

                          <div class="col-md-6">
                              <div class="form-floating">
                                  <select id="editYouthAgeGroup" name="inputYouthAgeGroup" class="form-select" required>
                                      <option value="">Choose Youth Age Group...</option>
                                      <option value="unregistered">Unregistered Youth (below 15 years old)</option>
                                      <option value="child">Child Youth (15-17 years old)</option>
                                      <option value="core">Core Youth (18-24 years old)</option>
                                      <option value="young_adult">Young Adult (25-30 years old)</option>
                                  </select>
                                  <label for="editYouthAgeGroup">Youth Age Group</label>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-floating">
                                  <select id="editYouthClassification" name="inputYouthClassification"
                                      class="form-select" required>
                                      <option value="">Choose Youth Classification...</option>
                                      <option value="In School">In School</option>
                                      <option value="Out of School Youth">Out of School Youth</option>
                                      <option value="Working Youth">Working Youth</option>
                                      <option value="Youth with Special Needs">Youth with Special Needs</option>
                                      <option value="Person with Disability">Person with Disability</option>
                                      <option value="Children in conflict with Law">Children in conflict with Law
                                      </option>
                                      <option value="Indigenous People">Indigenous People</option>
                                  </select>
                                  <label for="editYouthClassification">Youth Classification</label>
                              </div>
                          </div>



                          <label class="form-label fw-semibold">Educational Background</label>

                          <!-- Educational Background Section -->
                          <div class="mb-4">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editElementaryLevel" value="Elementary Level" required>
                                          <label class="form-check-label" for="editElementaryLevel">Elementary
                                              Level</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editElementaryGraduate" value="Elementary Graduate">
                                          <label class="form-check-label" for="editElementaryGraduate">Elementary
                                              Graduate</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editHighSchoolLevel" value="High School Level">
                                          <label class="form-check-label" for="editHighSchoolLevel">High School
                                              Level</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editHighSchoolGraduate" value="High School Graduate">
                                          <label class="form-check-label" for="editHighSchoolGraduate">High School
                                              Graduate</label>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editVocationalGraduate" value="Vocational Graduate">
                                          <label class="form-check-label" for="editVocationalGraduate">Vocational
                                              Graduate</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editCollegeLevel" value="College Undergraduate">
                                          <label class="form-check-label" for="editCollegeLevel">College
                                              Undergraduate</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editCollegeGraduate" value="Bachelor's Degree">
                                          <label class="form-check-label" for="editCollegeGraduate">Bachelor's
                                              Degree</label>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editMasterLevel" value="Post Graduate Level">
                                          <label class="form-check-label" for="editMasterLevel">Post Graduate
                                              Level</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editMasterGraduate" value="Master's Degree">
                                          <label class="form-check-label" for="editMasterGraduate">Master's
                                              Degree</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editDoctorateLevel" value="Doctoral Level">
                                          <label class="form-check-label" for="editDoctorateLevel">Doctoral
                                              Level</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="educationalBackground"
                                              id="editDoctorateGraduate" value="Doctorate Degree">
                                          <label class="form-check-label" for="editDoctorateGraduate">Doctorate
                                              Degree</label>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Work Status Section -->
                          <div class="mb-4">
                              <label class="form-label fw-semibold">Work Status</label>
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editEmployed" value="Employed" required>
                                          <label class="form-check-label" for="editEmployed">Employed</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editUnemployed" value="Unemployed">
                                          <label class="form-check-label" for="editUnemployed">Unemployed</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editSelfEmployed" value="Self-Employed">
                                          <label class="form-check-label" for="editSelfEmployed">Self-Employed</label>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editCurrentlyLooking" value="Currently looking for a job">
                                          <label class="form-check-label" for="editCurrentlyLooking">Currently looking
                                              for a
                                              job</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editWorkNotInterested" value="Not interested in looking for a job">
                                          <label class="form-check-label" for="editWorkNotInterested">Not interested in
                                              looking
                                              for a
                                              job</label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="workStatus"
                                              id="editStillStudying" value="Still Studying">
                                          <label class="form-check-label" for="editStillStudying">Still Studying</label>
                                      </div>
                                  </div>
                              </div>
                          </div>


                          <!-- Voter Registration Section -->
                          <div class="mb-4">
                              <label class="form-label fw-semibold">Voter's Registration</label>
                              <div class="row">
                                  <div class="col-md-4">
                                      <label>Registered SK Voter?</label><br>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="skVoter"
                                              id="editSkVoterYes" value="Yes" required>
                                          <label class="form-check-label" for="editSkVoterYes">Yes</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="skVoter" id="editSkVoterNo"
                                              value="No">
                                          <label class="form-check-label" for="editSkVoterNo">No</label>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <label>Registered National Voter?</label><br>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="nationalVoter"
                                              id="editNationalVoterYes" value="Yes" required>
                                          <label class="form-check-label" for="editNationalVoterYes">Yes</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="nationalVoter"
                                              id="editNationalVoterNo" value="No">
                                          <label class="form-check-label" for="editNationalVoterNo">No</label>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Assembly Participation Section -->
                          <div class="mb-4">
                              <label class=" form-label fw-semibold">Assembly
                                  Participation</label>
                              <div class="row">
                                  <div class="col-md-6">
                                      <label>Have you already attended a KK Assembly?</label><br>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssembly"
                                              id="editKkAssemblyYes" value="Yes" required>
                                          <label class="form-check-label" for="editKkAssemblyYes">Yes</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssembly"
                                              id="editKkAssemblyNo" value="No">
                                          <label class="form-check-label" for="editKkAssemblyNo">No</label>
                                      </div>
                                  </div>

                                  <div class="col-md-6" id="editIfYes" style="display: none;">
                                      <label>If Yes, how many times?</label><br>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                              id="editTimes1to2" value="1-2">
                                          <label class="form-check-label" for="editTimes1to2">1-2 times</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                              id="editTimes3to4" value="3-4">
                                          <label class="form-check-label" for="editTimes3to4">3-4 times</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                              id="editTimes5plus" value="5 and above">
                                          <label class="form-check-label" for="editTimes5plus">5 and above</label>
                                      </div>
                                  </div>

                                  <div class="col-md-6" id="editIfNo" style="display: none;">
                                      <label>If No, Why?</label><br>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssemblyWhy"
                                              id="editNoAssembly" value="There was no KK Assembly Meeting">
                                          <label class="form-check-label" for="editNoAssembly">There was no KK Assembly
                                              Meeting</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="kkAssemblyWhy"
                                              id="editNotInterested" value="Not interested to attend">
                                          <label class="form-check-label" for="editNotInterested">Not interested to
                                              attend
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <script>
                          $(document).ready(function() {
                              $('input[name="kkAssembly"]').change(function() {
                                  if ($(this).val() == "Yes") {
                                      $("#editIfYes").show();
                                      $("#editIfNo").hide(); // Hide 'No' section if 'Yes' is selected
                                  } else if ($(this).val() == "No") {
                                      $("#editIfNo").show();
                                      $("#editIfYes").hide(); // Hide 'Yes' section if 'No' is selected
                                  }
                              });
                          });
                          </script>


                          <!-- Vote History Section -->
                          <div class="mb-4">
                              <label class=" form-label fw-semibold">Did you vote last SK
                                  Election?</label>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="vote" id="editVoteYes"
                                              value="Yes" required>
                                          <label class="form-check-label" for="editVoteYes">Yes</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="vote" id="editVoteNo"
                                              value="No">
                                          <label class="form-check-label" for="editVoteNo">No</label>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="updateDetails" class="btn btn-success"><i class="bi bi-save"></i> Save
                      Changes</button>
              </div>
              </form>
          </div>
      </div>
  </div>