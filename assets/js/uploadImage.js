// $(function () {
//   $("#uploadImage").on("change", function (event) {
//     // alert('Image changed');
//       e.preventDefault(); // prevent page reload
//     var input = event.target;
//     if (input.files && input.files[0]) {
//       let image = input.files[0];
//       //Validate image size and format
//       if (image.size > 2 * 1024 * 1024) {
//         // 2MB
//         alert("Image size should be less than 2MB");
//         input.value = "";
//         return;
//       }
//       const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
//       if (!validImageTypes.includes(image.type)) {
//         alert("Invalid image format. Only JPG, PNG, and GIF are allowed.");
//         input.value = "";
//         return;
//       }
//       $("#uploadedImage").attr("src", URL.createObjectURL(image));
//       //Upload image to server using ajax
//       let user_id = $("#user_id").val();
//       console.log(user_id);

//     var formData = new FormData(this); // collect form data (including image)
//       $.ajax({
//         type: "post",
//         url: "../backend/image-upload.php?user_id=" + user_id,
//         dataType: "JSON",
//         data: formData,
//         contentType: false, // important
//         processData: false, // important
//         success: function (data) {
//           console.log(data.data);
//         },
//         error: function (err) {
//           console.log(err.message);
//           alert("An error occurred while fetching states");
//         },
//         xhr: function () {
//           var xhr = new XMLHttpRequest();
//           // Bind the correct context to the arrayBuffer method
//           xhr.responseType = function () {
//             return "arraybuffer";
//           }.bind(xhr);
//           return xhr;
//         },
//       });
//     }
//   });
// });

$(document).ready(function() {
  $('#uploadImage').on('change', function(e) {
    e.preventDefault(); // prevent page reload

    var formData = new FormData(this); // collect form data (including image)

    $.ajax({
      url: "../backend/image-upload.php?user_id=" + user_id, // backend PHP file
      type: 'POST',
      data: formData,
      contentType: false, // important
      processData: false, // important
      success: function(response) {
        $('#message').html('<span style="color:green;">' + response + '</span>');
        alert('Image uploaded successfully');
      },
      error: function(xhr, status, error) {
        $('#message').html('<span style="color:red;">Error: ' + error + '</span>');
        alert('An error occurred while uploading the image');
      }
    });
  });
});