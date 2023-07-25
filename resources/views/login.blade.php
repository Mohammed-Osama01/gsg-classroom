<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="text-center">Welcom Login</h1>
    {{-- @dump($errors)
    @dump($errors->any())
    @dump($errors->all()) --}}

    @include('errors')

    <form method="post" action="{{ route('login') }}" class="container mt-5">
        @csrf
        <div class="mb-3">
            <label for="exampleInputName" class="form-label">email</label>
            <input type="text" name="email" class="form-control w-25 @error('email') is-invalid @enderror" id="exampleInputEmail1"
                aria-describedby="emailHelp">
            @error('email')
            <small class="invalid-feedback">{{ $message }} </small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control w-25 @error('password') is-invalid @enderror" id="exampleInputEmail1"
                aria-describedby="emailHelp">
            @error('password')
            <small class="invalid-feedback">{{ $message }} </small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</body>

</html>
