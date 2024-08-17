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
    <p class="label">Households:</p>
    <div>
        <table>
            <thead>
                <tr>
                    <th>House #</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Civil Status</th>
                    <th>Height</th>
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profiles as $p)
                @if($p->household_profile_id !== $previousHouseholdNumber)
                @php
                // Count the number of profiles with the same household_number
                $rowspanCount = $profiles->where('household_profile_id', $p->household_profile_id)->count();
                $previousHouseholdNumber = $p->household_profile_id;
                @endphp
                <tr>
                    <td rowspan="{{ $rowspanCount }}" style="width: 10em;">{{ $p->household_number }}</td>
                    <td> @if($p->id == $p->personal_profile_id) <span class="household-head">(HEAD)</span> @endif {{ $p->firstname . ' ' . $p->middlename . ' ' .  $p->lastname . ' '. $p->suffix }}</td>
                    <td>{{ $p->sex }}</td>
                    <td>{{ $p->birthdate }}</td>
                    <td>{{ $p->civil_status }}</td>
                    <td>{{ $p->height }}</td>
                    <td>{{ $p->weight }}</td>
                </tr>
                @else
                <tr>
                    <td> {{ $p->firstname . ' ' . $p->middlename . ' ' .  $p->lastname . ' '. $p->suffix }}</td>
                    <td>{{ $p->sex }}</td>
                    <td>{{ $p->birthdate }}</td>
                    <td>{{ $p->civil_status }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No households found.</p>
    @endif
</body>

</html>