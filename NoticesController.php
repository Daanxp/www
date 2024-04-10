<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mentor;
use App\Models\Notice;
use App\Models\Reason;
use App\Models\User;

class NoticesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::where('created_at', '>=', now()->subDays(10)->setTime(0, 0, 0)->toDateTimeString())->orderby('created_at', 'asc')->get();
//return $notices;
        return view('dashboard/notices/index')->with('notices', $notices);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mentors = Mentor::all();
        $reasons = Reason::where('is_active', '=', true)->get();
        
        return view('dashboard/notices/create')
            ->with('mentors', $mentors)
            ->with('reasons', $reasons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'mentor_id' => 'required'
        ]);
        //dd($request);
        //$imgName = $request->file('img');
        //Storage::store($request->file('img'), 'public');
        //$request->file('img')->store('img', $imgName);

        $file = $request->file('img');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('img', 'public');

        $notice = new Notice();
        $notice->user_id = \Auth::id();
        $notice->mentor_id = $request->mentor_id;
        $notice->reason_id = $request->reason_id;
        $notice->img = $filePath;
        $notice->save();

        return redirect()->route('notices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        $mentors = Mentor::all();

        return view('dashboard/notices/edit')
                ->with(['notice' => $notice])
                ->with('mentors', $mentors);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'mentor_id' => 'required'
        ]);

        $notice = Notice::findOrFail($id);
        $notice->mentor_id = $request->mentor_id;
        if($request->is_approved == '1'){
        $notice->is_approved = $request->is_approved;
        }
        $notice->save();

        session()->flash('message', 'Notice succesfully saved.');

        return redirect()->route('notices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Notice::destroy($id);

        return redirect()->route('notices.index');
    }
}
