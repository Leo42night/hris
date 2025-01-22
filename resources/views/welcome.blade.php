@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:250px" url="{{ route('getusers') }}"
        toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="name" width="50">Name</th>
                <th field="email" width="50">Email</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New
            User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit
            User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true"
            onclick="destroyUser()">Remove User</a>
    </div>

    {{-- add user modal --}}
    <div id="add-dlg" class="easyui-dialog" style="width:450px"
        data-options="closed:true,modal:true,border:'thin',buttons:'#add-dlg-buttons'">
        <form id="add-fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>User Information</h3>
            <div style="margin-bottom:10px">
                <input name="name" class="easyui-textbox" required="true" label="Name:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="email" class="easyui-textbox" required="true" validType="email" label="Email:"
                    style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="password" type="text" class="easyui-textbox" style="width:100%" validType="length[6,12]"
                    label="Password:">
            </div>
        </form>
    </div>
    <div id="add-dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()"
            style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
            onclick="javascript:$('#add-dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>

    {{-- edit user modal --}}
    <div id="edit-dlg" class="easyui-dialog" style="width:450px"
        data-options="closed:true,modal:true,border:'thin',buttons:'#edit-dlg-buttons'">
        <form id="edit-fm" method="POST" novalidate style="margin:0;padding:20px 50px">
            <h3>User Information</h3>
            <div style="margin-bottom:10px">
                <input name="name" class="easyui-textbox" required="true" label="Name:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="email" class="easyui-textbox" required="true" validType="email" label="Email:"
                    style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input type="hidden" name="password" style="width:100%">
                <input name="newPassword" class="easyui-textbox" type="text" style="width:100%" validType="length[6,12]"
                    prompt="default same" label="New Password:">
            </div>
        </form>
    </div>
    <div id="edit-dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="updateUser()"
            style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
            onclick="javascript:$('#edit-dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        var url;

        function newUser() {
            $('#add-dlg').dialog('open').dialog('center').dialog('setTitle', 'New User');
            $('#add-fm').form('clear');
            url = 'users';
        }

        function editUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#edit-dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit User');
                $('#edit-fm').form('clear');
                $('#edit-fm').form('load', row);
                url = 'users/' + row.id;
            } else {
                alert('Please select a row.');
            }
        }

        function saveUser() {
            $.messager.progress();
            $('#add-fm').form('submit', {
                url: url,
                iframe: false,
                onSubmit: function() {
                    var isValid = $(this).form('validate');
                    if (!isValid) {
                        $.messager.progress('close'); // hide progress bar while the form is invalid
                    }
                    return isValid; // return false will stop the form submission
                },
                success: function(result) {
                    $.messager.progress('close');
                    console.log(result);
                    var result = eval('(' + result + ')');
                    if (result.errorMsg) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#add-dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload the user data
                    }
                }
            });
        }

        function updateUser() {
            $.messager.progress();
            $('#edit-fm').form('submit', {
                url: url,
                iframe: false,
                onSubmit: function(param) {
                    param._method = 'PUT';
                    var isValid = $(this).form('validate');
                    if (!isValid) {
                        $.messager.progress('close'); // hide progress bar while the form is invalid
                    }
                    return isValid; // return false will stop the form submission
                },
                success: function(result) {
                    $.messager.progress('close');
                    var result = JSON.parse(result); // Parse the result
                    if (result.errorMsg) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#edit-dlg').dialog('close'); // close the dialog
                        $('#dg').datagrid('reload'); // reload the user data
                    }
                }
            });
        }

        function destroyUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function(r) {
                    if (r) {
                        $.post('users/' + row.id, {
                            _method: 'DELETE'
                        }, function(result) {
                            if (result.success) {
                                $('#dg').datagrid('reload'); // reload the user data
                            } else {
                                $.messager.show({ // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        }, 'json');
                    }
                });
            }
        }
    </script>
@endsection
