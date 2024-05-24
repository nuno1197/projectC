<!-- resources/views/pdf_layout.blade.php -->
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
        <td>Game:</td>
        <td>Date:</td>
        <td>Local:</td>
    </tr>
</table>

<table>
    <tr>
        <th>Nº</th>
        <th>Athlete</th>
        <th colspan="3">1st Quarter</th>
        <th colspan="3">2nd Quarter</th>
    </tr>
    <tr>
        <th>00</th>
        <td>NameAthlete</td>
        <th>Nº</th>
        <th>Athlete</th>
        <th>Function</th>
        <th>Nº</th>
        <th>Athlete</th>
        <th>Function</th>
    </tr>
    <!-- Repeat for each athlete -->
    @for ($i = 0; $i < 8; $i++)
        <tr>
            <th>00</th>
            <td>NameAthlete</td>
            <th>00</th>
            <td>NameAthlete</td>
            <td>00</td>
            <th>00</th>
            <td>NameAthlete</td>
            <td>00</td>
        </tr>
    @endfor
</table>

<table>
    <tr>
        <td><img src="path/to/court_diagram.png" class="court-diagram"></td>
        <td><img src="path/to/court_diagram.png" class="court-diagram"></td>
    </tr>
</table>

<div>
    <h4>OFFENSIVE KEYS:</h4>
    <p style="border: 1px solid black; height: 100px;"></p>
</div>

<div>
    <h4>DEFENSIVE KEYS:</h4>
    <p style="border: 1px solid black; height: 100px;"></p>
</div>

<div class="notes">
    <h4>NOTES:</h4>
    <p style="border: 1px solid black; height: 50px;"></p>
</div>
</body>
</html>
