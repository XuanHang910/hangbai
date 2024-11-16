@include('backend.dashboard.component.breadcrumb', ['title'=>$config['seo']['create']['title']])


<form action="{{route('user.groupmembers.destroy', $userGroupMember->id)}}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeInRight"> 
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-title">Thông tin chung</div>
                <div class="panel-description">
                    <p>-   Bạn muốn xóa nhóm thành viên có tên là: <span class="text-danger">{{ $userGroupMember->ten }}</span></p>
                    <p>-    Lưu ý: Không thể khôi phục khi xóa <span class="text-danger">(*)</span>Là bắt buộc</p>
                </div>                
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                <label for="" class="control-label text-left"> Tên nhóm 
                                 <span class="text-danger">(*)</span></label>
                                <input
                                 type="text"
                                 name="ten"
                                 value="{{ old('ten', ($userGroupMember->ten) ?? '') }}"
                                 class="form-control"
                                 placeholder=""
                                 autocomplete="off"
                                 readonly
                                >
                                </div>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-danger" type="submit" name="send" value="send">Xóa dữ liệu</button>
        </div>
    </div>
</form>
