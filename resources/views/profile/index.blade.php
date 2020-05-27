@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-4 text-center">
                                <label for="">Email: </label>
                            </div>
                            <div class="form-group col-8">
                                <input type="text" value="{{ $email }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4 text-center">
                                <label for="">Name: </label>
                            </div>
                            <div class="form-group col-8">
                                <input type="text" value="{{ $name }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4 text-center">
                                <label for="">Nickname: </label>
                            </div>
                            <div class="form-group col-8">
                                <input type="text" value="{{ $nickname }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4 text-center">
                                <label for="">Pubic Repo: </label>
                            </div>
                            <div class="form-group col-8">
                                <input type="text" value="{{ $public_repo }}" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection

