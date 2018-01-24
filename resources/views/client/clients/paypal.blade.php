@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav')
@section('content') 
      <section>
        <div id="paypal-button"></div>

        <script>
          paypal.Button.render({
            env: 'production', // Or 'sandbox',

            commit: true, // Show a 'Pay Now' button

            style: {
              color: 'gold',
              size: 'small'
            },

            payment: function(data, actions) {
              return view('client.clients.index');
            },

            onAuthorize: function(data, actions) {
              /* 
               * Execute the payment here 
               */
            },

            onCancel: function(data, actions) {
              /* 
               * Buyer cancelled the payment 
               */
            },

            onError: function(err) {
              /* 
               * An error occurred during the transaction 
               */
            }
          }, '#paypal-button');
        </script>
      
      </section>
          
          

@endsection

@section('scripts')
  <script type="text/javascript">
    $(function(){
  });

  </script>
@endsection

    

    
