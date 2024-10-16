$(document).ready(function () {
  $("#regionSelect").change(function () {
    var region = $(this).val();
    $.ajax({
      url: "get_address.php",
      type: "post",
      data: { get_option: region },
      success: function (response) {
        $("#provinceSelect").html(response);
        $("#municipalitySelect").html(
          "<option selected>Select City/Municipality</option>"
        );
        $("#barangaySelect").html("<option selected>Select Barangay</option>");
      },
    });
  });

  $("#provinceSelect").change(function () {
    var province = $(this).val();
    $.ajax({
      url: "get_address.php",
      type: "post",
      data: { get_province: province },
      success: function (response) {
        $("#municipalitySelect").html(response);
        $("#barangaySelect").html("<option selected>Select Barangay</option>");
      },
    });
  });

  $("#municipalitySelect").change(function () {
    var municipality = $(this).val();
    $.ajax({
      url: "get_address.php",
      type: "post",
      data: { get_municipality: municipality },
      success: function (response) {
        $("#barangaySelect").html(response);
      },
    });
  });
});

$(document).ready(function () {
  $("#municipality").change(function () {
    var municipality = $(this).val();
    $.ajax({
      url: "get_address.php",
      type: "post",
      data: { get_municipality: municipality },
      success: function (response) {
        $("#barangay").html(response);
      },
    });
  });
});
