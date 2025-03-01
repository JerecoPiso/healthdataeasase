<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report By Category</title>
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
    @if(!empty($members) && $members->count())
    <p class="label" style="text-align: center">{{$category . ' ( ' . $value . ' )'}}:</p>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Civil Status</th>
                    <th>Educational Attainment</th>
                    <th>Work</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                <tr>
                    <td> {{ $m->lastname . ' ' . $m->firstname . ' ' .  $m->middlename . ' '. $m->suffix }}</td>
                    <td>{{ $m->sex }}</td>
                    <td>{{ $m->birthdate }}</td>
                    <td>{{ $m->civil_status }}</td>
                    <td>{{ $m->educational_attainment }}</td>
                    <td>{{ $m->work }}</td>
                </tr>
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
</body>

</html>