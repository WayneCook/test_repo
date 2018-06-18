
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
            <td>{!! $user->role_id !!}</td>
            <td>{!! $user->created_at !!}</td>

            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
