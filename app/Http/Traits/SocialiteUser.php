<?php 
namespace App\Http\Traits;

use Auth;
use Request;
use App\Models\GithubUser;
use App\Models\User;
use Socialite;

trait SocialiteUser
{
    /**
     * 允许登录的第三方
     */
    protected $filterLogin = ['github'];
    
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
        $driver = in_array($request->input('driver'), $this->filterLogin) ? $request->input('driver') : 'github';
        
        if($this->guard()->check()){
            return redirect($this->redirectTo);
        }
        
        return Socialite::driver($driver)
                ->with(['dirver' => $dirver])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $driver = in_array($request->input('driver'), $this->filterLogin) ? $request->input('driver') : 'github';
        
        $socialiteUser= $this->getSocialiteUser($driver);      // 获取第三方数据

        if($socialiteUser->token){
            $driverUser = $this->get.ucfirst($driver).User($socialiteUser);
            
            if($driverUser){
                $this->guard()->loginUsingId($driverUser['user_id'], true);
                return redirect($this->redirectTo)->withSuccess('登录成功');
            }else {
                // 创建用户和第三方用户
                $request->session()->flash('socialiteUser', $socialiteUser);
                $request->session()->flash('driver', $driver);
                return redirect($this->redirectCreate);
            }
        }
        
        // 没有获取到第三方数据
        return redirect($this->redirectTo)->withError('请刷新重试');
    }
    
    
    /**
     * getSocialiteUser
     * @author @smallnews 2016-12-28
     * @param  [type] $driver [description]
     * @return [type]         [description]
     */
    protected function getSocialiteUser($driver){
        $thirdUser = Socialite::driver($driver)->user();

        return $thirdUser;
    }
    
    /**
     * 通过token 获取 Socialite 用户
     * @author @smallnews 2016-12-28
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    protected function getSocialiteUserFromToken($driver, $token){
        Socialite::driver($driver)->userFromToken($token);
        
        return $thirdUser;
    }
    
    
    /**
     * 用户通过github 登录，获取 github 用户       get.Driver.User
     */
    protected function getGithubUser($thirdUser){
        $githubUser = new GithubUser();
        
        return $githubUser->getGithubUser($thirdUser->id);
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
    public function createUser(){
        $this->validator($request->all())->validate();

        // 创建 User
        $user = $this->create($request->all());

        // create third user
        $github = $this->createSocialiteUser($user->id);

        $user->github_id = $github->id;
        $user->save();

        $this->guard()->login($user);

        return redirect($this->redirectTo)->withSuccess('登录成功');
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
            'driver' => 'required|in_array:'.$this->$filterLogin,
            'token' => 'required',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar' => $data['avator'],
            'github_name' => $data['github_name'],
            'driver' => $data['driver'],
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
        $driver = $request->input('driver');
        $token = $request->input('token');
        $socialiteUser = getSocialiteUserFromToken($driver, $token);
        
        // 创建对应的第三方用户
        return $this->create.Ucfirst($driver).User($socialiteUser);
    }
    
    protected function createGithubUser($githubUser){
        return GithubUser::create([
            'github_id' => $githubUser->getId(),
            'nick_name' => $githubUser->getNickname(),
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'avatar' => $githubUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
}

