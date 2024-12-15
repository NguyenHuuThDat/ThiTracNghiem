<div class="content">
    <div class="row">
        <div class="col-6 flex-grow-1">
            <div class="input-group">
                <button class="btn btn btn-alt-primary dropdown-toggle btn-filter" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">Đang giảng dạy</button>
                <ul class="dropdown-menu mt-1">
                    <li><a class="dropdown-item filter-search" href="javascript:void(0)" data-value="1">Đang giảng
                            dạy</a></li>
                    <li><a class="dropdown-item filter-search" href="javascript:void(0)" data-value="0">Đã ẩn</a></li>
                </ul>
                <input type="text" class="form-control" placeholder="Tìm kiếm nhóm..." id="form-search-group">
            </div>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end gap-3">
            <button type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal"
                data-bs-target="#modal-add-group" data-role="hocphan" data-action="create"><i class="fa fa-fw fa-plus me-1"></i> Thêm nhóm</button>
        </div>
    </div>
    <div class="class-group" id="class-group">
    </div>
</div>