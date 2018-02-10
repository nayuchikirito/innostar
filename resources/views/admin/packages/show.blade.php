<div class="modal-dialog modal-lg add-user-form" style="max-width: 500px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">View Package</h4>
    </div>
 
    <form action="{{ url('/admin/users/'.$package->id) }}" method="GET" id="show-clients-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="package">Package Name: </label>
          <span id="package">{{ $package->name }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">For Service: </label>
          <span id="service">{{ $package->service->name }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="price">Price: </label>
          <span id="price">{{ $package->price }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="description">Description: </label>
          @php
          $arr = explode('>', $package->description);
          @endphp
          <span id="description" style="float:left; height: 200px; overflow: auto; width: 100%;">
            @foreach($arr as $a)
            <li>{{$a}}</li>
            @endforeach
          </span>          
          <span class="help-text text-danger"></span>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Description</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              @foreach($package->pacakge_detail as $detail)
                <tr>
                  <td>{{ $detail->package_description->name }}</td>
                  <td class="text-right">{{ number_format($detail->price,2) }}</td>
                </tr>
              @endforeach
              <tfoot>
                <tr>
                  <th class="text-right">TOTAL:</th>
                  <th class="text-right">{{ number_format($detail->sum('price'),2) }}</th>
                </tr>
              </tfoot>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form>

  </div>
</div>