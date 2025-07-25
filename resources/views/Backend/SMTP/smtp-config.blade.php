@extends('Backend.admin.admin_dashboard')


@section('admin')
    <div class="page-content">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <div class="row profile-body">
            <div class="d-flex justify-content-center w-100">
                <div class="col-md-8 col-xl-6">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Mail Service</h6>

                                <form class="forms-sample" method="POST" action="{{ route('mailconfig.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Mailer</label>
                                        <input type="text" name="mailer" class="form-control" id="exampleInputUsername1"
                                            autocomplete="off" value="{{ $data->mailer ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Host</label>
                                        <input type="text" name="host" class="form-control" id="exampleInputUserhost1"
                                            autocomplete="off" value="{{ $data->host ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Port</label>
                                        <input type="text" name="port" class="form-control" id="exampleInputUsername1"
                                            autocomplete="off" value="{{ $data->port ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control"
                                            id="exampleInputUsername1" autocomplete="off"
                                            value="{{ $data->username ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control"
                                            id="exampleInputUsername1" autocomplete="off"
                                            value="{{ $data->password ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Encryption</label>
                                        <input type="text" name="encryption" class="form-control"
                                            id="exampleInputUsername1" autocomplete="off"
                                            value="{{ $data->encryption ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputUsername1" class="form-label">Sender</label>
                                        <input type="text" name="sender" class="form-control" id="exampleInputUsername1"
                                            autocomplete="off" value="{{ $data->sender ?? '' }}">
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Configure</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
    </div>
@endsection
