@extends('Backend.admin.admin_dashboard')

@section('admin')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .body-preview {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Show max 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            /* Allows wrapping */
            word-break: break-word;
            /* Break long words */
            max-width: 500px;
            /* Prevents overflow */
            border: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Article List</h5>
                            <a href="{{ route('article.create') }}" class="btn btn-light btn-sm">Add New</a>
                        </div>

                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="text-white">{{ Session::get('success') }}</div>
                            @endif

                            @if ($articles->isEmpty())
                                <p class="text-muted mb-0">No Article found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Author</th>
                                                <th style="width: 250px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($articles as $index => $article)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $article->title }}</td>
                                                    <td class="body-preview">{{ $article->body }}</td>
                                                    <td>{{ $article->author }}</td>
                                                    {{-- <td>
                                                        <a href="{{ route('article.edit', $article->id) }}"
                                                            class="btn btn-sm btn-inverse-warning" title="Edit"><i
                                                                data-feather="edit"></i></a>
                                                        <a href="{{ route('article.delete', $article->id) }}"
                                                            class="btn btn-sm btn-inverse-danger delete-confirm"
                                                            title="Delete">
                                                            <i data-feather="trash-2"></i>
                                                        </a>

                                                    </td> --}}
                                                    <td>
                                                        @can('Edit')
                                                            <a href="{{ route('article.edit', $article->id) }}"
                                                                class="btn btn-sm btn-inverse-warning" title="Edit">
                                                                <i data-feather="edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('Delete')
                                                            <a href="{{ route('article.delete', $article->id) }}"
                                                                class="btn btn-sm btn-inverse-danger delete-confirm"
                                                                title="Delete">
                                                                <i data-feather="trash-2"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="d-flex mt-3 ms-auto justify-content-end">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-confirm').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>
@endsection
