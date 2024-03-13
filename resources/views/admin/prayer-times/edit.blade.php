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
                        <h1>Edir Prayer Time</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.prayer-times.index') }}">View All</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                <form action="{{ route('admin.prayer-times.update', $prayerTime->id) }}" method="post" id="submitForm">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Date</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="prayer_date" data-target-input="nearest">
                                        <input type="text" name="prayer_date" class="form-control datetimepicker-input"
                                            data-target="#prayer_date" value="{{ old('prayer_date', $prayerTime->date) }}" />
                                        <div class="input-group-append" data-target="#prayer_date"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Fajr Prayer Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="fajr" data-target-input="nearest">
                                        <input type="text" name="fajr" class="form-control datetimepicker-input"
                                        data-target="#fajr" value="{{ old('fajr', PrayerTime($prayerTime->fajr)) }}" />
                                        <div class="input-group-append" data-target="#fajr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Sunrise Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="sunrise" data-target-input="nearest">
                                        <input type="text" name="sunrise" class="form-control datetimepicker-input"
                                        data-target="#sunrise" value="{{ old('sunrise', PrayerTime($prayerTime->sunrise)) }}" />
                                        <div class="input-group-append" data-target="#sunrise" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Zuhr Prayer Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="zuhr" data-target-input="nearest">
                                        <input type="text" name="zuhr" class="form-control datetimepicker-input"
                                        data-target="#zuhr" value="{{ old('zuhr', PrayerTime($prayerTime->zuhr)) }}" />
                                        <div class="input-group-append" data-target="#zuhr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Asr Prayer Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="asr" data-target-input="nearest">
                                        <input type="text" name="asr" class="form-control datetimepicker-input"
                                        data-target="#asr" value="{{ old('asr', PrayerTime($prayerTime->asr)) }}" />
                                        <div class="input-group-append" data-target="#asr" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Maghrib Prayer Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="maghrib" data-target-input="nearest">
                                        <input type="text" name="maghrib" class="form-control datetimepicker-input"
                                        data-target="#maghrib" value="{{ old('maghrib', PrayerTime($prayerTime->maghrib)) }}" />
                                        <div class="input-group-append" data-target="#maghrib" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /.row --}}
                        <div class="row">
                            <label class="col-lg-2 col-md-2 col-sm-12">Isha Prayer Time</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <div class="input-group date" id="isha" data-target-input="nearest">
                                        <input type="text" name="isha" class="form-control datetimepicker-input"
                                        data-target="#isha" value="{{ old('isha', PrayerTime($prayerTime->isha)) }}" />
                                        <div class="input-group-append" data-target="#isha" data-toggle="datetimepicker">
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
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#fajr').datetimepicker({
            format: 'LT'
        });
        // sunrise
        $('#sunrise').datetimepicker({
            format: 'LT'
        });
        // zuhr
        $('#zuhr').datetimepicker({
            format: 'LT'
        });
        // asr
        $('#asr').datetimepicker({
            format: 'LT'
        });
        // Fajr
        $('#maghrib').datetimepicker({
            format: 'LT'
        });
        // isha
        $('#isha').datetimepicker({
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
