<?php
require_once 'vendor/autoload.php';
// require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

use Dompdf\Dompdf;
use Sabberworm\CSS\Value\Size;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Test extends Controller {

    public $dethimodel;
    public $chitietde;
    public $ketquamodel;

    public function __construct() {
        $this->dethimodel = $this->model("DeThiModel");
        $this->chitietde = $this->model("ChiTietDeThiModel");
        $this->ketquamodel = $this->model("KetQuaModel");
        parent::__construct();
        require_once "./mvc/core/Pagination.php";
    }

    public function default() {
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

    public function add() {
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

    public function update($made) {
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

    public function start($made) {
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

    public function detail($made) {
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

    public function select($made) {
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
                $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }

    // Tham gia thi
    public function taketest($made) {
        if(filter_var($made, FILTER_VALIDATE_INT) !== false) {
            if (AuthCore::checkPermission("tgthi", "join")) {
                $user_id = $_SESSION['user_id'];
                $check = $this->ketquamodel->getMaKQ($made, $user_id);
                $infoTest = $this->dethimodel->getById($made);
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $now = new DateTime();
                $timestart = new DateTime($infoTest['thoigianbatdau']);
                $timeend = new DateTime($infoTest['thoigianketthuc']);
                if ($now >= $timestart && $now <= $timeend && $check['diemthi'] == '') {
                    $this->view("single_layout", [
                        "Page" => "de_thi",
                        "Title" => "Làm bài kiểm tra",
                        "Made" => $made,
                        "Script" => "de_thi",
                        "Plugin" => [
                            "sweetalert2" => 1
                        ]
                    ]);
                } else {
                    header("Location: ../start/$made");
                }
            } else {
                $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
            }
        } else {
            $this->view("single_layout", ["Page" => "error/page_404", "Title" => "Lỗi !"]);
        }
    }

    public function delete() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && AuthCore::checkPermission("dethi", "delete")) {
            $made = $_POST['made'];
            $result = $this->dethimodel->delete($made);
            echo json_encode($result);
        } else {
            echo json_encode(false);
        }
    }

    public function addTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && AuthCore::checkPermission("dethi", "create")) {
            $mamonhoc = $_POST['mamonhoc'];
            $nguoitao = $_SESSION['user_id'];
            $tende = $_POST['tende'];
            $thoigianthi = $_POST['thoigianthi'];
            $thoigianbatdau = $_POST['thoigianbatdau'];
            $thoigianketthuc = $_POST['thoigianketthuc'];
            $socaude = $_POST['socaude'];
            $socautb = $_POST['socautb'];
            $socaukho = $_POST['socaukho'];
            $chuong = isset($_POST['chuong']) ? $_POST['chuong'] : array();
            $loaide = $_POST['loaide'];
            $xemdiem = $_POST['xemdiem'];
            $xemdapan = $_POST['xemdapan'];
            $xembailam = $_POST['xembailam'];
            $daocauhoi = $_POST['daocauhoi'];
            $daodapan = $_POST['daodapan'];
            $tudongnop = $_POST['tudongnop'];
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->create($mamonhoc, $nguoitao, $tende, $thoigianthi, $thoigianbatdau, $thoigianketthuc, $xembailam, $xemdiem, $xemdapan, $daocauhoi, $daodapan, $tudongnop, $loaide, $socaude, $socautb, $socaukho, $chuong, $manhom);
            echo $result;
        }
    }

    public function updateTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && AuthCore::checkPermission("dethi", "update")) {
            $made = $_POST['made'];
            $mamonhoc = $_POST['mamonhoc'];
            $tende = $_POST['tende'];
            $thoigianthi = $_POST['thoigianthi'];
            $thoigianbatdau = $_POST['thoigianbatdau'];
            $thoigianketthuc = $_POST['thoigianketthuc'];
            $socaude = $_POST['socaude'];
            $socautb = $_POST['socautb'];
            $socaukho = $_POST['socaukho'];
            $chuong = $_POST['chuong'];
            $loaide = $_POST['loaide'];
            $xemdiem = $_POST['xemdiem'];
            $xemdapan = $_POST['xemdapan'];
            $xembailam = $_POST['xembailam'];
            $daocauhoi = $_POST['daocauhoi'];
            $daodapan = $_POST['daodapan'];
            $tudongnop = $_POST['tudongnop'];
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->update($made, $mamonhoc, $tende, $thoigianthi, $thoigianbatdau, $thoigianketthuc, $xembailam, $xemdiem, $xemdapan, $daocauhoi, $daodapan, $tudongnop, $loaide, $socaude, $socautb, $socaukho, $chuong, $manhom);
            echo $result;
        }
    }

    public function getDetail() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && AuthCore::checkPermission("dethi", "view")) {
            $made = $_POST['made'];
            $result = $this->dethimodel->getById($made);
            echo json_encode($result);
        }
    }

    public function getTestGroup() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->getListTestGroup($manhom);
            echo json_encode($result);
        }
    }

    public function addDetail() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $cauhoi = $_POST['cauhoi'];
            $result = $this->chitietde->createMultiple($made, $cauhoi);
            echo json_encode($result);
        }
    }

    public function getQuestion() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $result = $this->dethimodel->getQuestionByUser($made, $_SESSION['user_id']);
            echo json_encode($result);
        }
    }

    // Tạo đề thủ công
    public function getQuestionOfTestManual() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $result = $this->dethimodel->getQuestionOfTestManual($made);
            echo json_encode($result);
        }
    }

    public function getResultDetail() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $makq = $_POST['makq'];
            $result = $this->dethimodel->getResultDetail($makq);
            echo json_encode($result);
        }
    }

    public function startTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $user_id = $_SESSION['user_id'];
            $result = $this->ketquamodel->start($made, $user_id);
            $question = $this->dethimodel->getQuestionOfTest($made);
            echo json_encode($result);
        }
    }

    public function getTimeTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dethi = $_POST['dethi'];
            $result = $this->dethimodel->getTimeTest($dethi, $_SESSION['user_id']);
            echo $result;
        }
    }

    public function getTimeEndTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dethi = $_POST['dethi'];
            $result = $this->dethimodel->getTimeEndTest($dethi);
            echo $result;
        }
    }

    public function submit() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $listtr = $_POST['listCauTraLoi'];
            $thoigian = $_POST['thoigianlambai'];
            str_replace("(Indochina Time)", "(UTC+7:00)", $thoigian);
            $date = DateTime::createFromFormat('D M d Y H:i:s e+', $thoigian);
            $made = $_POST['made'];
            $nguoidung = $_SESSION['user_id'];
            $result = $this->ketquamodel->submit($made, $nguoidung, $listtr, $date->format('Y-m-d H:i:s'));
            echo $result;
        }
    }

    public function getDethi() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dethi = $_POST['made'];
            $result = $this->dethimodel->create_dethi($dethi);
            echo json_encode($result);
        }
    }

    public function tookTheExam() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $result = $this->ketquamodel->tookTheExam($made);
            echo json_encode($result);
        }
    }

    public function getExamineeByGroup() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $manhom = $_POST['manhom'];
            $result = $this->ketquamodel->getExamineeByGroup($made, $manhom);
            echo json_encode($result);
        }
    }

    public function getQuery($filter, $input, $args) {
        $result = $this->ketquamodel->getQuery($filter, $input, $args);
        return $result;
    }

    public function getStatictical() {
        $made = $_POST['made'];
        $manhom = $_POST['manhom'];
        $result = $this->ketquamodel->getStatictical($made, $manhom);
        echo json_encode($result);
    }

    public function chuyentab(){
        $made = $_POST['made'];
        $id = $_SESSION['user_id'];
        $result = $this->ketquamodel->chuyentab($made,$id);
        echo $result;
    }

    public function exportPdf($makq) {
        $dompdf = new Dompdf();

        $info = $this->ketquamodel->getInfoPrintPdf($makq);
        $cauHoi = $this->dethimodel->getResultDetail($makq);
        $diem = $info['diemthi'] != "" ? $info['diemthi'] : 0;
        $socaudung = $info['socaudung'] != "" ? $info['socaudung'] : 0;
        
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <style>
                * {
                    padding: 0;
                    margin: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: DejaVu Sans, "Times New Roman", serif; 
                    padding: 50px 50px;
                }
            </style>
        </head>
        <body>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: center; font-weight: bold;">
                        TRƯỜNG ĐẠI HỌC KIẾN TRÚC HÀ NỘI<br>
                        KHOA CÔNG NGHỆ THÔNG TIN<br><br><br>
                    </td>

                    <td style="text-align: center;">
                        <p style="font-weight:bold">' . mb_strtoupper($info['tende'], "UTF-8") . '</p>
                        <p style="font-weight:bold">Học phần: ' . $info['tenmonhoc'] . '</p>
                        <p style="font-weight:bold">Mã học phần: ' . $info['mamonhoc'] . '</p>
                        <p style="font-style:italic">Thời gian làm bài: ' . $info['thoigianthi'] . ' phút</p>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-bottom: 10px">
                <tr style="width: 100%">
                    <td>Mã sinh viên: ' . $info['manguoidung'] . '</td>
                    <td>Tên thí sinh: ' . $info['hoten'] . '</td>
                </tr>

                <tr style="width: 100%">
                    <td>Số câu đúng: ' . $socaudung . '/' . $info['tongsocauhoi'] . '</td>
                    <td>Điểm: ' . $diem . '</td>
                </tr>
            </table>       
            <hr>
            <div style="margin-top:20px">
        ';
        foreach ($cauHoi as $index => $ch) {
            $html .= '<li style="list-style:none"><strong>Câu ' . ($index + 1) . '</strong>: ' . $ch['noidung'] . '<ol type="A" style="margin-left: 30px">';
            foreach ($ch['cautraloi'] as $ctl) {
                $dapAn = $ctl['ladapan'] == "1" ? " (Đáp án chính xác)" : "";
                $dapAnChon = $ctl['macautl'] == $ch['dapanchon'] ? " (Đáp án chọn)" : "";
                $html .= '<li>' . $ctl['noidungtl'] . $dapAnChon . $dapAn . '</li>';
            }

            $html .= '</ol></li>';
        }

        $html .= '
        </div>
        </body>
        </html>
        ';
        $dompdf->loadHtml($html, 'UTF-8');

        // Thiết lập kích thước giấy và hướng giấy
        $dompdf->setPaper('A4', 'portrait');

        // Xuất PDF
        $dompdf->render();
        $output = $dompdf->output();
        echo base64_encode($output);
    }

    public function exportExcel() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $made = $_POST['made'];
            $manhom = $_POST['manhom'];
            $ds = $_POST['ds'];
            $result = $this->ketquamodel->getTestScoreGroup($made, $manhom);
            if ($manhom == 0) {
                $result = $this->ketquamodel->getTestAll($made, $ds);
            }

            // Khởi tạo đối tượng
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Tạo tiêu đề cho trang
            $sheet->setTitle("Danh sách kết quả");

            // Xét chiều rộng cho từng cột
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(10);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);

            // Xét in đậm và màu cho khoảng cột
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);
            $sheet->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('33FF33');
            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Thiết lập tiêu đề cột
            $sheet->setCellValue('A1', 'MSSV');
            $sheet->setCellValue('B1', 'Họ và tên');
            $sheet->setCellValue('C1', 'Điểm thi');
            $sheet->setCellValue('D1', 'Thời gian vào thi');
            $sheet->setCellValue('E1', 'Thời gian làm bài');
            $sheet->setCellValue('F1', 'Số câu đúng');
            $sheet->setCellValue('G1', 'Số lần chuyển Tab');

            // Thêm dữ liệu vào từng ô
            $numRow = 2;
            foreach ($result as $row) {
                $sheet->setCellValue('A' . $numRow, $row["manguoidung"]);
                $sheet->setCellValue('B' . $numRow, $row["hoten"]);
                $sheet->setCellValue('C' . $numRow, $row["diemthi"] == "" ? "0" : $row["diemthi"]);
                $sheet->setCellValue('D' . $numRow, $row["thoigianvaothi"] == "" ? "0" : $row["thoigianvaothi"]);
                $sheet->setCellValue('E' . $numRow, $row["thoigianlambai"] == "" ? "0" : $row["thoigianlambai"]);
                $sheet->setCellValue('F' . $numRow, $row["socaudung"] == "" ? "0" : $row["socaudung"]);
                $sheet->setCellValue('G' . $numRow, $row["solanchuyentab"] == "" ? "0" : $row["solanchuyentab"]);
                $sheet->getStyle("A{$numRow}:G{$numRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $numRow++;
            }

            // Xuất file Excel
            ob_start();
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'status' => TRUE,
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );

            die(json_encode($response));
        }
    }

    public function getMarkOfAllTest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manhom = $_POST['manhom'];
            $result = $this->ketquamodel->getMarkOfAllTest($manhom);
    
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Danh sách kết quả");
    
            // Xét chiều rộng cho từng cột
            $end = $this->toAlpha(count($result[0]) - 1);
            for ($x = 0; $x < count($result[0]); $x++) {
                $sheet->getColumnDimension($this->toAlpha($x))->setWidth(25);
            }
    
            // Định dạng tiêu đề
            $headerRange = "A1:" . $end . "1";
            $sheet->getStyle($headerRange)->getFont()->setBold(true)->setColor(new Color(Color::COLOR_WHITE));
            $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('33FF33');
            $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
            // Ghi tiêu đề
            for ($x = 0; $x < count($result[0]); $x++) {
                $sheet->setCellValue($this->toAlpha($x) . "1", $result[0][$x]);
            }
    
            // Thêm dữ liệu vào từng ô
            $numRow = 2;
            for ($x = 1; $x < count($result); $x++) {
                for ($y = 0; $y < count($result[$x]); $y++) {
                    $sheet->setCellValue($this->toAlpha($y) . $numRow, $result[$x][$y] == "" ? "0" : $result[$x][$y]);
                }
                $sheet->getStyle("A" . $numRow . ":G" . $numRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $numRow++;
            }
    
            // Xuất file
            ob_start();
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();
    
            $response = array(
                'status' => TRUE,
                'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }

    function toAlpha($num){
        return chr(substr("000".($num+65),-3));
    }

    public function check(){
        $result = $this->ketquamodel->getMarkOfAllTest(2);
        echo "</br>";
        print_r($result);
    }

    public function getGroupsTakeTests() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tests = $_POST["tests"];
            $result = $this->dethimodel->getGroupsTakeTests($tests);
            echo json_encode($result);
        }
    }

    public function getTestsGroupWithUserResult() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manhom = $_POST['manhom'];
            $result = $this->dethimodel->getTestsGroupWithUserResult($manhom, $_SESSION['user_id']);
            echo json_encode($result);
        }
    }
}