<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationInfo;
use Illuminate\Support\Facades\DB;

class ApplicationInfoController extends Controller
{
    public function create()
    {
        $row = DB::table('club_list')
        ->get();
        
        $data = [
            'Info'=> $row
        ];

        return view ('applications.create', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Determine which departments were selected
        $selectedDepartments = $data['departments'] ?? [];

        // Prepare department statuses
        $departmentStatuses = [
            'onm_status' => in_array('ONM', $selectedDepartments) ? 0 : 3,
            'cits_status' => in_array('CITS', $selectedDepartments) ? 0 : 3,
            'facilities_status' => in_array('Facilities', $selectedDepartments) ? 0 : 3,
            'security_status' => in_array('Security', $selectedDepartments) ? 0 : 3,
            'finance_status' => in_array('Finance', $selectedDepartments) ? 0 : 3,
            'administration_status' => in_array('Administration', $selectedDepartments) ? 0 : 3,
            'councilaffairs_status' => in_array('Council Affairs', $selectedDepartments) ? 0 : 3,
            'mpr_status' => in_array('MPR', $selectedDepartments) ? 0 : 3,
            'dean_status' => 0, // Set dean_status to 0
            'vc_status' => 0,   // Set vc_status to 0
            'dosa_status' => 0, // Set dosa_status to 0
            // Add more departments here
        ];

        // Add department statuses to data array
        $data = array_merge($data, $departmentStatuses);

        $application = ApplicationInfo::create($data);

        return redirect()->back()->with('success', 'Application created successfully.');
    }

}
