<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Repositories\AuthRuleRepository;


class AuthRuleController extends BaseController
{
    // 任务资源库的实例。
    protected $auth_rule;

    public function __construct(AuthRuleRepository $auth_rule)
    {
        parent::__construct();
        $this->auth_rule = $auth_rule;
    }

    public function index()
    {
        return view('admin.auth_rule.index');
    }

    public function lists(Request $request)
    {
        $data = $this->auth_rule->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:20',
                'rule_val' => 'required|max:100',
                'menu_url' => 'required|max:100'
            ]);
            return $this->auth_rule->saveData($request);
        }
        $result['sub_url'] = $request->url();
        $result['auth_tree'] = $this->auth_rule->getTreeHtml();
        return view('admin.auth_rule.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:20',
                'rule_val' => 'required|max:100',
                'menu_url' => 'required|max:100'
            ]);
            return $this->auth_rule->saveData($request, $id);
        }
        $result['data'] = $this->auth_rule->info($id);
        $result['sub_url'] = $request->url();
        $result['auth_tree'] = $this->auth_rule->getTreeHtml();
        return view('admin.auth_rule.create_and_edit', $result);
    }

    //编辑状态
    public function editRow(Request $request, $id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'sort_order' => 'required|integer',
            ]);
            $edit_data = $request->all();
            if (count($edit_data) != 1 || !isset($edit_data['sort_order'])) {
                return resultInfo('非法数据', 0);
            }
            return $this->auth_rule->saveData($request, $id);
        }
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->auth_rule->destroy($request->id);
    }

}
