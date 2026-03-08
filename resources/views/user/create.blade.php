@extends('layouts.app')
@section('title', 'Create User')

@section('css')
@endsection

@section('content')

  <h2>Create User</h2>

  <form action="{{ route('users.store') }}" method="POST">

    @csrf

    <label>Name</label>
    <br>
    <input type="text" name="name">

    <br><br>

    <label>Email</label>
    <br>
    <input type="email" name="email">

    <br><br>

    <button type="submit">Save</button>

  </form>

  <br>

  <a href="{{ route('user.index') }}">Back</a>

@endsection
