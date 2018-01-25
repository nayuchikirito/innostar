<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use App\User;
use App\Service;
use App\Reservation;

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

    public function service()
    {
        $chart = Charts::multiDatabase('bar', 'material')->dateColumn('date')
            ->colors(['#2196F3', '#F44336', '#FFC107', '#1a8217'])
            ->dataset('Wedding', Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Wedding');
            })->get())
            ->dataset('Christening', Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Christening');
            })->get())
            ->dataset('Debut', Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Debut');
            })->get())
            ->dataset('Birthday', Reservation::whereHas('package.service', function ($query){
                $query->where('name', 'Birthday');
            })->get())
            // ->dataset('Christening', Reservation::where('package->service->name')->count(), 'Christening')
            // ->dataset('Birthday', Reservation::where('package->service->name')->count(), 'Debut')
            // ->dataset('Debut', Reservation::where('package->service->name')->count(), 'Birthday')
            ->groupByMonth();
        return view('reports.service', ['chart' => $chart]);
    }

    public function user()
    {
        $chart = Charts::database(User::all()->where('user_type', 'Client'), 'area', 'highcharts')
            ->title('Client Registrations')
            ->elementLabel("Client")
            ->dimensions(1000, 500)
            ->responsive(false)
            ->groupByMonth();
        return view('reports.user', ['chart' => $chart]);
    }
}
