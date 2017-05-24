<?php 
namespace App\Http\Traits;

use Auth;
use Illuminate\Http\Request;
use App\Models\GithubUser;
use App\Models\QqUser;
use App\Models\WeiboUser;
use App\Models\TwitterUser;
use App\Models\User;
use Socialite;
use Validator;
use MyUpload;

trait SocialiteUser
{
    /**
     * 允许登录的第三方
     */
    protected $filterLogin = ['github', 'wechat', 'qq', 'weibo', 'twitter'];
    
    /**
     * 
     * @var [type]
     */
    protected $redirectCreate = "/createUser";
    
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        $type = $request->input('type') ? : '';
        $driver = in_array($request->input('driver'), $this->filterLogin) ? $request->input('driver') : 'qq';
        
        if($type == 'bind' || $type == 'unbind'){
            if(!$this->guard()->check()){
                flash('您还未登录，请先登录', 'warning');
                return redirect($this->redirectTo);
            }
        }else {
            if($this->guard()->check()){
                return redirect($this->redirectTo);
            }
        }
        
        app('config')['services.'.$driver.'.redirect'] = app('config')['services.'.$driver.'.redirect']."/".$type;  // type 参数 callback 带不回来，问题未解决
        
        return Socialite::driver($driver)->redirect();
        
        // return Socialite::driver($driver)        // with 参数可以带进去，但是带不回来
        //         ->with(['login_type' => $type])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * @param driver    第三方驱动
     * @param type      登录还是绑定    
     * @return Response
     */
    public function handleProviderCallback(Request $request, $driver = 'qq', $type = '')
    {
        var_dump($driver);
        var_dump($type);exit;
        
        $driver = in_array($driver, $this->filterLogin) ? $driver : 'qq';

        if ($type == 'bind') {
            $this->bindDriver($driver, $type);
        } else if ($type == 'unbind') {
            $this->unbindDriver($driver, $type);
        } else {
            $this->loginDriver($driver, $type);
        }
    }
    
    /**
     * 第三方登录
     * @author @smallnews 2017-05-23
     * @param  [type] $driver [第三方驱动]
     */
    protected function loginDriver($driver) {
        $socialiteUser= $this->getSocialiteUser($driver);      // 获取第三方数据
        
        if($socialiteUser['token']){
            $method = "get".ucfirst($driver)."User";
            $driverUser = $this->$method($socialiteUser);
            
            if($driverUser){        // 找到第三方用户
                $this->guard()->loginUsingId($driverUser['user_id'], true);
                flash('登录成功', 'success');
                
                return redirect($this->redirectTo);
            }else {                 // 创建用户和第三方用户
                session()->flash('socialiteUser', $socialiteUser);
                session()->flash('driver', $driver);
                
                return redirect($this->redirectCreate);
            }
        }
        
        // 没有获取到第三方数据
        flash('请刷新重试', 'warning');
        return redirect($this->redirectTo);
    }
    
    /**
     * 第三方绑定
     * @author @smallnews 2017-05-23
     * @param  [type] $driver [第三方驱动名称]
     */
    protected function bindDriver($driver) {
        $socialiteUser= $this->getSocialiteUser($driver);      // 获取第三方数据

        if($socialiteUser['token']){
            $method = "get".ucfirst($driver)."User";
            $driverUser = $this->$method($socialiteUser);
            
            if($driverUser){
                if (empty($driverUser['user_id'])) {
                    $driverUser->user_id = $this->guard->id();
                    $driverUser->save();
                    
                    flash('绑定成功', 'success');
                    return redirect()->route('user.bind');
                }
                
                flash('该第三方账号已被绑定其他帐号，请解绑之后重新绑定', 'warning');
                return redirect($this->redirectTo);
            }else {
                $method = "create".ucfirst($driver)."User";
                $driverUser = $this->$method($socialiteUser, $this->guard->id());
                
                $third_id = $driver."_id";
                
                $user = Auth::user();
                $user->$third_id = $driverUser->id;
                $user->save();
                
                flash('绑定成功', 'success');
                return redirect()->route('user.bind');
            }
        }
        
        // 没有获取到第三方数据
        flash('绑定失败，请刷新重试', 'warning');
        return redirect($this->redirectTo);
    }
    
