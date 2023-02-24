@extends('layouts.admin_staff')

@section('title')
    Staff - Salary
@endsection

<!-- Add the Dynamic Menu -->
@section('menus')
    @include('admin_menu.staff')
@endsection

@section('content')
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="col-lg-6 col-6">
            <div class="form-group mb-4">
                <a href="{{ url('admin/staffs/salary') }}" class="btn btn-success btn-max-200 text-uppercase font-weight-bold"
                    style="width: 200px"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                        <h3 class="p-4 font-weight-bold text-uppercase">Update Staff Salary </h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12 col-12 mt-5 ">
                        <div class="row">

                            <div class="col-lg-6 col-12">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $salary->id }}" class="salary_id">
                                    <div class="col-lg-4 col-12">
                                        <div class="form-group mb-4">
                                            <label for="exampleFormControlInput2">Year<span
                                                    class="text-danger">*</span></label>
                                            @php
                                                $year = date('Y');
                                            @endphp
                                            <select name="paid_year" class="form-control disabled-results year">
                                                @for ($i = $year; $i > 2022; $i--)
                                                    <option value="{{ $i }}"
                                                        {{ $salary->paid_year == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <div class="form-group mb-4">
                                            <label for="exampleFormControlInput2">Month<span
                                                    class="text-danger">*</span></label>
                                            <select name="paid_month" class="form-control disabled-results month">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $salary->paid_month == $i ? 'selected' : '' }}>
                                                        {{ date('F', strtotime(date('Y-' . $i))) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger font-weight-bold error_year_month"></span>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Select Staff<span
                                            class="text-danger">*</span></label>
                                    <select name="staff" class="form-control disabled-results staff">
                                        <option value=""></option>
                                        @foreach ($staffs as $item)
                                            <option value="{{ $item->id }}" {{$salary->user_id == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger font-weight-bold error_staff"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Basic Salary<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="basic_salary" class="form-control text-black basic_salary"
                                        readonly value="{{ $salary->staff->basicSalary->salary }}" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_basic_salary"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mb-4">
                                    <label for="exampleFormControlInput2">Salary<span class="text-danger">*</span></label>
                                    <input type="text" name="salary" class="form-control price salary"
                                        value="{{ $salary->paid_amount }}" maxlength="10" id="exampleFormControlInput2">

                                    <span class="text-danger font-weight-bold error_salary"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-5" id="submit_button">
                                <div class="form-group text-center text-sm-right">
                                    <button type="submit" class="btn btn-theme btn-max-200 text-uppercase font-weight-bold"
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
                    url: "{{ url('/admin/staffs/salary/update') }}",
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
                                            location.href =
                                                "{{ url('/admin/staffs/salary') }}";
                                        }
                                    },
                                }
                            });
                        }
                    }
                });
            });

            function clearForm() {
                $('.error_salary').text('');
                $('.error_year_month').text('');
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

            $('.staff').change(function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                var month = $('.month').val();
                var year = $('.year').val();
                var id = $('.salary_id').val();

                var data = {
                    'user_id': user_id,
                    'month': month,
                    'year': year,
                    'id': id
                }
                validation(data);
            });

            $('.month').change(function(e) {
                e.preventDefault();
                var user_id = $('.staff').val();
                var month = $(this).val();
                var year = $('.year').val();
                var id = $('.salary_id').val();

                var data = {
                    'user_id': user_id,
                    'month': month,
                    'year': year,
                    'id': id
                }
                validation(data);
            });

            $('.year').change(function(e) {
                e.preventDefault();
                var user_id = $('.staff').val();
                var month = $('.month').val();
                var year = $(this).val();
                var id = $('.salary_id').val();

                var data = {
                    'user_id': user_id,
                    'month': month,
                    'year': year,
                    'id': id
                }
                validation(data);
            });

            function validation(data) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/staffs/salary/validation') }}",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        $('.basic_salary').val('');
                        $('.salary').val('');
                        $('.error_year_month').text('');
                        if (response.status == false) {
                            $.each(response.errors, function(key, item) {
                                if (key) {
                                    $('.error_year_month').text(item);
                                }
                            });
                        } else {
                            $('.basic_salary').val(response.salary);
                            $('.salary').val(response.salary);
                        }
                    }
                });
            }

        });
    </script>
@endsection
