@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col">
            <form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="filename">File Name</label>
                  <input type="text" class="form-control" name="filename" id="filename" aria-describedby="helpId" placeholder="File Name">
                </div>

                <div class="form-group">
                  <label for="berkas">Upload File</label>
                  <input type="file" class="form-control" name="berkas" id="berkas" aria-describedby="helpId" placeholder="Upload File">
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>File Name</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($files as $file)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $file->filename }}</td>
                            <td><a href="{{ route('upload.download', $file->url) }}"><i class="fa fa-download" aria-hidden="true"></i></a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada file</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
