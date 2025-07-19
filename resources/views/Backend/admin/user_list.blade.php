@extends('Backend.admin.admin_dashboard')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="page-content">

        {{-- <nav class="page-breadcrumb">
            <ol class="breadcrumb">

                <a href="{{ route('add.roles') }}" class="btn btn-inverse-info">Add Roles</a>

            </ol>
        </nav> --}}

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Users</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>phone</th>
                                        <th>role</th>
                                        <th>address</th>
                                        <th>photo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td><img src="{{ asset('upload/user_images/' . $item->photo) }}" alt="image"
                                                    height="80px" width="auto"></td>
                                            <td>
                                                {{-- <a href="{{ route('user.status' , $item->id) }}"  class="btn btn-inverse-{{$item->status ? 'success' : 'danger'}}">
                                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                                </a> --}}
                                                <a href="{{ route('user.status', $item->id) }}"
                                                    class="btn btn-inverse-{{ $item->status === 'active' ? 'success' : 'danger' }}">{{ $item->status }}</a>

                                            </td>

                                            {{-- <td><img src="{{!empty($item->photo) ? url('upload/user_images/' . $item->photo) : url('/upload/no_image.jpg') }}" alt="image" height="80px" width="auto"></td>
                                             --}}
                                            <td>
                                                <a href="{{route('user.password.reset', $item->id)}}" class="btn btn-outline-info my-1">Reset Password</a> <br>
                                                <a href="{{route('user.profile.edit', $item->id)}}" class="btn btn-inverse-warning" title="Edit"><i data-feather="edit"></i></a>
                                                <a href="{{route('user.profile.delete', $item->id)}}" class="btn btn-inverse-danger" title="delete" id="delete"><i data-feather="trash-2"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
