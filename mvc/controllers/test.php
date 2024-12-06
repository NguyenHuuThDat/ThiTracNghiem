<?php
require_once 'vendor/autoload.php';
require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
use Dompdf\Dompdf;
use Sabberworm\CSS\Value\Size;

class Test extends Controller
{

    public $dethimodel;
    public $chitietde;
    public $ketquamodel;

    public function __construct()
    {
        $this->dethimodel = $this->model("DeThiModel");
        $this->chitietde = $this->model("ChiTietDeThiModel");
        $this->ketquamodel = $this->model("KetQuaModel");
        parent::__construct();
        require_once "./mvc/core/Pagination.php";
    }

    public function default()
    {
        if (AuthCore::checkPermission("dethi", "view")) {
            $this->view("main_layout", [
                "Page" => "test",
                "Title" => "Đề kiểm tra",
                "Plugin" => [
                    "notify" => 1,
                    "sweetalert2" => 1,
                    "pagination" => [],
                ],
                "Script" => "test",
                "user_id" => $_SESSION['user_id'],
            ]);
        } else {
            $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
        }
    }

    public function add()
    {
        if (AuthCore::checkPermission("dethi", "create")) {
            $this->view("main_layout", [
                "Page" => "add_update_test",
                "Title" => "Tạo đề kiểm tra",
                "Plugin" => [
                    "datepicker" => 1,
                    "flatpickr" => 1,
                    "select" => 1,
                    "notify" => 1,
                    "jquery-validate" => 1
                ],
                "Script" => "action_test",
                "Action" => "create"
            ]);
        } else {
            $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
        }
    }

    public function update($made)
    {
        if(filter_var($made, FILTER_VALIDATE_INT) !== false) {
            $dethi = $this->dethimodel->getById($made);
            if(isset($dethi)) {
                if (AuthCore::checkPermission("dethi", "update") && $dethi['nguoitao'] == $_SESSION['user_id']) {
                    $this->view("main_layout", [
                        "Page" => "add_update_test",
                        "Title" => "Cập nhật đề kiểm tra",
                        "Plugin" => [
                            "datepicker" => 1,
                            "flatpickr" => 1,
                            "select" => 1,
                            "notify" => 1,
                            "jquery-validate" => 1
                        ],
                        "Script" => "action_test",
                        "Action" => "update"
                    ]);
                } else {
                    $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
                }
            } else {
                $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }

    public function start($made)
    {
        if(filter_var($made, FILTER_VALIDATE_INT) !== false) {
            $dethi = $this->dethimodel->getById($made);
            $check_allow = $this->dethimodel->checkStudentAllowed($_SESSION['user_id'], $made);
            if (isset($dethi)) {
                if(AuthCore::checkPermission("tgthi", "join") && $check_allow) {
                    $this->view("main_layout", [
                        "Page" => "vao_thi",
                        "Title" => "Bắt đầu thi",
                        "Test" => $dethi,
                        "Check" => $this->ketquamodel->getMaKQ($made, $_SESSION['user_id']),
                        "Script" => "vaothi",
                        "Plugin" => [
                            "notify" => 1
                        ]
                    ]);
                } else {
                    $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
                }
            } else {
                $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }

    public function detail($made)
    {
        if(filter_var($made, FILTER_VALIDATE_INT) !== false) {
            $dethi = $this->dethimodel->getInfoTestBasic($made);
            if (isset($dethi)) {
                if(AuthCore::checkPermission("dethi", "create") && $dethi['nguoitao'] == $_SESSION['user_id']) {
                    $this->view("main_layout", [
                        "Page" => "test_detail",
                        "Title" => "Danh sách đã thi",
                        "Test" => $dethi,
                        "Script" => "test_detail",
                        "Plugin" => [
                            "pagination" => [],
                            "chart" => 1
                        ]
                    ]);
                } else {
                    $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
                }
            } else {
                $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }

    public function select($made)
    {
        if(filter_var($made, FILTER_VALIDATE_INT) !== false) {
            $check = $this->dethimodel->getById($made);
            if (isset($check)) {
                if(($check && AuthCore::checkPermission("dethi", "create") || AuthCore::checkPermission("dethi", "update")) && $check['loaide'] == 0 && $check['nguoitao'] == $_SESSION['user_id']) {
                    $this->view('main_layout', [
                        "Page" => "select_question",
                        "Title" => "Chọn câu hỏi",
                        "Script" => "select_question",
                        "Plugin" => [
                            "notify" => 1,
                            "pagination" => [],
                        ],
                    ]);
                } else {
                    $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
                }
            } else {
                $this->view("single_layout", [
                    "Page" => "error/page_404",
                    "Title" => "Lỗi !"
                ]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }
}