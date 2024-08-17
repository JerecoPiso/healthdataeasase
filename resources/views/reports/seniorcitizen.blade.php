<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizens</title>
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
    @if(!empty($seniors) && $seniors->count())
    <p class="label">Senior Citizens:</p>
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
                @foreach($seniors as $s)
              
                <tr>
                    <td> {{ $s->lastname . ' ' . $s->firstname . ' ' .  $s->middlename . ' '. $s->suffix }}</td>
                    <td>{{ $s->sex }}</td>
                    <td>{{ $s->birthdate }}</td>
                    <td>{{ $s->civil_status }}</td>
                    <td>{{ $s->educational_attainment }}</td>
                    <td>{{ $s->work }}</td>
                </tr>
          
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No senior citizen found.</p>
    @endif
</body>

</html>