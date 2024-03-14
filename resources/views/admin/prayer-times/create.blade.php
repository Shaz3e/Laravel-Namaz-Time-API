@extends('layouts.app')

@section('styles')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Prayer Time</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.prayer-times.index') }}">View All</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.prayer-times.index') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-eye"></i> View
                            All</a>
                    </div>
                </div>
                <form action="{{ route('admin.prayer-times.store') }}" method="post" id="submitForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Date</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="prayer_date" data-target-input="nearest">
                                        <input type="text" name="prayer_date" class="form-control datetimepicker-input"
                                            data-target="#prayer_date" value="{{ old('prayer_date') }}" />
                                        <div class="input-group-append" data-target="#prayer_date"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Sunrise Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="sunrise" data-target-input="nearest">
                                        <input type="text" name="sunrise" class="form-control datetimepicker-input"
                                        data-target="#sunrise" value="{{ old('sunrise') }}" />
                                        <div class="input-group-append" data-target="#sunrise" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}

                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Fajr Adhan Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="fajr_azan" data-target-input="nearest">
                                        <input type="text" name="fajr_azan" class="form-control datetimepicker-input"
                                        data-target="#fajr_azan" value="{{ old('fajr_azan') }}" />
                                        <div class="input-group-append" data-target="#fajr_azan" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Fajr Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="fajr" data-target-input="nearest">
                                        <input type="text" name="fajr" class="form-control datetimepicker-input"
                                        data-target="#fajr" value="{{ old('fajr') }}" />
                                        <div class="input-group-append" data-target="#fajr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}

                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Zuhr Adhan Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="zuhr_azan" data-target-input="nearest">
                                        <input type="text" name="zuhr_azan" class="form-control datetimepicker-input"
                                        data-target="#zuhr_azan" value="{{ old('zuhr_azan') }}" />
                                        <div class="input-group-append" data-target="#zuhr_azan" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Zuhr Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="zuhr" data-target-input="nearest">
                                        <input type="text" name="zuhr" class="form-control datetimepicker-input"
                                        data-target="#zuhr" value="{{ old('zuhr') }}" />
                                        <div class="input-group-append" data-target="#zuhr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Asr Adhan Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="asr_azan" data-target-input="nearest">
                                        <input type="text" name="asr_azan" class="form-control datetimepicker-input"
                                        data-target="#asr_azan" value="{{ old('asr_azan') }}" />
                                        <div class="input-group-append" data-target="#asr_azan" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Asr Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="asr" data-target-input="nearest">
                                        <input type="text" name="asr" class="form-control datetimepicker-input"
                                        data-target="#asr" value="{{ old('asr') }}" />
                                        <div class="input-group-append" data-target="#asr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Maghrib Adhan Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="maghrib_azan" data-target-input="nearest">
                                        <input type="text" name="maghrib_azan" class="form-control datetimepicker-input"
                                        data-target="#maghrib_azan" value="{{ old('maghrib_azan') }}" />
                                        <div class="input-group-append" data-target="#maghrib_azan" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Maghrib Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="maghrib" data-target-input="nearest">
                                        <input type="text" name="maghrib" class="form-control datetimepicker-input"
                                        data-target="#maghrib" value="{{ old('maghrib') }}" />
                                        <div class="input-group-append" data-target="#maghrib" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Isha Adhan Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="isha_azan" data-target-input="nearest">
                                        <input type="text" name="isha_azan" class="form-control datetimepicker-input"
                                        data-target="#isha_azan" value="{{ old('isha_azan') }}" />
                                        <div class="input-group-append" data-target="#isha_azan" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Isha Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="isha" data-target-input="nearest">
                                        <input type="text" name="isha" class="form-control datetimepicker-input"
                                        data-target="#isha" value="{{ old('isha') }}" />
                                        <div class="input-group-append" data-target="#isha" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">First Khuthbah Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="first_jumma_khutba" data-target-input="nearest">
                                        <input type="text" name="first_jumma_khutba" class="form-control datetimepicker-input"
                                        data-target="#first_jumma_khutba" value="{{ old('first_jumma_khutba') }}" />
                                        <div class="input-group-append" data-target="#first_jumma_khutba" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">First Friday Prayer Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="first_jumma" data-target-input="nearest">
                                        <input type="text" name="first_jumma" class="form-control datetimepicker-input"
                                        data-target="#first_jumma" value="{{ old('first_jumma') }}" />
                                        <div class="input-group-append" data-target="#first_jumma" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-3 col-md-3 col-sm-12">Second Khuthbah Time</label>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="second_jumma_khutba" data-target-input="nearest">
                                        <input type="text" name="second_jumma_khutba" class="form-control datetimepicker-input"
                                        data-target="#second_jumma_khutba" value="{{ old('second_jumma_khutba') }}" />
                                        <div class="input-group-append" data-target="#second_jumma_khutba" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <label class="col-lg-3 col-md-3 col-sm-12">Second Friday Prayer Time</label>
                            <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="second_jumma" data-target-input="nearest">
                                        <input type="text" name="second_jumma" class="form-control datetimepicker-input"
                                        data-target="#second_jumma" value="{{ old('second_jumma') }}" />
                                        <div class="input-group-append" data-target="#second_jumma" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                    </div>
                    {{-- /.card-body --}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-theme">Submit</button>
                    </div>
                    {{-- /.card-footer --}}
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        // Date
        $('#prayer_date').datetimepicker({
            format: 'YYYY-MM-DD',
            icons: {
                time: 'far fa-clock'
            }
        });
        // Fajr
        $('#fajr_azan').datetimepicker({
            format: 'LT'
        });
        $('#fajr').datetimepicker({
            format: 'LT'
        });
        // sunrise
        $('#sunrise').datetimepicker({
            format: 'LT'
        });
        // zuhr
        $('#zuhr_azan').datetimepicker({
            format: 'LT'
        });
        $('#zuhr').datetimepicker({
            format: 'LT'
        });
        // asr
        $('#asr_azan').datetimepicker({
            format: 'LT'
        });
        $('#asr').datetimepicker({
            format: 'LT'
        });
        // Fajr
        $('#maghrib_azan').datetimepicker({
            format: 'LT'
        });
        $('#maghrib').datetimepicker({
            format: 'LT'
        });
        // isha
        $('#isha_azan').datetimepicker({
            format: 'LT'
        });
        $('#isha').datetimepicker({
            format: 'LT'
        });
        $('#first_jumma_khutba').datetimepicker({
            format: 'LT'
        });
        $('#first_jumma').datetimepicker({
            format: 'LT'
        });
        $('#second_jumma_khutba').datetimepicker({
            format: 'LT'
        });
        $('#second_jumma').datetimepicker({
            format: 'LT'
        });

        $('#submitForm').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
