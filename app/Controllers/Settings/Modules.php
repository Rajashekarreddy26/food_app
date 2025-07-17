<?php 
namespace App\Controllers\Settings;
use App\Controllers\BaseController;
/**
 * Modules 
 */
class Modules extends BaseController
{
	protected $moduleModel;
	public function __construct()
	{
		$this->moduleModel = model('App\Models\Settings\ModulesModel');
	}

	/**
	 * To get the Total Modules
	 */ 
	public function index()
	{
        // Load modals
		$data['modules'] = $this->moduleModel->orderBy('position','asc')->findAll();
		$data['page'] = array(
            'title' => 'Modules',
            'page_title' => 'Modules',
            'js' => ['module'],
        );
		return view('settings/modules/modules', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['modules'] = $this->moduleModel->orderBy('position','asc')->findAll();
		return view('settings/modules/modules_body', $data);
	}

	/**
	 * To Add Module
	 */ 
	public function add()
	{
		$data['parent_id'] = $this->request->getPost('parent_id');
		return view('settings/modules/add_module', $data);
	}

	/**
	 * To Insert Module
	 */ 
	public function create()
	{
		$rules = array(
			'name' => ['label' => 'name', 'rules' => 'required'],
			'url' => ['label' => 'URL', 'rules' => 'required'],
		);
		$check = $this->validate($rules);
		if($check == TRUE)
		{
			$add_url = array(
				'name' => $this->request->getPost('name'),
				'url' => $this->request->getPost('url'),
				'url2' => $this->request->getPost('url2') ?? '',
				'parent_id' => $this->request->getPost('parent_id'),
				'position' => $this->getMaxPosition($this->request->getPost('parent_id')),
				'status' => 1,
			);
			if($this->moduleModel->insert($add_url)) {
				$alert = array('color' => 'success', 'msg' => 'Module Inserted Successfully');
			}else {
				$alert = array('color' => 'danger', 'msg' => 'Error in Inserting');
			}
		}
		else {
			$data['parent_id'] = $this->request->getPost('parent_id');
			return view('settings/modules/add_module',$data);
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * To edit the Module
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['module_details'] = $this->moduleModel->find($id);
		return view('settings/modules/edit_module', $data);
	}

	/**
	 * To Update the Module
	 */ 
	public function update()
	{
		$id = $this->request->getPost('id');
		$rules = array(
			'name' => ['label' => 'name', 'rules' => 'required'],
			'url' => ['label' => 'URL', 'rules' => 'required'],
		);
		$check = $this->validate($rules);
		if($check == True) {
			$edit_module = array(
				'name' => $this->request->getPost('name'),
				'url' => $this->request->getPost('url'),
				'url2' => $this->request->getPost('url2') ?? '',
			);
			if($this->moduleModel->update($id, $edit_module)) {
				$alert = array('color' => 'success', 'msg' => 'Module Updated Successfully');
			}else {
				$alert = array('color' => 'danger', 'msg' => 'Error in Updating');
			}
		}
		else 
		{
			return view('settings/modules/edit_module');
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Get max position of module
	 */
	public function getMaxPosition($parentId = 0)
	{
		$position = $this->moduleModel->select('MAX(position) as max_position')->where(['parent_id' => $parentId])->first();
		return ($position) ? ($position['max_position'] + 1) : 1;
	}

	/**
	 * To Delete the Module
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->moduleModel->delete($id)) {
			$alert = array('color' => 'success', 'msg' => "Module Deleted Successfully");
		}else {
			$alert = array('color' => 'danger', 'msg' => "Error in Deleting");
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Update Module Status
	 */ 
	public function changeModuleStatus()
	{
		$id = $this->request->getPost('id');
		$status = array('status' => $this->request->getPost('status'));
		if($this->moduleModel->update($id, $status)) {
			$alert = array('color' => 'success', 'msg' => '<div class="alert alert-success mb-0" role="alert">Status Updated Successfully</div>');
		}else {
			$alert = array('color' => 'danger', 'msg' => '<div class="alert alert-danger mb-0" role="alert">Error in Updating</div>');
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Change Module Position
	 */ 
	public function changeModulePosition()
	{
		$params = array(
			'id' => $this->request->getPost('id'),
			'parent_id' => $this->request->getPost('parent_id'),
			'position' => $this->request->getPost('position'),
		);
		 $this->getMaxPosition1($params['parent_id'], $params['position']);
		/*$qry = $this->moduleModel->select('MAX(position) as maxposition')->where(['parent_id' => $params['parent_id']])->get()->getRowArray();
		echo $this->moduleModel->getLastQuery();*/
		print "<pre>"; print_r($params); print "</pre>";exit;
		
		//Getting the Query Results
		$result = $this->moduleModel->find($id1);
		$result2 = $this->moduleModel->find($id2);
		/*print "<pre>"; print_r($result); print "</pre>";
		print "<pre>"; print_r($result2); print "</pre>";exit;
		//Swap the Positions*/
	}

	/**
	 * Get max position of module
	 */
	public function getMaxPosition1($parentId = 0, $position = 1)
	{
		$position = $this->moduleModel->select('position')->where(['parent_id' => $parentId])->orderBy('position','desc')->first();
		echo $this->moduleModel->getLastQuery();
		return ($position) ? ($position['position']) : 1;
	}
}
