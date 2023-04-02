@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card my-3">
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="body">Create a new post</label>
                                <textarea name="body" class="form-control" id="body" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Select an image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
