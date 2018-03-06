<!-- <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">Package Reservations</h2>  -->



            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservations as $reservation)
                <tr>
                  <td class="text-left">{{ $reservation->client->user->lname.', '.$reservation->client->user->fname.' '.substr($reservation->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($reservation->date))}}</td>
                  <td class="text-left">{{ $reservation->balance }}</td>
                  <td class="text-center">{{ $reservation->package->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-danger btn-xs cancel-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-close"></i> Send Cancellation Request</a>
                  <td class="text-center"><a href="#" class="btn btn-warning btn-xs change-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-calendar"></i> Change Date Request</a>
                   </td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>


       <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">On-the-day Coordination Reservations</h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($coordinations as $coordination)
                <tr>
                  <td class="text-left">{{ $coordination->client->user->lname.', '.$coordination->client->user->fname.' '.substr($coordination->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($coordination->date))}}</td>
                  <td class="text-left">{{ $coordination->balance }}</td>
                  <td class="text-center">{{ $coordination->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-danger btn-xs cancel2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-close"></i> Send Cancellation Request</a>
                  <td class="text-center"><a href="#" class="btn btn-warning btn-xs change2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-calendar"></i> Change Date Request</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $coordination->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $coordination->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>


          <div class="row">
          <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">Package Reservations</h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservations as $reservation)
                <tr>
                  <td class="text-left">{{ $reservation->client->user->lname.', '.$reservation->client->user->fname.' '.substr($reservation->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($reservation->date))}}</td>
                  <td class="text-left">{{ $reservation->balance }}</td>
                  <td class="text-center">{{ $reservation->package->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-success btn-xs pay-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-check"></i> Send Payment Details</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $reservation->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $reservation->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">On-the-day Coordination Reservations</h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($coordinations as $coordination)
                <tr>
                  <td class="text-left">{{ $coordination->client->user->lname.', '.$coordination->client->user->fname.' '.substr($coordination->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($coordination->date))}}</td>
                  <td class="text-left">{{ $coordination->balance }}</td>
                  <td class="text-center">{{ $coordination->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-success btn-xs pay2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-check"></i> Send Payment Details</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $coordination->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $coordination->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>