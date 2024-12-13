<div class="content" data-id="<?php echo $_SESSION["user_id"] ?>">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tất cả câu hỏi</h3>
            <div class="block-options">
                <button type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-add-question" id="addquestionnew" data-role="cauhoi" data-action="create"><i class="fa-regular fa-plus"></i> Thêm câu
                    hỏi mới</button>
            </div>
        </div>
        <div class="block-content">
            <form action="#" method="POST" id="search-form" onsubmit="return false;">
                <div class="row mb-3">
                    <div class="col-xl-4 d-flex gap-2 align-items-center">
                        <select class="js-select2 form-select" id="main-page-monhoc" name="main-page-monhoc"
                            data-placeholder="Chọn môn học" data-tab="1">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-xl-4 d-flex gap-2 align-items-center">
                        <select class="js-select2 form-select" id="main-page-chuong" data-tab="1"
                            name="main-page-chuong" data-placeholder="Chọn chương">
                            <option></option>
                        </select>
                    </div>
                    <div class="col-xl-4 d-flex gap-2 align-items-center">
                        <label for="">Độ khó:</label>
                        <select class="js-select2 form-select" id="main-page-dokho" name="main-page-dokho"
                            style="width: 150px;" data-placeholder="Choose one..">
                            <option value="0">Tất cả</option>
                            <option value="1">Cơ bản</option>
                            <option value="2">Trung bình</option>
                            <option value="3">Nâng cao</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search-input" name="search-input"
                            placeholder="Nội dung câu hỏi...">
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
                            <th style="width: 700px;">Nội dung câu hỏi</th>
                            <th class="d-none d-sm-table-cell">Môn học</th>
                            <th class="d-none d-xl-table-cell">Độ khó</th>
                            <th class="text-center col-header-action">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="listQuestion">
                    </tbody>
                </table>
            </div>
            <?php if(isset($data["Plugin"]["pagination"])) require "./mvc/views/inc/pagination.php"?>
        </div>
    </div>
</div>