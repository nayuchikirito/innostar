<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
// use PDF;
use App\User;
use App\Service;
use App\Reservation;
use App\Coordination;

class ReportsController extends Controller
{
    public function index()
    {
        $chart = Charts::multi('bar', 'material')
            // Setup the chart settings
            ->title("My Cool Chart")
            // A dimension of 0 means it will take 100% of the space
            ->dimensions(0, 400) // Width x Height
            // This defines a preset of colors already done:)
            ->template("material")
            // You could always set them manually
            // ->colors(['#2196F3', '#F44336', '#FFC107'])
            // Setup the diferent datasets (this is a multi chart)
            ->dataset('Element 1', [5,20,100])
            ->dataset('Element 2', [15,30,80])
            ->dataset('Element 3', [25,10,40])
            // Setup what the values mean
            ->labels(['One', 'Two', 'Three']);

        return view('reports.test', ['chart' => $chart]);
    }

    public function try()
    {
        $reservation = Reservation::all();
    }

    public function yearly_service()
    { 
        $weddingRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $weddingCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $wedding = $weddingRes->merge($weddingCoord);
        $christeningRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christeningCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christening = $christeningRes->merge($christeningCoord);
        $debutRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debutCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debut = $debutRes->merge($debutCoord);
        $birthdayRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthdayCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthday = $birthdayRes->merge($birthdayCoord);
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Service Report') 
            ->elementLabel('Number of Service')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Wedding', $wedding)
            ->dataset('Christening', $christening)
            ->dataset('Debut', $debut)
            ->dataset('Birthday', $birthday)
            ->dimensions(1000, 500)
            ->responsive(true)
            ->groupByYear();
        return view('reports.user', ['chart' => $chart]);
    }

    public function monthly_service($year = null)
    {
        if($year == null){
            $year = date('Y');
        }
        $weddingRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $weddingCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $wedding = $weddingRes->merge($weddingCoord);
        $christeningRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christeningCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christening = $christeningRes->merge($christeningCoord);
        $debutRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debutCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debut = $debutRes->merge($debutCoord);
        $birthdayRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthdayCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthday = $birthdayRes->merge($birthdayCoord);
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Service Yearly Report') 
            ->elementLabel('Number of Service')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Wedding', $wedding)
            ->dataset('Christening', $christening)
            ->dataset('Debut', $debut)
            ->dataset('Birthday', $birthday)

            ->groupByMonth($year, true);
        return view('reports.generate', ['chart' => $chart]);
    }

