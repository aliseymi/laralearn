@extends('profile.layout')

@section('main')
    <h4>Two Factor Auth :</h4>
    <hr>

    @if($errors->any())

        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <label for="type" class="col-form-label">type</label>

            <select name="type" id="type" class="form-control">
                @foreach(config('twofactor.types') as $key => $name)
                    <option value="{{$key}}" {{old('type') == $key || auth()->user()->hasTwoFactor($key) == $key ? 'selected' : ''}}>{{$name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="phone" class="col-form-label">phone</label>

            <input class="form-control" type="text" name="phone" id="phone" placeholder="please enter your phone"
                   value="{{old('phone') ?? auth()->user()->phone_number}}">
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-success">Update</button>
        </div>
    </form>
@endsection
