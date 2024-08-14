<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        font-size: 12px;
        font-family: Arial, sans-serif;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    .head{
        color: green;
    }
    .title{
        font-size: 1.2em;
        margin-top: 0em;
        text-align: center;
    }
    .logo{
        width: 18em;
        display: block;
        margin: auto;
    }
</style>

<body>
    
    <img src="{{ asset('images/stafe.png') }}" alt="Sta fe" class="logo">
    <!-- <p class="title">STA. FE LEYTE</p> -->
    @php
    $previousHouseholdNumber = null;
    $rowspanCount = 0;
    @endphp

    @if(!empty($profiles) && $profiles->count())
    <div>
        <table>
            <thead>
                <tr>
                    <th>House #</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Civil Status</th>
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
                        <td>  @if($p->id == $p->personal_profile_id) <span class="head">(HEAD)</span> @endif {{ $p->firstname . ' ' . $p->middlename . ' ' .  $p->lastname . ' '. $p->suffix }}</td>
                        <td>{{ $p->sex }}</td>
                        <td>{{ $p->birthdate }}</td>
                        <td>{{ $p->civil_status }}</td>
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