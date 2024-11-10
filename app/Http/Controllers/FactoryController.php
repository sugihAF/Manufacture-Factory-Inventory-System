<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;

class FactoryController extends Controller
{
    public function dashboard()
    {
        // Get the authenticated factory
        $factory = Auth::guard('factory')->user();

        // Load the factory along with its machines
        $factory->load('machines');

        return view('factory.dashboard', compact('factory'));
    }
    public function setMachineMaintenance($id)
    {
        // Get the authenticated factory
        $factory = Auth::guard('factory')->user();

        // Find the machine belonging to the factory
        $machine = $factory->machines()->where('id', $id)->first();

        if ($machine) {
            // Update the machine status to 'Maintenance'
            $machine->status = 'Maintenance';
            $machine->save();

            return redirect()->route('factory.dashboard')->with('success', 'Machine status updated to Maintenance.');
        } else {
            return redirect()->route('factory.dashboard')->with('error', 'Machine not found or not authorized.');
        }
    }
}