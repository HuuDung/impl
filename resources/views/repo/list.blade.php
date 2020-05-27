@foreach($datas as $key => $value)
    <tr>
        <td>{{ $value["name"] }}</td>
        <td>{{ $value["stargazers_count"] }}</td>
        <td>
            <form action="{{ route('repo.save', auth()->id()) }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $value["name"] }}">
                <input type="hidden" name="html_url" value="{{ $value["html_url"] }}">
                <input type="hidden" name="owner" value="{{ $value["owner"]["login"] }}">
                <button type="submit" class="btn btn-success">Clone</button>
            </form>
        </td>
    </tr>
@endforeach
@if(count($datas) == $perPage)
    <tr>
        <td colspan="3">
            <button class="btn-primary btn btn-success" id="loadMore" onclick="loadMore($(this))">Load more</button>
        </td>
    </tr>
@endif
