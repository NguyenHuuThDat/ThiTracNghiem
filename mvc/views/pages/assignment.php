<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tất cả phân công</h3>
            <div class="block-options">
                <button data-role="phancong" data-action="create" type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-add-assignment" id="add_assignment"><i class="fa-regular fa-plus"></i> Thêm
                    phân công mới</button>
            </div>
        </div>
        <div class="block-content">
            <form action="#" id="main-page-search-form" onsubmit="return false;">
                <div class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search-input" name="search-input"
                            placeholder="Tìm kiếm giảng viên, môn học...">
                        <button class="input-group-text bg-body border-0 btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">ID</th>
                            <th>Tên giảng viên</th>
                            <th class="text-center">Mã môn</th>
                            <th>Môn học</th>
                            <th class="text-center col-header-action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="listAssignment">

                    </tbody>
                </table>
            </div>
            <?php if (isset($data["Plugin"]["pagination"])) require "./mvc/views/inc/pagination.php" ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-assignment" tabindex="-1" role="dialog" aria-labelledby="modal-add-assignment"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <ul class="nav nav-tabs nav-tabs-alt mb-1" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="btabs-alt-static-home-tab" data-bs-toggle="tab"
                        data-bs-target="#btabs-alt-static-home" role="tab" aria-controls="btabs-alt-static-home"
                        aria-selected="true">
                        Thêm thủ công
                    </button>
                </li>
                <li class="nav-item ms-auto">
                    <button type="button" class="btn btn-close p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </li>
            </ul>
            <div class="modal-body block block-transparent bg-white mb-0 block-rounded">
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-home" role="tabpanel"
                        aria-labelledby="btabs-static-home-tab" tabindex="0">
                        <form class="mb-4 form-phancong">
                            <div class="row">
                                <div class="col-6 d-flex flex-row w-100">
                                    <div class="d-flex align-items-center">
                                        <label for="giang-vien" class="form-label" style="width: 100px">
                                            Giảng viên
                                        </label>
                                    </div>
                                    <select class="js-select2 form-select data-monhoc" data-tab="1" id="giang-vien"
                                        name="giang-vien" style="width: 100%;" data-placeholder="Chọn giảng viên cần phân công"
                                        required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <form action="#" id="modal-add-assignment-search-form" onsubmit="return false;">
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-alt" id="search-input" name="search-input"
                                        placeholder="Tìm kiếm môn học...">
                                    <button class="input-group-text bg-body border-0 btn-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>