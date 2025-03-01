<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Below 18 Underweight</title>
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
    @if(!empty($underweight) && $underweight->count())
    <p class="label" style="text-align: center">Underweight: ({{$purok}})</p>
    <div>
        <table>
            <thead>
                <tr>

                    <th>Name</th>
                    <th>Age</th>
                    <th>BMI</th>

                    <th>Gender</th>
                    <th>Birthdate</th>


                </tr>
            </thead>
            <tbody>
                @foreach($underweight as $u)

                <tr>
                    <td> {{ $u->lastname . ' ' . $u->firstname . ' ' .  $u->middlename . ' '. $u->suffix }}</td>
                    <td>{{ $u->age }}</td>

                    <td>{{ $u->bmi }}</td>

                    <td>{{ $u->sex }}</td>
                    <td>{{ $u->birthdate }}</td>

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