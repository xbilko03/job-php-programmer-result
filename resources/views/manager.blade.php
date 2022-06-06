<!DOCTYPE html>

@extends('managerLayout')
@section('tools')
	<div class="managerBody">
  		<div class="left">
		<h1>Tools</h1>
			@foreach ($toolList as $toolName)
				<p><a href="/{{ $toolName }}" type="button"> {{ $toolName }} </a></p>
			@endforeach
			<h2> {{$toolActive}} </h2>
			@foreach ($tool as $toolName)
				<p><a href="/{{$toolActive}}/{{$toolName}}" type="button"> {{ $toolName }} </a> </p>
			@endforeach
	
		<h2> {{$actionActive}} </h2>
			@foreach ($action as $actionName)
				@if(
				$actionName == 'Add' || 
				$actionName == 'Remove' || 
				$actionName == 'Subtract' || 
				$actionName == 'Find')
					<button type="submit">{{ $actionName }}</button>
				@else
					<p><label name="name" id="name">{{ $actionName }}</label> </p>
					<form method="POST" action="/{{$toolActive}}/{{$actionActive}}/action">
					@csrf
					<p><input type="text" name="{{$actionName}}" id="{{$actionName}}" required> </p>
				@endif
			@endforeach
			@if($errors->any())
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			@endif
  	</div>

@endsection
@section('tables')
		<div class="right">
		<h3>Customers</h3>
			<table class="center">
			<tr>
			<th> ID </th>
			<th> Name </th>
			<th> Balance </th>
			<th> Groups </th>
			</tr>
			@foreach ($customers as $customer)
		
				<tr> 
				<td style="text-align:center"> {{ $customer->id }} </td>
				<td style="text-align:center"> {{ $customer->name }} </td>
				<td style="text-align:center"> {{ $customer->balance }} </td>
				<td style="text-align:center">
				@foreach ($customers_groups_relation as $customerRel)
					@if ($customerRel['customer_id'] == $customer->id)
						{{ $customerRel['groups_id'] }}
					@endif
				@endforeach
				</td>
				</tr>
			@endforeach
			</table>
		<h3>Groups</h3>
			<table class = "center">
			<tr>
			<th> ID </th>
			<th> Name </th>
			</tr>
			@foreach ($groups as $group)
				<tr  style="text-align:center"> 
				<td> {{ $group->id }} </td>
				<td> {{ $group->name }} </td> </tr>
			@endforeach
			</table>
  	</div>

</div>
@endsection

</html>
