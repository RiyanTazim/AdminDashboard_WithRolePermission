@extends('Backend.admin.admin_dashboard')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Add Article</h4>
                        </div>
                        <div class="card-body">
                            <form id="permissionForm" action="{{ route('article.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        placeholder="Enter Title" required
                                        class="form-control @error('title') is-invalid @enderror">
                                </div>

                                @error('title')
                                    <div class="text-danger mb-3">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="mb-3">
                                    <label for="" class="form-label">Content</label>
                                    <textarea name="body" id="body" placeholder="Enter Content" class="form-control" cols="30" rows="10">{{ old('body') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" name="author" id="author" value="{{ old('author') }}"
                                        placeholder="Enter Author" required
                                        class="form-control @error('author') is-invalid @enderror">
                                </div>

                                @error('author')
                                    <div class="text-danger mb-3">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <button type="submit" class="btn btn-secondary w-100 border border-white">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
