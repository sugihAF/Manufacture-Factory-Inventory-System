<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Machine;
use App\Models\Workload;
use Illuminate\Support\Facades\Auth;

class FactoryController extends Controller
{
    public function dashboard()
    {
        // Get the authenticated factory
        $factory = Auth::guard('factory')->user();

        // Load the machines relationship
        $factory->load('machines');

        // Retrieve workloads associated with the factory
        $workloads = Workload::where('factory_id', $factory->id)->get();

        // Retrieve available machines (status 'Available') associated with the factory
        $availableMachines = Machine::where('factory_id', $factory->id)
                                    ->where('status', 'Available')
                                    ->get();

        return view('factory.dashboard', compact('factory', 'workloads', 'availableMachines'));
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
    public function setMachineAvailable($id)
    {
        // Get the authenticated factory
        $factory = Auth::guard('factory')->user();

        // Find the machine associated with the factory and in 'Maintenance' status
        $machine = Machine::where('factory_id', $factory->id)
                          ->where('id', $id)
                          ->where('status', 'Maintenance')
                          ->first();

        if (!$machine) {
            return redirect()->route('factory.dashboard')->with('error', 'Machine not found or not in Maintenance.');
        }

        // Update machine status to 'Available'
        $machine->status = 'Available';
        $machine->save();

        return redirect()->route('factory.dashboard')->with('success', 'Machine status updated to Available.');
    }

    /**
     * Accept a workload by assigning an available machine.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  Workload ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptWorkload(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
        ]);

        // Get the authenticated factory
        $factory = Auth::guard('factory')->user();

        // Find the workload
        $workload = Workload::where('factory_id', $factory->id)
                            ->where('id', $id)
                            ->where('status', '!=', 'Working') // Ensure workload isn't already working
                            ->first();

        if (!$workload) {
            return redirect()->route('factory.dashboard')->with('error', 'Workload not found or already in progress.');
        }

        // Find the selected machine
        $machine = Machine::where('factory_id', $factory->id)
                          ->where('id', $request->input('machine_id'))
                          ->where('status', 'Available')
                          ->first();

        if (!$machine) {
            return redirect()->route('factory.dashboard')->with('error', 'Selected machine is not available.');
        }

        // Update workload status and assign machine
        $workload->status = 'Working';
        $workload->machine_id = $machine->id;
        $workload->save();

        // Update machine status to 'Busy'
        $machine->status = 'Busy';
        $machine->save();

        return redirect()->route('factory.dashboard')->with('success', 'Workload accepted and machine assigned successfully.');
    }
}