<div class="modal-dialog modal-lg add-user-form" style="max-width: 500px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">View Client</h4>
    </div>
 
    <form action="{{ url('/admin/users/'.$user->id) }}" method="GET" id="show-clients-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="name">Name: </label>
          <span id="name">{{ $user->lname.', '.$user->fname.' '.substr($user->midname, 0, 1).'.' }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="email">Email Address: </label>
          <span id="email">{{ $user->email }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="location">Location: </label>
          <span id="location">{{ ucwords($user->location) }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="contact">Contact: </label>
          <span id="location">{{ $user->contact }}</span>          
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form>

  </div>
</div>