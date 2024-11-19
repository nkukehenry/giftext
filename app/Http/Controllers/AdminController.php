<?php

namespace App\Http\Controllers;

use App\Models\Participant; // Import the Participant model
use App\Models\Group; // Import the Group model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard'); // Point to the admin dashboard view
    }

    public function participants()
    {
        $institutionId = auth()->user()->institution_id; // Get the current institution ID
        // Fetch groups for the institution
        $groups = Group::where('institution_id', $institutionId)->get(); 
        // Fetch participants that belong to the groups of the institution
        $participants = Participant::whereIn('group_id', $groups->pluck('id'))->paginate(20); 
        return view('admin.participants', compact('participants', 'groups')); // Pass participants and groups to the view
    }

    public function storeParticipant(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:participants',
            'name' => 'required|string',
            'group_id' => 'required|exists:groups,id', // Validate that the group_id exists
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the avatar upload
            'wishlist' => 'nullable|string', // Validate the wish_list
        ]);

        // Generate a random login code
        $loginCode = $this->generateLoginCode();

        // Handle the avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Store the avatar in the 'public/avatars' directory
        }

        // Create the participant
        $participant = Participant::create([
            'email' => $request->email,
            'name' => $request->name,
            'pin' => $loginCode,
            'phone' => $request->phone,
            'group_id' => $request->group_id, // Store the group_id
            'avatar' => $avatarPath, // Store the avatar path
            'wishlist' => $request->wish_list, // Store the wish_list
        ]);

        return redirect()->route('admin.participants')->with('success', 'Participant added successfully!');
    }

    public function editParticipant($id)
    {
        $participant = Participant::findOrFail($id);
        return response()->json($participant); // Return participant data as JSON for the modal
    }

    public function updateParticipant(Request $request, $id)
    {
        dd($request->all());
        
        $request->validate([
            'email' => 'required|email|unique:participants,email,' . $id,
            'name' => 'required|string',
            'group_id' => 'required|exists:groups,id', // Validate that the group_id exists
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the avatar upload
            'wishlist' => 'nullable|string', // Validate the wish_list
        ]);

        $participant = Participant::findOrFail($id);

        // Handle the avatar upload
        if ($request->hasFile('avatar')) {
            // Delete the old avatar if it exists
            if ($participant->avatar) {
                \Storage::disk('public')->delete($participant->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Store the new avatar
            $participant->avatar = $avatarPath; // Update the avatar path
        }

        $participant->update($request->only('email', 'name', 'group_id', 'phone', 'wishlist')); // Update the participant's details

        return redirect()->route('admin.participants')->with('success', 'Participant updated successfully!');
    }

    private function generateLoginCode()
    {
        // Generate a random 6-digit code
        return rand(100000, 999999); // Adjust as needed
    }

    public function showAddGroupForm()
    {
        return view('admin.add_group'); // Create this view
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Get the current institution ID
        $institutionId = auth()->user()->institution_id;

       $group = Group::create([
            'name' => $request->name,
            'institution_id' => $institutionId, // Store the institution ID
        ]);

        return redirect()->back()->with('success', 'Group added successfully!');
    }

    public function groups()
    {
        $groups = Group::all(); // Fetch all groups
        return view('admin.groups', compact('groups')); // Pass groups to the view
    }

    public function updateGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::findOrFail($id);
        $group->update($request->only('name')); // Update the group name

        return redirect()->route('admin.groups')->with('success', 'Group updated successfully!');
    }

    public function destroyGroup($id)
    {
        $group = Group::findOrFail($id);
        $group->delete(); // Delete the group

        return redirect()->route('admin.groups')->with('success', 'Group deleted successfully!');
    }
}
    