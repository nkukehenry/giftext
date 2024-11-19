@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Participant Groupings</h1>
    <p class="text-sm text-gray-500 mb-4">Manage the groups of participants</p>


    <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h2 class="text-xl font-semibold mb-4">Add New Group</h2>
        <button class="bg-santa-green text-white font-bold py-2 px-4 rounded" onclick="showAddGroupModal()">Add Group</button>
    </div>

    <h2 class="text-xl font-semibold mt-6 mb-4">Existing Groups</h2>
    <div class="bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full table-auto" width="100%">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Group Name</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td class="border px-4 py-2">{{ $group->name }}</td>
                        <td class="border px-4 py-2">
                            <button class="text-santa-gold hover:underline" onclick="editGroup({{ $group->id }}, '{{ $group->name }}')">Edit</button>
                            <button class="text-red-500 hover:underline" onclick="deleteGroup({{ $group->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Group Modal -->
    <dialog id="addGroupModal" class="modal w-full max-w-2xl p-3">
        <div class="modal-box rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-lg font-bold" id="addGroupModalTitle">Add Group</h3>
            <form id="addGroupForm" method="POST" action="{{ route('admin.groups.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="group_name" class="block text-santa-green text-sm font-bold mb-2">Group Name</label>
                    <input id="group_name" type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-action flex justify-between">
                    <button type="submit" class="bg-santa-green hover:bg-santa-gold text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Group</button>
                    <button type="button" class="btn" onclick="closeAddGroupModal()">Close</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Edit Group Modal -->
    <dialog id="editGroupModal" class="modal w-full max-w-2xl p-3">
        <div class="modal-box rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-lg font-bold" id="editGroupModalTitle">Edit Group</h3>
            <form id="editGroupForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_group_id" name="group_id">
                <div class="mb-4">
                    <label for="edit_group_name" class="block text-santa-green text-sm font-bold mb-2">Group Name</label>
                    <input id="edit_group_name" type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-action flex justify-between">
                    <button type="submit" class="bg-santa-green hover:bg-santa-gold text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Group</button>
                    <button type="button" class="btn" onclick="closeEditGroupModal()">Close</button>
                </div>
            </form>
        </div>
    </dialog>
</div>

<script>
    function showAddGroupModal() {
        document.getElementById('addGroupModal').showModal();
    }

    function closeAddGroupModal() {
        document.getElementById('addGroupModal').close();
    }

    function editGroup(id, name) {
        document.getElementById('edit_group_id').value = id;
        document.getElementById('edit_group_name').value = name;
        document.getElementById('editGroupForm').action = '{{ url('/admin/groups') }}/' + id; // Set the action for the edit form
        document.getElementById('editGroupModal').showModal();
    }

    function closeEditGroupModal() {
        document.getElementById('editGroupModal').close();
    }

    function deleteGroup(id) {
        if (confirm('Are you sure you want to delete this group?')) {
            // Perform the delete action (you may want to implement this via AJAX or a form submission)
            fetch(`/admin/groups/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Reload the page to see the changes
                } else {
                    alert('Failed to delete the group.');
                }
            });
        }
    }
</script>
@endsection
