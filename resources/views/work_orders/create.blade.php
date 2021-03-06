@extends('layouts.app')

@section('css')
  @include('layouts.datatables_css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/work_order/user_workorder_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap_select/select.min.css')}}">
@endsection

@section('content')

<section class="content-header">
  <nav>
      <ol class="breadcrumb breadcrumb-arrow">
      <li><a href="{{ route('admin') }}">Dashboard</a></li>
      <li class="active"><span>Work Orders</span></li>
    </ol>
  </nav>
</section>

<div class="content">
  @include('adminlte-templates::common.errors')
  <div class="panel panel-default panel-custom">
    <div class="panel-heading"><h4 style="display: inline-block">New Maintenance Request</h4></div>
      <div class="panel-body">
        <form class="form needs-validation" novalidate role="form" id="create-form">
                {!! csrf_field() !!}
          <div class="form-row">
              <div class="">
              <div class="form-group">
                <input type="hidden" value="{{ Auth::user()->username }}" name="name" class="form-control show-order-data" id="name" autocomplete="off" readonly>
                <small class="text-danger" name="name"></small>
              </div>
            </div>

            <div class="">
              <div class="form-group">
                <input type="hidden" name="unit_number" class="form-control show-order-data" value="{{ Auth::user()->unit_number }}" id="unit_number" autocomplete="off" readonly>
                <small class="text-danger" name="unit_number"></small>
              </div>
            </div>
          </div> <!---End row---->

          <div class="form-row">
            <div class="col">
              <div class="form-group col-sm-6">
                <label class="control-label" for="title">Category:</label>
                <select name="category" class="selectpicker form-control show-order-data" id="category" style="max-width: 250px;" title="Select category">
                  <option value="Light bulb">Light bulb</option>
                  <option value="Plumbing">Plumbing</option>
                  <option value="AC/Heating">AC/Heating</option>
                  <option value="Plumbing">Electric</option>
                  <option value="Plumbing">Other</option>
                </select>
                <small class="text-danger" name="category"></small>
              </div>
            </div>

            <div class="col">
              <div class="form-group col-sm-6">
                <label class="control-label" for="id">Permission to enter:</label>
                <select class="selectpicker form-control show-order-data change-status" name="permission_to_enter" id="permission_to_enter" autocomplete="off" title="Select permission">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
                <small class="text-danger" name="permission_to_enter"></small>
              </div>
            </div>
          </div> <!---End row---->

          <div class="form-row">
            <div class="form-group col-sm-12">
              <label class="control-label" for="content">Description:</label>
              <textarea class="form-control show-order-data" name="description" id="description" cols="40" rows="6"></textarea>
              <small class="text-danger" name="description"></small>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <label class="control-label" for="content">Comments:</label>
            <textarea class="form-control show-order-data" name="comments" id="comments" cols="40" rows="4"></textarea>
            <small class="text-danger" name="comments"></small>
          </div>

          <div class="form-row">
            <div class="col">
              <div class="form-group col-sm-6 submit-button">
                <label class="control-label " style="display: block" for="">&nbsp&nbsp</label>
                <button type="button" class="btn btn-primary add pull-left" id="create-order-btn">
                  <span class='glyphicon glyphicon-check'></span> Submit
                </button>
              </div>
            </div>
          </div>
          {!! csrf_field() !!}
      </form>
    </div>
  </div>

  {{-- user history section --}}
  <div class="panel panel-default panel-custom">
    <div class="panel-heading"><h4 style="display: inline-block">Request History</h4></div>
      <div class="panel-body">
        <table class="display nowrap table table-striped table-hover" id="workOrders-table" style="width: 100%">
        <thead>
          <tr>
            <th>Category</th>
            <th>Status</th>
            <th>Submitted on</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<!-- Modal form to show a post -->
<div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body row">
                <form class="form" role="form">
                  <div class="form-row">
                    <div class="col">
                      <div class="form-group col-sm-6">
                          <label class="control-label" for="id">Status:</label>
                          <input type="text" name="order_status" class="form-control show-order-data change-status" id="order_status" disabled>
                      </div>
                    </div>

                    <div class="col">
                      <div class="form-group col-sm-6">
                        <label class="control-label" for="id">Name:</label>
                        <input type="name" name="name" class="form-control show-order-data" id="name" disabled>
                      </div>
                    </div>
                  </div> <!---End row---->

                  <div class="form-row">
                    <div class="col">
                      <div class="form-group col-sm-6">
                        <label class="control-label" for="title">Apartment number:</label>
                        <input type="text" name="unit_number" class="form-control show-order-data" id="unit_number" disabled>
                      </div>
                    </div>

                    <div class="col">
                      <div class="form-group col-sm-6">
                        <label class="control-label" for="title">Category:</label>
                        <input type="text" name="category" class="form-control show-order-data" id="category" disabled>
                      </div>
                    </div>

                    <div class="form-group col-sm-6">
                      <label class="control-label" for="permission_to_enter">Permission to enter:</label>
                      <input type="text" name="permission_to_enter" class="form-control show-order-data" id="permission_to_enter" disabled>
                    </div>

                    <div class="col">
                      <div class="form-group col-sm-6">
                        <label class="control-label" for="priority">Priority:</label>
                        <input type="text" name="priority" class="form-control show-order-data" id="priority" disabled>
                        <small class="text-danger" name="priority"></small>
                      </div>
                    </div>
                  </div> <!---End row---->

                  <div class="form-row">
                    <div class="form-group col-sm-12">
                      <label class="control-label" for="content">Description:</label>
                      <textarea class="form-control show-order-data" name="description" id="description" cols="40" rows="6" disabled></textarea>
                    </div>
                  </div>

                  <div class="form-group col-sm-12">
                    <label class="control-label" for="content">Comments:</label>
                    <textarea class="form-control show-order-data" name="comments" id="comments" cols="40" rows="4" disabled></textarea>
                  </div>
                </form>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                  </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  @include('layouts.datatables_js')
  <script src="{{asset('js/work_orders/user_order_ajax.js')}}"></script>
  <script src="{{asset('js/bootstrap_select/select.min.js')}}"></script>

@endsection
