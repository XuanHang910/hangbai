<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
       
        <th>Tên Nhóm Thành Viên</th>
        <th class="text-center">Số thành viên</th>
        <th>Mô tả</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($userGroupMember) && is_object($userGroupMember))
        @foreach($userGroupMember as $userGroupMember)
        <tr >
            <td>
                <input type="checkbox" value="{{ $userGroupMember->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                {{ $userGroupMember->name }}
            </td>
            <td class="text-center">
                {{ $userGroupMember->users_count }} người
            </td>
            <td>
                {{ $userGroupMember->description }}
            </td>
            <td class="text-center js-switch-{{ $userGroupMember->id }}"> 
                <input type="checkbox" value="{{ $userGroupMember->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($userGroupMember->publish == 2) ? 'checked' : '' }} data-modelId="{{ $userGroupMember->id }}" />
            </td>
            <td class="text-center"> 
                <a href="{{ route('user.catalogue.edit', $userGroupMember->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="{{ route('user.catalogue.delete', $userGroupMember->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    @endif
</tbody>
</table>
{{  $userGroupMember->links('pagination::bootstrap-4') }}
