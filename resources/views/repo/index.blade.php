@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Repository</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-8">
                                <input type="text" name="username" id="username" placeholder="Username Github"
                                       class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <a href="javascript:void(0)" onclick="searchRepo()" class="btn btn-primary">Tìm kiếm</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Username: <b id="name"></b></label>
                        </div>
                        <div class="form-group">
                            <label for="">Tổng: <span id="count"></span>/<b id="max"></b></label>
                        </div>

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Stargazers</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="listRepo">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var page = 1;
        var getListRepo = (page = 1) => {
            $.ajax({
                url: "{{ route('repo.get') }}",
                data: {
                    page: page,
                    key: $('#username').val(),
                    count: $('#count').html(),
                },
                success: function (result) {
                    let data = JSON.parse(result);
                    $('#listRepo').append(data.html);
                    $('#name').html(data.username);
                    $('#max').html(data.max);
                    $('#count').html(data.count);
                }
            })
        };
        var searchRepo = () => {
            $("#listRepo").html("");
            page = 1;
            getListRepo();
        };
        {{--var saveClone = () => {--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('repo.') }}",--}}
        {{--        data: {--}}
        {{--            // page: page,--}}
        {{--            key: $('#username').val(),--}}
        {{--            count: $('#count').html(),--}}
        {{--        },--}}
        {{--        success: function (result) {--}}
        {{--            let data = JSON.parse(result);--}}
        {{--            $('#listRepo').append(data.html);--}}
        {{--            $('#name').html(data.username);--}}
        {{--            $('#max').html(data.max);--}}
        {{--            $('#count').html(data.count);--}}
        {{--        }--}}
        {{--    })--}}
        {{--}--}}
        var loadMore = (_this) => {
            page += 1;
            console.log($(_this).parent().parent());
            $(_this).parent().parent().html("");
            getListRepo(page);
        };

        // $(document).ready(function () {
        //     getListRepo(page);
        // })
    </script>
@endsection

