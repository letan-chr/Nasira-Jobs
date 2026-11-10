document.addEventListener('DOMContentLoaded', loadRolesData);

function loadRolesData() {
    if (!$('#indexRolesData').length) {
        return;
    }
}

listenClick('.roles-delete-btn', function (event) {
    let roleId = $(event.currentTarget).attr('data-id');
    deleteItem(route('roles.destroy', roleId), Lang.get('js.role') || 'Role', '#rolesTable');
});
