<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Households</title>
    <link rel="stylesheet" href="{{ $css_path }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> -->
</head>
<style>
    @page {
        size: landscape;
        repeat-header: false
    }
</style>

<body>
    <div class="header">
        <div class="header-logo">
            <img src="{{ $img_path }}" alt="Sta Fe" class="logo">
        </div>
        <div class="header-title">
            <p>HEALTH DATA EASE <br /> STA. FE LEYTE</p>
        </div>
        <div class="header-logo">
            <img src="{{ $img_path }}" alt="Sta Fe" class="logo">
        </div>
    </div>
    <p class="center">REGISTRY OF BARANGAY INHABITANTS BY HOUSEHOLD</p>
    <div style="margin-top: 30px">
        <div style="display: inline-block;
    vertical-align: middle;">
            <table style="width: 40%;">
                <tbody>
                    <tr>
                        <td style="width: 20px">A.REGION</td>
                        <td style="width: 180px;">VIII</td>
                        <td style="width: 100px;"></td>

                    </tr>
                    <tr>
                        <td>B.PROVINCE</td>
                        <td>LEYTE</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>C.CITY/MUNICIPALITY</td>
                        <td>STA. FE</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>D.BARANGAY</td>
                        <td>CABANGCALAN</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="display: inline-block;
    vertical-align: middle;padding-left: 20%">
            <div style="display: inline-block;
    vertical-align: middle;" ><label for="">DATE ACCOMPLISHED: </label> <input type="text" style="padding: 15px;margin-bottom: -10px"></div>
        </div>
    </div>

    <!-- <div class="header">
        <div class="header-logo">
            <img src="{{ asset('images/stafe.png') }}" alt="Sta Fe" class="logo">
        </div>
        <div class="header-title">
            <p>HEALTH DATA EASE <br /> STA. FE LEYTE</p>
        </div>
        <div class="header-logo">
            <img src="{{ asset('images/stafe.png') }}" alt="Sta Fe" class="logo">
        </div>
    </div> -->
    @php
    $previousHouseholdNumber = null;
    $rowspanCount = 0;
    @endphp
    @if(!empty($profiles) && $profiles->count())
    <!-- <p class="label " style="text-align: center">Households: ({{$purok}})</p> -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>Household Number (1)</th>
                    <th>Lastname (2.1)</th>
                    <th>Firstname (2.2)</th>
                    <th>Middlename (2.3)</th>
                    <th style="width: 32px;">Name of Subdivision (Zone/Purok) (3)</th>
                    <th>Birthdate (4)</th>
                    <th>Age (5)</th>
                    <th>Gender (6)</th>

                    <th>Civil Status (7)</th>
                    <th>Occupation (8)</th>

                </tr>
            </thead>
            <tbody>
                @foreach($profiles as $p)
                @if($p->household_profile_id !== $previousHouseholdNumber)
                @php
                // Count the number of profiles with the same household_profile_id
                $rowspanCount = $profiles->where('household_profile_id', $p->household_profile_id)->count();
                $previousHouseholdNumber = $p->household_profile_id;
                @endphp
                <tr>
                    <td style="width: 10em;">{{ $p->household_number }}</td>
                    <td>@if($p->id == $p->personal_profile_id) <span class="household-head">(HEAD)</span> @endif {{ $p->lastname . ' ' . $p->suffix }}</td>
                    <td>{{ $p->firstname }}</td>

                    <td> {{ $p->middlename }}</td>
                    <td> {{ $p->purok_name }}</td>
                    <td>{{ $p->birthdate }}</td>
                    <td>{{ $p->age }}</td>
                    <td>{{ $p->sex }}</td>

                    <td>{{ $p->civil_status }}</td>
                    <td>{{ $p->work }}</td>

                </tr>
                @else
                <tr>
                    <td style="width: 10em;">{{ $p->household_number }}</td>
                    <td>@if($p->id == $p->personal_profile_id) <span class="household-head">(HEAD)</span> @endif {{ $p->lastname . ' ' . $p->suffix }}</td>
                    <td>{{ $p->firstname }}</td>
                    <td> {{ $p->middlename }}</td>
                    <td> {{ $p->purok_name }}</td>
                    <td>{{ $p->birthdate }}</td>
                    <td>{{ $p->age }}</td>

                    <td>{{ $p->sex }}</td>
                    <td>{{ $p->civil_status }}</td>
                    <td>{{ $p->work }}</td>

                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <p style="margin-top: 20px;">
        <strong>As of:</strong> {{ \Carbon\Carbon::now()->format('F j, Y g:i a') }}
    </p>
    @else

    <p style="text-align: center">No result found.</p>
    @endif
    <div class="flex-container">
        <div class="flex-item">
            <label for="">Prepared by:</label>
            <p class="line"></p>
            <p class="center"><i>Household Head/Member</i></p>
            <p class="center"><i>Signature Over Printed Name</i></p>

        </div>
        <div class="flex-item">
            <label for="">Certified by:</label>
            <p class="line"></p>
            <p class="center"><i>Barangay Health Worker</i></p>
            <p class="center"><i>Signature Over Printed Name</i></p>

        </div>
        <div class="flex-item">
            <label for="">Validated by:</label>
            <p class="line"></p>
            <p class="center"><i>Punong Barangay</i></p>
            <p class="center"><i>Signature Over Printed Name</i></p>

        </div>
    </div>
</body>

</html>