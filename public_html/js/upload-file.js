/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function ()
{
    $("#fileuploader").uploadFile({
        url: "_upload.php",
        fileName: "myfile",
        //acceptFiles: "image/*",
        showPreview: true,
        previewHeight: "100px",
        previewWidth: "100px",
        maxFileSize: (2 * 1024) * 1024,
        dynamicFormData: function ()
        {
            var data = {location: "INDIA"}
            return data;
        },
        afterUploadAll: function (obj)
        {
            alert('The file has been uploaded');
        }
    });
});
