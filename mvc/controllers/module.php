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
