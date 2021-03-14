<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr id="data_{{$user->id}}">
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <button type="button" data-toggle="modal" data-target="#update"
                    data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-id="{{ $user->id }}"
                    data-attr="{{ route('update',['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                    Update
                </button>
            </td>
            <td>
                <a href="javascript:void(0)" id="button-delete" data-id="{{ $user->id }}" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="row justify-content-center ajax__load__paginate">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
