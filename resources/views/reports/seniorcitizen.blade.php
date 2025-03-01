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
    <p class="label" style="text-align: center">Senior Citizens: ({{$purok}})</p>
    <div>
        <table>
            <thead>
                <tr>
               
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
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
                    <td>{{ $s->age }}</td>
                    <td>{{ $s->birthdate }}</td>
                    <td>{{ $s->civil_status }}</td>
                    <td>{{ $s->educational_attainment }}</td>
                    <td>{{ $s->work }}</td>
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