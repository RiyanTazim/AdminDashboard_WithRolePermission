@extends('Backend.master')

@section('admin')
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Edit Page</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dynamicpage.update', $dynamicpage->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $dynamicpage->title) }}"
                                        class="form-control @error('title') is-invalid @enderror" required>
                                    @error('title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror"
                                        required>{{ old('content', $dynamicpage->content) }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary w-100">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
