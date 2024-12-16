<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Danh sách nhóm quyền</h3>
            <div class="block-options">
                <button data-role="nhomquyen" data-action="create" type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-add-role"><i class="fa-regular fa-plus me-1"></i> Thêm mới</button>
            </div>
        </div>
        <div class="block-content">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <form action="be_pages_ecom_orders.html" method="POST" onsubmit="return false;">
                        <div class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-alt" id="one-ecom-orders-search"
                                    name="one-ecom-orders-search" placeholder="Tìm kiếm nhóm quyền..">
                                <span class="input-group-text bg-body border-0">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center">Mã nhóm quyền</th>
                                    <th>Tên nhóm</th>
                                    <th class="text-center">Số người dùng</th>
                                    <th class="text-center col-header-action">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="list-roles"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-labelledby="modal-add-role"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title add-role-element">Thêm nhóm quyền</h5>
                <h5 class="modal-title update-role-element">Sửa nhóm quyền</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-1">
                <form class="form_role">
                    <div class="mb-2">
                        <label class="form-label" for="ten-nhom-quyen">Tên nhóm quyền</label>
                        <input type="text" class="form-control form-control-alt" id="ten-nhom-quyen"
                            name="ten-nhom-quyen" placeholder="VD: Giảng viên">
                    </div>
                    <table class="table table-vcenter table-role">
                        <thead>
                            <tr>
                                <th>Tên quyền</th>
                                <th class="text-center">Xem</th>
                                <th class="text-center">Thêm mới</th>
                                <th class="text-center">Cập nhật</th>
                                <th class="text-center">Xoá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <tr>
                                <td>Người dùng</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="nguoidung" value="view">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="nguoidung" value="create">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="nguoidung" value="update">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="nguoidung" value="delete">
                                </td>
                            </tr>
                            <tr>
                                <td>Học phần</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="hocphan" value="view">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="hocphan" value="create">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="hocphan" value="update">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="hocphan" value="delete">
                                </td>
                            </tr>
                            <tr>
                                <td>Câu hỏi</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="cauhoi" value="view">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="cauhoi" value="create">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="cauhoi" value="update">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="cauhoi" value="delete">
                                </td>
                            </tr>
                            <tr>
                                <td>Môn học</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="monhoc" value="view">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="monhoc" value="create">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="monhoc" value="update">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="checkbox" name="monhoc" value="delete">
                                </td>
                            </tr>