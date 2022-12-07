<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Scoring</title>
    <style>
        .container {
            display:flex;
            align-items:center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table tr th, table tr td {
            border: 1px solid black;
            width: 20%;
            padding: 10px;
        }

        table tr td {
            vertical-align: top;
        }

        .title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .emoji {
            font-family: "DejaVu Sans", sans-serif;
        }

        div + .title {
            margin-top: 15px
        }

        .subtotal {
            font-weight: bold;
            float: right;
        }

        .total {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>Character</th>
                <th>Capacity</th>
                <th>Capital</th>
                <th>Condition</th>
                <th>Collateral</th>
            </tr>
            <tr>
                <td>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                </td>
                <td>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                </td>
                <td>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                </td>
                <td>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                </td>
                <td>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div class="title">Tes Judul</div>
                    <div><span class="emoji">☐</span> Tes</div>
                    <div><span class="emoji">☑</span> Tes</div>
                    <div><span class="emoji">☐</span> Tes</div>
                </td>
            </tr>
            <tr>
                <td>Sub Total Character: <span class="subtotal">10</span></td>
                <td>Sub Total Capacity: <span class="subtotal">8</span></td>
                <td>Sub Total Capital: <span class="subtotal">6</span></td>
                <td>Sub Total Condition: <span class="subtotal">7</span></td>
                <td>Sub Total Collateral: <span class="subtotal">3</span></td>
            </tr>
        </table>
        <div class="total">Total Nilai: <b>35</b></div>
    </div>
</body>
</html>
