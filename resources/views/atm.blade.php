<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test ATM</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="container">
        <h1>ATM</h1>
        @if ($errors->any())
            <h3>Errors</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="validation-error-item">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h3>Available Notes</h3>
        <ul>
            @foreach ($notes as $note)
                <li>{{ $note->value }} THB: {{ $note->amount }}</li>
            @endforeach
        </ul>

        @if (session('notesList'))
            <h3>Deducted Notes</h3>
            <ul>
                @foreach (session('notesList') as $note)
                    <li>{{ $note['note'] }} THB: {{$note['deduct']}}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('withdraw') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Withdraw Amount</label>
                <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</div>
</body>
</html>

