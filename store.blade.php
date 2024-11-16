@include('backend.dashboard.component.breadcrumb', ['title'=>$config['seo']['create']['title']])
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>   
@endif
@php
    $url = ($config['method'] == 'create')    
           ? route('user.groupmembers.store') 
           : route('user.groupmembers.update', $userGroupMember->id);
@endphp

<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight"> 
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-title">Thông tin chung</div>
                <div class="panel-description">
                    <p>-    Nhập thông tin chung của nhóm thành viên</p>
                    <p>-    Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span>Là bắt buộc</p>
                </div>                
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                <label for="" class="control-label text-left"> Tên Nhóm  
                                 <span class="text-danger">(*)</span></label>
                                <input
                                 type="text"
                                 name="ten"
                                 value="{{ old('ten', ($userGroupMember->ten) ?? '') }}"
                                 class="form-control"
                                 placeholder=""
                                 autocomplete="off"
                                >
                                </div>
                            </div>          
                        </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                <label for="" class="control-label text-left">Ghi Chú</label>
                                <input
                                 type="text"
                                 name="description"
                                 value="{{ old('description', isset($userGroupMember->description) ?? '') }}"
                                 class="form-control"
                                 placeholder=""
                                 autocomplete="off"

                                >
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>

