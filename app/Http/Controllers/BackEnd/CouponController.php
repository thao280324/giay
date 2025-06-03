<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;
use Validator;

class CouponController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $coupon = Coupon::orderBy('coupon_id','DESC')->get();

            return datatables()->of($coupon)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="edit" data-coupon_id="'.$data->coupon_id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->coupon_id.'" data-coupon_id="'.$data->coupon_id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('BackEnd.Coupon.list');
    }

    public function create() {}

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'coupon_qty'         => 'required|integer|min:1',
                'coupon_sale_number' => 'required|numeric|min:1',
                'coupon_code'        => 'required|string|max:50|unique:coupons,coupon_code',
                'coupon_condition'   => 'required|in:Percent,Fixed',
                'coupon_status'      => 'required|in:Show,Hide',
                'coupon_date_start'  => 'required|date',
                'coupon_date_end'    => 'required|date|after_or_equal:coupon_date_start',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            }

            // Optional: So sánh chính xác bằng Carbon
            if (Carbon::parse($request->coupon_date_start)->gt(Carbon::parse($request->coupon_date_end))) {
                return response()->json([
                    'message_erro' => 'The Start Date Is Too Big',
                ]);
            }

            $coupon = new Coupon();
            $coupon->coupon_qty = $request->coupon_qty;
            $coupon->coupon_sale_number = $request->coupon_sale_number;
            $coupon->coupon_code = $request->coupon_code;
            $coupon->coupon_condition = $request->coupon_condition;
            $coupon->coupon_status = $request->coupon_status;
            $coupon->coupon_date_start = $request->coupon_date_start;
            $coupon->coupon_date_end = $request->coupon_date_end;

            $coupon->save();

            return response()->json([
                'status'  => 200,
                'message' => 'Coupon Created Successfully',
            ]);
        }
    }

    public function show($id, Request $request)
    {
        return response()->json(['data' => $request->value]);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $coupon = Coupon::findOrFail($id);
            if ($coupon) {
                $day = date_create($coupon->coupon_date_start);
                $day_end = date_create($coupon->coupon_date_end);

                $format_from = date_format($day,'d');
                $format_to = date_format($day_end,'d');
                return response()->json([
                    'status'  => 200,
                    'coupon'  => $coupon,
                    'from'    => $format_from,
                    'to'      => $format_to,
                ]);
            } else {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Coupon Not Found',
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'coupon_qty'         => 'required|integer|min:1',
                'coupon_sale_number' => 'required|numeric|min:1',
                'coupon_code'        => 'required|string|max:50|unique:coupons,coupon_code,'.$id.',coupon_id',
                'coupon_condition'   => 'required|in:Percent,Fixed',
                'coupon_status'      => 'required|in:Show,Hide',
                'coupon_date_start'  => 'required|date',
                'coupon_date_end'    => 'required|date|after_or_equal:coupon_date_start',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            }

            if (Carbon::parse($request->coupon_date_start)->gt(Carbon::parse($request->coupon_date_end))) {
                return response()->json([
                    'message_erro' => 'The Start Date Is Too Big',
                ]);
            }

            $coupon = Coupon::findOrFail($id);
            $coupon->coupon_qty = $request->coupon_qty;
            $coupon->coupon_sale_number = $request->coupon_sale_number;
            $coupon->coupon_code = $request->coupon_code;
            $coupon->coupon_condition = $request->coupon_condition;
            $coupon->coupon_status = $request->coupon_status;
            $coupon->coupon_date_start = $request->coupon_date_start;
            $coupon->coupon_date_end = $request->coupon_date_end;

            $coupon->save();

            return response()->json([
                'status'  => 200,
                'message' => 'Coupon Updated Successfully',
            ]);
        }
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        if ($coupon) {
            $coupon->delete();

            return response()->json([
                'status'  => 200,
                'message' => 'Delete Successfully',
            ]);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'Coupon Not Found',
            ]);
        }
    }
}
