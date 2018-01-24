@extends('admin.includes.app')
@section('content')
	<div class="content-wrapper">
		<h3>Generate Reports On User Registrations</h3>
		<form action="{{ url('/reports/registrations/pdf') }}" method="GET">
			<div class="form-group">
				From:
				<input type="date" name="from_date" class="form-control">
			</div>
			<div class="form-group">
				To:
				<input type="date" name="to_date" class="form-control">
			</div>
			<div class="form-group">
				Sort by:
				<input type="hidden" name="sort_by" class="form-control" value="id">
			</div>
			<div>
				<select name="sort_by" class="form-control">
					<option value="id">ID</option>
					<option value="lname">Name</option>
				</select>
     			<button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
     		</div>
		</form>
	</div>
@endsection