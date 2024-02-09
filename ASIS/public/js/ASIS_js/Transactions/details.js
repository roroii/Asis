var bpath;

$(document).ready(function() {

    bpath = __basepath + "/";

    $('#btn_print_transaction').on('click', function() {

        var contentToPrint = document.getElementById("contentToPrint");
        var content = contentToPrint.outerHTML;
        var newWindow = window.open();
        newWindow.document.write('<html><head><link rel="stylesheet" href="' + bpath + 'dist/css/app.css" /></head><body>');
        newWindow.document.write(content);
        newWindow.document.write('</body></html>');
        newWindow.document.close();

        // It's generally better to trigger the print operation after a short delay to ensure that the content is fully loaded.
        // You can use setTimeout for this purpose.
        setTimeout(function () {
            newWindow.print();
            newWindow.close(); // Close the window after printing (optional)
        }, 500); // Adjust the delay as needed (e.g., 1000 milliseconds or 1 second)

    });
});
