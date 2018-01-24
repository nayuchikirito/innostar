<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PdfReport;
class GenerateReportController extends Controller
{
	public function registration()
	{
		return view('reports.reports');
	}
    public function reportRegistrations(Request $request) {
    // Retrieve any filters
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $sortBy = $request->input('sort_by');

    // Report title
    $title = 'Registered User Report';

    // For displaying filters description on header
    $meta = [
        'Registered on' => $fromDate . ' To ' . $toDate,
        'Sort By' => $sortBy
    ];

    // Do some querying..
    $queryBuilder = User::select(['id', 'fname', 'lname', 'midname', 'user_type', 'created_at'])
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->orderBy($sortBy);

    // Set Column to be displayed
    $columns = [
    	'ID' => 'id',
        'Name',
        'Registered At' => 'created_at',// if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
        'User Type' => 'user_type',
        // 'Status' => function($result) { // You can do if statement or any action do you want inside this closure
        //     return ($result->balance > 100000) ? 'Rich Man' : 'Normal Guy';
    ];

    /*
        Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).

        - of()         : Init the title, meta (filters description to show), query, column (to be shown)
        - editColumn() : To Change column class or manipulate its data for displaying to report
        - editColumns(): Mass edit column
        - showTotal()  : Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
        - groupBy()    : Show total of value on specific group. Used with showTotal() enabled.
        - limit()      : Limit record to be showed
        - make()       : Will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    */
    return PdfReport::of($title, $meta, $queryBuilder, $columns)
    				->editColumn('Name', [
                        'displayAs' => function($result) {
                            return $result->lname.', '.$result->fname.' '.substr($result->midname, 0, 1).'.';
                        }
                    ])
                    ->editColumn('Registered At', [
                        'displayAs' => function($result) {
                            return $result->created_at->format('d M Y');
                        }
                    ])
                    ->editColumn('User Type', [
                        'displayAs' => function($result) {
                            return $result->user_type;
                        }
                    ])
                    ->setCss([
			            '.head-content' => 'border-width: 1px',
			  		])->download('report');
                    // ->editColumns(['Total Balance', 'Status'], [
                    //     'class' => 'right bold'
                    // ])
                    // ->showTotal([
                    //     'Total Balance' => 'point' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                    // ])
                    // ->limit(20)
                    // ->stream(); // or download('filename here..') to download pdf
}
}
