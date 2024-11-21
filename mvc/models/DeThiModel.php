<?php

class DeThiModel extends DB 
{
    public function create($monthi, $nguoitao, $tende, $thoigianthi, $thoigianbatdau, $thoigianketthuc, $hienthibailam, $xemdiemthi, $xemdapan, $troncauhoi, $trondapan, $nopbaichuyentab, $loaide, $socaude, $socautb, $socaukho, $chuong, $nhom)
    {
        $sql = "INSERT INTO `dethi`(`monthi`, `nguoitao`, `tende`, `thoigianthi`, `thoigianbatdau`, `thoigianketthuc`, `hienthibailam`, `xemdiemthi`, `xemdapan`, `troncauhoi`, `trondapan`, `nopbaichuyentab`, `loaide`, `socaude`, `socautb`, `socaukho`) VALUES ('$monthi','$nguoitao','$tende','$thoigianthi','$thoigianbatdau','$thoigianketthuc','$hienthibailam','$xemdiemthi','$xemdapan','$troncauhoi','$trondapan','$nopbaichuyentab','$loaide','$socaude','$socautb','$socaukho')";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $madethi = mysqli_insert_id($this->con);
            // Một đề thi giao cho nhiều nhóm
            $result = $this->create_giaodethi($madethi, $nhom);
            // Một đề thi thì có nhiều chương
            $result = $this->create_chuongdethi($madethi, $chuong);
            return $madethi;
        } else return false;
    }

    public function create_chuongdethi($made, $chuong)
    {
        $valid = true;
        foreach ($chuong as $machuong) {
            $sql = "INSERT INTO `dethitudong`(`made`, `machuong`) VALUES ('$made','$machuong')";
            $result = mysqli_query($this->con, $sql);
            if (!$result) $valid = false;
        }
        return $valid;
    }

    public function create_giaodethi($made, $nhom)
    {
        $valid = true;
        foreach ($nhom as $manhom) {
            $sql = "INSERT INTO `giaodethi`(`made`, `manhom`) VALUES ('$made','$manhom')";
            $result = mysqli_query($this->con, $sql);
            if (!$result) $valid = false;
        }
        return $valid;
    }

    public function create_dethi_auto($made, $monhoc, $chuong, $socaude, $socautb, $socaukho)
    {
        $valid = true;
        $sql_caude = "SELECT * FROM cauhoi ch join monhoc mh on ch.mamonhoc = mh.mamonhoc where ch.mamonhoc = $monhoc and ch.dokho = 1 and ";
        $sql_cautb = "SELECT * FROM cauhoi ch join monhoc mh on ch.mamonhoc = mh.mamonhoc where ch.mamonhoc = $monhoc and ch.dokho = 2 and ";
        $sql_caukho = "SELECT * FROM cauhoi ch join monhoc mh on ch.mamonhoc = mh.mamonhoc where ch.mamonhoc = $monhoc and ch.dokho = 3 and ";
        $countChuong = count($chuong) - 1;
        $detailChuong = "(";
        $i = 0;
        while ($i < $countChuong) {
            $detailChuong .= "ch.machuong='$chuong[$i]' or ";
            $i++;
        }
        $detailChuong .= "ch.machuong=$chuong[$countChuong])";

        $sql_caude = $sql_caude . $detailChuong . " order by rand() limit $socaude";
        $sql_cautb = $sql_cautb . $detailChuong . " order by rand() limit $socautb";
        $sql_caukho = $sql_caukho . $detailChuong . " order by rand() limit $socaukho";

        $result_cd = mysqli_query($this->con, $sql_caude);
        $result_tb = mysqli_query($this->con, $sql_cautb);
        $result_ck = mysqli_query($this->con, $sql_caukho);

        $data_cd = array();

        while ($row = mysqli_fetch_assoc($result_cd)) {
            $data_cd[] = $row;
        }
        while ($row = mysqli_fetch_assoc($result_tb)) {
            $data_cd[] = $row;
        }
        while ($row = mysqli_fetch_assoc($result_ck)) {
            $data_cd[] = $row;
        }
        shuffle($data_cd);
        return $data_cd;
    }
}