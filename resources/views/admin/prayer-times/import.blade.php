@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Prayer Times</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">View All</li>
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
                    <h3 class="card-title">Import Prayer Time with CSV file.</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.prayer-times.index') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-eye"></i> View
                            All</a>
                        <a href="{{ route('admin.prayer-times.create') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-square-plus"></i> Create
                            New</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.import.prayer.times.post') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".csv">
                        <button type="submit" class="btn btn-primary btn-theme">Import CSV</button>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ asset('downloads/sample_file_prayer_time.csv') }}" class="btn btn-default btn-sm "><i
                            class="fas fa-cloud-download-alt"></i> Download Sample File</a>
                </div>
                {{-- /.card-footer --}}
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
@endsection
