<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 14-3-14
 * Time: AM10:59
 */

namespace Admin\Controller;

use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminConfigBuilder;
use Admin\Builder\AdminSortBuilder;

class DemoController extends AdminController
{
	/* 楼宇列表 */
	public function index($page = 1, $r = 20)
    {
        $map['status'] = array('EGT', 0);
        $model = M('Resources');
        $lists = $model->where($map)->page($page, $r)->order('create_time desc')->select();
        $totalCount = $model->where($map)->count();

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('商圈列表')
            ->buttonNew(U('doResources'))
            ->buttonDelete()
            ->setStatusUrl(U('setResourcesStatus'))
            ->buttonEnable()
            ->buttonDisable()
            ->keyId()
            ->keyText('title', '楼宇名称')
            ->keyText('trading_area', '商圈')
            ->keyStatus()->keyDoActionEdit('doResources?id=###')->keyDoActionEdit('detail?rid=###','详情')
            ->data($lists)
            ->pagination($totalCount, $r)
            ->display();
    }
    public function detail($rid = 0){
        $map['rid'] = array('eq', $rid);
        $map['status'] = array('egt', 0);
        $model = M('ResourcesPosition');
        $lists = $model->where($map)->page($page, $r)->order('create_time desc')->select();
        $totalCount = $model->where($map)->count();
        $rtypes = C('RES_TYPE');
        foreach ($lists as &$v){
            $v['_type'] = $rtypes[$v['type']];
        }
        unset($v);

        //显示页面
        $builder = new AdminListBuilder();
        $builder->title('商圈列表')
            ->buttonNew(U('doResources'))
            ->buttonDelete()
            ->setStatusUrl(U('setResourcesStatus'))
            ->buttonEnable()
            ->buttonDisable()
            ->keyId()
            ->keyText('_type', '房源类型')
            ->keyText('trading_area', '商圈')
            ->keyStatus()->keyDoActionEdit('doResources?id=###')->keyDoActionEdit('showDetail?id=###','详情')
            ->data($lists)
            ->pagination($totalCount, $r)
            ->display();
    }
    public function showDetail($id = 0){
    	$info = $model = D('ResourcesPosition')->find($id);
        $rtypes = C('RES_TYPE');
        //获取房源类型
        $info['_type'] = $rtypes[$info['type']];

        //实时房源
        $actual_time = $info['actual_time'];
        if($actual_time == 1)$info['huodong'] = '实时';

        //促销房源
        $promotion = $info['promotion'];
        if($promotion == 1)$info['huodong'] = '促销';
        //动态显示实时房源
        if($actual_time == 0 && $promotion == 0) $info['huodong'] = '无';
        if($actual_time ==1 && $promotion == 1) $info['huodong'] = '实时,促销';
    	//显示页面
        $builder = new AdminConfigBuilder();
        $builder->title($isEdit ? '编辑规则' : '添加规则')
            ->keyId()
            ->keyReadOnly('_type', '房源类型')
			->keyReadOnly('huodong', '活动类型')
            ->keyStatus()
            ->data($info)
            ->buttonSubmit(U('doResources'))->buttonBack()
            ->display();
    }
	//商圈状态
	public function setResourcesStatus($ids, $status){
		$builder = new AdminListBuilder();
        $builder->doSetStatus('Resources', $ids, $status);
	}
	//编辑商圈
	public function doResources($id = 0){
		//判断是否为编辑模式
        $isEdit = $id ? true : false;
		if(IS_POST){
			if ($isEdit) {
				$data = D('Resources')->create();
	            $res = D('Resources')->save($data);
	        } else {
	            $data = D('Resources')->create();
				$data['uid'] = UID;
				$res = D('Resources')->add($data);
	        }
			if(!$res){
				$this->error($isEdit ? '编辑失败' : '创建失败');
			}
			//显示成功信息
            $this->success($isEdit ? '编辑成功' : '创建成功', U('index'));
		}else{
			//读取楼宇内容
	        if ($isEdit) {
	            $data = M('Resources')->where(array('id' => $id))->find();

	        } else {
	            $data['status'] = 1;
	        }
			
			//读取地区数据
			$citys = M('region')->where('status = 1')->select();
			$arr = array();
			foreach($citys as $key=>$val){
				$arr[$val['region_id']] = $val['region_name'];
			}
			
			$model = M('TradingArea');
            $tarea = $model->order('sort asc')->select();
			$area = array();
			foreach($tarea as $key=>$val){
				$area[$val['id']] = $val['name'];
			}
			
			//显示页面
	        $builder = new AdminConfigBuilder();
	        $builder->title($isEdit ? '编辑规则' : '添加规则')
	            ->keyId()
                ->keyText('title', '楼宇名称')
				->keyText('address', '楼宇地址')
                ->keyTime('build_time', '楼宇建造时间')
				->keySelect('city', '选择城市','',$arr)
				->keySelect('trading_area', '商圈','',$area)
				->keyTextArea('desc', '描述')
				->keyTextArea('more_desc', '更多描述')
	            ->keyStatus()
	            ->data($rule)
	            ->buttonSubmit(U('doResources'))->buttonBack()
	            ->display();
			
		}
	}
	
}