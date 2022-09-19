/*
Script: Custom Javascript
*/

function readURL(input) 
{
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        console.log(input.files[0]);
        reader.onload = function (e) {
            $('#uploadedAvatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {

    $("#upload").change(function () {
        readURL(this);
    });

});

