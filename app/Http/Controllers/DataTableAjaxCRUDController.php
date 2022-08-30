<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Support\Facades\File;

use Datatables;
use Illuminate\Http\Request;

class DataTableAjaxCRUDController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Company::select('*'))
            ->addColumn('action', 'company-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('companies');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time().'.'.$file->extension();
            $file_full_path = '/uploads/image/';
            $destinationPath = public_path($file_full_path);
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // $name = $request->file('image')->getClientOriginalName();
            // $path = $request->file('image')->store('public/images');
            // dd($name);
            // $application->cnic_front_copy_file = $name;
             $file->move($destinationPath, $name);
        }
        $companyId = $request->id;

        $company   =   Company::updateOrCreate(
                    [
                     'id' => $companyId
                    ],
                    [
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'image' => $name,
                    ]);

        return Response()->json($company);

    }
     private function clean_file_name($value)
    {
        $result = preg_replace('/[^a-zA-Z0-9_.-]/s', '', $value);
        return $result;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $company  = Company::where($where)->first();

        return Response()->json($company);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company = Company::where('id',$request->id)->delete();

        return Response()->json($company);
    }
}


