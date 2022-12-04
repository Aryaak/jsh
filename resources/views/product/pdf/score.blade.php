<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Score</title>
    <style>
        .container {
          margin-top: 20vh;
          display: grid;
          grid-template-columns: auto auto auto auto auto;
          grid-gap: 1px;
          /* background-color: coral; */
          padding: 12px;
        }

        .item {
          /* background-color: skyblue; */
          display: flex;
          /* align-items: center; */
          /* justify-content: center; */
          /* font-weight: bold; */
          /* padding: 3em; */
          border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="item" style="justify-content:center; font-weight:bold">Character</div>
        <div class="item" style="justify-content:center; font-weight:bold">Capacity</div>
        <div class="item" style="justify-content:center; font-weight:bold">Capital</div>
        <div class="item" style="justify-content:center; font-weight:bold">Condition</div>
        <div class="item" style="justify-content:center; font-weight:bold">Collateral</div>

        <div class="item">
            @foreach ($scorings->where('category','Character') as $grouped)
                <br>{{ $grouped->title }}
                @foreach ($grouped->details as $detail)
                    <br><span><input type="checkbox">{{ $detail->text }}</span>
                @endforeach
            @endforeach
        </div>
        <div class="item">
            @foreach ($scorings->where('category','Capacity') as $grouped)
                <br>{{ $grouped->title }}
                @foreach ($grouped->details as $detail)
                    <br>{{ $detail->text }}
                @endforeach
            @endforeach
        </div>
        <div class="item">
            @foreach ($scorings->where('category','Capital') as $grouped)
                <br>{{ $grouped->title }}
                @foreach ($grouped->details as $detail)
                    <br>{{ $detail->text }}
                @endforeach
            @endforeach
        </div>
        <div class="item">
            @foreach ($scorings->where('category','Condition') as $grouped)
                <br>{{ $grouped->title }}
                @foreach ($grouped->details as $detail)
                    <br>{{ $detail->text }}
                @endforeach
            @endforeach
        </div>
        <div class="item">
            @foreach ($scorings->where('category','Collateral') as $grouped)
                <br>{{ $grouped->title }}
                @foreach ($grouped->details as $detail)
                    <br>{{ $detail->text }}
                @endforeach
            @endforeach
        </div>
    </div>
</body>
</html>
