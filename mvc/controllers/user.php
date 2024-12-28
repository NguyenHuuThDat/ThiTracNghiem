<?php
class User extends Controller{
    public $NguoiDungModel;

    public function __construct() {
        $this->NguoiDungModel = $this->model("NguoiDungModel");
        parent::__construct();
        require_once "./mvc/core/Pagination.php";
    }

    public function default() {
        if(AuthCore::checkPermission("nguoidung","view")) {
            $this->view("main_layout",[
                "Page" => "user",
                "Title" => "Quản lý người dùng",
                "Script" => "user",
                "Plugin" => [
                    "sweetalert2" => 1,
                    "datepicker" => 1,
                    "flatpickr" => 1,
                    "notify" => 1,
                    "jquery-validate" => 1,
                    "select" => 1,
                    "pagination" => [],
                ],
                "Roles" => $this->NguoiDungModel->getAllRoles(),
            ]);
        } else $this->view("single_layout", ["Page" => "error/page_403","Title" => "Lỗi !"]);
    }

    public function add() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['masinhvien'];
            $email = $_POST['email'];
            $hoten = $_POST['hoten'];
            $ngaysinh = $_POST['ngaysinh'];
            $gioitinh = $_POST['gioitinh'];
            $password = $_POST['password'];
            $nhomquyen = $_POST['role'];
            $trangthai = $_POST['status'];
            $result = $this->NguoiDungModel->create($id,$email,$hoten,$password,$ngaysinh,$gioitinh,$nhomquyen,$trangthai);
            echo $result;
        }
    }

    public function checkUser()  {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['mssv'];
            $email = $_POST['email'];
            $result = $this->NguoiDungModel->checkUser($id,$email);
            echo json_encode($result);
        }
    }

    public function getData() {
        $data = $this->NguoiDungModel->getAll();
        echo json_encode($data);
    }

    public function deleteData(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $result = $this->NguoiDungModel->delete($id);
        }
    }

    public function update(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $hoten = $_POST['hoten'];
            $ngaysinh = $_POST['ngaysinh'];
            $gioitinh = $_POST['gioitinh'];
            $password = $_POST['password'];
            $nhomquyen = $_POST['role'];
            $trangthai = $_POST['status'];
            $result = $this->NguoiDungModel->update($id,$email,$hoten,$password,$ngaysinh,$gioitinh,$nhomquyen,$trangthai);
            echo $result;
        }
    }

    public function getDetail() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->NguoiDungModel->getById($_POST['id']);
            echo json_encode($result);
        }
    }

    public function addExcel() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once 'vendor/autoload.php';

            $inputFileName = $_FILES["fileToUpload"]["tmp_name"];

            try {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($inputFileName);
                $spreadsheet = $reader->load($inputFileName);
            } catch (Exception $e) {
                die('Lỗi không thể đọc file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            $data = [];
            for ($i = 2; $i <= $highestRow; $i++) {
                $ho = "";
                $ten = "";
                $email = "";
                $mssv = "";

                for ($j = 0; $j < $highestColumnIndex; $j++) {
                    $cellValue = $sheet->getCellByColumnAndRow($j + 1, $i)->getValue(); // +1 because columnIndexFromString is 1-based

                    if ($j == 1) $mssv = $cellValue;
                    if ($j == 2) $ho .= $cellValue;
                    if ($j == 3) $ten .= $cellValue;
                    if ($j == 7) $email = $cellValue;
                }
                $fullname = $ho . ' ' . $ten;

                $data[$i]['fullname'] = trim($fullname);
                $data[$i]['email'] = trim($email);
                $data[$i]['mssv'] = trim($mssv);
                $data[$i]['nhomquyen'] = 11;
                $data[$i]['trangthai'] = 1;
            }
            echo json_encode($data);
        }
    }

    public function addFileExcel(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $listUser = $_POST['listuser'];
            $password = $_POST['password'];
            $result = $this->NguoiDungModel->addFile($listUser,$password);
            echo $result;
        }
    }

    public function addFileExcelGroup(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $listUser = $_POST['listuser'];
            $password = $_POST['password'];
            $manhom = $_POST['group'];
            $result = $this->NguoiDungModel->addFileGroup($listUser,$password,$manhom);
            echo $result;
        }
    }

    public function getQuery($filter, $input, $args) {
        $query = $this->NguoiDungModel->getQuery($filter, $input, $args);
        return $query;
    }
}
