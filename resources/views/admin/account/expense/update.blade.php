@extends('layouts.admin_staff')

@section('title')
    Accounts - Expense
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.accounts')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/accounts/expense') }}"
                    class="btn btn-success btn-max-200 text-uppercase font-weight-bold" style="width: 200px"><i
                        class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Update Expense </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">
                            <input type="hidden" name="id" value="{{$expense->id}}" id="">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Category<span
                                            class="text-danger">*</span></label>
                                    <select name="category" class="form-control disabled-results">
                                        <option value=""></option>
                                        @foreach ($category as $item)
                                            <option value="{{$item->id}}" {{$expense->category_id == $item->id ? 'selected' : ''}}>{{$item->category}}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold error_category"></span>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Year<span
                                            class="text-danger">*</span></label>
                                            <select name="year" class="form-control disabled-results">
                                                <option value=""></option>
                                                @for ($i = date('Y'); $i >= 2022; $i--)
                                                    <option value="{{$i}}" {{$expense->year == $i ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>

                                    <span class="text-danger font-weight-bold error_year"></span>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Month<span
                                            class="text-danger">*</span></label>
                                            <select name="month" class="form-control disabled-results">
                                                <option value=""></option>
                                                @for ($i = 1; $i <=12; $i++)
                                                    <option value="{{$i}}" {{$expense->month == $i ? 'selected' : ''}}>{{date('F', strtotime('2023-'.$i))}}</option>
                                                @endfor
                                            </select>

                                    <span class="text-danger font-weight-bold error_month"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Date<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="paid_date" class="form-control price"
                                         min="{{date('Y-m-d')}}" value="{{$expense->paid_date}}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_paid_date"></span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Admount<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="amount" class="form-control price"
                                        value="{{ $expense->amount }}" maxlength="10" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_amount"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="submit_button">
                                <div class="form-group text-center text-sm-right">
                                    <button type="submit"
                                        class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px">Update</button>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="disable_button" style="display: none">
                                <div class="form-group text-center text-sm-right">
                                    <button type="button" class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
                                        style="width: 200px"><i class="fas fa-spinner fa-spin"></i> Updating ...</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submitForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#submitForm')[0]);

                $.ajax({
                    type: "POST",
                    beforeSend: function() {
                        $('#submit_button').css('display', 'none');
                        $('#disable_button').css('display', 'block');
                    },
                    url: "{{ url('/admin/accounts/expense/update') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $('#submit_button').css('display', 'block');
                        $('#disable_button').css('display', 'none');
                        clearForm();
                        if (response.statuscode == 400) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.error_' + key).text(item);
                                } else {
                                    $('.error_' + key).text('');
                                }
                            });
                        } else {
                            $.confirm({
                                theme: 'modern',
                                columnClass: 'col-md-6 col-8 col-md-offset-4',
                                title: 'Success! ',
                                content: response.message,
                                type: 'green',
                                buttons: {
                                    confirm: {
                                        text: 'OK',
                                        btnClass: 'btn-150',
                                        action: function() {
                                            location.href = "{{ url('/admin/accounts/expense') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            function clearForm()
            {
                $('.error_year').text('');
                $('.error_month').text('');
                $('.error_category').text('');
                $('.error_paid_date').text('');
                $('.error_amount').text('');
            }

            $(".contact").on("input", function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9]/g, ''));
                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which >
                        57)) {
                    evt.preventDefault();
                }
            });

            $(".price").on("input", function(evt) {
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which >
                        57)) {
                    evt.preventDefault();
                }
            });

        });
    </script>
@endsection
