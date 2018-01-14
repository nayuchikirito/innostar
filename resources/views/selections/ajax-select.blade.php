@if(sizeof($packages) > 0)
  @foreach($packages as $package)
    <option value="{{ $package->id }}">{{ $package->name }}</option>
  @endforeach
@else
	<option>No Package Found</option>
@endif