
<table class="display nowrap table table-striped table-hover" id="users-table" style="width: 100%">
    <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Unit</th>
          <th>Role</th>
          <th>Registered on</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
          <td>{!! $user->username !!}</td>
          <td>{!! $user->email !!}</td>
          <td>{!! $user->unit_number !!}</td>

            @switch($user->role_id)
                @case(1)
                    <td>Admin</td>
                    @break

                @case(2)
                    <td>Maintanence</td>
                    @break

                @default
                    <td>Resident</td>
            @endswitch

          <td>{!! $user->created_at->format('M d Y') !!}</td>
          <td>
              {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete', 'class' => 'delete-user']) !!}

                  <a data-toggle="tooltip" title="View" data-placement="top" href="{!! route('users.show', [$user->id]) !!}" class='btn btn-info btn-sm'>View</a>
                  <a data-toggle="tooltip" title="Edit" data-placement="top" href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-warning btn-sm'>Edit</a>
                  {!! Form::button('<a class="del-button">Delete</a>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm del-button', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'data-placement' => 'top']) !!}

              {!! Form::close() !!}
          </td>
        </tr>
    @endforeach
    </tbody>
</table>
