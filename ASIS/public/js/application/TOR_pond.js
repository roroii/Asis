// Register the plugin
FilePond.registerPlugin(
    // validates the size of the file
    FilePondPluginFileValidateSize,
);

const TOR_inputElement = document.querySelector('input[id="transcript_of_records"]');

const TOR_pond = FilePond.create((TOR_inputElement),
    {
        credits: false,
        maxTotalFileSize: "5MB",
        labelFileProcessingComplete: "Uploaded successfully",
        labelMaxTotalFileSizeExceeded: "Maximum total size exceeded",
        labelMaxTotalFileSize: 'Maximum total file size is {filesize}',

    });

TOR_pond.setOptions({
    server: {
        process: "/application/temp/tor/upload",
        revert: "/application/temp/delete",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    },
});

function removeUploaded_TOR() {
    if (TOR_pond) {
        var files = TOR_pond.getFiles();
        if (files.length > 0) {
            TOR_pond.processFiles().then(() => {
                TOR_pond.removeFiles();
                // console.log('Removed');
            });
        }
    }
}

