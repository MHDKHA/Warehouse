<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>{{ $cert_name }}</title>

    <style>

        @page {

            margin: 30mm 7mm 40mm 7mm; /* Set margins: top, right, bottom, left */

            header: page-header;

            footer: page-footer;

        }

        body { font-family: 'dejavusans', 'sans-serif'; font-size: 7pt; color: #333; }

        table { border-collapse: collapse; width: 100%; }

        .bordered, .bordered td, .bordered th { border: 1px solid #333; }

        td, th { padding: 3px; vertical-align: middle; word-wrap: break-word; }

        .bg-grey { background-color: #eeeeee; font-weight: bold; }

        .text-center { text-align: center; }

        .text-left { text-align: left; }

        .text-right { text-align: right; }

        .text-green { color: green; }

        .text-red { color: red; }

        .text-blue { color: blue; }

        h2 { font-size: 13pt; background-color:#ca182c; color:#fff; text-align:center; padding: 5px; margin-bottom: 5px; }

        h3 { text-decoration: underline; font-size: 11pt; text-align: center; margin-top: 15px; margin-bottom: 10px;}

        .page-break { page-break-after: always; }

        .signature { height: 30px; }

        .disclaimer { font-size: 8px; line-height: 1.4; text-align: justify; padding: 5px 0; }

        .footer-bar { background-color:#ca182c; color:#fff; font-size:9px; font-weight:bold; padding: 4px; text-align: center; }


        /* --- Blade Icon Styles --- */

        .icon-check { width: 10px; height: 10px; }

        .icon-sign { width: 10px; height: 10px; }

        .icon-pass { width: 12px; height: 12px; color: green; }

        .icon-fail { width: 12px; height: 12px; color: red; }

        .icon-na { width: 12px; height: 12px; color: #555; }


        .photo-cell {

            width: 33.33%;

            height: 200px; /* <-- Force a fixed height for every photo container */

            border: 1px solid #333;

            padding: 5px;

            text-align: center;

            vertical-align: middle;

        }

        .photo-img {

            max-width: 100%; /*<-- Ensure image doesn't overflow width */

            max-height: 100%; /*<-- Ensure image doesn't overflow height */

            height: auto;

            width: auto;

        }

    </style>

</head>

<body>


@include('pdf.partials._header-block')



<x-pdf.footer-block :record="$record" :isDraft="$isDraft" />

<main>

    <h2>CROWN BLOCK INSPECTION REPORT</h2>

    <table class="bordered" style="font-size: 6.5pt;">

        <tbody>

        <tr>

            <td width="12%" class="bg-grey">Certificate No:</td>

            <td width="20%">{{ $cert_name }}</td>

            <td width="15%" class="bg-grey">Client Name:</td>

            <td width="22%">{{ $record->customer->name ?? 'N/A' }}</td>

            <td width="15%" class="bg-grey">Work Location:</td>

            <td width="16%">{{ $record->work_location }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Work Order No:</td>

            <td>{{ $record->workOrder->first()->wo_name ?? $record->wo_id }}</td>

            <td class="bg-grey">Inspection Date:</td>

            <td>{{ \Carbon\Carbon::parse($record->test_date)->format('F j, Y') }}</td>

            <td class="bg-grey">Next Inspection:</td>

            <td>{{ $record->status == '1' && $record->next_test_date ? \Carbon\Carbon::parse($record->next_test_date)->format('F j, Y') : 'N/A' }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Specification:</td>

            <td>

                @if($record->standard_type_api == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> API: {{ $record->standard_name_api }} @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> API: @endif <br>

                @if($record->standard_type_astm == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> ASTM: {{ $record->standard_name_astm }} @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> ASTM: @endif

            </td>

            <td class="bg-grey">Insp. Method:</td>

            <td>

                @if($record->inspection_method == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> Visible @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> Visible @endif

                @if($record->inspection_method == 2) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> Flourescent @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> Flourescent @endif

            </td>

            <td class="bg-grey">MPI Type:</td>

            <td>

                @if($record->mpi_type == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> Wet @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> Wet @endif

                @if($record->mpi_type == 2) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> Dry @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> Dry @endif

            </td>

        </tr>

        <tr>

            <td class="bg-grey">Magnetization Eq:</td>

            <td>

                @if($record->mg_eq_used == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> AC @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> AC @endif

                @if($record->mg_eq_used == 2) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> DC @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> DC @endif

                @if($record->mg_eq_used == 3) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> Permanent @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> Permanent @endif

            </td>

            <td class="bg-grey">Manufacturer:</td>

            <td>{{ $record->mg_eq_manuf }}</td>

            <td class="bg-grey">Magnet No:</td>

            <td>{{ $record->magnet_no }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Cal. Test Weight:</td>

            <td>

                @if($record->cal_test_weight == 1) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> 40 LBS @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> 40 LBS @endif

                @if($record->cal_test_weight == 2) <img src="{{storage_path('app/public/img/checkNew.png') }}"style="height:12px;"> 10 LBS @else <img src="{{storage_path('app/public/img/square.png')}}"style="height:10px;"> 10 LBS @endif

            </td>

            <td class="bg-grey">Pole Spacing:</td>

            <td>{{ $record->pole_spacing }}-150mm</td>

            <td class="bg-grey">Light Intensity:</td>

            <td>{{ $record->light_intensity_value }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Surface Condition:</td>

            <td>{{ $record->surface_condition }}</td>

            <td class="bg-grey">Temperature:</td>

            <td>{{ $record->temprature }} C</td>

            <td class="bg-grey">Light Meter No:</td>

            <td>{{ $record->light_meter_no }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Contrast Media:</td>

            <td>{{ $record->contrast_media }}</td>

            <td class="bg-grey">Batch No:</td>

            <td>{{ $record->contrast_media_batch }}</td>

            <td class="bg-grey">Manufacturer:</td>

            <td colspan="1">{{ $record->contrast_media_manuf }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Indicator:</td>

            <td>{{ $record->indicator }}</td>

            <td class="bg-grey">Batch No:</td>

            <td>{{ $record->indicator_batch }}</td>

            <td class="bg-grey">Manufacturer:</td>

            <td colspan="1">{{ $record->indicator_manuf }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Description:</td>

            <td colspan="5">{{ $record->description }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Manufacturer:</td>

            <td>{{ $record->manufacturer }}</td>

            <td class="bg-grey">Manuf. Date:</td>

            <td>{{ \Carbon\Carbon::parse($record->manuf_date)->format('F j, Y') }}</td>

            <td class="bg-grey">Model:</td>

            <td>{{ $record->model }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Sheaves OD:</td>

            <td>{{ $record->sheaves_od }} mm</td>

            <td class="bg-grey">Drill Line Dia.:</td>

            <td>{{ $record->drill_line_dia }} mm</td>

            <td class="bg-grey">Rated Loading:</td>

            <td>{{ $record->rated_loading }} KN</td>

        </tr>

        <tr>

            <td class="bg-grey">Equipment No:</td>

            <td>{{ $record->equipment_no }}</td>

            <td class="bg-grey">F/L Sheave SN:</td>

            <td>{{ $record->fl_sheave_sn }}</td>

            <td class="bg-grey">Sand-Line Sheave SN:</td>

            <td>{{ $record->sand_line_sheave_sn ?? 'N/A' }}</td>

        </tr>

        <tr>

            <td class="bg-grey">Cluster Sheaves SN:</td>

            <td colspan="5">{{ $record->cluster_sheaves_sn }}</td>

        </tr>

        </tbody>

    </table>

    <br>

    <table>

        <tr>

            <td style="border:none; width: 50%; text-align:center;">

                <img src="{{ storage_path('app/public/images/crown.jpeg') }}" style="height:200px; border:1px solid #000;">

            </td>

            <td style="border:none; width: 50%; text-align:center;">

                @if($record->crown_photo && file_exists(storage_path('app/public/' . $record->crown_photo)))

                    <img src="{{ storage_path('app/public/' . $record->crown_photo) }}" style="height:200px; border:1px solid #000;">

                @else

                    <div style="height:200px; border:1px solid #000; padding-top: 90px; text-align:center;">Photo Not Available</div>

                @endif

            </td>

        </tr>

    </table>

    <br>

    <table class="bordered">

        <tr>

            <td width="50%">

                <b class="text-blue">Dimensional Result:</b>

                <p>{!! $record->status == '1' ? str_replace('(ACCEPTED)', '<span class="text-green">(ACCEPTED)</span>', $record->dim_results) : str_replace('(REJECTED)', '<span class="text-red">(REJECTED)</span>', $record->dim_results) !!}</p>

            </td>

            <td width="50%">

                <b class="text-blue">MPI Result:</b>

                <p>{!! $record->status == '1' ? str_replace('(ACCEPTED)', '<span class="text-green">(ACCEPTED)</span>', $record->mpi_results) : str_replace('(REJECTED)', '<span class="text-red">(REJECTED)</span>', $record->mpi_results) !!}</p>

            </td>

        </tr>

    </table>

</main>


<div class="page-break"></div>


<h2>CROWN BLOCK INSPECTION REPORT</h2>

<br>

<h1 class="text-center">INSPECTION CHECKLIST</h1>

<br>

<table class="bordered mb-14" >

    <thead>

    <tr>

        <th width="70%">Checklist Items</th>

        <th width="10%" class="text-right text-green">ACCEPTED</th>

        <th width="10%" class="text-right text-red">REJECT</th>

        <th width="10%" class="text-right">N/A</th>

    </tr>

    </thead>

    <tbody>

    @foreach($record->checklist->details as $detail)

        <tr class="mt-10">

            <td>{{ $loop->iteration }} - {{\App\Models\ChecklistDetail::find($detail->checklist_item_id)->item_title ?? 'Item not found' }}</td>

            <td class="text-center">@if($detail->pass_fail == 1) @svg('heroicon-s-check-circle', 'icon-pass') @endif</td>

            <td class="text-center">@if($detail->pass_fail == 2) @svg('heroicon-s-x-circle', 'icon-fail') @endif</td>

            <td class="text-center">@if($detail->pass_fail == 0) @svg('heroicon-s-minus-circle', 'icon-neutral') @endif</td>

        </tr>

    @endforeach

    </tbody>

</table>

<br><br><br>

<table>

    <tr>

        <th width="15%" class="text-center text-green">Accept <br> Rope Dia.+2.5% <br> Max.</th>

        <th width="15%" class="text-center text-red">Reject<br> More than Rope Dia.+ 2.5%</th>

        <th width="35%" class="text-center">Cluster Sheaves Wear<br> Check Photograph</th>

        <th width="35%" class="text-center">Fast Line Sheave Wear<br>Check Photograph</th>

    </tr>

    <tr>

        <td class="text-center">

            <img src="{{ storage_path('app/public/images/sheaves_groove.jpeg') }}" style="height:200px; width: 20%"/>


        </td>

        <td class="text-center">


            <img src="{{storage_path('app/public/images/sheaves_groove.jpeg') }}" style="height:200px; width: 20%"/>


        </td>

        <td class="text-center">

            @if($record->cluster_wear_photo && file_exists(storage_path('app/public/' . $record->cluster_wear_photo)))

                <img src="{{ storage_path('app/public/' . $record->cluster_wear_photo) }}" style="height:200px; width: 30%; border:1px solid #000;">

            @else

                <div style="height:200px; border:1px solid #000; padding-top: 90px; text-align:center;">Photo Not Available</div>

            @endif

        </td>

        <td class="text-center">

            @if($record->fast_line_wear_photo && file_exists(storage_path('app/public/' . $record->fast_line_wear_photo)))

                <img src="{{ storage_path('app/public/' . $record->fast_line_wear_photo) }}" style="height:200px; width: 30%; border:1px solid #000;">

            @else

                <div style="height:200px; border:1px solid #000; padding-top: 90px; text-align:center;">Photo Not Available</div>

            @endif

        </td>

    </tr>

</table>



<div class="page-break"></div>

<h2>CROWN BLOCK INSPECTION REPORT</h2>

<br>

<h1 class="text-center">GROOVE DEPTH MEASUREMENTS</h1>

<br>

@php

    $cluster_min = (float)$record->drill_line_dia * 1.33;

    $cluster_max = (float)$record->drill_line_dia * 1.75;

@endphp

<table>

    <tr>

        <td style="border: none;" width="40%"><b style="text-decoration: underline;">Cluster Sheaves Min. Groove Depth</b></td>

        <td class="bordered" width="10%">{{ number_format($cluster_min, 2) }} mm</td>

        <td style="border: none;" width="40%" class="text-right"><b style="text-decoration: underline;">Max. Groove Depth</b></td>

        <td class="bordered" width="10%">{{ number_format($cluster_max, 2) }} mm</td>

    </tr>

    <tr>

        <td style="border: none;" width="40%"><b style="text-decoration: underline;">Fast Line Sheave Min. Groove Depth</b></td>

        <td class="bordered" width="10%">{{ number_format($cluster_min, 2) }} mm</td>

        <td style="border: none;" width="40%" class="text-right"><b style="text-decoration: underline;">Max. Groove Depth</b></td>

        <td class="bordered" width="10%">{{ number_format($cluster_max, 2) }} mm</td>

    </tr>

</table>

<br><br><br>

<table class="bordered">

    <thead>

    <tr>

        <th>Cluster Sheaves<br> Serial No</th>

        <th>Nominal Wire<br>Rope Diameter</th>

        <th>Groove Depth<br> Point (A)</th>

        <th>Groove Depth<br> Point (B)</th>

        <th>Groove Depth<br> Point (C)</th>

        <th>Groove Depth<br> Point (D)</th>

        <th><span class="text-green">Pass</span>/<span class="text-red">Fail</span></th>

    </tr>

    </thead>

    <tbody>

    @forelse($record->clusterReadings as $reading)

        <tr>

            <td class="text-center">{{ $reading->cluster_sn }}</td>

            <td class="text-center">{{ $record->drill_line_dia }} mm</td>

            <td class="text-center">{{ $reading->groove_a }} mm</td>

            <td class="text-center">{{ $reading->groove_b }} mm</td>

            <td class="text-center">{{ $reading->groove_c }} mm</td>

            <td class="text-center">{{ $reading->groove_d }} mm</td>

            <td class="text-center @if($reading->pass_fail == 1) text-green @else text-red @endif">

                {{ $reading->pass_fail == 1 ? 'Pass' : 'Fail' }}

            </td>

        </tr>

    @empty

        <tr><td colspan="7" class="text-center">No cluster readings found.</td></tr>

    @endforelse

    </tbody>

</table>

<br>

@if($record->fastLineReading)

    <table class="bordered">

        <thead>

        <tr>

            <th>Fast Line Sheave<br> Serial No</th>

            <th>Nominal Wire<br>Rope Diameter</th>

            <th>Groove Depth<br> Point (A)</th>

            <th>Groove Depth<br> Point (B)</th>

            <th>Groove Depth<br> Point (C)</th>

            <th>Groove Depth<br> Point (D)</th>

            <th><span class="text-green">Pass</span>/<span class="text-red">Fail</span></th>

        </tr>

        </thead>

        <tbody>

        <tr>

            <td class="text-center">{{ $record->fastLineReading->fast_line_sn }}</td>

            <td class="text-center">{{ $record->drill_line_dia }} mm</td>

            <td class="text-center">{{ $record->fastLineReading->groove_a }} mm</td>

            <td class="text-center">{{ $record->fastLineReading->groove_b }} mm</td>

            <td class="text-center">{{ $record->fastLineReading->groove_c }} mm</td>

            <td class="text-center">{{ $record->fastLineReading->groove_d }} mm</td>

            <td class="text-center @if($record->fastLineReading->pass_fail == 1) text-green @else text-red @endif">

                {{ $record->fastLineReading->pass_fail == 1 ? 'Pass' : 'Fail' }}

            </td>

        </tr>

        </tbody>

    </table>

@endif

<br>

<table>

    <tr>

        <td width="10%" class="text-center text-blue" rowspan="2" style="vertical-align: middle;">Cluster<br>Sheaves<br>Depth Check</td>

        <td width="40%" class="text-center">

            <img src="{{storage_path('app/public/images/cluster_sheaves.jpeg') }}" style="height:150px;"/>

        </td>

        <td width="10%" class="text-center text-blue" rowspan="2" style="vertical-align: middle;">Fast Line<br>Sheave<br>Depth Check</td>

        <td width="40%" class="text-center">

            <img src="{{ storage_path('app/public/images/cluster_sheaves.jpeg') }}" style="height:150px;"/>

        </td>

    </tr>

    <tr>

        <td class="text-center">

            <b>Cluster Sheaves Groove Depth Check Photo</b><br>

            @if($record->cluster_photo && file_exists(storage_path('app/public/' . $record->cluster_photo)))

                <img src="{{ storage_path('app/public/' . $record->cluster_photo) }}" style="height:150px; border:1px solid #000;">

            @else

                <div style="height:150px; border:1px solid #000; padding-top: 60px; text-align:center;">Photo Not Available</div>

            @endif

        </td>

        <td class="text-center">

            <b>Fast Line Sheave Groove Depth Check Photo</b><br>

            @if($record->fast_line_photo && file_exists(storage_path('app/public/' . $record->fast_line_photo)))

                <img src="{{ storage_path('app/public/' . $record->fast_line_photo) }}" style="height:150px; border:1px solid #000;">

            @else

                <div style="height:150px; border:1px solid #000; padding-top: 60px; text-align:center;">Photo Not Available</div>

            @endif

        </td>

    </tr>

</table>

<div class="page-break"></div>

{{-- This is the main Photo Annex section --}}

@if($record->photos->isNotEmpty())


    @foreach($record->photos->chunk(12) as $photosOnPage)


        @if(!$loop->first)

            <div class="page-break"></div>

        @endif


        <h2>CROWN BLOCK INSPECTION REPORT</h2>

        <h3 class="text-left" style="text-align: left; text-decoration: underline; font-size: 11pt;">

            ANNEX TO CROWN BLOCK INSPECTION REPORT NO: {{ $cert_name }}

        </h3>

        <br>


        <table style="width: 100%; border-collapse: separate; border-spacing: 10px;">

            @foreach($photosOnPage->chunk(3) as $row)

                <tr>

                    @foreach($row as $photo)

                        {{-- This is the updated table cell with the fixed height --}}

                        <td class="photo-cell">

                            @if($photo->file_name && file_exists(storage_path('app/public/' . $photo->file_name)))

                                <img src="{{ storage_path('app/public/' . $photo->file_name) }}" class="photo-img">

                            @else

                                <div>Photo Not Found</div>

                            @endif

                        </td>

                    @endforeach


                    {{-- This part fills empty cells if the last row isn't full --}}

                    @if($row->count() < 3)

                        @for($i = 0; $i < (3 - $row->count()); $i++)

                            <td style="width: 33.33%; border: none;"></td>

                        @endfor

                    @endif

                </tr>

            @endforeach

        </table>


    @endforeach

@endif


</body>

</html>

