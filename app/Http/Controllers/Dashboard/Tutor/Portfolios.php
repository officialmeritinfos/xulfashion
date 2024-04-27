<?php

namespace App\Http\Controllers\Dashboard\Tutor;

use App\Custom\GoogleUpload;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\RateType;
use App\Models\UserCertification;
use App\Models\UserExperience;
use App\Models\UserSkill;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Portfolios extends BaseController
{
    use Helpers;
    //landing page
    public function landingPage()
    {
        $user = Auth::user();
        $web = GeneralSetting::find(1);

        return view('dashboard.users.portfolios.index')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>'Profile',
            'user'          =>$user,
            'accountType'   =>$this->userAccountType($user),
            'rateType'      =>RateType::where('id',$user->rateTypeId)->first(),
            'fiat'          =>Fiat::where('code',$user->mainCurrency)->first(),
            'experiences'   =>UserExperience::where('user',$user->id)->get(),
            'skills'        =>UserSkill::where('user',$user->id)->get(),
            'certifications'=>UserCertification::where('user',$user->id)->get(),
        ]);
    }
    //add experience
    public function addExperience(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'title'                 =>['required','string'],
                'employer'              =>['required','string'],
                'location'              =>['required','string'],
                'dateStart'             =>['required','date'],
                'current'               =>['nullable','numeric'],
                'dateFinish'            =>['nullable','date'],
                'description'           =>['required','string']

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $reference = $this->generateUniqueReference('user_experiences','reference',20);

            $experience = UserExperience::create([
                'user'=>$user->id,
                'reference'=>$reference,'name'=>$input['title'],
                'employer'=>$input['employer'],'address'=>$input['location'],
                'content'=>$input['description'],'timeStart'=>$input['dateStart'],
                'timeEnd'=>(empty($input['dateFinish']) || $request->filled('current'))?'':$input['dateFinish'],
                'isCurrent'=>(empty($input['dateFinish']) || $request->filled('current'))?1:2
            ]);
            if (!empty($experience)){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Experience added');
            }
            return $this->sendError('experience.error',['error'=>'Something went wrong'],421);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('experience.error',['error'=>'Internal Server Error']);
        }
    }
    //update experience
    public function updateExperience(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'title'                 =>['required','string'],
                'employer'              =>['required','string'],
                'location'              =>['required','string'],
                'dateStart'             =>['required','date'],
                'current'               =>['nullable','numeric'],
                'dateFinish'            =>['nullable','date'],
                'description'           =>['required','string'],
                'id'                    =>['required','numeric','exists:user_experiences,id']

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();


            $experience = UserExperience::where('user',$user->id)->where('id',$input['id'])->first();
            if (empty($experience)){
                return $this->sendError('experience.error',['error'=>'Work experience not found'],404);
            }

            $update = UserExperience::where('id',$experience->id)->update([
                'name'=>$input['title'],
                'employer'=>$input['employer'],'address'=>$input['location'],
                'content'=>$input['description'],'timeStart'=>$input['dateStart'],
                'timeEnd'=>(empty($input['dateFinish']) || $request->filled('current'))?'':$input['dateFinish'],
                'isCurrent'=>(empty($input['dateFinish']) || $request->filled('current'))?1:2
            ]);
            if ($update){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Work experience updated');
            }
            return $this->sendError('experience.error',['error'=>'Something went wrong'],421);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('experience.error',['error'=>'Internal Server Error']);
        }
    }
    //delete experiences
    public function deleteExperiences(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'id'  =>['required','numeric','exists:user_experiences,id'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $experiences = UserExperience::where('user',$user->id)->where('id',$input['id'])->first();
            if (empty($experiences)){
                return $this->sendError('experience.error',['error'=>'Work experience not found'],404);
            }
            $experiences->delete();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Work Experience removed.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('experience.error',['error'=>'Internal Server Error']);
        }
    }
    //truncate experiences
    public function truncateExperiences(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $experiences = UserExperience::where('user',$user->id)->get();
            if ($experiences->count()<1){
                return $this->sendError('experience.error',['error'=>'Nothing found to be deleted.'],404);
            }
            UserExperience::where('user',$user->id)->delete();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Experiences deleted.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('experience.error',['error'=>'Internal Server Error']);
        }
    }
    //add skills
    public function addSkills(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'title'                 =>['required','string',Rule::unique('user_skills','name')->where('user',$user->id)],
                'level'                 =>['required','numeric','max:10','min:1'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $skill = UserSkill::create([
                'user'=>$user->id,
                'name'=>$input['title'],
                'level'=>$input['level'],
            ]);
            if (!empty($skill)){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Skill added');
            }
            return $this->sendError('skill.error',['error'=>'Something went wrong'],421);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('skill.error',['error'=>'Internal Server Error']);
        }
    }
    //delete skills
    public function deleteSkills(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'id'  =>['required','numeric','exists:user_skills,id'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $skill = UserSkill::where('user',$user->id)->where('id',$input['id'])->first();
            if (empty($skill)){
                return $this->sendError('skill.error',['error'=>'Skill not found'],404);
            }
            $skill->delete();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Skill removed.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('skill.error',['error'=>'Internal Server Error']);
        }
    }
    //truncate experiences
    public function truncateSkills(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $skills = UserSkill::where('user',$user->id)->get();
            if ($skills->count()<1){
                return $this->sendError('experience.error',['error'=>'Nothing found to be deleted.'],404);
            }
            UserSkill::where('user',$user->id)->delete();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Skills deleted.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('skill.error',['error'=>'Internal Server Error']);
        }
    }
    //add certification
    public function addCertification(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'title'                 =>['required','string'],
                'organization'          =>['required','string'],
                'certificate'           =>['required','mimes:jpg,jpeg,pdf,png,gif','max:5000'],
                'certificateType'       =>['required','string'],
                'isPublic'              =>['nullable','numeric'],

            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            //check if certification exists
            $exists = UserCertification::where([
                'user'=>$user->id,
                'name'=>$input['title'],
                'organization'=>$input['organization']
            ])->first();

            if (!empty($exists)){
                return $this->sendError('validation.error',['error'=>'Certification already added']);
            }

            //upload image
            $google = new GoogleUpload();
            $imageResult = $google->uploadGoogle($request->file('certificate'));
            $image  = $imageResult['link'];

            $reference = $this->generateUniqueReference('user_certifications','reference',20);

            $certification = UserCertification::create([
                'user'=>$user->id,
                'name'=>$input['title'],
                'isPublic'=>$request->filled('isPublic')?1:2,
                'reference'=>$reference,
                'certType'=>$input['certificateType'],
                'link'=>$image,
                'organization'=>$input['organization']
            ]);
            if (!empty($certification)){
                return $this->sendResponse([
                    'redirectTo'=>url()->previous()
                ],'Certification added');
            }
            return $this->sendError('certification.error',['error'=>'Something went wrong'],421);
        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('certification.error',['error'=>'Internal Server Error']);
        }
    }
    //delete certification
    public function deleteCertification(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $validator = Validator::make($request->all(),[
                'id'  =>['required','numeric','exists:user_certifications,id'],
            ])->stopOnFirstFailure();
            if ($validator->fails()) return $this->sendError('validation.error',['error'=>$validator->errors()->all()],422);
            $input = $validator->validated();

            $certification = UserCertification::where('user',$user->id)->where('id',$input['id'])->first();
            if (empty($certification)){
                return $this->sendError('certification.error',['error'=>'Certification not found'],404);
            }
            //upload image
            $google = new GoogleUpload();
            $google->deleteUpload($certification->link);

            $certification->delete();

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Certification removed.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('certification.error',['error'=>'Internal Server Error']);
        }
    }
    //truncate certifications
    public function truncateCertifications(Request $request)
    {
        try {
            $user = Auth::user();
            $web = GeneralSetting::find(1);

            $certifications = UserCertification::where('user',$user->id)->get();
            if ($certifications->count()<1){
                return $this->sendError('experience.error',['error'=>'Nothing found to be deleted.'],404);
            }
            foreach ($certifications as $certification) {
                //upload image
                $google = new GoogleUpload();
                $google->deleteUpload($certification->link);

                $certification->delete();
            }

            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Certifications deleted.');

        }catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return $this->sendError('certification.error',['error'=>'Internal Server Error']);
        }
    }
}
