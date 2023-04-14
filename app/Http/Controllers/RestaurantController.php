<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // Retrieve all restaurants and return them as a JSON response
    public function index()
    {
        $restaurants = Restaurant::with('user')->get();
        return response()->json($restaurants);
    }

    // Validate the incoming request, create a new restaurant, and return a success message along with the created restaurant as a JSON response
    public function store(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id|unique:restaurants,user_id',
        //     'name' => 'required',
        //     'description' => 'required',
        //     'logo_url' => 'nullable|url',
        //     'address' => 'required',
        //     'phone_number' => 'required',
        //     'email' => 'required|email',
        // ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => 'restaurant'
        ]);

        // // Create the associated restaurant record
        // $restaurant = Restaurant::create([
        //     'user_id' => $user->id,
        //     'name' => $request->input('name'),
        //     'description' => $request->input('description'),
        //     'logo_url' => $request->input('logo_url'),
        //     'address' => $request->input('address'),
        //     'phone_number' => $request->input('phone_number'),
        //     'email' => $request->input('email'),
        // ]);

        return response()->json(['message' => 'Restaurant added successfully', 'restaurant' => $user], 201);
    }

    // Retrieve a specific restaurant by their ID and return them as a JSON response
    public function show(Restaurant $restaurant)
    {
        $restaurant->load('user');
        return response()->json($restaurant);
    }

    // Validate the incoming request, update the specified restaurant, and return a success message along with the updated restaurant as a JSON response
    public function update(Request $request, Restaurant $restaurant)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // Update the restaurant's details
        $restaurant->update([
            'name' => $request->name,
            'description' => $request->description,
            'logo_url' => $request->logo_url,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->!email,
        ]);

        // Return a success message or the updated restaurant's details
        return response()->json(['message' => 'Restaurant updated successfully', 'restaurant' => $restaurant]);
    }

    // Delete the specified restaurant and return a success message as a JSON response
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json(['message' => 'Restaurant deleted successfully']);
    }
}

