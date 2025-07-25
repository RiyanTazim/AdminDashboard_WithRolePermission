@extends('Backend.admin.admin_dashboard')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Add Dynamic Page</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dynamicpage.store') }}" method="POST">
                                @csrf

                                {{-- Title --}}
                                <div class="mb-3">
                                    <label for="title" class="form-label">Page Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        placeholder="Enter Page Title" required
                                        class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Content --}}
                                <div class="mb-4">
                                    <label for="content" class="form-label">Page Content</label>
                                    <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror"
                                        placeholder="Enter Page Content">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary w-100 border border-white">
                                    Save Page
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CKEditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <style>
            .ck-editor__editable_inline {
                color: #333333 !important;
                /* Dark text color */
                background-color: #ffffff !important;
                /* White background */
                min-height: 500px !important;
                /* Retain height */
            }
        </style>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    height: 500 // Retain height setting
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    </div>
@endsection
