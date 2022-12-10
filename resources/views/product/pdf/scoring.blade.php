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
                @foreach ($product->scorings->groupBy('category') as $grouped)
                    <th>{{ $grouped->first()->category  }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($product->scorings->groupBy('category') as $grouped)
                    <td>
                        @foreach ($grouped as $score)
                            <div class="title">{{ $score->scoring->title }}</div>
                            @foreach ($score->scoring->details as $detail)
                                <div><span class="emoji">
                                    @if(in_array($detail->id,$selected))
                                        ☑
                                    @else
                                        ☐
                                    @endif
                                </span> {{ $detail->text }}</div>
                            @endforeach
                        @endforeach
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach ($product->scorings->groupBy('category') as $grouped)
                    <td>Sub Total {{ $grouped->first()->category  }}: <span class="subtotal">{{ $subTotals[$grouped->first()->category] }}</span></td>
                @endforeach
            </tr>
        </table>
        <div class="total">Total Nilai: <b>{{ $product->score }}</b></div>
    </div>
</body>
</html>
