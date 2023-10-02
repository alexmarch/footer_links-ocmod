<?php
class ControllerExtensionModuleFooterLinks extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/footer_links');

        $data = array();

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/footer_links');

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_extension_module_footer_links->addFooterLink($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/footer_links', 'user_token=' . $this->session->data['user_token'], true));
        }

        if(isset($this->request->get['delete_id'])) {
            $this->model_extension_module_footer_links->deleteFooterLinks($this->request->get['delete_id']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/footer_links', 'user_token=' . $this->session->data['user_token'], true));
        }

        foreach($this->model_extension_module_footer_links->getAllFooterLinks() as $footer_link) {
            $data['footer_links'][] = array(
                'id' => $footer_link['id'],
                'sort_order' => $footer_link['sort_order'],
                'status' => $footer_link['status'],
                'text' => $footer_link['text'],
                'link' => $footer_link['link'],
                'edit' => $this->url->link('extension/module/footer_links/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $footer_link['id'], true),
                'delete' => $this->url->link('extension/module/footer_links', 'user_token=' . $this->session->data['user_token'] . '&delete_id=' . $footer_link['id'], true),
            );
        }

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $data['error_link_text'] = isset($this->error['error_link_text']) ? $this->error['error_link_text'] : '';
        $data['error_link_href'] = isset($this->error['error_link_href']) ? $this->error['error_link_href'] : '';
        $data['error_sort_order'] = isset($this->error['error_sort_order']) ? $this->error['error_sort_order'] : '';
        $data['action'] = $this->url->link('extension/module/footer_links', 'user_token=' . $this->session->data['user_token'], true);

        $this->response->setOutput($this->load->view('extension/module/footer_links', $data));
    }

    public function edit() {
        $this->load->language('extension/module/footer_links');

        $data = array();

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/footer_links');

        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_extension_module_footer_links->editFooterLink($this->request->get['id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/footer_links', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $data['error_link_text'] = isset($this->error['error_link_text']) ? $this->error['error_link_text'] : '';
        $data['error_link_href'] = isset($this->error['error_link_href']) ? $this->error['error_link_href'] : '';
        $data['error_sort_order'] = isset($this->error['error_sort_order']) ? $this->error['error_sort_order'] : '';

        $data['footer_link'] = $this->model_extension_module_footer_links->getFooterLink($this->request->get['id']);

        $data['action'] = $this->url->link('extension/module/footer_links/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $this->request->get['id'], true);

        $this->response->setOutput($this->load->view('extension/module/footer_links_form', $data));
    }

    public function createTable() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "footer_links` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `sort_order` int(3) NOT NULL,
            `status` tinyint(1) NOT NULL,
            `text` varchar(255) NOT NULL,
            `link` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "footer_links`;");
    }

    public function install() {
        $this->createTable();
    }

    protected function validate() {
        if(!$this->user->hasPermission('modify', 'extension/module/footer_links')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if(!$this->request->post['link_href']) {
            $this->error['error_link_href'] = $this->language->get('error_link_href');
        }

        if(!$this->request->post['link_text']) {
            $this->error['error_link_text'] = $this->language->get('error_link_text');
        }

        // if(!$this->request->post['sort_order']) {
        //     $this->error['sort_order'] = $this->language->get('error_sort_order');
        // }

        return !$this->error;
    }
}
