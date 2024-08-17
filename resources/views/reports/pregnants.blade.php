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
    @if(!empty($pregnants) && $pregnants->count())
    <p class="label">Pregnants:</p>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>LMP</th>
                    <th>EDC</th>
                    <th>GP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pregnants as $p)
              
                <tr>
                    <td> {{ $p->lastname . ' ' . $p->firstname . ' ' .  $p->middlename . ' '. $p->suffix }}</td>
                    <td>{{ $p->lmp }}</td>
                    <td>{{ $p->edc }}</td>
                    <td>{{ $p->gp }}</td>
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