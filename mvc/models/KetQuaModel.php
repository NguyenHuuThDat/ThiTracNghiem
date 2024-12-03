<?php
class KetQuaModel extends DB{
    // 1. Phương thức khởi tạo kết quả
    public function start($made, $manguoidung)
    {
        $valid = true;
        $sql = "INSERT INTO `ketqua`(`made`, `manguoidung`) VALUES ('$made','$manguoidung')";
        $result = mysqli_query($this->con, $sql);
        if(!$result) $valid = false;
        return $valid;
    }

    public function updateChangeTab($made, $manguoidung)
    {
        $solanchuyentab = $this->getChangeTab($made, $manguoidung)['solanchuyentab'];
        $sql = "UPDATE `ketqua` SET `solanchuyentab`='$solanchuyentab' WHERE `made`='$made' AND `manguoidung`='$manguoidung'";
        $valid = true;
        $result = mysqli_query($this->con, $sql);
        if(!$result) $valid = false;
        return $valid;
    }

    public function getChangeTab($made, $manguoidung) {
        $sql = "SELECT `solanchuyentab` FROM `ketqua` WHERE `made`='$made' AND `manguoidung`='$manguoidung'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getMaKQ($made, $manguoidung)
    {
        $sql = "SELECT * FROM `ketqua` WHERE `made` = '$made' AND `manguoidung` = '$manguoidung'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function submit($made,$nguoidung,$list,$thoigian){
        $sql_ketqua = "Select * from ketqua where made = '$made' and manguoidung = '$nguoidung'";
        $result_ketqua = mysqli_query($this->con,$sql_ketqua);
        $data = mysqli_fetch_assoc($result_ketqua);
        $thoigianvaolam = strtotime($data['thoigianvaothi']);
        $thoigianlambai = strtotime($thoigian) - $thoigianvaolam;
        $valid = true;
        $socaudung = $this->socaudung($list);
        $socau = count($list);
        $diem = round((10/$socau * $socaudung),2);
        $sql = "UPDATE `ketqua` SET `diemthi`='$diem',`thoigianlambai`='$thoigianlambai',`socaudung`='$socaudung' WHERE manguoidung = '$nguoidung' and made = '$made'";
        $result = mysqli_query($this->con,$sql);
        if(!$result) $valid = false;
        $makq = $data['makq'];
        foreach($list as $ct){
            $macauhoi = $ct['macauhoi'];
            $cautraloi = $ct['cautraloi'];
            $sql = "UPDATE `chitietketqua` SET `dapanchon`='$cautraloi' WHERE `makq`='$makq' AND `macauhoi`='$macauhoi'";
            $insertCt = mysqli_query($this->con,$sql);
            if(!$insertCt) $valid = false;
        }
        return $valid;
    }

    public function tookTheExam($made){
        $sql = "select * from ketqua kq join nguoidung nd on kq.manguoidung = nd.id where kq.made = '$made'";
        $result = mysqli_query($this->con,$sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    public function getExamineeByGroup($made, $manhom) {
        $sql = "SELECT KQ.*, email, hoten, avatar FROM ketqua KQ, nguoidung ND, chitietnhom CTN WHERE KQ.manguoidung = ND.id AND CTN.manguoidung = ND.id AND KQ.made = $made AND CTN.manhom = $manhom";
        $result = mysqli_query($this->con,$sql);
        $rows = array();
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    public function getListAbsentFromTest($filter, $input, $args) {
        if (is_array($args['manhom'])) {
            $listGroup = implode(", ", $args['manhom']);
        } else {
            $listGroup = $args['manhom'];
        }
        $query = "SELECT KQ.makq, KQ.made, CTN.manguoidung, KQ.diemthi, KQ.thoigianvaothi, KQ.thoigianlambai, KQ.socaudung, KQ.solanchuyentab, email, hoten, avatar FROM chitietnhom CTN JOIN nguoidung ND ON ND.id = CTN.manguoidung LEFT JOIN ketqua KQ ON CTN.manguoidung = KQ.manguoidung AND KQ.made = ".$args['made']." WHERE KQ.made IS NULL AND CTN.manhom IN ($listGroup)";
        return $query;
    }

    public function getQueryAll($filter, $input, $args) {
        $absent_query = $this->getListAbsentFromTest($filter, $input, $args);
        $query = "SELECT DISTINCT KQ.*, email, hoten, avatar FROM ketqua KQ, nguoidung ND, chitietnhom CTN WHERE KQ.manguoidung = ND.id AND CTN.manguoidung = ND.id AND KQ.made = ".$args['made'];
        if (is_array($args['manhom'])) {
            $list = implode(", ", $args['manhom']);
            $query .= " AND CTN.manhom IN ($list)";
        } else {
            $query .= " AND CTN.manhom = ".$args['manhom'];
        }
        $present_query = $query;
        $query = "($present_query) UNION ($absent_query)";
        
        $order_by = "ORDER BY manguoidung ASC";
        if (isset($args["custom"]["function"])) {
            $function = $args["custom"]["function"];
            switch ($function) {
                case "sort":
                    $column = $args["custom"]["column"];
                    $order = $args["custom"]["order"];
                    switch ($column) {
                        case "manguoidung":
                        case "diemthi":
                        case "thoigianvaothi":
                        case "thoigianlambai":
                        case "solanchuyentab":
                            $order_by = "ORDER BY $column $order";
                            break;
                        case "hoten":
                            $present_query = $this->getQueryAddColumnFirstname($present_query, $filter, $input, $args, $order);
                            $absent_query = $this->getQueryAddColumnFirstname($absent_query, $filter, $input, $args, $order);
                            $query = "($present_query) UNION ($absent_query)";
                            $order_by = "ORDER BY firstname $order";
                            break;
                        default:
                    }
                    break;
                default:
            }
        }
        if ($input) {
            $query = "SELECT * FROM ($query) AS combined_results WHERE (hoten LIKE N'%${input}%' OR manguoidung LIKE '%${input}%')";
        }
        $query .= " $order_by";
        return $query;
    }
    
    // Tìm kiếm & phân trang & sắp xếp
    public function getQuery($filter, $input, $args) {
        if ($filter == "all") {
            return $this->getQueryAll($filter, $input, $args);
        }
        if ($filter == "absent") {
            $query = $this->getListAbsentFromTest($filter, $input, $args);
        } else {
            $query = "SELECT DISTINCT KQ.*, email, hoten, avatar FROM ketqua KQ, nguoidung ND, chitietnhom CTN WHERE KQ.manguoidung = ND.id AND CTN.manguoidung = ND.id AND KQ.made = ".$args['made'];
            switch ($filter) {
                case "present":
                    $query .= " AND diemthi IS NOT NULL";
                    break;
                case "interrupted":
                    $query .= " AND ISNULL(diemthi)";
                    break;
                default:
            }
            if (is_array($args['manhom'])) {
                $list = implode(", ", $args['manhom']);
                $query .= " AND CTN.manhom IN ($list)";
            } else {
                $query .= " AND CTN.manhom = ".$args['manhom'];
            }
        }
        if ($input) {
            $query .= " AND (hoten LIKE N'%${input}%' OR CTN.manguoidung LIKE '%${input}%')";
        }
        if (isset($args["custom"]["function"])) {
            $function = $args["custom"]["function"];
            switch ($function) {
                case "sort":
                    $column = $args["custom"]["column"];
                    $order = $args["custom"]["order"];
                    switch ($column) {
                        case "manguoidung":
                        case "diemthi":
                        case "thoigianvaothi":
                        case "thoigianlambai":
                        case "solanchuyentab":
                            $query .= " ORDER BY $column $order";
                            break;
                        case "hoten":
                            $query = $this->getQueryAddColumnFirstname($query, $filter, $input, $args, $order);
                            $query .= " ORDER BY firstname $order";
                            break;
                        default:
                    }
                    break;
                default:
            }
        } else {
            $query .= " ORDER BY manguoidung ASC";
        }
        return $query;
    }
}