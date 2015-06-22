@extends('app')

@section('content')
    <h2 class="subheader">Other People</h2>
    <div class="row">
        <div class="col-md-6">
            <table data-toggle="table"
                   data-sort-name="name"
                   data-sort-order="desc"
                   data-show-header="false"
                   data-search="true"
                   data-show-toggle="true"
                   data-pagination="true"
                    >
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($not_friends as $friend)
            <tr>
                <td>
                    <a href="/user/{{$friend->id}}">
                        <img src="{{ $friend->photo }}" alt=" {{ $friend->getFullName() }}" height="256px">
                    </a>
                </td>
                <td>
                    <a href="/user/{{$friend->id}}">
                        {{ $friend->getFullName() }}
                    </a>
                </td>
                <td><a href="{{url('/friends/add',$friend->id)}}">Add friend</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

        </div>
    </div>

@stop