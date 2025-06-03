@extends('Layout_admin')
@section('title')
  Coupon
@endsection
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Coupon</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-product">
                            <li><a href="#" class="dropdown-item">Config option 1</a></li>
                            <li><a href="#" class="dropdown-item">Config option 2</a></li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form>
                    @csrf
                    <div class="table-responsive">
                        <table id="load_table" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>sale</th>
                                    <th>code</th>
                                    <th>condition</th>
                                    <th>Status</th>
                                    <th>expiry</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll_footer"><button id="deleteAllcheck" class="ladda-button btn btn-danger none" data-style="expand-right">Delete</button></th>
                                    <th>sale</th>
                                    <th>code</th>
                                    <th>condition</th>
                                    <th>Status</th>
                                    <th>expiry</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>

    {{-- Add & Edit Modal --}}
    <div class="modal inmodal" id="Modal_sample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span id="image_show"></span>
                    <h4 class="modal-title">Edit</h4>
                    <small class="font-bold">Add or edit coupon details.</small>
                </div>
                <form id="sample_form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div id="message_err"></div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" class="form-control" name="coupon_id" id="coupon_id">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Qty <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" name="coupon_qty" id="coupon_qty" oninput="this.value = Math.abs(this.value)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="coupon_date_start" id="coupon_date_start" value="{{ \Carbon\Carbon::now()->format('Y/m/d') }}"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control-sm form-control" name="coupon_date_end" id="coupon_date_end" value="{{ \Carbon\Carbon::tomorrow()->format('Y/m/d') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Condition <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="coupon_condition" id="coupon_condition">
                                    <option value="">-----Choose--------</option>
                                    <option value="Fixed">Money</option>
                                    <option value="Percent">Percent</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sale Number </label>
                            <div class="col-sm-10" id="show_coupon_sale_number">
                                <input type="number" name="coupon_sale_number" id="coupon_sale_number" class="form-control" oninput="this.value = Math.abs(this.value)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="coupon_status" id="coupon_status">
                                    <option value="">-----Choose--------</option>
                                    <option value="Show">Show</option>
                                    <option value="Hide">Hidden</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <input type="hidden" name="action" id="action" />
                        <button type="submit" name="action_button" id="action_button" class="ladda-button btn btn-primary" data-style="expand-right">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
