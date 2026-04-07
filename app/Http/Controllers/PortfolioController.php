<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Setting,Experience,Education,Skill,UpworkReview,Contact,Project};

class PortfolioController extends Controller {
    public function index() {
        $s           = Setting::allSettings();
        $experiences = Experience::active()->get();   // latest first
        $educations  = Education::active()->get();    // latest first
        $skills      = Skill::active()->get();        // latest first
        $reviews     = UpworkReview::active()->get(); // latest first
        $projects    = Project::active()->get();      // latest first
        return view('pages.home', compact('s','experiences','educations','skills','reviews','projects'));
    }
    public function contact(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ]);
        $c = Contact::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'subject'  => $request->subject,
            'type'     => $request->type ?? 'general',
            'budget'   => $request->budget,
            'timeline' => $request->timeline,
            'message'  => $request->message,
        ]);
        try {
            \Mail::to(env('ADMIN_EMAIL','darshan.p1792@gmail.com'))
                ->send(new \App\Mail\ContactNotification($c));
        } catch(\Exception $e) {}
        return back()->with('success', "Thank you {$c->name}! I'll reply within 24 hours 🚀");
    }
}
