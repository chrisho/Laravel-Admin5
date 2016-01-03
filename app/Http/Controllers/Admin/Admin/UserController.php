<?php
namespace App\Http\Controllers\Admin\Admin;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Http\Controllers\Admin\BaseController;

use App\Model\Admin\AdminUser;
use App\Model\Admin\AdminAssignedRole;
use App\Model\Admin\AdminRole;

use App\Http\Requests\AdminUserRequest;

class UserController extends BaseController {    
    
    public function getIndex() {
        return view('admin.admin.users.index');
    }
        
    public function getData() {
        $users = \App\Model\Admin\AdminUser::where('confirmed', 1)
                ->whereNull('deleted_at')                
                ->select(['id', 'username', 'truename', 'email', 'updated_at']);        
        
        return \Datatables::of($users)
                        ->addColumn('operations', function($row) {
                            return $this->ab_tb($row->id, 'admin/users');
                        })
                        ->editColumn('updated_at', function($row) {
                            return $row->updated_at;
                        })
                        ->removeColumn('id')
                        ->make();
    }
    
    public function getAdd() {
        $roles = AdminRole::pluck('display_name', 'id');
        
        return view('admin.admin.users.add', compact("roles"));
    }
    public function postAdd(AdminUserRequest $request) {    
        $user = new AdminUser();
        $user->username = $request->telephone;
        $user->telephone = $user->username;
        $is_user = $user
                ->where('username', $user->telephone);
        if ($is_user->count() > 0) {
            return response('手机号码已存在', 422);
        }
        
        $user->email = $user->username . "@" . env("DOMAIN", "admin5.cc");
        $user->truename = $request->truename;
        $user->password = bcrypt($request->password);
        $user->confirmed = $request->confirm ? 1 : 0;
                
        $user->save();

        if ($user->id) {
            $user->saveRoles($request->roles);

            return response(saveok());            
        } else {
            return response("操作失败", 422);
        }
    }
    
    public function getEdit() {
        $roles = AdminRole::pluck('display_name', 'id');
        $user = AdminUser::find(request('id'));
        if (!$user) {
            return $this->notfound();
        }
        
        return view('admin.admin.users.edit', compact("roles", "user"));
    }
    
    public function postEdit(AdminUserRequest $request) {
        
        $user = AdminUser::find($request->id);
        if (!$user) {
            return $this->notfound();
        }
        
        $user->username = $request->telephone;
        $user->telephone = $user->username;
        $is_user = $user
                ->where('username', $user->telephone)
                ->where('id', '!=', $user->id);
        if ($is_user->count() > 0) {
            return response('手机号码已存在', 422);
        }
        
        $user->email = $user->username . "@" . env("DOMAIN", "admin5.cc");
        $user->truename = $request->truename;
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->confirmed = $request->confirm ? 1 : 0;
                
        $user->save();
        if ($user->id) {
            $user->saveRoles($request->roles);

            return response(saveok());            
        } else {
            return response("操作失败", 422);
        }
    }
    
    public function getDelete() {
        $user = AdminUser::find(request('id'));
        if ($user->id == auth()->user()->id || $user->id == 1) {
            return response('不能删除你当前的用户', 422);
        }
        
        AdminAssignedRole::where('user_id', $user->id)->delete();
        $id = $user->id;
        $user->delete();
        $user = AdminUser::find($id);
        if (!empty($user)) {
            return response('删除失败', 422);
        } else {
            return response('删除成功');
        }        
    }
        
    /*
    |--------------------------------------------------------------------------
    | Login & Logout Actions
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */    
    
    /**
     * set username is a account name.
     *
     * @var string
     */
    protected $username = 'username';
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
        
    /**
     * Login View
     *
     * @return void
     */        
    public function getLogin() { 
        if (auth()->user()){
            return redirect('/');
        }
        
        return view('admin.admin.users.login');
    }
    
    
}