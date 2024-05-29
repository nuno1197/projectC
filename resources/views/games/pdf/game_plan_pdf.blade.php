<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .header-table td {
            border: none;
        }
        .court-diagram {
            width: 150px;
            height: auto;
        }
        .notes {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<table class="header-table">
    <tr>
        <td>Game: {{$game->opp_name}}</td>
        <td>Date: {{\Carbon\Carbon::parse($game->start_date)->format('Y-m-d H:i')}}</td>
        <td>Local: {{$game->local}}</td>
    </tr>
</table>

<table>
    <tr>
        <th>Nº</th>
        <th>Athlete</th>
        <th>Position</th>
    </tr>
    @foreach($players as $player )
    <tr>
        <th>{{$player->jersey_number}}</th>
        <td>{{$player->name}}</td>
        <td>{{$player->position}}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('resources/images/pdf/halfcourt.png'))); ?>" class="court-diagram" alt="halfcourt"></td>
        <td><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('resources/images/pdf/fullcourt.png'))); ?>" class="court-diagram" alt="fullcourt"></td>
    </tr>
</table>

<div>
    <h4>OFFENSIVE KEYS:</h4>
    <p style="border: 1px solid black; height: 100px;">{{$game->off_keys}}</p>
</div>

<div>
    <h4>DEFENSIVE KEYS:</h4>
    <p style="border: 1px solid black; height: 100px;">{{$game->def_keys}}</p>
</div>

<div class="notes">
    <h4>NOTES:</h4>
    <p style="border: 1px solid black; height: 50px;">{{$game->notes}}</p>
</div>
</body>
</html>
