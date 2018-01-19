<div class="modal-dialog modal-lg add-user-form" style="max-width: 500px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">View Client</h4>
    </div>
 
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group text-center">
          <button class="btn-md btn btn-success package-data-btn"><i class="fa fa-calendar"></i> Package</button>
          <button class="btn-md btn btn-primary coord-data-btn"><i class="fa fa-calendar-check-o"></i> On-the-day Coordination</button>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>