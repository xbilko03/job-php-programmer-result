<!DOCTYPE html>

@extends('menuLayout')

@section('name')
	<h1>Customer Group System</h1>
@endsection
@section('description')
	<h2> Description </h2>
	<p>Simple application that manipulates Customers and Groups with various tools <br>(Made in Laravel)</p>
@endsection
@section('action')
	<p><a href="/{{$toolActive}}" type="button"> demo </a> </p>
@endsection
@section('author')
	<h2> Author </h2>
	<p>Jozef Bilko</p>
@endsection
@section('date')
	<h2> Last Updated </h2>
	<p>6/6/2022</p>
@endsection

</html>
