<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * {{ controller_name }}控制器
 *
 */
class {{ controller_class_name }} extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('{{ model_name }}');
    }

    /**
     * {{ controller_name }} 首页
     */
    public function index()
    {
        $this->helper->redirect(array('{{ controller_name|lower }}/lists'));
    }

    /**
     * 列表页面
     */
    public function lists()
    {
        $this->load->config('pagination', true);
        $pagination = $this->config->item('pagination');
        $param = array();
        $page_query = $search = $this->input->get();
        $param = array();
        if(isset($search['{{ entity.primaryKey }}']) && $search['{{ entity.primaryKey }}'] != '') {
            $param['{{ entity.primaryKey }}'] = $search['{{ entity.primaryKey }}'];
        }
        $total = $this->{{ model_class_name }}->count($param);
        $data = array();
        if($total > 0) {
            $sortby = NULL;
            if(isset($search['sortby']) && in_array($search['sortby'], array_keys($this->{{ model_class_name }}->attributes()))) {
                $sortby = $search['sortby'];
                $sort_type = isset($search['asc']) && $search['asc'] ? 'ASC' : 'DESC';
                $sortby .= ' ' . $sort_type;
            }
            $page = intval($this->input->get($pagination['query_string_segment']));
            $page < 1 && $page = 1;
            $pages = ceil($total / $pagination['per_page']);
            $page > $pages && $page = $pages;
            $data = $this->{{ model_class_name }}->findAll($param, $pagination['per_page'], ($page - 1)*$pagination['per_page'], $sortby);
        }
        if(isset($page_query[$pagination['query_string_segment']])) {
            unset($page_query[$pagination['query_string_segment']]);
        }
        $pagination['base_url'] = create_url('{{ controller_name|lower }}/lists', $page_query);
        $pagination['total_rows'] = $total;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);

        {{ render|raw }}('{{ view_folder }}/list', array(
                'pagination' => $this->pagination->create_links(),
                'data' => $data,
                'search' => $search,
                'column' => $this->{{ model_class_name }}->attributes(),
        ));
    }

    /**
     * 新增页面
     */
    public function create()
    {
        $captcha = random_string();
        $this->session->set_userdata('captcha_create', $captcha);
        {{ render|raw }}('{{ view_folder }}/form', array(
                'action' => 'create',
                'captcha' => $captcha,
                'column' => $this->{{ model_class_name }}->attributes(),
        ));
    }

    /**
     * 编辑页面
     */
    public function edit()
    {
        $id = intval($this->input->get('{{ entity.primaryKey }}'));
        if($id < 1) {
            $this->helper->msg('参数错误');
        }
        $data = $this->{{ model_class_name }}->findByPk($id);
        if(empty($data)) {
            $this->helper->msg('该记录不存在或已被删除');
        }

        {{ render|raw }}('{{ view_folder }}/form', array(
                'action' => 'edit',
                'data' => $data,
                'column' => $this->{{ model_class_name }}->attributes(),
        ));
    }

    /**
     * 新增、编辑校验页面
     */
    public function verify()
    {
        if(! ($post = $this->input->post())) {
            $this->helper->redirect(array('{{ controller_name|lower }}/lists'));
        }

        $action = $this->input->post('_action');
        $data = $post['data'];

        $attributes = $this->{{ model_class_name }}->attributes();
        $this->load->library('form_validation');
{% for key, val in entity.fieldDefine %}{% if key != entity.primaryKey and val.required %}
        $this->form_validation->set_rules("data[{{ key }}]", $attributes['{{ key }}'], 'required');
{% endif %}{% endfor %}
        if($this->form_validation->run() == FALSE) {
            $this->helper->msg($this->form_validation->error_string('<span>', '</span><BR>'));
            return false;
        }

        if($action == 'create') {
            $captcha_verify = $this->session->userdata('captcha_create');
            if(empty($captcha_verify) || $post['_captcha'] != $captcha_verify) {
                $this->helper->msg('页面已过期');
            }
            $this->verify_create($data);
        } elseif ($action == 'edit') {
            $pk = $post['{{ entity.primaryKey }}'];
            $this->verify_edit($pk, $data);
        } else {
            $this->helper->msg('非法操作');
        }
    }

    /**
     * 处理新增请求
     */
    private function verify_create($data)
    {
        if($id = $this->{{ model_class_name }}->save($data)) {
            $this->session->unset_userdata('captcha_create');
            $this->helper->msg('提交成功', '{{ controller_name|lower }}/detail?{{ entity.primaryKey }}='.$id, '详细页面');
        } else {
            $this->helper->msg('提交失败');
        }
    }

    /**
     * 处理编辑请求
     */
    private function verify_edit($pk, $data)
    {
        if($this->{{ model_class_name }}->updateByPk($pk, $data)) {
            $this->helper->msg('更新成功', '{{ controller_name|lower }}/detail?{{ entity.primaryKey }}='.$pk, '详细页面');
        } else {
            $this->helper->msg('更新失败');
        }
    }

    /**
     * 详细页面
     */
    public function detail()
    {
        $id = intval($this->input->get('{{ entity.primaryKey }}'));
        if($id < 1) {
            $this->helper->msg('参数错误');
        }
        $data = $this->{{ model_class_name }}->findByPk($id);
        if(empty($data)) {
            $this->helper->msg('该记录不存在或已被删除');
        }
        {{ render|raw }}('{{ view_folder }}/detail', array(
                'data' => $data,
                'column' => $this->{{ model_class_name }}->attributes(),
        ));
    }

    /**
     * 删除页面
     */
    public function del()
    {
        $id = intval($this->input->get('{{ entity.primaryKey }}'));
        if($id < 1) {
            $this->helper->msg('参数错误');;
        }
        if($this->{{ model_class_name }}->deleteByPk($id)) {
            $this->helper->msg('删除成功', '{{ controller_name|lower }}/lists', '列表页面');
        } else {
            $this->helper->msg('该记录不存在或已被删除');
        }
    }
}

/* End of file {{ controller_file_name }} */
/* Location: ./application/models/{{ controller_file_name }} */