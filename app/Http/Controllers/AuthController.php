<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_submit(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            Auth::login($user);
    
            $dashboard = "admin.dashboard";
            return response()->json(['status' => true, 'msg' => "Success, Welcome Back!", 'location' => route($dashboard)]);
        } else {
            return response()->json(['status' => false, 'msg' => "User Not Found!"]);
        }
    }
    public function dashboard()
    {
      return view('admin.dashboard');
    }
    
    public function register()
    {
        return view('auth.register');
    }
    public function register_submit(Request $request)
    {
     
        $rules = [
            'first_name'   => 'required',
            'lastname' => 'required',
            'phone_number' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'resume_upload' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'message' => $validator->errors()->first()));
        }
        if ($request->hasFile('resume_upload')) {
            $attach_file1 = 'file_' . time() . '.' . $request->file('resume_upload')->getClientOriginalExtension();
            $request->file('resume_upload')->move(public_path('resume/'), $attach_file1);
        } else {
            $attach_file1 = '';
        }
    
        if ($request->hasFile('croppedImage')) {
            $croppedImage = $request->file('croppedImage');
    
            // Process and save the image
            $filename = time() . '_' . $croppedImage->getClientOriginalName();
            $croppedImage->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }

        $data = [
            'name'   => $request->first_name,
            'last_name'   => $request->lastname,
            'phone_number'   => $request->input('phone_number'),
            'email'   => $request->input('email'),
            'address'   => $request->input('address'),
            'dob'   => $request->input('dob'),
            'gender'   => $request->input('gender'),
            'resume'   => $attach_file1,
            'image'   => $imagePath,   
        ];
        
        $user = new User();
        $insert = $user->insert($data);
        
        if ($insert) {
            return response()->json(['status' => true, 'location' => route('login'), 'message' => 'Data update to the table successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!']);
        }

    }

    public function logout()
    { 
        Auth::logout();
        return view('auth.login');
    }

    public function index(Request $request)
    {
     
          
               if (isset($request->search['value'])) {
                   $search = $request->search['value'];
               } else {
                   $search = '';
               }
               if (isset($request->length)) {
                   $limit = $request->length;
               } else {
                   $limit = 10;
               }
               if (isset($request->start)) {
                   $ofset = $request->start;
               } else {
                   $ofset = 0;
               }
               $orderType = $request->order[0]['dir'];
               $nameOrder = $request->columns[$request->order[0]['column']]['name'];
               $loggedInUserId = auth()->user()->id;
               $total = User::select('users.*')
               ->where(function ($query) use ($search) {
                   $query->orWhere('users.name', 'like', '%' . $search . '%');
               
               }) ->where('users.id', $loggedInUserId);
               $total = $total->count();
           
               $books = User::select('users.*')
               ->where(function ($query) use ($search) {
                   $query->orWhere('users.name', 'like', '%' . $search . '%');
               })->where('users.id', $loggedInUserId)
               ->orderBy( $nameOrder, $orderType)
               ->limit($limit)
               ->offset($ofset)
               ->get();
           
               $i = 1 * $ofset;
               $data = [];
           
               foreach ($books as $key => $item) {
                $action = '
                <button class="px-2 py-0 btn-primary mydatashow rounded mt-2" data-id="' . $item->id . '">
                <i class="fas fa-eye" aria-hidden="true"></i> 
            </button>
                <a href="' . route('admin.edit_user', $item->id) . '" class="px-2 py-1 bg-warning rounded text-white" id="editClient" style="margin: 5px;">
                    <i class="fa fa-edit"></i>
                </a>
                <button class="px-2 py-0 btn-danger customerDelete rounded mt-2" data-id="' . $item->id . '">
                    <i class="fas fa-trash" aria-hidden="true"></i>
                </button>
            
            ';

                   $image = '<img src="public/'. $item->image . '" alt="Item Image" width="80">';
                   $profile = '<a href="public/resume/' . $item->resume . '" download><i class="fas fa-download"></i></a>';
    
              
                
                   
                   $data[] = array(
                       $i + $key + 1,
    
                       $image,
                       $item->name,
                       $item->last_name,
                       $item->phone_number,
                       $item->email ,
                       $item->dob,
                       $item->gender,  
                       $profile,
                       $action,               
                   );
               }        
               // Session::put('filter',$request->all());
               $records['recordsTotal'] = $total;
               $records['recordsFiltered'] = $total;
               $records['data'] = $data;
               echo json_encode($records);
      
       
        
    }
    public function edit_user($id)
    {
            $data= User::find($id);
            return view("admin.user.edit",compact('data'));
    }
    public function update(Request $request)
    {
        $rules = [
         
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('result' => false, 'message' => $validator->errors()->first()));
        }
        $user = User::find($request->id);
        if ($request->hasFile('resume_upload')) {
            $attach_file1 = 'file' . time() . '.' . $request->file('resume_upload')->getClientOriginalExtension();
            $request->file('resume_upload')->move(public_path('resume/'), $attach_file1);
        } else {
            $attach_file1 = $user->resume;
        }
        if ($request->hasFile('croppedImage')) {
            $croppedImage = $request->file('croppedImage');
    
            // Process and save the image
            $filename = time() . '_' . $croppedImage->getClientOriginalName();
            $croppedImage->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }
        else{
        $imagePath=$user->image;
        }  
        $data = [
            'name'   => $request->first_name,
            'last_name'   => $request->last_name,
            'phone_number'   => $request->input('phone_number'),
            'email'   => $request->input('email'),
            'address'   => $request->input('address'),
            'dob'   => $request->input('dob'),
            'gender'   => $request->input('gender'),
            'resume'   => $attach_file1,
            'image'   => $imagePath,   
        ];
        $insert = $user->update($data);
        
        if ($insert) {
            return response()->json(['status' => true, 'location' => route('admin.dashboard'), 'message' => 'Data update to the table successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something Went Wrong!']);
        }
    }

    public  function delete_user(Request $request)
    {
       $delete = User::where('id', $request->id)->delete();
  
       if ($delete) {
           return response()->json(['status' => true, 'message' => "Data Deleted Successfully"]);
       } else {
           return response()->json(['status' => false, 'message' => "Error Occurred, Please try again"]);
       }
    }

    public function showdata(Request $request)
    {
        $data = User::find($request->id);
        if($data){
            return response()->json([
                'status' => true,
                'user' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
        }
    }
    

    
}