    /**
     * 解绑第三方登录
     * @author @smallnews 2017-05-23
     * @param  [type] $driver [第三方驱动名称]
     */
    protected function unbindDriver($driver) {
        $user = Auth::user();
        
        if ($user->source_driver == $driver) {
            flash('创建账号的第三方账号不能解绑', 'success');
            return redirect()->route('user.bind');
        }
        
        $socialiteUser= $this->getSocialiteUser($driver);      // 获取第三方数据

        if($socialiteUser['token']){
            $method = "get".ucfirst($driver)."User";
            $driverUser = $this->$method($socialiteUser);
            
            if($driverUser){
                $driverUser->user_id = '';
                $driverUser->save();
                
                $third_id = $driver."_id";
                
                
                $user->$third_id = '';
                $user->save();
                
                flash('解绑成功', 'success');
                return redirect()->route('user.bind');
            }
        }
        
        // 没有获取到第三方数据
        flash('解绑失败，请刷新重试', 'warning');
        return redirect($this->redirectTo);
    }
    
    
    /**
     * getSocialiteUser
     * @author @smallnews 2016-12-28
     * @param  [type] $driver [description]
     * @return [type]         [description]
     */
    protected function getSocialiteUser($driver){
        $thirdUser = Socialite::driver($driver)->user();

        $simUser = array(
            'token' => $thirdUser->token,
            'id' => $thirdUser->getId(),
            'avatar' => $thirdUser->getAvatar(),
            'name' => $thirdUser->getNickname(),
            'email' => $thirdUser->getEmail()
        );

        return $simUser;
    }
    
    /**
     * 通过token 获取 Socialite 用户
     * @author @smallnews 2016-12-28
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    protected function getSocialiteUserFromToken($driver, $token){
        $thirdUser = Socialite::driver($driver)->userFromToken($token);
        
        return $thirdUser;
    }
    
    
    /**
     * 用户通过github 登录，获取 github 用户       get.Driver.User
     */
    protected function getGithubUser($thirdUser){
        $githubUser = new GithubUser();
        
        return $githubUser->getGithubUser($thirdUser['id']);
    }
    
    /**
     * 用户通过qq 登录，获取 qq 用户       get.Qq.User
     */
    protected function getQqUser($thirdUser){
        $qqUser = new QqUser();
        
        return $qqUser->getQqUser($thirdUser['id']);
    }
    
    /**
     * 用户通过weibo 登录，获取 weibo 用户       get.Weibo.User
     */
    protected function getWeiboUser($thirdUser){
        $weiboUser = new WeiboUser();
        
        return $weiboUser->getWeiboUser($thirdUser['id']);
    }
    
    /**
     * 用户通过twitter 登录，获取 twitter 用户       get.twitter.User
     */
    protected function getTwitterUser($thirdUser){
        $twitterUser = new TwitterUser();
        
        return $twitterUser->getTwitterUser($thirdUser['id']);
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
        $this->validator($request->all())->validate();
        // 创建 User
        $user = $this->create($request->all());

        // create third user
        $socialite = $this->createSocialiteUser($user->id);

        $driver = request()->input('driver');
        
        $third_id = $driver."_id";
        $user->$third_id = $socialite->id;
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
            'driver' => 'required|in:'.join(',', $this->filterLogin),
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
    
    
    /**
     * Create 第三方用户 user
     *
     * @param  array  $data
     * @return User
     */
    protected function createSocialiteUser($user_id)
    {
        $driver = request()->input('driver');
        $token = request()->input('token');
        $socialiteUser = $this->getSocialiteUserFromToken($driver, $token);
        
        // 创建对应的第三方用户
        $method = "create".ucfirst($driver)."User";
        return $this->$method($socialiteUser, $user_id);
    }
    
    /**
     * [创建github 用户]
     * @author @smallnews 2017-01-20
     */
    protected function createGithubUser($githubUser, $user_id){
        return GithubUser::create([
            'github_id' => $githubUser->getId(),
            'nick_name' => $githubUser->getNickname(),
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'avatar' => $githubUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    /**
     * [创建 qq 用户]
     * @author @smallnews 2017-01-20
     */
    protected function createQqUser($qqUser, $user_id){
        return QqUser::create([
            'qq_id' => $qqUser->getId(),
            'nick_name' => $qqUser->getNickname(),
            'name' => $qqUser->getName(),
            'email' => $qqUser->getEmail(),
            'avatar' => $qqUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    
    /**
     * [创建 weibo 用户]
     * @author @smallnews 2017-03-17
     */
    protected function createWeiboUser($weiboUser, $user_id){
        return WeiboUser::create([
            'weibo_id' => $weiboUser->getId(),
            'nick_name' => $weiboUser->getNickname(),
            'name' => $weiboUser->getName(),
            'email' => $weiboUser->getEmail(),
            'avatar' => $weiboUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    /**
     * [创建 weibo 用户]
     * @author @smallnews 2017-03-17
     */
    protected function createTwitterUser($twitter, $user_id){
        return TwitterUser::create([
            'twitter_id' => $twitter->getId(),
            'nick_name' => $twitter->getNickname(),
            'name' => $twitter->getName(),
            'email' => $twitter->getEmail(),
            'avatar' => $twitter->getAvatar(),
            'user_id' => $user_id
        ]);
    }
}

