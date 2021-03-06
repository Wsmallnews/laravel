<?php 
namespace App\Http\Traits;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use MyUpload;

trait ThirdOper
{
    // protected $redirectTo = "/";
    protected $redirectToCreate = "/createUser";
    protected $redirectToBind = "/user/bind";
    
    protected $myThirdLoginDriver = null;   // 自定义第三方操作对象
    protected $mySocialite = null;   // 自定义第三方 驱动 对象
    protected $request = null;
    protected $driver = null;
    protected $driverUser = null;
    protected $socialiteUser = null;
    protected $user = null;
    /**
     * 第三方登录，绑定，解绑 操作
     */

    public function __construct(){
        $this->myThirdLoginDriver = resolve('App\Repositories\MyThirdLoginDriver');
        $this->mySocialite = resolve('App\Repositories\MySocialite');
    }

    
    /**
     * 第三方登录
     * @author @smallnews 2017-05-26
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function thirdLogin(Request $request){
        $driver = $request->input('driver');

        return resolve('App\Repositories\MySocialite')->redirectToProvider($driver);   // 获取第三方数据
    }
    
    
    /**
     * 第三方绑定, 必须登录，别忘了权限
     * @author @smallnews 2017-05-26
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function thirdBind(Request $request){
        $driver = $request->input('driver');
        $type = $request->input('type');
        
        $user = Auth::user();
        $user->third_oper = $type;          // 保存操作类型
        $user->save();

        return resolve('App\Repositories\MySocialite')->redirectToProvider($driver);   // 获取第三方数据
    }
    
    
    public function thirdUnbind(Request $request){      // 解绑
        $driver = $request->input('driver');
        $type = $request->input('type');
        
        $user = Auth::user();
        $user->third_oper = $type;           // 保存操作类型
        $user->save();
        
        if ($user->source_driver == $driver) {
            flash('创建账号的第三方账号不能解绑', 'warning');
            return redirect($this->redirectToBind);
        }
        
        $this->driverUser = resolve('App\Repositories\MyThirdLoginDriver')->getThirdUserById($driver, $user->{$driver.'_id'});
        $this->driverUser->user_id = 0;
        $this->driverUser->save();
        
        $user->{$driver.'_id'} = 0;
        $user->save();
        
        flash('解绑成功', 'success');
        return redirect($this->redirectToBind);
    }
    
    
    /**
     * Obtain the user information from GitHub. 
     * @param driver    第三方驱动  
     * @return Response
     */
    public function handleProviderCallback(Request $request, $driver)
    {
        $this->request = $request;
        $this->driver = $driver;
        $this->myThirdLoginDriver = resolve('App\Repositories\MyThirdLoginDriver');
        $this->mySocialite = resolve('App\Repositories\MySocialite');
        
        $mySocialite = $this->mySocialite->handleProviderCallback($driver); // 返回 MySocialite 实例

		return $this->thirdCallBack($mySocialite);	// 获取第三方之后的本地回调
    }
    

	public function thirdCallBack($socialite = null){
		$this->socialiteUser = $socialite->socialiteUser;
		
		if ($this->socialiteUser->token) {
            if ($this->guard()->check()) {
                $this->user = $this->guard()->user();
                $method = 'third'.ucfirst($this->user->third_oper).'Back';
            }else {
                $method = 'thirdLoginBack';
            }

            if (!method_exists($this, $method)) {
                abort('third type oper not found'); // 第三方操作 不存在（登录，绑定，解绑）
            } 

            return $this->$method();       // 根据操作类型，调用对应function
		}
		
		// 没有获取到第三方数据
        flash('拉取第三方数据失败，请刷新重试', 'error');
        return redirect($this->redirectTo);
	}
    
    
    /**
     * 第三方登录回调
     * @author @smallnews 2017-05-27
     * @return [type] [description]
     */
    protected function thirdLoginBack(){
        // get third user data
        $this->driverUser = $this->myThirdLoginDriver->getThirdUserByThirdId($this->driver, $this->socialiteUser->getId());

        if($this->driverUser['user_id']){        // 找到第三方用户
            $this->guard()->loginUsingId($this->driverUser['user_id'], true);
            flash('登录成功', 'success');
            
            return redirect($this->redirectTo);
        }else {                 // 创建用户和第三方用户
            session()->flash('socialiteUser', $this->socialiteUser);
            session()->flash('driver', $this->driver);
            
            return redirect($this->redirectToCreate);
        }
    }
    
    
    /**;
     * 第三方账号绑定
     * @author @smallnews 2017-05-27
     * @return [type] [description]
     */
    protected function thirdBindBack(){
        // get third user data
        $this->driverUser = $driverUser = $this->myThirdLoginDriver->getThirdUserByThirdId($this->driver, $this->socialiteUser->getId());
        
        if ($this->driverUser['user_id']) {
            flash('绑定失败，该第三方账号已绑定其他帐号，请解绑重新绑定', 'error');
            return redirect($this->redirectToBind);
        }
            
        if($this->driverUser){        // 找到第三方用户
            //绑定
            $this->driverUser->user_id = $this->user->id;
            $this->driverUser->save();
            
            $this->user->{$this->driver."_id"} = $this->driverUser->id;
            $this->user->save();
        }else {
            // 创建第三方用户
            $this->driverUser = $this->myThirdLoginDriver->createThirdUser($this->driver, $this->socialiteUser, $this->user->id);
            
            $this->user->{$this->driver."_id"} = $this->driverUser->id;
            $this->user->save();
        }
        
        flash('绑定成功', 'success');
        return redirect($this->redirectToBind);
    }
    
    
    /**
     * 第三方 解绑，不需要返回
     * @author @smallnews 2017-05-27
     * @return [type] [description]
     */
    public function thirdUnbindBack(){
        return true;
    }
    

    /**
     * create Third user
     * @author @smallnews 2016-12-27
     * @return [type] [description]
     */
    public function showFastCreateUserForm(){
        return view('desktop.login.createUser');
    }
    
    
    /**
     * 创建用户，和第三方用户
     * @author @smallnews 2016-12-28
     * @return [type] [description]
     */
    public function createUser(Request $request){
        $driver = $request->input('driver');
        $token = $request->input('token');
        
        // 验证 输入数据
        $this->validator($request->all())->validate();
        
        // 取出第三方登录实例
        $myThird = resolve('App\Repositories\MyThirdLoginDriver');
        $mySocialite = resolve('App\Repositories\MySocialite');
        
        // 获取 socialite 用户
        $socialiteUser = $mySocialite->getSocialiteUserFromToken($driver, $token);
        
        // 创建 User
        $user = $this->create($request->all());

        // create third user
        $thirdUser = $myThird->createThirdUser($driver, $socialiteUser, $user->id);
        
        $user->{$driver."_id"} = $thirdUser->id;    // 绑定
        $user->save();

        $this->guard()->login($user);
        
        flash('登录成功', 'success'); 
        return redirect($this->redirectTo);
    }
    
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'driver' => 'required|in:'.join(',', resolve('App\Repositories\MySocialite')->filterLogin),
            'token' => 'required',
        ],[
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // 检测头像 host 是否是 配置的host ，如果不是，将图片转存
        if (parse_url($data['avatar'])['host'] != config('qcloud.cos.host')) {
            $result = MyUpload::uploadCopy($data['avatar'], 'avatars');
            
            if (!$result['error']) {
                $data['avatar'] = $result['data']['url'];
            }
        }
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => $data['avatar'],
            'source_driver' => $data['driver'],
        ]);
    }
}

