

$(document).ready(function () {
    onSubmit_functions()
});

//E-Signature Here
const e_signature_inputElement = document.querySelector('input[id="user_signature"]');
const e_sig_pond = FilePond.create((e_signature_inputElement), {

    credits: false,
    allowMultiple: false,
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/png'],

});

e_sig_pond.setOptions({
    server: {
        process: "/signature/temp/user/signature/upload",
        revert: "/signature/temp/user/signature/delete",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
});

function onSubmit_functions() {
    $("#save_user_signature").submit(function (e) { 
        e.preventDefault();
        
        const fd = $(this);
        
        $.ajax({
            type: "POST",
            url: bpath + 'signature/save/user/signature',
            data: fd.serialize(),
            success: function (response) {
                if(response.status == 200){
                    $('#save_user_signature')[0].reset();
                    __notif_show(1, "Success", " Signature added successfully!");

                    // load_uploaded_signature(_token);

                }else {

                    __notif_show(-1, "Warning", "OOps! Something went wrong!");
                }
                
            }
        });

    });
}
  
  
  
  
  
  
  