    public function weekly_service($month = null, $year = null)
    {
        if($month == null){
            $month = date('M');
            $year = date('Y');
        }
        $weddingRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $weddingCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Wedding');
                })->get();
        $wedding = $weddingRes->merge($weddingCoord);
        $christeningRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christeningCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Christening');
            })->get();
        $christening = $christeningRes->merge($christeningCoord);
        $debutRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debutCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Debut');
            })->get();
        $debut = $debutRes->merge($debutCoord);
        $birthdayRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthdayCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Birthday');
            })->get();
        $birthday = $birthdayRes->merge($birthdayCoord);
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Service Monthly Report') 
            ->elementLabel('Number of Service')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Wedding', $wedding)
            ->dataset('Christening', $christening)
            ->dataset('Debut', $debut)
            ->dataset('Birthday', $birthday)

            ->groupByDay($month, $year, true);
        return view('reports.generate2', ['chart' => $chart]);
    }


    public function user()
    {
        $chart = Charts::database(User::all()->where('user_type', 'Client'), 'line', 'highcharts')
            ->title('Client Registrations')
            ->elementLabel('Number of Registrations')
            ->dimensions(1000, 500)
            ->responsive(false)
            ->lastByMonth(12);
        return view('reports.user', ['chart' => $chart]);
    }

    public function overall()
    {
        $weddingRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Wedding');
            })->get()->count();
        $weddingCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Wedding');
                })->get()->count();
        $wedding = $weddingRes + $weddingCoord;
        $christeningRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Christening');
            })->get()->count();
        $christeningCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Christening');
            })->get()->count();
        $christening = $christeningRes + $christeningCoord;
        $debutRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Debut');
            })->get()->count();
        $debutCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Debut');
            })->get()->count();
        $debut = $debutRes + $debutCoord;
        $birthdayRes = Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Birthday');
            })->get()->count();
        $birthdayCoord = Coordination::whereHas('service', function ($query){
                $query->where('name', 'Birthday');
            })->get()->count();
        $birthday = $birthdayRes + $birthdayCoord;
        $chart = Charts::create('pie', 'highcharts')
        ->title('Service Chart')
        ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
        ->labels(['Wedding', 'Christening', 'Debut', 'Birthday'])  
        ->values([$wedding, $christening, $debut, $birthday])
        ->dimensions(1000,500)
        ->responsive(false);
        return view('reports.user', ['chart' => $chart]);
    }

    public function overall_package()
    {
        $golden = Reservation::whereHas('package', function ($query){
                $query->where('name', 'Golden Package');
            })->count();
        $silver = Reservation::whereHas('package', function ($query){
                        $query->where('name', 'Silver Package');
            })->count();
        $bronze = Reservation::whereHas('package', function ($query){
                        $query->where('name', 'Bronze Package');
            })->count();
        $regular = Reservation::whereHas('package', function ($query){
                        $query->where('name', 'Regular Package');
            })->count();
        $chart = Charts::create('pie', 'highcharts')
        ->title('Package Chart')
        ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
        ->labels(['Golden', 'Silver', 'Bronze', 'Regular'])  
        ->values([$golden, $silver, $bronze, $regular])
        ->dimensions(1000,500)
        ->responsive(false);
        return view('reports.user', ['chart' => $chart]);
    }

    public function monthly_package($year = null)
    {
        if($year == null){
            $year = date('Y');
        }
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Package Yearly Report') 
            ->elementLabel('Number of Package')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Golden Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Golden Package');
            })->get())
            ->dataset('Silver Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Silver Package');
            })->get())
            ->dataset('Bronze Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Bronze Package');
            })->get())
            ->dataset('Regular Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Regular Package');
            })->get())
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->groupByMonth($year, true);
        return view('reports.generate3', ['chart' => $chart]);
    }

    public function weekly_package($month = null, $year = null)
    {
        if($month == null){
            $month = date('M');
            $year = date('Y');
        }
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Package Monthly Report') 
            ->elementLabel('Number of Package')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Golden Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Golden Package');
            })->get())
            ->dataset('Silver Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Silver Package');
            })->get())
            ->dataset('Bronze Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Bronze Package');
            })->get())
            ->dataset('Regular Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Regular Package');
            })->get())
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->groupByDay($month, $year, true);
        return view('reports.generate3', ['chart' => $chart]);
    }

    public function yearly_package()
    {
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Package Report') 
            ->elementLabel('Number of Package')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Golden Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Golden Package');
            })->get())
            ->dataset('Silver Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Silver Package');
            })->get())
            ->dataset('Bronze Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Bronze Package');
            })->get())
            ->dataset('Regular Package', Reservation::whereHas('package', function ($query){
                $query->where('name', 'Regular Package');
            })->get())
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->groupByYear();
        return view('reports.user', ['chart' => $chart]);
    }

    public function yearly_reservation()
    {
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Reservation Report') 
            ->elementLabel('Number of Reservations')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Reservation', Reservation::all())
            ->dataset('Coordination', Coordination::all())
            ->groupByYear();
        return view('reports.user', ['chart' => $chart]);
    }

    public function monthly_reservation($year = null)
    {
        if($year == null){
            $year = date('Y');
        }
        $chart = Charts::multiDatabase('bar', 'highcharts')->dateColumn('date')
            ->title('Reservations Yearly Report') 
            ->elementLabel('Number of Reservations')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Package Reservation', Reservation::all())
            ->dataset('Coordination', Coordination::all())
            ->groupByMonth($year, true);
        return view('reports.generate5', ['chart' => $chart]);
    }

    public function overall_reservation()
    {
        $reservation = Reservation::all()->count();
        $coordination = Coordination::all()->count();
        $chart = Charts::create('pie', 'highcharts')
        ->title('Package Chart')
        ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
        ->labels(['Package Reservation', 'Coordination'])  
        ->values([$reservation, $coordination])
        ->dimensions(1000,500)
        ->responsive(false);
        return view('reports.user', ['chart' => $chart]);
    }


}
