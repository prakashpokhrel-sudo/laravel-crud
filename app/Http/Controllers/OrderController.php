<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{   
     
    public function index()
    {
        return view('welcome');
    }


    /**
     * AJAX request
    */
    public function getUser(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
        ->where('name', 'like', '%' .$searchValue . '%')
        ->count();

        // Fetch records
        $result = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.name as name',
                'users.email as email',
                'users.mobile as mobile',
                'users.status as status',                
                DB::raw("SUM(orders.total) as total"),
                DB::raw("COUNT(orders.id) as count")
            )
            ->groupBy('orders.user_id')
            ->where('name', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->orderBy('users.'.$columnName, $columnSortOrder)
            ->get();
        
        $data_arr = $result->toArray();

        // foreach($records as $record){
        //    $id = $record->id;
        //    $name = $record->name;
        //    $email = $record->email;
        //    $mobile = $record->mobile;
        //    $status = $record->status;
        //    $total_count=DB::table('users')
        //        ->join('orders', 'orders.user_id', '=', 'users.id')
        //        ->where('orders.user_id',$record->id)
        //        ->groupBy('orders.user_id')
        //        ->count();
        //     $total_sum=DB::table('users')
        //         ->join('orders', 'orders.user_id', '=', 'users.id')
        //         ->where('orders.user_id',$record->id)
        //         ->groupBy('orders.user_id')
        //         ->sum('orders.total');
        //    $total= $total_sum;
        //    $count = $total_count;

        //    $data_arr[] = array(
        //      "id" => $id,
        //      "name" => $name,
        //      "email" => $email,
        //      "mobile" => $mobile,
        //      "status"=>$status,
        //      "total"=>$total,
        //      "count"=>$count
        //    );
        // }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }
    
    public function changeStatus(Request $request) {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        
        return response()->json(['success' => 'Status Changed Successfully','status'=>$user->status]);
    }
}