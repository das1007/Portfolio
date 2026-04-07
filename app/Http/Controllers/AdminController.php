<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Contact,Setting,Experience,Education,Skill,UpworkReview,Project};
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {

    /* AUTH */
    public function showLogin() {
        if (session('admin_logged_in')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }
    public function login(Request $r) {
        $r->validate(['email'=>'required|email','password'=>'required']);
        if ($r->email===env('ADMIN_EMAIL','darshan.p1792@gmail.com') && $r->password===env('ADMIN_PASSWORD','Admin@2024')) {
            session(['admin_logged_in'=>true]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials.'])->withInput();
    }
    public function logout() { session()->forget('admin_logged_in'); return redirect()->route('admin.login'); }

    /* DASHBOARD */
    public function dashboard() {
        $stats=['total'=>0,'new'=>0,'replied'=>0,'archived'=>0];
        $recent=collect(); $chartData=[]; $byType=[];
        try {
            $stats['total']=Contact::count();
            $stats['new']=Contact::where('status','new')->count();
            $stats['replied']=Contact::where('status','replied')->count();
            $stats['archived']=Contact::where('status','archived')->count();
            $recent=Contact::latest()->take(6)->get();
            for($i=6;$i>=0;$i--){$day=now()->subDays($i);$chartData[]=['label'=>$day->format('D'),'count'=>Contact::whereDate('created_at',$day)->count()];}
            $byType=Contact::selectRaw('type, count(*) as cnt')->groupBy('type')->pluck('cnt','type')->toArray();
        } catch(\Exception $e){}
        $s=Setting::allSettings();
        return view('admin.dashboard',compact('stats','recent','chartData','byType','s'));
    }

    /* SETTINGS — now handles profile image + bg_color + extra socials */
    public function saveSettings(Request $r) {
        $r->validate(['profile_image'=>'nullable|image|max:3072|mimes:jpg,jpeg,png,webp,gif']);

        // Profile image upload
        if ($r->hasFile('profile_image')) {
            $old=Setting::get('profile_image');
            if ($old && Storage::disk('public')->exists($old)) Storage::disk('public')->delete($old);
            Setting::set('profile_image', $r->file('profile_image')->store('profile','public'));
        }
        if ($r->input('remove_profile_image')==='1') {
            $old=Setting::get('profile_image');
            if ($old && Storage::disk('public')->exists($old)) Storage::disk('public')->delete($old);
            Setting::set('profile_image','');
        }

        $fields=[
            'full_name','email','phone','location','availability_text','hero_tagline','about_text',
            'years_experience','projects_count','upwork_rating','job_success',
            'upwork_section_title','upwork_section_desc',
            'linkedin_url','github_url','stackoverflow_url','upwork_url',
            'twitter_url','instagram_url','youtube_url','dribbble_url',
            'behance_url','devto_url','medium_url','website_url',
            'accent_color','bg_color',
        ];
        foreach ($fields as $f) Setting::set($f, $r->input($f,''));
        foreach (['available_for_work','show_experience','show_education','show_skills','show_upwork','show_projects','show_contact'] as $f)
            Setting::set($f, $r->has($f)?'1':'0');

        return back()->with('success','Settings saved! Portfolio updated.');
    }

    /* CONTACTS */
    public function contacts(Request $r) {
        $q=Contact::latest();
        if($r->status) $q->where('status',$r->status);
        if($r->type)   $q->where('type',$r->type);
        if($r->search) $q->where(fn($x)=>$x->where('name','like','%'.$r->search.'%')->orWhere('email','like','%'.$r->search.'%'));
        $contacts=$q->paginate(15)->withQueryString();
        $newCount=Contact::where('status','new')->count();
        return view('admin.contacts',compact('contacts','newCount'));
    }
    public function showContact(Contact $contact) {
        if($contact->status==='new') $contact->update(['status'=>'read']);
        return view('admin.contact-show',compact('contact'));
    }
    public function updateContact(Request $r,Contact $contact) {
        $contact->update(['status'=>$r->status,'admin_notes'=>$r->admin_notes]);
        return back()->with('success','Contact updated.');
    }
    public function destroyContact(Contact $contact) {
        $contact->delete();
        return redirect()->route('admin.contacts')->with('success','Deleted.');
    }

    /* EXPERIENCE — latest first in admin */
    public function experiences() { $items=Experience::latest()->get(); return view('admin.experiences',compact('items')); }
    public function storeExperience(Request $r) {
        Experience::create(['role'=>$r->role,'company'=>$r->company,'location'=>$r->location,
            'period_start'=>$r->period_start,'period_end'=>$r->period_end?:'Present',
            'description'=>$r->description,
            'bullets'=>array_values(array_filter(explode("\n",$r->input('bullets','')))),
            'tags'=>array_values(array_filter(array_map('trim',explode(',',$r->input('tags',''))))),
            'is_active'=>true,'sort_order'=>Experience::max('sort_order')+1]);
        return back()->with('success','Experience added — showing at top!');
    }
    public function updateExperience(Request $r,Experience $experience) {
        $experience->update(['role'=>$r->role,'company'=>$r->company,'location'=>$r->location,
            'period_start'=>$r->period_start,'period_end'=>$r->period_end?:'Present',
            'description'=>$r->description,
            'bullets'=>array_values(array_filter(explode("\n",$r->input('bullets','')))),
            'tags'=>array_values(array_filter(array_map('trim',explode(',',$r->input('tags',''))))),
            'is_active'=>$r->has('is_active')]);
        return back()->with('success','Experience updated!');
    }
    public function destroyExperience(Experience $experience) { $experience->delete(); return back()->with('success','Deleted.'); }

    /* EDUCATION — latest first */
    public function educations() { $items=Education::latest()->get(); return view('admin.educations',compact('items')); }
    public function storeEducation(Request $r) {
        Education::create(['degree'=>$r->degree,'institution'=>$r->institution,'location'=>$r->location,
            'period_start'=>$r->period_start,'period_end'=>$r->period_end,'emoji'=>$r->emoji?:'🎓',
            'badges'=>array_values(array_filter(array_map('trim',explode(',',$r->input('badges',''))))),
            'is_active'=>true,'sort_order'=>Education::max('sort_order')+1]);
        return back()->with('success','Education added — showing at top!');
    }
    public function updateEducation(Request $r,Education $education) {
        $education->update(['degree'=>$r->degree,'institution'=>$r->institution,'location'=>$r->location,
            'period_start'=>$r->period_start,'period_end'=>$r->period_end,'emoji'=>$r->emoji?:'🎓',
            'badges'=>array_values(array_filter(array_map('trim',explode(',',$r->input('badges',''))))),
            'is_active'=>$r->has('is_active')]);
        return back()->with('success','Education updated!');
    }
    public function destroyEducation(Education $education) { $education->delete(); return back()->with('success','Deleted.'); }

    /* SKILLS — latest first */
    public function skills() { $items=Skill::latest()->get(); return view('admin.skills',compact('items')); }
    public function storeSkill(Request $r) {
        Skill::create(['group_name'=>\Str::slug($r->group_label,'_'),'group_label'=>$r->group_label,
            'items'=>array_values(array_filter(array_map('trim',explode(',',$r->input('items',''))))),
            'is_active'=>true,'sort_order'=>Skill::max('sort_order')+1]);
        return back()->with('success','Skill group added — showing at top!');
    }
    public function updateSkill(Request $r,Skill $skill) {
        $skill->update(['group_label'=>$r->group_label,
            'items'=>array_values(array_filter(array_map('trim',explode(',',$r->input('items',''))))),
            'is_active'=>$r->has('is_active')]);
        return back()->with('success','Skills updated!');
    }
    public function destroySkill(Skill $skill) { $skill->delete(); return back()->with('success','Deleted.'); }

    /* UPWORK REVIEWS — latest first */
    public function upworkReviews() { $items=UpworkReview::latest()->get(); return view('admin.upwork-reviews',compact('items')); }
    public function storeReview(Request $r) {
        UpworkReview::create(['reviewer'=>$r->reviewer?:'Upwork Client','project_type'=>$r->project_type,
            'review_text'=>$r->review_text,'rating'=>$r->rating??5,
            'is_active'=>true,'sort_order'=>UpworkReview::max('sort_order')+1]);
        return back()->with('success','Review added — showing at top!');
    }
    public function updateReview(Request $r,UpworkReview $review) {
        $review->update(['reviewer'=>$r->reviewer,'project_type'=>$r->project_type,
            'review_text'=>$r->review_text,'rating'=>$r->rating??5,'is_active'=>$r->has('is_active')]);
        return back()->with('success','Review updated!');
    }
    public function destroyReview(UpworkReview $review) { $review->delete(); return back()->with('success','Deleted.'); }

    /* PROJECTS — latest first */
    public function projects() { $items=Project::latest()->get(); return view('admin.projects',compact('items')); }
    public function storeProject(Request $r) {
        $r->validate(['company_logo'=>'nullable|image|max:2048|mimes:jpg,jpeg,png,webp,gif,svg']);
        $logoPath='';
        if ($r->hasFile('company_logo')) $logoPath=$r->file('company_logo')->store('logos','public');
        Project::create(['title'=>$r->title,'company_name'=>$r->company_name,'company_logo'=>$logoPath,
            'description'=>$r->description,
            'tags'=>array_values(array_filter(array_map('trim',explode(',',$r->input('tags',''))))),
            'project_url'=>$r->project_url,'github_url'=>$r->github_url,
            'featured'=>$r->has('featured'),'is_active'=>true,
            'sort_order'=>Project::max('sort_order')+1]);
        return back()->with('success','Project added — showing at top!');
    }
    public function updateProject(Request $r,Project $project) {
        $r->validate(['company_logo'=>'nullable|image|max:2048|mimes:jpg,jpeg,png,webp,gif,svg']);
        $data=['title'=>$r->title,'company_name'=>$r->company_name,
            'description'=>$r->description,
            'tags'=>array_values(array_filter(array_map('trim',explode(',',$r->input('tags',''))))),
            'project_url'=>$r->project_url,'github_url'=>$r->github_url,
            'featured'=>$r->has('featured'),'is_active'=>$r->has('is_active')];
        if ($r->hasFile('company_logo')) {
            if ($project->company_logo && Storage::disk('public')->exists($project->company_logo))
                Storage::disk('public')->delete($project->company_logo);
            $data['company_logo']=$r->file('company_logo')->store('logos','public');
        }
        if ($r->input('remove_logo')==='1') {
            if ($project->company_logo && Storage::disk('public')->exists($project->company_logo))
                Storage::disk('public')->delete($project->company_logo);
            $data['company_logo']='';
        }
        $project->update($data);
        return back()->with('success','Project updated!');
    }
    public function destroyProject(Project $project) {
        if ($project->company_logo && Storage::disk('public')->exists($project->company_logo))
            Storage::disk('public')->delete($project->company_logo);
        $project->delete();
        return back()->with('success','Project deleted.');
    }
}
