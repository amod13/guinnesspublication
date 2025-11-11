@extends('admin.main.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <iframe id="pdf-viewer" src="{{ route('books.pdf', $data['record']->id ?? '') }}" width="100%" height="800px"
                frameborder="0">
            </iframe>
        </div>
    </div>
@endsection
