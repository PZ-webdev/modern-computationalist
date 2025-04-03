<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        @page {
            margin: 5mm;
        }

        body {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 10px;
            white-space: pre-wrap;
        }

        h1 {
            margin-left: 35mm;
            margin-bottom: -5mm;
        }

        h3 {
            margin-left: 35mm;
        }

        .page-break {
            page-break-after: always;
        }

        .first-page-inner {
            margin-top: -47mm;
            margin-left: 22mm;
            font-size: 12px;
            line-height: 1.2;
        }
    </style>
</head>
<body>
{!! $content !!}
</body>
</html>
