FilePond.registerPlugin(
    // validates the size of the file

   // FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,

);

const update_leave_attachment_inputElement = document.querySelector('input[id="leave_attachments_id"]');

const update_leave_attachements_pond = FilePond.create((update_leave_attachment_inputElement), {

        credits: false,
        allowMultiple: false,
        allowFileTypeValidation: true,
       // acceptedFileTypes: ['pdf/*'],

});

update_leave_attachements_pond.setOptions({
    server: {
        process: "/Leave/temp_attachement_documents",
        revert: "/Leave/remove_attachments_forleave",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
});

function remove_Update_UploadedProfile_pic() {
    if (update_leave_attachements_pond) {
        var files = update_leave_attachements_pond.getFiles();
        if (files.length > 0) {
            update_leave_attachements_pond.processFiles().then(() => {
                update_leave_attachements_pond.removeFiles();
                // console.log('Removed');
            });
        }
    }
}





