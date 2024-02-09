FilePond.registerPlugin(
    // validates the size of the file

   FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,

);

const update_request_attachment_inputElement = document.querySelector('input[id="attachments_request_id"]');

const update_request_attachements_pond = FilePond.create((update_request_attachment_inputElement), {

        credits: false,
        allowMultiple: false,
        allowFileTypeValidation: true,
       // acceptedFileTypes: ['pdf/*'],

});

update_request_attachements_pond.setOptions({
    server: {
        process: "/onlinerequest/dashboard/create_temporaryfiles",
        revert: "/onlinerequest/dashboard/remove_attachement_documents",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
});

function remove_Update_UploadedProfile_pic() {
    if (update_request_attachements_pond) {
        var files = update_request_attachements_pond.getFiles();
        if (files.length > 0) {
            update_request_attachements_pond.processFiles().then(() => {
                update_request_attachements_pond.removeFiles();
                // console.log('Removed');
            });
        }
    }
}





//