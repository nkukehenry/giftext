@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Participant Management</h1>
    <p class="text-sm text-gray-500 mb-4">Manage your participants list</p>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Add New Participant</h2>
        <button class="bg-santa-green text-white font-bold py-2 px-4 rounded" onclick="showAddModal()">Add Participant</button>
    </div>

    <h2 class="text-xl font-semibold mt-6 mb-4">Existing Participants</h2>
    <div class="bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full table-auto" width="100%">
            <thead>
                <tr class="border-b border-gray-200 text-left text-santa-green">
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">PIN</th>
                    <th class="px-4 py-2">Group</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-2"><img src="{{ $participant->avatar }}" alt="{{ $participant->name }}" class="w-10 h-10 rounded-full border-2 border-santa-white" /></td>
                        <td class="px-4 py-2">{{ $participant->name }}</td>
                        <td class="px-4 py-2">{{ $participant->email }}</td>
                        <td class="px-4 py-2">{{ $participant->phone }}</td>
                        <td class="px-4 py-2">{{ '******' }}</td>
                        <td class="px-4 py-2">{{ $participant->group_name }}</td>
                        <td class="px-4 py-2">
                            <button class="text-santa-gold hover:underline" onclick="editParticipant({{ $participant->id }}, '{{ $participant->email }}', '{{ $participant->name }}', '{{ $participant->phone }}', '{{ $participant->pin }}', '{{ $participant->group_id }}', '{{ $participant->avatar }}', '{{ $participant->wishlist }}')">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $participants->links() }} <!-- This will generate the pagination links -->
    </div>

    <!-- Modal -->
    <dialog id="my_modal_1" class="modal w-full max-w-2xl p-3">
        <div class="modal-box rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-lg font-bold" id="modal-title">Add Participant</h3>
            <form id="participantForm" method="POST" action="{{ route('admin.participants.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="method" value="POST">
                <div class="mb-4">
                    <label for="participant_avatar" class="block text-santa-green text-sm font-bold mb-2">Avatar</label>
                    <input id="participant_avatar" type="file" name="avatar" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <button type="button" class="bg-santa-green text-white font-bold py-2 px-4 rounded" onclick="document.getElementById('participant_avatar').click();">Upload Photo</button>
                    <div class="mt-2 text-center">
                        <img id="avatar_preview" src="#" alt="Avatar Preview" class="hidden w-32 h-32 max-w-32 max-h-32 rounded-full border-2 border-santa-white" />
                    </div>
                    <div class="mt-2 text-center">
                        <button type="button" id="confirmCrop" class="bg-santa-green text-white font-bold py-2 px-4 rounded hidden" onclick="confirmCrop()">Confirm Crop</button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="participant_email" class="block text-santa-green text-sm font-bold mb-2">Email Address</label>
                    <input id="participant_email" type="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="participant_name" class="block text-santa-green text-sm font-bold mb-2">Name</label>
                    <input id="participant_name" type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="participant_phone" class="block text-santa-green text-sm font-bold mb-2">Phone</label>
                    <input id="participant_phone" type="text" name="phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="participant_group_id" class="block text-santa-green text-sm font-bold mb-2">Group</label>
                    <select id="participant_group_id" name="group_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('group_id') border-red-500 @enderror">
                        <option value="">Select a group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="wish_list" class="block text-santa-green text-sm font-bold mb-2">Wish List</label>
                    <textarea id="wish_list" name="wishlist" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('wish_list') border-red-500 @enderror"></textarea>
                    @error('wish_list')
                        <span class="text-red-500 text-xs italic">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-action flex justify-between"> <!-- Flexbox for even spacing -->
                    <button type="submit" class="bg-santa-green hover:bg-santa-gold text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Participant</button>
                    <button type="button" class="btn" onclick="my_modal_1.close()">Close</button>
                </div>
            </form>
        </div>
    </dialog>
</div>

<script>
    function showAddModal() {
        document.getElementById('modal-title').innerText = 'Add Participant';
        document.getElementById('participantForm').reset(); // Reset the form for adding a new participant
        document.getElementById('method').value = 'POST'; // Set method to POST
        document.getElementById('participantForm').action = "{{ route('admin.participants.store') }}"; // Set action for adding
        my_modal_1.showModal();
    }

    function editParticipant(id, email, name, phone, pin, group_id,photo,wishlist) {
        document.getElementById('modal-title').innerText = 'Edit Participant';
        document.getElementById('participant_email').value = email;
        document.getElementById('participant_name').value = name;
        document.getElementById('participant_phone').value = phone;
        document.getElementById('participant_group_id').value = group_id; // Set the group ID
        document.getElementById('avatar_preview').src = photo;
        document.getElementById('wish_list').text = wishlist;
        document.getElementById('avatar_preview').classList.remove('hidden');
        document.getElementById('method').value = 'PUT'; // Set method to PUT
        document.getElementById('participantForm').action = `{{ url('/admin/participants/${id}')}}`; // Set action for updating
        my_modal_1.showModal();
    }

    let cropper;

    function previewImage(event) {
        const image = document.getElementById('avatar_preview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            image.src = e.target.result;
            image.classList.remove('hidden');

            // Destroy previous cropper instance if it exists
            if (cropper) {
                cropper.destroy();
            }

            // Initialize Cropper.js
            cropper = new Cropper(image, {
                aspectRatio: 1, // Set aspect ratio to 1:1 for square cropping
                viewMode: 1,
                autoCropArea: 1,
                crop(event) {
                    // You can get the crop data here if needed
                },
            });

            // Show the confirm crop button
            document.getElementById('confirmCrop').classList.remove('hidden');
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    window.confirmCrop = function () {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const image = document.getElementById('avatar_preview');
                image.src = URL.createObjectURL(blob); // Set the preview to the cropped image
                image.classList.remove('hidden');

                // Hide the confirm crop button after cropping
                document.getElementById('confirmCrop').classList.add('hidden');
            });
        }
    }

    /*
    // Override the form submission to include the cropped image data
    document.getElementById('participantForm').onsubmit = function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the cropped canvas data
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob((blob) => {
                const formData = new FormData(this);
                formData.append('avatar', blob, 'avatar.png'); // Append the cropped image

                // Submit the form with the cropped image
                fetch(this.action, {
                    method: this.method,
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    // Handle success or error
                    console.log(data);
                    my_modal_1.close(); // Close the modal
                    location.reload(); // Reload the page to see the updated list
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        } else {
            // If no cropping is done, submit the form normally
            this.submit();
        }
    };

    */
</script>
@endsection