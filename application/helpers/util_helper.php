<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 靠靠
 * @return bool
 */
function is_login(){
    return false;
}

/**
 * 靠靠靠
 * @return array
 */
function get_login(){
    return array();
}

/**
 * 靠靠靠
 * @param $user
 * @return bool
 */
function set_login($user){
    return true;
}

/**
 * 靠靠
 */
function logout(){

}

/**
 * 输出ip
 * @param null $arr
 * @param null $type
 * @param $length
 * @param array $vip_list_arr
 * @return string
 */
function output_ip($arr = null, $type = null,$length,array $vip_list_arr=array())
{
    $row = '';
    $cos = 12 /$length;
    if ($type=='checkbox'){
        $click = "onclick='return false'";
    }else{
        $click = '';
    }
    foreach ($arr as $k => $v) {
        if (isset($v['assigned']) && $v['assigned'] ==1){
            $check = "checked";
        }else{
            $check = "";
        }
        if($vip_list_arr && in_array($v['ip'],$vip_list_arr)){
            $red_style = 'class="segment_vip_div col-xs-3" style="color:red"';
            $vip = '(vip)';
        }else{
            $red_style  = '';
            $vip ='';
        }

        $row .= "<div   $red_style  class='col-xs-".$cos."'><label><input required ". $click ." name='ip' ". $check ." class='ace '    type='" . $type . "' value='" . $v['ip'] . "'/><span class='lbl'> " . $v['ip'] . "</span></label></div>";
    }
    return $row;
}



/**
 * is_ip
 * 判断IP是否符合格式
 * @param string $ip
 * @return void
 */
function is_ip($ip)
{
    if (empty($ip)) {
        return false;
    }
    if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)) {
        return true;
    }else{
        return false;
    }
}

/**
 * 获取网段ip列表
 * @param null $ip_addr ip段
 * @param null $mask 掩码
 * @return array
 */
function get_segment_ip($ip_addr = null, $mask = null)
{
    if(empty($ip_addr) || empty($mask)){
        return array();
    }
    $ip = ip2long($ip_addr);
    $nm = ip2long($mask);
    $nw = ($ip & $nm);
    $bc = $nw | (~$nm);

    $data =array();
    $stat_ip = long2ip($nw + 1) ;
    $end_ip = long2ip($bc - 1) ;
    $sip=bindec(decbin(ip2long($stat_ip)));
    $eip=bindec(decbin(ip2long($end_ip)));
    for($i=$sip;$i<=$eip;$i++){
        list($s0,$s1,$s2,$s3) = explode('.',long2ip($i));
        if(!in_array($s3,array(0,255))){ //去掉*.0,*.255的ip
            array_push($data,long2ip($i));
        }
    }
    return $data;
}


function arr_to_tree($data, $pid, $level = 1, $parent_id = 'parent_id')
{
    $tree = array();
    foreach ($data as $k => $v) {

        if ($v[$parent_id] == $pid) {
            $v['level'] = $level;
            $temp = arr_to_tree($data, $v['id'], ++$level,$parent_id);
            if (!empty ($temp)) {
                $v['children'] = $temp;
                $v['folder'] = true;
                $v['expanded'] = true;
            }
            $tree [] = $v;
            $level--;
        }
    }
    return $tree;
}

/**
 * ajax返回
 * @param $data
 */
function ajax_return($data){
    exit(json_encode($data));
}


/**
 * cobbler 装机
 * @param $room_unit
 * @param $params
 * @return string
 * @throws Exception
 */
function cobbler_add_system($room_unit,$params){
    $ci = &get_instance();
    require(APPPATH.'/libraries/cobbler/CobblerApiClient.php');
    $ci->config->load('cobbler',false,true);
    $cobbler_config = $ci->config->item('cobbler');
    $client = new CobblerApiClient($cobbler_config[$room_unit]['ip'], 80, '/cobbler_api', $cobbler_config[$room_unit]['user'], $cobbler_config[$room_unit]['password'], false);

    $system_id = @$client->createSystem($params);

    return $system_id;
}

/**
 * 根据assets_id装机
 * @param $assets_id
 * @return bool
 */
function add_system($assets_id){
    if(empty($assets_id)){
        return false;
    }
    $ci = &get_instance();
    $device = $ci->db->where('assets_id',$assets_id)->get('device')->row_array();
    if(empty($device)){
        return false;
    }
    $ip_arr = $ci->db->where('assets_id',$assets_id)->where_in('ip_type',array('1'))->get('ip')->row_array();

    $host_name = '';
    $profile = '';

    $room_unit= $device['room_unit'];
    $mac0=$device['nic1_mac'];
    $mac1=$device['nic2_mac'];
    $ip = $ip_arr['ip'];
    $gateway = $ip_arr['gateway'];
    $netmask = $ip_arr['mask'];
    $static_route='0.0.0.0/0:'.$gateway;
    $params = array();
    $params['name'] = $ip;
    $params['host'] = $host_name;
    $params['mac0'] = $mac0;
    $params['mac1'] = $mac1;
    $params['netmask'] = $netmask;
    $params['static_route'] = $static_route;
    $params['profile'] = $profile;
    $params['gateway'] = $gateway;
    $params['ip'] = $ip;

    return cobbler_add_system($room_unit,$params);
}

/**
 * 获取hostname
 * @param $ip 机器ip
 * @return array
 */
function get_hostname($ip){
    $ci = &get_instance();
    $ip_info = $ci->db->where('ip',$ip)->get('ip')->row_array();
    if(empty($ip_info)){
        return 'UNKOWN'.$ip;
    }else{
        list($ip1,$ip2,$ip3,$ip4) = explode('.',$ip);
        $assets = $this->db->where('assets_id',$ip_info['assets_id'])->get('device')->row_array();
        $room = $this->db->where('room_unit',$assets['room_unit'])->get('room')->row_array();
        //todo 机房-机型-业务-容器-模块-后2位
        $hostname = '';
        return $hostname;
    }
}
