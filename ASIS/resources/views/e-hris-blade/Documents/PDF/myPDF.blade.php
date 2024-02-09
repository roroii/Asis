<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
</head>
<body>

<!-- Define header and footer blocks before your content -->
    <div class = "information">
        <img src="data:image/png;base64, {!! $qrcode !!}">

        <div
            style="font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-size: 10px;
            margin-top: .75rem;">
            Tap to QRCODE Reader
        </div>

        <div
            style="font-family: Arial, Helvetica, sans-serif;
            font-style: italic;
            font-size: 10px;
            margin-top: .25rem;"
        >
            System Generated QR
        </div>

        <div
            style="font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-size: 10px;
            margin-top: .25rem;"
            >
            {{ $date_generated }}
        </div>
    </div>

</body>
</html>

