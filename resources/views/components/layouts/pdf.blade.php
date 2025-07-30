<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Inspection Report' }}</title>
    <style>
        @page {
            margin: 30mm 7mm 40mm 7mm;
            header: page-header;
            footer: page-footer;
        }
        body { font-family: 'dejavusans', 'sans-serif'; font-size: 7pt; color: #333; }
        table { border-collapse: collapse; width: 100%; }
        .bordered, .bordered td, .bordered th { border: 1px solid #333; }
        td, th { padding: 3px; vertical-align: middle; word-wrap: break-word; }
        .bg-grey { background-color: #eeeeee; font-weight: bold; }
        .text-center { text-align: center; }
        h2 { font-size: 13pt; background-color:#ca182c; color:#fff; text-align:center; padding: 5px; margin-bottom: 5px; }
        h3 { text-decoration: underline; font-size: 11pt; text-align: center; margin-top: 15px; margin-bottom: 10px;}
        .page-break { page-break-after: always; }
        .signature { height: 30px; }
        .photo-cell { height: 200px; border: 1px solid #333; padding: 5px; text-align: center; vertical-align: middle; }
        .photo-img { max-width: 100%; max-height: 100%; }
    </style>
</head>
<body>

{{-- Define the header and footer for mPDF --}}
<htmlpageheader name="page-header">
    <x-pdf.header />
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <x-pdf.footer :record="$record" />
</htmlpagefooter>

{{-- This is where the main content of each specific report will go --}}
<main>
    {{ $slot }}
</main>

</body>
</html>
