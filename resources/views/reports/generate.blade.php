@extends('admin.includes.app')
@section('content')
    <div class="content-wrapper">
        <!-- Main Application (Can be VueJS or other JS framework) -->
        <!-- <div class="container"> -->
            <div class="app">
                <center>
                    {!! $chart->html() !!}
                </center>
            </div>
        <!-- </div> -->
        <div class="form-group"> <!-- Date input -->
            <label class="control-label" for="date">Year</label>
            <input class="form-control" id="datepicker" name="date" placeholder="YYYY" type="text">
          </div>
          <div class="form-group"> <!-- Submit button -->
            <a href="{{url('admin/report/service/monthly')}}" class="btn btn-primary " name="submit" id="link" >Generate</a>
          </div>    
      </div>


      <!--   <div class="form-group">
            Date
            <div class="input-group date" id="datepicker">
                <input type="text" class="form-control" >
                <span class="input-group-append">
                    <i class="fa fa-calendar"></i>
                </span>
            </div>
        </div> -->

    
        <!-- End Of Main Application -->

        {!! Charts::scripts() !!}
        {!! $chart->script() !!}
@endsection 

@section('scripts')
    <script type="text/javascript">
        $(function () {
             $("#change-date-form").on('submit', function(e){
                e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
                var $form = $(this);
                var $url = $form.attr('action');
                var formData = {};
                //submit a POST request with the form data
                $form.find('input', 'select').each(function(){
                    formData[ $(this).attr('name') ] = $(this).val();
                });

                //  $('#datepicker').change(function(){
                //     var date = $(this).val();
                //     var that = this;
                //     var token = $("input[name='_token']").val();
                //     $.ajax({
                //           url: "{{url('/report/service/monthly/{date}')}}",
                //           method: 'POST',
                //       });
                // });
                $.ajax({
                  type: 'POST',
                  url: "{{url('/report/service/monthly')}}",
                  data: $("#change-date-form").serialize()
                });

      });
            $('#datepicker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            }).on('changeDate', function(e) {
                $('#link').attr('href', "{{url('admin/report/service/monthly')}}/"+$('#datepicker').val())
            });
        });
    </script>
@endsection