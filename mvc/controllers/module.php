<?php
require_once 'vendor/autoload.php';
require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
class Module extends Controller
{
    public $nhomModel;

    function __construct()
    {
        $this->nhomModel = $this->model("NhomModel");
        parent::__construct();
        require_once "./mvc/core/Pagination.php";
    }

    public function default()
    {
        if (AuthCore::checkPermission("hocphan", "view")) {
            $this->view("main_layout", [
                "Page" => "module",
                "Title" => "Quản lý nhóm học phần",
                "Script" => "module",
                "Plugin" => [
                    "sweetalert2" => 1,
                    "select" => 1,
                    "jquery-validate" => 1,
                    "notify" => 1
                ]
            ]);
        } else
            $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
    }
    public function detail($manhom)
    {
        $chitietnhom = $this->nhomModel->getDetailGroup($manhom);
        if (AuthCore::checkPermission("hocphan", "view") && $_SESSION['user_id'] == $chitietnhom['giangvien']) {
            $this->view("main_layout", [
                "Page" => "class_detail",
                "Title" => "Quản lý nhóm",
                "Plugin" => [
                    "datepicker" => 1,
                    "flatpickr" => 1,
                    "sweetalert2" => 1,
                    "jquery-validate" => 1,
                    "notify" => 1,
                    "pagination" => [],
                ],
                "Script" => "class_detail",
                "Detail" => $chitietnhom
            ]);
        } else
            $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
    }
