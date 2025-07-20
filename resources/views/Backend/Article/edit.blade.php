@extends('Backend.admin.admin_dashboard')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Edit Article</h4>
                        </div>
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="text-white">{{ Session::get('success') }}</div>
                            @endif

                            <form action="{{ route('article.update', $article->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Article Name</label>
                                    <input type="text" name="title" id="title" placeholder="Enter Title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $article->title) }}" required>
                                    @error('article')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label">Content</label>
                                    <textarea name="body" id="body" placeholder="Enter Content" class="form-control" cols="30" rows="10">{{ old('body', $article->body) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" name="author" id="author" placeholder="Enter Author"
                                        class="form-control @error('author') is-invalid @enderror"
                                        value="{{ old('author', $article->author) }}" required>
                                    @error('author')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary w-100 border border-white text-white">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
