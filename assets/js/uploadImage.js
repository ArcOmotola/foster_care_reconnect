$(function () {
  $("#uploadImage").on("change", function (event) {
    // alert('Image changed');
    var input = event.target;
    if (input.files && input.files[0]) {
      let image = input.files[0];
      //Validate image size and format
      if (image.size > 2 * 1024 * 1024) {
        // 2MB
        alert("Image size should be less than 2MB");
        input.value = "";
        return;
      }
      const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
      if (!validImageTypes.includes(image.type)) {
        alert("Invalid image format. Only JPG, PNG, and GIF are allowed.");
        input.value = "";
        return;
      }
      $("#uploadedImage").attr("src", URL.createObjectURL(image));
      //Upload image to server using ajax
      let user_id = $("#user_id").val();
      console.log(user_id);

      $.ajax({
        type: "post",
        url: "../backend/image-upload.php",
        dataType: "JSON",
        data: {
          image: image,
          user_id: user_id,
        },
        success: function (data) {
          console.log(data.data);
        },
        error: function (err) {
          console.log(err.message);
          alert("An error occurred while fetching states");
        },
        xhr: function () {
          var xhr = new XMLHttpRequest();
          // Bind the correct context to the arrayBuffer method
          xhr.responseType = function () {
            return "arraybuffer";
          }.bind(xhr);
          return xhr;
        },
      });
    }
  });
});
