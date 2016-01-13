<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Open extends CI_Controller
{
    //获取各机房的cobbler ip
    function  get_cobbler_ip()
    {
        $ci = &get_instance();
        $ci->config->load('cobbler', false, true);
        $cobbler_config = $ci->config->item('cobbler');
        foreach ($cobbler_config as $item) {
            $res[] = $item['ip'];
        }
        exit(implode(',', array_unique($res)));
    }

    //装机后回调
    function cobbler_callback()
    {
        $facts = json_decode(file_get_contents("php://input"), true);
        if (!empty($facts)) {
            #获取ip
            $ip = $facts['ip'];

            #记录日志
            error_log(var_export($facts, true), 3, APPPATH . '/logs/' . $ip . '.log');

            #facts入库
            $facts = $facts['facts']['ansible_facts'];

            #根据ip获取资产号
            $assets = $this->db->where('ip', $ip)->get('c_ip')->row_array();
            $assets = $assets['assets'];

            $device = array(
                'device_status' => 2,//标记为待运营
                'supplier_type' => $facts['ansible_product_name'],
                'os' => json_encode(array('distribution' => $facts['ansible_distribution'], 'version' => $facts['ansible_distribution_version'])),
                'kernel' => $facts['ansible_kernel'],
                'device_serial_number' => $facts['ansible_product_serial'],
                'uuid' => $facts['ansible_product_uuid'],
                'hardware_info' => json_encode($facts['ansible_devices']),
                'storage_info' => json_encode($facts['ansible_mounts']),
                'cpu' => json_encode(array(
                    'processor' => $facts['ansible_processor'],
                    'processor_count' => $facts['ansible_processor_count'],
                    'processor_cores' => $facts['ansible_processor_cores'],
                    'threads_per_core' => $facts['ansible_processor_threads_per_core'],
                    'processor_vcpus' => $facts['ansible_processor_vcpus'])),
                'memory' => $facts['ansible_memtotal_mb'],
                'nic3_mac' => $facts['ansible_eth2']['macaddress'],
                'nic4_mac' => $facts['ansible_eth3']['macaddress'],
                'bond' => $facts['ansible_bond0'],
                'bios_date' => $facts['ansible_bios_date'],
                'bios_version' => $facts['ansible_bios_version'],
                'swap' => $facts['ansible_swaptotal_mb']
            );

            $this->db->where('assets', $assets)->update('c_device', $device);

        } else {
            exit(json_encode(array('code' => 1001, 'message' => 'fail')));
        }
    }
}