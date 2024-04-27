<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\Job;
use App\Models\JobType;
use App\Models\State;
use App\Models\TutorApplication;
use App\Models\TutorEmployment;
use App\Models\User;
use App\Models\UserActivity;
use App\Notifications\SendEmployerNotification;
use App\Notifications\SendPushNotification;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Jobs extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage(Request $request)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        $jobs = Job::where('status',1)->orderBy('id','desc')->paginate(9);
        if ($request->ajax()){

            $view = view('dashboard.users.jobs.job_data', compact('jobs'))->render();

            return response()->json(['html' => $view]);
        }
        $country = Country::where('iso3',$user->countryCode)->first();

        return view('dashboard.users.jobs.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Job Hall',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'jobs'          =>$jobs,
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'jobTypes'      =>JobType::where('status',1)->get()
        ]);
    }
    //search job
    public function searchJob(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'nullable|string',
            'state' => 'nullable|string',
            'work_type' => 'nullable|string',
        ]);

        $query = Job::query();

        // Check if title parameter exists and is filled
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $validatedData['title'] . '%');
        }

        // Check if state parameter exists and is filled
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' .$validatedData['state'].'%');
        }

        // Check if work_type parameter exists and is filled
        if ($request->filled('work_type')) {
            $query->where('typeOfJob','like', '%' . $validatedData['work_type'].'%');
        }

        // Execute the query
        $results = $query->where('status',1)->orderBy('id','desc')->paginate(15)->withQueryString();


        // Check if no results found
        if ($results->isEmpty()) {
            // Fallback to displaying a list of all jobs
            $fallBack = Job::where('status',1)->orderBy('id','desc')->paginate(15)->withQueryString();
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $country = Country::where('iso3',$user->countryCode)->first();
            return view('dashboard.users.jobs.job_search_result')->with([
                'web'           =>$web,
                'siteName'      =>$web->name,
                'pageName'      =>'Job Hall - Search Page',
                'user'          =>$user,
                'accountType'   =>$this->userAccountType($user),
                'jobs'          =>$results,
                'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
                'jobTypes'      =>JobType::where('status',1)->get(),
                'searchParam'   =>$validatedData,
                'fallbackJobs'  =>$fallBack
            ]);
        }


        $user = Auth::user();
        $web = GeneralSetting::find(1);

        $country = Country::where('iso3',$user->countryCode)->first();
        return view('dashboard.users.jobs.job_search_result')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Job Hall - Search Page',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'jobs'          =>$results,
            'states'        =>State::where('country_code',$country->iso2)->orderBy('name','asc')->get(),
            'jobTypes'      =>JobType::where('status',1)->get(),
            'searchParam'   =>$validatedData
        ]);
    }
    //job details
    public function jobDetails($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        $job = Job::where('reference',$id)->where('user','!=',$user->id)->firstOrFail();

        return view('dashboard.users.jobs.job_details')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Job Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'job'           =>$job,
            'employer'      =>User::where('id',$job->user)->first()
        ]);
    }
    //apply for job
    public function applyForJob(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $job = Job::where('reference', $id)->where('user', '!=', $user->id)->first();
            if (empty($job)) {
                return $this->sendError('job.error', ['error' => 'Job not found']);
            }
            if ($job->status != 1) {
                return $this->sendError('job.error', ['error' => 'Application already closed for job']);
            }
            $validator = Validator::make($request->all(), [
                'coverLetter' => [
                    'required', 'string'
                ],
                'hasCv' => [
                    'nullable', 'numeric', 'integer'
                ],
                'Cv' => [
                    'nullable', 'required_with:hasCv', 'mimes:pdf', 'max:10240'
                ]
            ])->stopOnFirstFailure();
            if ($validator->fails()) {
                return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
            }
            $input = $validator->validated();

            //check if user has applied to job
            $applicationExists = TutorApplication::where([
                'user' => $user->id, 'jobId' => $job->id
            ])->first();
            if (!empty($applicationExists)) {
                return $this->sendError('application.error', ['error' => 'You have already applied for this job']);
            }
            //check if user uploaded document
            if ($request->hasFile('Cv')) {
                //upload document
                $google = new GoogleUpload();
                $imageResult = $google->uploadGoogle($request->file('cv'));
                $cv = $imageResult['link'];
            } else {
                $cv = $user->tutorCv;
            }
            $employer = User::where('id', $job->user)->first();

            //replace the cover-letter
            $coverLetter = $this->replaceCoverLetter($input['coverLetter'], $employer, $job, $user);

            $reference = $this->generateUniqueReference('tutor_applications', 'reference', 8);

            $application = TutorApplication::create([
                'user' => $user->id, 'jobId' => $job->id, 'coverLetter' => clean($coverLetter),
                'tutorCv' => $cv, 'status' => 2, 'reference' => $reference,'employer'=>$employer->id
            ]);
            if (!empty($application)) {

                $job->numberOfApplication=$job->numberOfApplication+1;
                $job->save();

                $message = 'You applied for the position of  '.$job->title.' which was listed by '.empty($employer->companyName)?$employer->name:$employer->companyName;
                $employerMessage = "
                    A new application has been received on <b>".$web->name."</b> for the position of <b>".$job->title."</b> which you listed.
                    The applicant's details are not included in this mail for security reasons; however, you can log in to your
                    account and view this application.
                ";
                UserActivity::create([
                    'user'=>$user->id,'title'=>'New Job Application',
                    'content'=>$message
                ]);
                //send notification
                $user->notify(new SendPushNotification($user,'New job application received.',$message));
                $employer->notify(new SendEmployerNotification($employer,$employerMessage,'New Job Application'));

                return $this->sendResponse([
                    'redirectTo'=>route('user.applications.index')
                ],'Job application successfully submitted.');
            }
            $this->sendError('application.error', ['error' => 'Something went wrong']);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('job.application.error',['error'=>'Internal Server Error']);
        }
    }
    //employments
    public function employments()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.jobs.employments')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Current Employments',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'employments'   =>TutorEmployment::where([
                'user' => $user->id,
                'status' => 1
            ])->paginate()
        ]);
    }
    //employment details
    public function employmentDetails($id)
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        $employment = TutorEmployment::where('reference',$id)->firstOrFail();

        return view('dashboard.users.jobs.employment_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Job Detail',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'employment'    =>$employment
        ]);
    }
}
