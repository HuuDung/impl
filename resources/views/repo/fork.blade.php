@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Repository Saved</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="listRepo">
                            @foreach($forks as $fork)
                                <tr>
                                    <td>{{ $fork->repo_name }}</td>
                                    <td>
                                        @if($fork->status == \App\Models\Fork::NO_CLONE)
                                            <a href="{{ route('repo.fork', $fork->id) }}" class="btn btn-success">Fork</a>
                                        @elseif($fork->status == \App\Models\Fork::PENDING)
                                            <button class="btn btn-primary">Pending</button>
                                        @else
                                            <a href="{{ $fork->html_url }}" target="_blank">{{ $fork->html_url }}</a>
                                        @endif
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
@endsection
@section('script')
@endsection

