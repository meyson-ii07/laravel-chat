@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2>{{ $user->name }} Profile</h2>
                <form enctype="multipart/form-data" action="/profile" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px; height:150px; border-radius:50%; margin-right:25px;">
                        <input type="file" name="avatar">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Password confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <input type="submit" class="btn btn-sm btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection
